<?php
// ? 刪除資料庫

require_once "../components/connect.php";
require_once "../components/Utilities.php";

if (!isset($_GET["id"])) {
    alertGoTo("非法進入", "./index.php");
    exit;
}

$id = $_GET["id"];

$sql = "DELETE FROM vinyl WHERE id = ?";

try {
    // ? 刪除圖片與資料庫
     // 1. 查詢 vinyl 資料，取得 shs_id
    $sqlId = "SELECT * FROM vinyl WHERE id = ?";
    $stmtId = $pdo->prepare($sqlId);
    $stmtId->execute([$id]);
    $rowsId = $stmtId->fetch(PDO::FETCH_ASSOC);

    if (!$rowsId) {
        exit("找不到唱片資料");
    }

    $shs_id = $rowsId["shs_id"];

    // 2. 查詢圖片資料
    $sqlImg = "SELECT * FROM vinyl_img WHERE shs_id = ?";
    $stmtImg = $pdo->prepare($sqlImg);
    $stmtImg->execute([$shs_id]);
    $rowsImg = $stmtImg->fetchAll(PDO::FETCH_ASSOC);

    // 3. 刪除圖片檔案
    if (count($rowsImg) > 0) {
        foreach ($rowsImg as $img) {
            $oldImgPath = "./img/{$img["img_name"]}";
            if (file_exists($oldImgPath)) {
                unlink($oldImgPath);
            }
        }
    }

    // 4. 刪除圖片資料
    $sqlImgData = "DELETE FROM vinyl_img WHERE shs_id = ?";
    $stmtDataImg = $pdo->prepare($sqlImgData);
    $stmtDataImg->execute([$shs_id]);

    // 5. 刪除 vinyl 資料
    $sql = "DELETE FROM vinyl WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "<br>";
    exit;
}
alertGoTo("刪除黑膠唱片成功", "./index.php");


?>