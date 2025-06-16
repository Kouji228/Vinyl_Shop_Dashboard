<?php
require_once "./components/connect.php";
require_once "./components/Utilities.php";

// 如果已經登入，重定向到首頁
if (isset($_SESSION['user_id'])) {
    header("Location: ./index.php");
    exit;
}

$error = '';

// 處理登入表單提交
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $account = $_POST['account'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($account) || empty($password)) {
        $_SESSION['login_error'] = '請輸入帳號和密碼';
        header("Location: user_login.php");
        exit;
    }

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE account = ? AND status = 'active'");
        $stmt->execute([$account]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // 登入成功
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['login_success'] = true;
            $_SESSION['welcome_name'] = $user['name'];
            header("Location: ./admin_login.php");
            exit;
        } else {
            $_SESSION['login_error'] = '帳號或密碼錯誤';
            header("Location: user_login.php");
            exit;
        }
    } catch (PDOException $e) {
        $_SESSION['login_error'] = '系統錯誤，請稍後再試';
        header("Location: user_login.php");
        exit;
    }
}

// 如果有錯誤，重定向回登入頁面並顯示錯誤訊息
if ($error) {
    $_SESSION['login_error'] = $error;
    header("Location: user_login.php");
    exit;
}
?>