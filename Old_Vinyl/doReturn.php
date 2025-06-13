<?php
//取消軟刪除
require_once "../components/connect.php";
require_once "../components/utilities.php";

if(!isset($_GET["id"])){
  alertGoTo("請從正常管道進入", "./index.php");
  exit;
}

$id = $_GET["id"];
$sql = "UPDATE `o_vinyl` SET `is_valid` = 1 WHERE `id` = ?";
$values = [$id];

try {
  $stmt = $pdo->prepare($sql);
  // $stmt->execute($values);
  $stmt->execute([$id]);
} catch (PDOException $e) {
  echo "錯誤: {{$e->getMessage()}}";
  exit;
}

alertGoTo("取消刪除成功", "./");