<?php
// 恢復被停權的會員
require_once "connect.php";
require_once "../components/Utilities.php";

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    header("Location: index.php");
    exit;
}

try {
    // 執行恢復（將 is_valid 設為 1）
    $stmt = $pdo->prepare("UPDATE users SET is_valid = 1 WHERE id = ?");
    $stmt->execute([$id]);

    // 重定向到會員列表
    header("Location: index.php?status=active");
    exit;
} catch (PDOException $e) {
    echo "錯誤: " . $e->getMessage();
    exit;
} 