<?php
require_once "../vinyl_shop/connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // 開始事務
        $pdo->beginTransaction();

        // 獲取表單數據
        $id = $_POST['id'] ?? '';
        $name = $_POST['name'] ?? '';
        $address = $_POST['address'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $business_hours = $_POST['business_hours'] ?? '';
        $services = $_POST['services'] ?? [];
        $weekdays = isset($_POST['weekdays']) ? implode(',', $_POST['weekdays']) : '1,2,3,4,5';
        $latitude = $_POST['latitude'] ?? null;
        $longitude = $_POST['longitude'] ?? null;

        // 驗證必填欄位
        if (empty($id) || empty($name) || empty($address) || empty($phone) || empty($business_hours) || empty($latitude) || empty($longitude)) {
            throw new Exception('所有欄位都必須填寫');
        }

        // 處理圖片
        $images = [];
        if (isset($_POST['images']) && is_array($_POST['images'])) {
            foreach ($_POST['images'] as $image) {
                if (!empty($image['url'])) {
                    $images[] = [
                        'url' => $image['url'],
                        'description' => $image['description'] ?? null
                    ];
                }
            }
        }

        // 更新分店資料
        $stmt = $pdo->prepare("UPDATE branch SET name = :name, address = :address, phone = :phone,
                              weekdays = :weekdays, business_hours = :business_hours,
                              latitude = :latitude, longitude = :longitude WHERE id = :id");
        $stmt->execute([
            ':name' => $name,
            ':address' => $address,
            ':phone' => $phone,
            ':weekdays' => $weekdays,
            ':business_hours' => $business_hours,
            ':latitude' => $latitude,
            ':longitude' => $longitude,
            ':id' => $id
        ]);

        // 刪除現有的圖片
        $stmt = $pdo->prepare("DELETE FROM branch_image WHERE branch_id = :branch_id");
        $stmt->execute([':branch_id' => $id]);

        // 插入新的圖片
        if (!empty($images)) {
            $stmt = $pdo->prepare("INSERT INTO branch_image (branch_id, url, description) VALUES (:branch_id, :url, :description)");
            foreach ($images as $image) {
                $stmt->execute([
                    ':branch_id' => $id,
                    ':url' => $image['url'],
                    ':description' => $image['description']
                ]);
            }
        }

        // 刪除現有的服務標籤
        $stmt = $pdo->prepare("DELETE FROM branch_hashtag WHERE branch_id = :branch_id");
        $stmt->execute([':branch_id' => $id]);

        // 插入新的服務標籤
        if (!empty($services)) {
            $stmt = $pdo->prepare("INSERT INTO branch_hashtag (branch_id, hashtag_id) VALUES (:branch_id, :hashtag_id)");
            foreach ($services as $hashtagId) {
                $stmt->execute([
                    ':branch_id' => $id,
                    ':hashtag_id' => $hashtagId
                ]);
            }
        }

        // 提交事務
        $pdo->commit();

        // 返回成功響應
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'message' => '店面更新成功',
            'redirect' => './index.php'
        ]);
        exit;

    } catch (Exception $e) {
        // 回滾事務
        $pdo->rollBack();

        // 返回錯誤響應
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
        exit;
    }
} else {
    // 返回錯誤響應
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => '無效的請求方法'
    ]);
    exit;
}
