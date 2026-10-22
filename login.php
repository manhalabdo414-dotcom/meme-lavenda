<?php
require 'config/db.php';

if (isLoggedIn()) redirect('index.php');

$error = '';
$pageTitle = 'تسجيل الدخول';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = "من فضلك املئي جميع الحقول";
    } else {
        $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            redirect('index.php');
        } else {
            $error = "البريد الإلكتروني أو كلمة المرور غير صحيحة";
        }
    }
}

include 'includes/header.php';
?>

<div class="form-box">
    <h2>مرحباً بكِ في عالم الجمال 💗</h2>

    <?php if ($error): ?>
        <div class="alert error"><?= sanitize($error) ?></div>
    <?php endif; ?>

    <form method="POST" onsubmit="return validateForm()">
        <input type="email" id="email" name="email" placeholder="البريد الإلكتروني" required>
        <input type="password" id="password" name="password" placeholder="كلمة المرور" required>
        <button class="btn" type="submit">تسجيل الدخول</button>
    </form>

    <p class="form-link">
        ليس لديك حساب؟ <a href="register.php">أنشئي حساباً جديداً</a>
    </p>
</div>

<?php include 'includes/footer.php'; ?>