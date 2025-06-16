<?php
session_start();

// 清除所有 session 變數
$_SESSION = array();

// 如果要徹底銷毀 session，還需要刪除 session cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-42000, '/');
}

// 最後，銷毀 session
session_destroy();

// 重定向到登入頁面
header("Location: user_login.php");
exit; 