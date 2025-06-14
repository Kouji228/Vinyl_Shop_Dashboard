<?php
// 軟刪除主要程式
require_once "../components/connect.php";
require_once "../components/utilities.php";

if(!isset($_GET["id"])){
  alertGoTo("請從正常管道進入", "./index.php");
  exit;
}

$id = $_GET["id"];
$sql = "DELETE FROM `o_vinyl` WHERE `id` = ?;";

try {
  $stmt = $pdo->prepare($sql);
  // $stmt->execute($values);
  $stmt->execute([$id]);
} catch (PDOException $e) {
  echo "錯誤: {{$e->getMessage()}}";
  exit;
}

alertGoTo("刪除資料成功", "./delete.php");