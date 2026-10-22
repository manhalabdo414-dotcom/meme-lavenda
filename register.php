<?php
require 'config/db.php';

if (isLoggedIn()) redirect('index.php');

$error = '';
$success = '';
$pageTitle = 'إنشاء حساب';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($name) || empty($email) || empty($password)) {
        $error = "من فضلك املئي جميع الحقول";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "البريد الإلكتروني غير صحيح";
    } elseif (strlen($password) < 6) {
        $error = "كلمة المرور يجب أن تكون 6 أحرف على الأقل";
    } else {
        // التحقق من عدم وجود البريد
        $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        
        if ($check->get_result()->num_rows > 0) {
            $error = "هذا البريد الإلكتروني مسجل بالفعل";
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $hashed);

            if ($stmt->execute()) {
                $success = "تم إنشاء حسابك بنجاح 💗 يمكنك تسجيل الدخول الآن";
            } else {
                $error = "حدث خطأ أثناء التسجيل";
            }
        }
    }
}

include 'includes/header.php';
?>

<div class="form-box">
    <h2>إنشاء حساب جديد ✨</h2>

    <?php if ($error): ?>
        <div class="alert error"><?= sanitize($error) ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert success"><?= sanitize($success) ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="name" placeholder="الاسم الكامل" required>
        <input type="email" name="email" placeholder="البريد الإلكتروني" required>
        <input type="password" name="password" placeholder="كلمة المرور (6 أحرف على الأقل)" required minlength="6">
        <button class="btn" type="submit">إنشاء الحساب</button>
    </form>

    <p class="form-link">
        لديك حساب بالفعل؟ <a href="login.php">سجلي الدخول</a>
    </p>
</div>

<?php include 'includes/footer.php'; ?>