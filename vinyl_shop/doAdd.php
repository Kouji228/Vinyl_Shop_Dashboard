<?php
require_once "../vinyl_shop/connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // 開始事務
        $pdo->beginTransaction();

        // 獲取表單數據
        $name = $_POST['name'] ?? '';
        $address = $_POST['address'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $business_hours = $_POST['business_hours'] ?? '';
        $services = $_POST['services'] ?? [];
        $weekdays = isset($_POST['weekdays']) ? implode(',', $_POST['weekdays']) : '1,2,3,4,5';
        $latitude = $_POST['latitude'] ?? null;
        $longitude = $_POST['longitude'] ?? null;

        // 驗證必填欄位
        if (empty($name) || empty($address) || empty($phone) || empty($business_hours) || empty($latitude) || empty($longitude)) {
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

        // 準備 SQL 語句
        $sql = "INSERT INTO branch (name, address, phone, weekdays, business_hours, latitude, longitude)
                VALUES (:name, :address, :phone, :weekdays, :business_hours, :latitude, :longitude)";
        $stmt = $pdo->prepare($sql);

        // 綁定參數
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':address', $address);
        $stmt->bindValue(':phone', $phone);
        $stmt->bindValue(':weekdays', $weekdays);
        $stmt->bindValue(':business_hours', $business_hours);
        $stmt->bindValue(':latitude', $latitude);
        $stmt->bindValue(':longitude', $longitude);

        // 執行 SQL
        $stmt->execute();
        $branchId = $pdo->lastInsertId();

        // 插入圖片
        if (!empty($images)) {
            $sql = "INSERT INTO branch_image (branch_id, url, description) VALUES (:branch_id, :url, :description)";
            $stmt = $pdo->prepare($sql);
            foreach ($images as $image) {
                $stmt->execute([
                    ':branch_id' => $branchId,
                    ':url' => $image['url'],
                    ':description' => $image['description']
                ]);
            }
        }

        // 處理服務標籤
        if (!empty($services)) {
            $sql = "INSERT INTO branch_hashtag (branch_id, hashtag_id) VALUES (:branch_id, :hashtag_id)";
            $stmt = $pdo->prepare($sql);

            foreach ($services as $serviceId) {
                $stmt->bindValue(':branch_id', $branchId);
                $stmt->bindValue(':hashtag_id', $serviceId);
                $stmt->execute();
            }
        }

        // 提交事務
        $pdo->commit();

        // 返回成功響應
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'message' => '店面新增成功',
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
?>
