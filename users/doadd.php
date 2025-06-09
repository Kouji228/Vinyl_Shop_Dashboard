<?php
// 新增會員主要程式
require_once "./connect.php";
require_once "../components/Utilities.php";

if (!isset($_POST["email"])) {
    alertGoTo("請從正常管道進入", "users/index.php"); //顯示提示文字,選擇要跳回的頁面
    exit;
}

$email = $_POST["email"];
$password = $_POST["password"];
$name = $_POST["name"];

//檢查email欄位
if($email == ""){
  alertAndBack("請輸入有效的信箱");
  exit;
};

//FILTER_VALIDATE_EMAIL告知是要檢查 email
//加上!!就是指沒有通過email驗證就會跳出"請輸入有效的信箱"
if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
  alertAndBack("請輸入有效的信箱");
  exit;
};

//檢查密碼欄位
if($password == ""){
  alertAndBack("請輸入有效密碼");
  exit;
};
 
//算出密碼的長度有幾個字
$passwordLength = strlen($password);

//檢查密碼長度
if($passwordLength < 5 || $passwordLength > 20){
    alertAndBack("請輸入有效密碼");
    exit;
}

$password = password_hash($password, PASSWORD_BCRYPT);
//PASSWORD_DEFAULT預設 = PASSWORD_BCRYPT
//密碼加密 

$sql = "INSERT INTO users (account, name, email, phone) VALUES (?, ?, ?, ?)";
$values = [$email, $password, $name];


//新增有送出檔案就且沒有錯誤就執行
if (isset($_FILES["myFile"]) && $_FILES["myFile"]["error"] == 0) {
    $img = null;

    //幫照片用時間戳記寫入新的檔案名稱
    $timestamp = time();
    $ext = pathinfo($_FILES["myFile"]["name"], PATHINFO_EXTENSION);
    $newFileName = "{$timestamp}.{$ext}";
    $file = "./uploads/{$newFileNam}";
    if (move_uploaded_file($_FILES["myFile"]["tmp_name"], $file)) {
        $img = $newFileName;
    }

    $sql = "INSERT INTO `users` (`email`, `password`, `name`) VALUES (?, ?, ?);";
    $values = [$email, $password, $name];
}


$splEmail = "SELECT COUNT(*) as COUNT FROM `users` WHERE `email` = ? ;";


try {
    $stmtEmail = $pdo->prepare($splEmail);
    $stmtEmail->execute([$email]);
    // $row = $stmtEmail->fetch(PDO::FETCH_CLASS);
    // $count = $row["count"];


    //檢查帳號是否有人使用過
    $count = $stmtEmail->fetchColumn();
    if($count > 0){
        alertAndBack("此帳號已經使用過");
        exit;
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($values);
} catch (PDOException $e) {
    echo "錯誤: {{$e->getMessage()}}";
    exit;
}

alertGoTO("新增資料成功", "./index.php");
?>