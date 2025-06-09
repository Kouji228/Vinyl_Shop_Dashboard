<?php
include "../components/connect.php";
include "../components/Utilities.php";

if(!isset($_GET["id"])){
  echo "請勿直接從網址使用 doDelete.php";
  exit;
}

$id = $_GET["id"];

try {
  $pdo->beginTransaction();

  // 先刪除關聯資料
  $pdo->prepare("DELETE FROM article_statuses WHERE article_id = ?")->execute([$id]);
  $pdo->prepare("DELETE FROM article_tag WHERE article_id = ?")->execute([$id]);
  $pdo->prepare("DELETE FROM article_category WHERE article_id = ?")->execute([$id]);
  $pdo->prepare("DELETE FROM article_images WHERE article_id = ?")->execute([$id]);

  // 最後刪除主表
  $pdo->prepare("DELETE FROM articles WHERE id = ?")->execute([$id]);

  $pdo->commit();
} catch (PDOException $e) {
  $pdo->rollBack();
  echo "錯誤: {$e->getMessage()}";
  exit;
}
alertGoBack("刪除資料成功");
