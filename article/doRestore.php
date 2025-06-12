<?php
require_once "../article/connect.php";

if(!isset($_GET["id"])){
    echo "請勿直接從網址使用 doRestore.php";
    exit;
}

$id = $_GET['id'];

try {
    // 執行恢復操作
    $sql = "UPDATE articles SET is_deleted = 0, deleted_at = NULL WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);

    // 如果恢復成功，重定向回回收站
    header("Location: trash.php?message=restore_success");
    exit;
} catch (PDOException $e) {
    // 如果發生錯誤，重定向回回收站並顯示錯誤訊息
    header("Location: trash.php?error=restore_failed");
    exit;
}
