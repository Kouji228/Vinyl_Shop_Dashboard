<?php
require_once "../components/connect.php";
require_once "../components/Utilities.php";

if (!isset($_GET['id'])) {
    alertGoTo("缺少ID", "index.php");
    exit;
}
$id = intval($_GET['id']);
if ($id === 1) {
    alertGoTo("總管理員帳號不可刪除", "index.php");
    exit;
}
$sql = "DELETE FROM admins WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
alertGoTo("已永久刪除", "index.php"); 