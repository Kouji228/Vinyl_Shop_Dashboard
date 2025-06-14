<?php
session_start();
require_once "./components/connect.php";
require_once "./components/Utilities.php";

if (!isset($_POST["account"])) {
    alertGoTo("請從正常管道進入", "./admin_login.php"); 
    exit;
}

$account = trim($_POST["account"]);
$password = trim($_POST["password"]);

if(empty($account)){
    alertAndBack("請輸入帳號");
    exit;
}

if(empty($password)){
    alertAndBack("請輸入密碼");
    exit;
}

try {
    $sql = "SELECT * FROM `admins` WHERE `account` = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$account]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($row) {
        $verify_result = password_verify($password, $row["password"]);
        
        if ($verify_result) {
            // 檢查資料庫欄位
            error_log("Admin data: " . print_r($row, true));
            
            $_SESSION["admin"] = [
                "id" => $row["id"],
                "name" => $row["name"],
                "img" => $row["img"] ? "../admin/" . $row["img"] : "../images/admin.png"
            ];
            
            // 檢查 session 是否正確設置
            error_log("Session data: " . print_r($_SESSION["admin"], true));
            
            alertGoTo("管理員登入成功", "./index.php");
        } else {
            alertAndBack("帳號或密碼錯誤");
        }
    } else {
        alertAndBack("帳號或密碼錯誤");
    }
} catch (PDOException $e) {
    error_log("資料庫錯誤: " . $e->getMessage());
    alertAndBack("系統錯誤，請稍後再試");
}
?> 