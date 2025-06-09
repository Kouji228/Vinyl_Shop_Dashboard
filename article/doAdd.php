<?php
include "../components/connect.php";
include "../components/Utilities.php";

$title = $_POST["title"];
$content = $_POST["content"];
$status = $_POST["status"];
$tags = json_decode($_POST["tags"], true);
$cover_image_url = $_POST["cover_image_url"];
$scheduled_at = !empty($_POST["scheduled_at"]) ? $_POST["scheduled_at"] : null;

try {
    // 開始交易
    $pdo->beginTransaction();

    // 插入文章
    $sql = "INSERT INTO articles (title, cover_image_url, scheduled_at, content, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$title, $cover_image_url, $scheduled_at, $content]);

    // 獲取新插入的文章ID
    $article_id = $pdo->lastInsertId();

    // 插入狀態
    $sqlStatus = "INSERT INTO article_statuses (article_id, status, updated_at) VALUES (?, ?, NOW())";
    $stmtStatus = $pdo->prepare($sqlStatus);
    $stmtStatus->execute([$article_id, $status]);

    // 插入標籤關聯
    if (!empty($tags)) {
        $sqlTags = "INSERT INTO article_tag (article_id, tag_id) VALUES (?, ?)";
        $stmtTags = $pdo->prepare($sqlTags);
        foreach ($tags as $tag_id) {
            $stmtTags->execute([$article_id, $tag_id]);
        }
    }

    // 插入分類關聯
    $categories = json_decode($_POST["categories"], true);
    if (!empty($categories)) {
        $sqlCategories = "INSERT INTO article_category (article_id, category_id) VALUES (?, ?)";
        $stmtCategories = $pdo->prepare($sqlCategories);
        foreach ($categories as $category_id) {
            $stmtCategories->execute([$article_id, $category_id]);
        }
    }

    // 解析內容中的圖片網址，並關聯到 article_images
    preg_match_all('/<img[^>]+src="([^"]+)"/', $content, $matches);
    $imageUrls = $matches[1];
    if (!empty($imageUrls)) {
        foreach ($imageUrls as $url) {
            // 刪除無主的同圖紀錄
            $pdo->prepare("DELETE FROM article_images WHERE url = ? AND article_id IS NULL")->execute([$url]);
            // 跳過封面圖網址
            if ($url === $cover_image_url) continue;
            // 檢查是否已存在且 description = 'cover'
            $stmtCheck = $pdo->prepare("SELECT id, description FROM article_images WHERE url = ?");
            $stmtCheck->execute([$url]);
            $imgRow = $stmtCheck->fetch(PDO::FETCH_ASSOC);
            if ($imgRow) {
                if ($imgRow['description'] === 'cover') continue; // 跳過封面圖
                // 已存在，更新 article_id 與 description
                $stmtUpdateImg = $pdo->prepare("UPDATE article_images SET article_id = ?, description = 'content' WHERE id = ?");
                $stmtUpdateImg->execute([$article_id, $imgRow['id']]);
            } else {
                // 不存在，新增
                $stmtInsertImg = $pdo->prepare("INSERT INTO article_images (article_id, url, description) VALUES (?, ?, 'content')");
                $stmtInsertImg->execute([$article_id, $url]);
            }
        }
    }

    // 封面圖同步寫入 article_images 並標記
    if (!empty($cover_image_url)) {
        $pdo->prepare("DELETE FROM article_images WHERE url = ? AND article_id IS NULL")->execute([$cover_image_url]);
        $stmtCoverImg = $pdo->prepare("INSERT INTO article_images (article_id, url, description) VALUES (?, ?, 'cover')");
        $stmtCoverImg->execute([$article_id, $cover_image_url]);
    }

    // 提交交易
    $pdo->commit();
    // 使用 JSON 回傳成功訊息與跳轉網址
    echo json_encode([
        'success' => true,
        'redirect' => '/article/index.php',
        'message' => '文章新增成功'
    ]);
    exit;
} catch (Exception $e) {
    // 如果發生錯誤，回滾交易
    $pdo->rollBack();
    // 使用 JSON 回傳錯誤訊息
    echo json_encode([
        'success' => false,
        'message' => '文章新增失敗：' . $e->getMessage()
    ]);
    exit;
}
?>
