<?php
require_once "../vinyl_shop/connect.php";

if(!isset($_GET["id"])){
    echo "請勿直接從網址使用 permanentDelete.php";
    exit;
}

$id = $_GET['id'];

try {
    $pdo->beginTransaction();

    // 先刪除關聯資料
    $pdo->prepare("DELETE FROM branch_hashtag WHERE branch_id = ?")->execute([$id]);
    $pdo->prepare("DELETE FROM branch_image WHERE branch_id = ?")->execute([$id]);

    // 最後刪除主表
    $pdo->prepare("DELETE FROM branch WHERE id = ?")->execute([$id]);

    $pdo->commit();

    // 如果刪除成功，重定向回回收站
    header("Location: trash.php?message=delete_success");
    exit;
} catch (PDOException $e) {
    $pdo->rollBack();
    // 如果發生錯誤，重定向回回收站並顯示錯誤訊息
    header("Location: trash.php?error=delete_failed");
    exit;
}
