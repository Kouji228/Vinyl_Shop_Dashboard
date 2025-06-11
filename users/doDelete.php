<?php
// 軟刪除會員
require_once "connect.php";
require_once "../components/Utilities.php";

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    header("Location: index.php");
    exit;
}

try {
    // 執行軟刪除（將 is_valid 設為 0）
    $stmt = $pdo->prepare("UPDATE users SET is_valid = 0 WHERE id = ?");
    $stmt->execute([$id]);

    // 重定向到停權會員列表
    header("Location: index.php?status=suspended");
    exit;
} catch (PDOException $e) {
    echo "錯誤: " . $e->getMessage();
    exit;
} 