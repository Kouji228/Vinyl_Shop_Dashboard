<?php
// 軟刪除
require_once "../components/connect.php";
require_once "../components/Utilities.php";

if (!isset($_GET["id"])) {
    alertGoTo("請從正常管道進入", "./index.php");
    exit();
}

$id = $_GET["id"];
$sql = "UPDATE `coupons` SET `is_valid` = 0 WHERE `id` = ?";
$values = [$id];

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute( [$id]);
} catch (PDOException $e) {
    echo "錯誤: {{$e->getMessage()}}";
    exit;
}

alertGoTo("刪除資料成功", "./");