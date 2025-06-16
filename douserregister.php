<?php
require_once "./components/connect.php";
require_once "./components/Utilities.php";

// 如果已經登入，重定向到首頁
if (isset($_SESSION['user_id'])) {
    header("Location: ./index.php");
    exit;
}

// 處理註冊表單提交
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $account = $_POST['account'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $birthday = $_POST['birthday'] ?? '';
    $gender = $_POST['gender'] ?? '';

    // 驗證輸入
    if (empty($name) || empty($account) || empty($password) || empty($confirm_password) || empty($phone) || empty($birthday) || empty($gender)) {
        $_SESSION['register_error'] = '所有欄位都必須填寫';
        header("Location: user_register.php");
        exit;
    } elseif ($password !== $confirm_password) {
        $_SESSION['register_error'] = '密碼不一致';
        header("Location: user_register.php");
        exit;
    } elseif (strlen($password) < 6) {
        $_SESSION['register_error'] = '密碼長度必須至少6個字符';
        header("Location: user_register.php");
        exit;
    }

    try {
        // 檢查帳號是否已存在
        $stmt = $pdo->prepare("SELECT id FROM users WHERE account = ?");
        $stmt->execute([$account]);
        if ($stmt->rowCount() > 0) {
            $_SESSION['register_error'] = '該帳號已被註冊';
            header("Location: user_register.php");
            exit;
        }

        // 創建新用戶
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (name, account, password, email, phone, birthday, gender, level, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, '一般會員', NOW())");

        if ($stmt->execute([$name, $account, $hashed_password, $account, $phone, $birthday, $gender])) {
            $_SESSION['register_success'] = '註冊成功！請登入';
            header("Location: user_login.php");
            exit;
        } else {
            $_SESSION['register_error'] = '註冊失敗，請稍後再試';
            header("Location: user_register.php");
            exit;
        }
    } catch (PDOException $e) {
        $_SESSION['register_error'] = '系統錯誤，請稍後再試';
        header("Location: user_register.php");
        exit;
    }
}
?>