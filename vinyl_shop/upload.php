<?php
require_once "../vinyl_shop/connect.php";

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

// 設定圖片儲存目錄
$uploadDir = __DIR__ . '/img/';

// 確保目錄存在
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// 生成唯一的文件名
$extension = pathinfo($file['name'], PATHINFO_EXTENSION);
$filename = uniqid() . '.' . $extension;
$filepath = $uploadDir . $filename;

// 移動上傳的文件
if (move_uploaded_file($file['tmp_name'], $filepath)) {
    $dbImagePath = '/vinyl_shop/img/' . $filename;

    // 返回成功響應
    echo json_encode([
        'url' => $dbImagePath,
        'uploaded' => 1,
        'fileName' => $filename,
        'description' => 'photo of shop'
    ]);
} else {
    echo json_encode(['error' => ['message' => '文件上傳失敗']]);
}
?>
