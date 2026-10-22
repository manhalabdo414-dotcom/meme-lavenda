// ===== التحقق من النموذج =====
function validateForm() {
    const email = document.getElementById("email")?.value.trim();
    const password = document.getElementById("password")?.value.trim();

    if (!email || !password) {
        alert("من فضلك املئي جميع الحقول");
        return false;
    }
    return true;
}

// ===== قائمة الموبايل =====
function toggleMenu() {
    const nav = document.getElementById('mainNav');
    nav?.classList.toggle('open');
}

// إغلاق القائمة عند الضغط على رابط
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('#mainNav a').forEach(link => {
        link.addEventListener('click', () => {
            document.getElementById('mainNav')?.classList.remove('open');
        });
    });

    // تأثير ظهور البطاقات
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.card').forEach((card, i) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = `all 0.5s ease ${i * 0.1}s`;
        observer.observe(card);
    });
});

// ===== رسالة ترحيب =====
function welcomeMessage() {
    alert("أهلاً بكِ في LAVENDA BEAUTY 💗");
}