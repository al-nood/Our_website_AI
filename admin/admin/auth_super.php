<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'super_admin') {
    $_SESSION['message'] = "❌ عذراً، هذه الصفحة مخصصة للسوبر أدمن فقط";
    $_SESSION['type'] = "danger";
    header("Location:index.php");
    exit();
}
?>
