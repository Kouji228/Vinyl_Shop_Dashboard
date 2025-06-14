<?php
// 停權會員功能執行軟刪除
require_once "../components/connect.php";
require_once "../components/Utilities.php";

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    header("Location: index.php");
    exit;
}

try {
    // 執行停權（將 is_valid 設為 0）
    $stmt = $pdo->prepare("UPDATE users SET is_valid = 0 WHERE id = ?");
    $stmt->execute([$id]);

    // 重定向到會員列表，並顯示停權會員
    header("Location: index.php?status=suspended");
    exit;
} catch (PDOException $e) {
    echo "錯誤: " . $e->getMessage();
    exit;
} 