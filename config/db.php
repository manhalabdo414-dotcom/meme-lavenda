<?php


// ============================================
// ⚠️ عدّل هذه القيم من لوحة تحكم InfinityFree
// ============================================


define('DB_HOST', 'sql207.infinityfree.com');

// 2. اسم المستخدم (Username)
// تجده في: Control Panel → MySQL Databases → Username
// مثال: if0_38472910
define('DB_USER', 'if0_43195108');

// 3. كلمة المرور (Password)
// هي كلمة المرور التي كتبتها عند إنشاء الحساب
define('DB_PASS', 'HpQnnOshWj2SM');

// 4. اسم قاعدة البيانات (Database Name)
// تجده في: Control Panel → MySQL Databases → Database Name
// مثال: if0_38472910_lavenda
define('DB_NAME', 'if0_43195108_database');

// ============================================
// لا تعدّل أي شيء بعد هذا السطر
// ============================================

// تفعيل عرض الأخطاء (مؤقتاً للتشخيص - عطّله بعد ما يشتغل)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// الاتصال بقاعدة البيانات
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// التحقق من نجاح الاتصال
if ($conn->connect_error) {
    die("❌ فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

// ضبط الترميز لدعم اللغة العربية بشكل صحيح
$conn->set_charset("utf8mb4");

// ضبط المنطقة الزمنية
date_default_timezone_set('Africa/Cairo');

// بدء الجلسة إذا لم تكن مبدوءة
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ============================================
// دوال مساعدة
// ============================================

/**
 * التحقق من تسجيل الدخول
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

/**
 * إعادة التوجيه لصفحة أخرى
 */
function redirect($url) {
    header("Location: $url");
    exit;
}

/**
 * تنظيف المدخلات لمنع XSS
 */
function sanitize($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}
?>