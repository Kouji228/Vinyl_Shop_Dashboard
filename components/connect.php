<?php
$servername = "127.0.0.1";
$username = "root";  // XAMPP 默認用戶名
$password = "";      // XAMPP 默認密碼為空
$dbname = "ef_db";

try {
  $pdo = new PDO(
    "mysql:host={$servername};dbname={$dbname};charset=utf8",
    $username,
    $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // echo "Connected successfully";
} catch(PDOException $e) {
  echo "資料庫連線失敗<br>";
  echo "Error: " .$e->getMessage() ."<br>";
  exit;
}

?>
