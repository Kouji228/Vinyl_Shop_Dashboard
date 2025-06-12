<?php
require_once "../article/connect.php";

if(!isset($_GET["id"])){
  echo "請勿直接從網址使用 doDelete.php";
  exit;
}

$id = $_GET['id'];

try {
    // 執行軟刪除
    $sql = "UPDATE articles SET is_deleted = 1, deleted_at = CURRENT_TIMESTAMP WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);

    // 如果刪除成功，重定向回列表頁
    header("Location: index.php?message=delete_success");
    exit;
} catch (PDOException $e) {
    // 如果發生錯誤，重定向回列表頁並顯示錯誤訊息
    header("Location: index.php?error=delete_failed");
    exit;
}
