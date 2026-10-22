<?php
require 'config/db.php';
$pageTitle = 'تواصل معنا';
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (empty($name) || empty($email) || empty($message)) {
        $error = "من فضلك أدخلي البيانات بصورة صحيحة";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "البريد الإلكتروني غير صحيح";
    } else {
        $stmt = $conn->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);

        if ($stmt->execute()) {
            $success = "تم إرسال رسالتك بنجاح 💗 سنتواصل معك قريباً";
        } else {
            $error = "حدث خطأ أثناء إرسال الرسالة";
        }
    }
}

include 'includes/header.php';
?>

<div class="form-box">
    <h2>يسعدنا تواصلك معنا ✨</h2>

    <?php if ($success): ?>
        <div class="alert success"><?= sanitize($success) ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert error"><?= sanitize($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="name" placeholder="الاسم" required>
        <input type="email" name="email" placeholder="البريد الإلكتروني" required>
        <textarea name="message" rows="5" placeholder="اكتبي رسالتك هنا..." required></textarea>
        <button class="btn" type="submit">إرسال الرسالة</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>