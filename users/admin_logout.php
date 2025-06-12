<?php
session_start();

// 清除所有 session 變數
$_SESSION = array();

// 如果要徹底清除 session，還需要刪除 session cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-3600, '/');
}

// 最後，銷毀 session
session_destroy();

// 導向到登入頁面
header("Location: ./admin_login.php");
exit;
?> 