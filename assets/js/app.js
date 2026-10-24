// ==========================================
// LAVENDA BEAUTY - التطبيق المشترك
// ==========================================

// ---------- Storage helpers ----------
const Store = {
    get(key, fallback) {
        try { return JSON.parse(localStorage.getItem(key)) ?? fallback; }
        catch { return fallback; }
    },
    set(key, v) { localStorage.setItem(key, JSON.stringify(v)); },
    remove(key) { localStorage.removeItem(key); }
};

const KEY = {
    users:    'lavenda_users',
    session:  'lavenda_session',
    orders:   'lavenda_orders',
    messages: 'lavenda_messages',
};

// ---------- Helpers ----------
const formatPrice = n => Number(n).toLocaleString('ar-EG') + ' جنيه';
const escapeHtml = s => String(s ?? '').replace(/[&<>"']/g, c =>
    ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));

async function sha256(str) {
    const data = new TextEncoder().encode(str + '::lavenda-2026');
    const buf  = await crypto.subtle.digest('SHA-256', data);
    return Array.from(new Uint8Array(buf))
        .map(b => b.toString(16).padStart(2,'0')).join('');
}

// ---------- Auth ----------
const Auth = {
    users() { return Store.get(KEY.users, []); },

    currentUser() {
        const s = Store.get(KEY.session, null);
        if (!s) return null;
        return this.users().find(u => u.id === s.user_id) || null;
    },

    isLoggedIn() { return !!this.currentUser(); },

    async register({ name, email, password }) {
        const users = this.users();

        if (users.some(u => u.email.toLowerCase() === email.trim().toLowerCase()))
            throw new Error('هذا البريد الإلكتروني مسجل بالفعل');
        if (password.length < 6)
            throw new Error('كلمة المرور يجب أن تكون 6 أحرف على الأقل');

        const user = {
            id: users.length ? Math.max(...users.map(u => u.id)) + 1 : 1,
            name: name.trim(),
            email: email.trim().toLowerCase(),
            password_hash: await sha256(password),
            created_at: new Date().toISOString(),
        };
        users.push(user);
        Store.set(KEY.users, users);
        return user;
    },

    async login(email, password) {
        const user = this.users().find(
            u => u.email.toLowerCase() === email.trim().toLowerCase()
        );
        if (!user) throw new Error('البريد الإلكتروني أو كلمة المرور غير صحيحة');

        const hash = await sha256(password);
        if (user.password_hash !== hash)
            throw new Error('البريد الإلكتروني أو كلمة المرور غير صحيحة');

        Store.set(KEY.session, { user_id: user.id });
        return user;
    },

    logout() { Store.remove(KEY.session); },
};

// ---------- Orders ----------
const Orders = {
    all() { return Store.get(KEY.orders, []); },

    create({ product_id, quantity }) {
        const user = Auth.currentUser();
        if (!user) throw new Error('يجب تسجيل الدخول أولاً');

        const product = PRODUCTS.find(p => p.id === product_id);
        if (!product) throw new Error('المنتج غير موجود');

        quantity = Math.max(1, parseInt(quantity) || 1);

        const all = this.all();
        const order = {
            id: all.length ? Math.max(...all.map(o => o.id)) + 1 : 1,
            user_id: user.id,
            product_id: product.id,
            product_name: product.name,
            product_image: product.image,
            quantity,
            total_price: product.price * quantity,
            status: 'pending',
            created_at: new Date().toISOString(),
        };
        all.push(order);
        Store.set(KEY.orders, all);
        return order;
    },

    forUser(userId) {
        return this.all()
            .filter(o => o.user_id === userId)
            .sort((a, b) => b.id - a.id);
    },

    statusLabel(status) {
        return {
            pending:   { text: '⏳ قيد المراجعة', cls: 'pending'   },
            confirmed: { text: '✅ مؤكد',         cls: 'confirmed' },
            cancelled: { text: '❌ ملغي',         cls: 'cancelled' },
        }[status] || { text: '—', cls: '' };
    },
};

// ---------- Messages ----------
const Messages = {
    all() { return Store.get(KEY.messages, []); },
    create({ name, email, message }) {
        const all = this.all();
        all.push({
            id: all.length ? Math.max(...all.map(m => m.id)) + 1 : 1,
            name: name.trim(),
            email: email.trim(),
            message: message.trim(),
            created_at: new Date().toISOString(),
        });
        Store.set(KEY.messages, all);
    },
};

// ---------- UI ----------
const UI = {
    toast(msg, type = 'info') {
        let c = document.querySelector('.toast-container');
        if (!c) {
            c = document.createElement('div');
            c.className = 'toast-container';
            document.body.appendChild(c);
        }
        const el = document.createElement('div');
        el.className = `toast ${type}`;
        el.textContent = msg;
        c.appendChild(el);
        setTimeout(() => {
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 300);
        }, 2600);
    },

    renderHeader() {
        const host = document.getElementById('site-header');
        if (!host) return;

        const current = (location.pathname.split('/').pop() || 'index.html').toLowerCase();
        const user = Auth.currentUser();

        host.innerHTML = `
            <header>
                <div class="logo">
                    <a href="index.html">LAVENDA<span>.</span></a>
                </div>

                <button class="menu-toggle" onclick="UI.toggleMenu()" aria-label="القائمة">
                    <span></span><span></span><span></span>
                </button>

                <nav id="mainNav">
                    <a href="index.html"    class="${current==='index.html'   ?'active':''}">الرئيسية</a>
                    <a href="products.html" class="${current==='products.html'?'active':''}">المنتجات</a>
                    <a href="contact.html"  class="${current==='contact.html' ?'active':''}">تواصل معنا</a>

                    ${user ? `
                        <a href="orders.html" class="${current==='orders.html'?'active':''}">🛒 طلباتي</a>
                        <a href="#" class="nav-btn" onclick="UI.logout(event)">خروج</a>
                    ` : `
                        <a href="login.html" class="nav-btn ${current==='login.html'?'active':''}">دخول</a>
                    `}
                </nav>
            </header>
        `;
    },

    renderFooter() {
        const host = document.getElementById('site-footer');
        if (!host) return;

        host.innerHTML = `
            <footer>
                <div class="footer-content">
                    <div>
                        <h3>LAVENDA BEAUTY</h3>
                        <p>جمالك يبدأ من هنا 💗</p>
                    </div>
                    <div>
                        <h4>روابط سريعة</h4>
                        <a href="index.html">الرئيسية</a>
                        <a href="products.html">المنتجات</a>
                        <a href="contact.html">تواصل معنا</a>
                    </div>
                    <div>
                        <h4>تابعينا</h4>
                        <p>📧 info@lavenda.com</p>
                        <p>📱 +20 100 000 0000</p>
                    </div>
                </div>
                <div class="copyright">
                    © ${new Date().getFullYear()} LAVENDA BEAUTY - جميع الحقوق محفوظة
                </div>
            </footer>
        `;
    },

    toggleMenu() {
        document.getElementById('mainNav')?.classList.toggle('open');
    },

    logout(e) {
        e.preventDefault();
        Auth.logout();
        UI.toast('تم تسجيل الخروج', 'success');
        setTimeout(() => location.href = 'index.html', 400);
    },

    productCard(p, withOrder = false) {
        const loggedIn = Auth.isLoggedIn();
        return `
            <div class="card">
                <img src="${escapeHtml(p.image)}" alt="${escapeHtml(p.name)}" loading="lazy">
                <h3>${escapeHtml(p.name)}</h3>
                <p class="desc">${escapeHtml(p.description)}</p>
                <p class="price">${formatPrice(p.price)}</p>
                ${withOrder
                    ? (loggedIn
                        ? `<form class="order-form" onsubmit="UI.orderNow(event, ${p.id})">
                               <input type="hidden" name="product_id" value="${p.id}">
                               <input type="number" name="quantity" value="1" min="1" max="10">
                               <button class="btn" type="submit">اطلبي الآن 🛒</button>
                           </form>`
                        : `<a href="login.html" class="btn">سجلي الدخول للطلب</a>`)
                    : `<a href="products.html" class="btn">اطلبي الآن</a>`
                }
            </div>
        `;
    },

    orderNow(e, productId) {
        e.preventDefault();
        const qty = e.target.querySelector('input[name="quantity"]').value;
        try {
            Orders.create({ product_id: productId, quantity: qty });
            UI.toast('تم إنشاء طلبك بنجاح 💗', 'success');
            setTimeout(() => location.href = 'orders.html', 700);
        } catch (err) {
            UI.toast(err.message, 'error');
            if (err.message.includes('تسجيل')) {
                setTimeout(() => location.href = 'login.html', 800);
            }
        }
    },
};

// ---------- Startup ----------
document.addEventListener('DOMContentLoaded', () => {
    UI.renderHeader();
    UI.renderFooter();
});
