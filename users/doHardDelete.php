<?php
// 硬刪除會員
require_once "../components/connect.php";
require_once "../components/Utilities.php";

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    header("Location: index.php");
    exit;
}

try {
    // 執行硬刪除（從資料庫中完全刪除記錄）
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$id]);

    // 重定向到停權會員列表
    header("Location: index.php?status=suspended");
    exit;
} catch (PDOException $e) {
    echo "錯誤: " . $e->getMessage();
    exit;
} 