<?php
$servername = "localhost";
$username = "ant020336";
$password = "ant360203";
$dbname = "yi";
$port = 3306;

try{
  $pdo = new PDO(
    "mysql:host={$servername};
     dbname={$dbname};
     port={$port};
     charset=utf8", 
    $username, 
    $password);
}catch(PDOException $e){
  echo "資料庫連線失敗<br>";
  echo "Error: " .$e->getMessage() ."<br>";
  exit;
}
?>