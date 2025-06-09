<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "../components/connect.php"; // 新增資料庫連線
// 設置允許的文件類型
$allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
// 設置最大文件大小（5MB）
$maxFileSize = 5 * 1024 * 1024;

// 檢查是否有文件上傳
if (!isset($_FILES['upload'])) {
    echo json_encode(['error' => ['message' => '沒有文件被上傳']]);
    exit;
}

$file = $_FILES['upload'];

// 檢查文件類型
if (!in_array($file['type'], $allowedTypes)) {
    echo json_encode(['error' => ['message' => '只允許上傳 JPG、PNG 或 GIF 格式的圖片']]);
    exit;
}

// 檢查文件大小
if ($file['size'] > $maxFileSize) {
    echo json_encode(['error' => ['message' => '文件大小不能超過 5MB']]);
    exit;
}

// 設定圖片儲存目錄（以 __DIR__ 為根目錄，確保不會多一層 article/）
// $uploadDir：一般上傳圖片暫存用（目前未直接使用）
// $coverDir：文章封面圖片儲存目錄
// $contentDir：文章內容插入圖片儲存目錄
$uploadDir = __DIR__ . '/img/uploads/';
$coverDir = __DIR__ . '/img/covers/';
$contentDir = __DIR__ . '/img/content/';

// 確保目錄存在
foreach ([$uploadDir, $coverDir, $contentDir] as $dir) {
    if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
    }
}

// 生成唯一的文件名
$extension = pathinfo($file['name'], PATHINFO_EXTENSION);
$filename = uniqid() . '.' . $extension;

// 根據圖片類型決定儲存目錄
$isCoverImage = isset($_POST['is_cover']) && $_POST['is_cover'] === 'true';
$targetDir = $isCoverImage ? $coverDir : $contentDir;
$filepath = $targetDir . $filename;

// 移動上傳的文件
if (move_uploaded_file($file['tmp_name'], $filepath)) {
    $isCoverImage = isset($_POST['is_cover']) && $_POST['is_cover'] === 'true';
    $articleId = isset($_POST['article_id']) ? $_POST['article_id'] : null;
    $dbImagePath = $isCoverImage ? '/article/img/covers/' . $filename : '/article/img/content/' . $filename;

    // 若有 article_id，先檢查是否有同 url、article_id=NULL 的紀錄，若有則 update
    if ($articleId) {
        $stmt = $pdo->prepare("SELECT id FROM article_images WHERE url = ? AND article_id IS NULL");
        $stmt->execute([$dbImagePath]);
        $nullId = $stmt->fetchColumn();
        if ($nullId) {
            $desc = $isCoverImage ? 'cover' : 'content';
            $stmt = $pdo->prepare("UPDATE article_images SET article_id = ?, description = ? WHERE id = ?");
            $stmt->execute([$articleId, $desc, $nullId]);
        }
    }

    if ($isCoverImage && $articleId) {
        // 1. 查詢同一篇文章是否已有 cover
        $stmt = $pdo->prepare("SELECT id FROM article_images WHERE article_id = ? AND url = ? AND description = 'cover'");
        $stmt->execute([$articleId, $dbImagePath]);
        $coverId = $stmt->fetchColumn();
        if ($coverId) {
            // 已有 cover，更新
            $stmt = $pdo->prepare("UPDATE article_images SET url = ? WHERE id = ?");
            $stmt->execute([$dbImagePath, $coverId]);
            $imageId = $coverId;
        } else {
            // 沒有 cover，插入
            $stmt = $pdo->prepare("INSERT INTO article_images (article_id, url, description) VALUES (?, ?, 'cover')");
            $stmt->execute([$articleId, $dbImagePath]);
            $imageId = $pdo->lastInsertId();
        }
        // 2. 刪除同一篇文章的 content（同圖）
        $stmt = $pdo->prepare("DELETE FROM article_images WHERE article_id = ? AND url = ? AND description = 'content'");
        $stmt->execute([$articleId, $dbImagePath]);
    } else if ($articleId) {
        // 內容圖上傳
        // 1. 查詢同一篇文章是否已有 cover
        $stmt = $pdo->prepare("SELECT id FROM article_images WHERE article_id = ? AND url = ? AND description = 'cover'");
        $stmt->execute([$articleId, $dbImagePath]);
        $coverId = $stmt->fetchColumn();
        if ($coverId) {
            // 已有 cover，不插入 content
            $imageId = $coverId;
        } else {
            // 查詢同一篇文章是否已有 content
            $stmt = $pdo->prepare("SELECT id FROM article_images WHERE article_id = ? AND url = ? AND description = 'content'");
            $stmt->execute([$articleId, $dbImagePath]);
            $contentId = $stmt->fetchColumn();
            if ($contentId) {
                // 已有 content，更新 article_id
                $stmt = $pdo->prepare("UPDATE article_images SET url = ? WHERE id = ?");
                $stmt->execute([$dbImagePath, $contentId]);
                $imageId = $contentId;
            } else {
                // 沒有就插入 content
                $stmt = $pdo->prepare("INSERT INTO article_images (article_id, url, description) VALUES (?, ?, 'content')");
                $stmt->execute([$articleId, $dbImagePath]);
                $imageId = $pdo->lastInsertId();
            }
        }
    } else {
        // 沒有 articleId，僅插入 content
        $stmt = $pdo->prepare("INSERT INTO article_images (url, description) VALUES (?, 'content')");
        $stmt->execute([$dbImagePath]);
        $imageId = $pdo->lastInsertId();
    }

    // 返回成功響應
    echo json_encode([
        'url' => $dbImagePath,
        'uploaded' => 1,
        'fileName' => $filename,
        'imageId' => $imageId
    ]);
} else {
    echo json_encode(['error' => ['message' => '文件上傳失敗']]);
}
?>
