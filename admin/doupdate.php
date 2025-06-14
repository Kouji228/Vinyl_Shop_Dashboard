<?php
require_once "../components/connect.php";
require_once "../components/Utilities.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $name = trim($_POST['name']);
    $account = trim($_POST['account']);
    $password = $_POST['password'];
    $imgPath = null;
    $updateImg = false;

    // 處理頭像上傳
    if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . "." . $ext;
        $target = "./uploads/" . $filename;
        if (move_uploaded_file($_FILES['img']['tmp_name'], $target)) {
            $imgPath = "./uploads/" . $filename;
            $updateImg = true;
        }
    }

    // 密碼處理
    $updatePassword = false;
    if (!empty($password)) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $updatePassword = true;
    }

    $sql = "UPDATE admins SET name=?, account=?";
    $params = [$name, $account];
    if ($updatePassword) {
        $sql .= ", password=?";
        $params[] = $hash;
    }
    if ($updateImg) {
        $sql .= ", img=?";
        $params[] = $imgPath;
    }
    $sql .= " WHERE id=?";
    $params[] = $id;

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    alertGoTo("修改成功", "../admin/update.php?id=" . $id);
    exit;
} else {
    alertAndBack("請用正確方式提交表單");
} 