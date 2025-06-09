<?php
include "../components/connect.php";
include "../components/Utilities.php";

$id = $_POST["id"];
$title = $_POST["title"];
$content = $_POST["content"];
$status = $_POST["status"];
$tags = json_decode($_POST["tags"], true);
$cover_image_url = $_POST["cover_image_url"];
$scheduled_at = !empty($_POST["scheduled_at"]) ? $_POST["scheduled_at"] : null;

// 取得舊文章資料
$stmt = $pdo->prepare("SELECT cover_image_url, content FROM articles WHERE id = ?");
$stmt->execute([$id]);
$oldArticle = $stmt->fetch(PDO::FETCH_ASSOC);
$oldCoverUrl = $oldArticle['cover_image_url'];
$oldContent = $oldArticle['content'];

// 取得舊內容所有圖片
preg_match_all('/<img[^>]+src="([^"]+)"/', $oldContent, $oldMatches);
$oldImageUrls = $oldMatches[1];

// 取得新內容所有圖片
preg_match_all('/<img[^>]+src="([^"]+)"/', $content, $newMatches);
$newImageUrls = $newMatches[1];

// 找出被移除的內容圖片
$removedImages = array_diff($oldImageUrls, $newImageUrls);

// 刪除被移除的內容圖片
foreach ($removedImages as $url) {
    $filePath = $_SERVER['DOCUMENT_ROOT'] . $url;
    if (file_exists($filePath)) unlink($filePath);
    $pdo->prepare("DELETE FROM article_images WHERE url = ? AND article_id = ?")->execute([$url, $id]);
}

// 處理封面圖更換
if ($oldCoverUrl && $cover_image_url !== $oldCoverUrl) {
    $filePath = $_SERVER['DOCUMENT_ROOT'] . $oldCoverUrl;
    if (file_exists($filePath)) unlink($filePath);
    $pdo->prepare("DELETE FROM article_images WHERE url = ? AND article_id = ? AND description = 'cover'")->execute([$oldCoverUrl, $id]);
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
            $stmtUpdateImg->execute([$id, $imgRow['id']]);
        } else {
            // 不存在，新增
            $stmtInsertImg = $pdo->prepare("INSERT INTO article_images (article_id, url, description) VALUES (?, ?, 'content')");
            $stmtInsertImg->execute([$id, $url]);
        }
    }
}

// 封面圖同步寫入 article_images 並標記
if (!empty($cover_image_url)) {
    $pdo->prepare("DELETE FROM article_images WHERE url = ? AND article_id IS NULL")->execute([$cover_image_url]);
    // 先檢查是否已存在封面圖
    $stmtCheck = $pdo->prepare("SELECT id FROM article_images WHERE article_id = ? AND description = 'cover'");
    $stmtCheck->execute([$id]);
    $coverImgId = $stmtCheck->fetchColumn();
    if ($coverImgId) {
        // 已有封面圖，更新
        $stmtUpdate = $pdo->prepare("UPDATE article_images SET url = ? WHERE id = ?");
        $stmtUpdate->execute([$cover_image_url, $coverImgId]);
    } else {
        // 沒有就新增
        $stmtInsert = $pdo->prepare("INSERT INTO article_images (article_id, url, description) VALUES (?, ?, 'cover')");
        $stmtInsert->execute([$id, $cover_image_url]);
    }
}

try {
    // 開始交易
    $pdo->beginTransaction();

    // 更新文章內容
    $sql = "UPDATE articles SET title = ?, cover_image_url = ?, scheduled_at = ?, content = ?, updated_at = NOW() WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$title, $cover_image_url, $scheduled_at, $content, $id]);

    // 更新狀態
    $sqlStatus = "UPDATE article_statuses SET status = ?, updated_at = NOW() WHERE article_id = ?";
    $stmtStatus = $pdo->prepare($sqlStatus);
    $stmtStatus->execute([$status, $id]);

    // 先刪除舊的標籤關聯
    $pdo->prepare("DELETE FROM article_tag WHERE article_id = ?")->execute([$id]);
    // 新增標籤關聯
    if (!empty($tags)) {
        $sqlTags = "INSERT INTO article_tag (article_id, tag_id) VALUES (?, ?)";
        $stmtTags = $pdo->prepare($sqlTags);
        foreach ($tags as $tag_id) {
            $stmtTags->execute([$id, $tag_id]);
        }
    }

    // 先刪除舊的分類關聯
    $pdo->prepare("DELETE FROM article_category WHERE article_id = ?")->execute([$id]);
    // 新增分類關聯
    $categories = json_decode($_POST["categories"], true);
    if (!empty($categories)) {
        $sqlCategories = "INSERT INTO article_category (article_id, category_id) VALUES (?, ?)";
        $stmtCategories = $pdo->prepare($sqlCategories);
        foreach ($categories as $category_id) {
            $stmtCategories->execute([$id, $category_id]);
        }
    }

    // 提交交易
    $pdo->commit();
    // 使用 JSON 回傳成功訊息與跳轉網址
    echo json_encode([
        'success' => true,
        'redirect' => '/article/index.php',
        'message' => '文章更新成功'
    ]);
    exit;
} catch (Exception $e) {
    // 如果發生錯誤，回滾交易
    $pdo->rollBack();
    // 使用 JSON 回傳錯誤訊息
    echo json_encode([
        'success' => false,
        'message' => '文章更新失敗：' . $e->getMessage()
    ]);
    exit;
}
?>
