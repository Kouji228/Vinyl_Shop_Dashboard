<?php
require_once "../users/connect.php";
require_once "../components/Utilities.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $account = trim($_POST['account']);
    $password = $_POST['password'];
    $imgPath = null;

    // 檢查帳號是否重複
    $sql_check = "SELECT COUNT(*) FROM admins WHERE account = ?";
    $stmt_check = $pdo->prepare($sql_check);
    $stmt_check->execute([$account]);
    if ($stmt_check->fetchColumn() > 0) {
        alertAndBack("帳號已存在，請更換帳號！");
        exit;
    }

    // 處理頭像上傳
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . "." . $ext;
        $target = "./uploads/" . $filename;
        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $target)) {
            $imgPath = "./uploads/" . $filename;
        }
    }

    // 密碼加密
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO admins (name, account, password, img) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name, $account, $hash, $imgPath]);
    alertGoTo("新增成功", "index.php");
    exit;
} else {
    alertAndBack("請用正確方式提交表單");
} 