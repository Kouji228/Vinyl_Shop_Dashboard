<?php
session_start();

// 檢查是否已登入
if (!isset($_SESSION["admin"])) {
    // 如果未登入，導向到登入頁面
    header("Location: ./admin_login.php");
    exit;
}
?> 