<?php
require_once "../components/connect.php";
require_once "../components/Utilities.php";

// 檢查請求來源是否正常
if (!isset($_POST["id"])) {
    alertGoTo("請從正常管道進入", "./index.php");
    exit();
}

// --- 1. 資料接收與整理 ---
$id = (int) $_POST['id'];

$couponData = [
    'id' => $id,
    'name' => $_POST["name"] ?? '',
    'code' => empty($_POST["code"]) ? null : $_POST["code"],
    'content' => $_POST["content"] ?? null,
    'status' => $_POST["status"] ?? '',
    'total_quantity' => isset($_POST["total_quantity"]) && is_numeric($_POST["total_quantity"]) ? (int) $_POST["total_quantity"] : null,
    'uses_per_instance' => isset($_POST["uses_per_instance"]) && is_numeric($_POST["uses_per_instance"]) ? (int) $_POST["uses_per_instance"] : null,
    'start_at' => empty($_POST["start_at"]) ? null : $_POST["start_at"],
    'end_at' => empty($_POST["end_at"]) ? null : $_POST["end_at"]
];

$ruleData = [
    'coupon_id' => $id,
    'min_spend' => empty($_POST["min_spend"]) ? null : (int) $_POST["min_spend"],
    'discount_type' => $_POST["discount_type"] ?? '', // 設為必填
    'discount_value' => isset($_POST["discount_value"]) && is_numeric($_POST["discount_value"]) ? (int) $_POST["discount_value"] : null,
    'max_discount_amount' => empty($_POST["max_discount_amount"]) ? null : (int) $_POST["max_discount_amount"],
    'free_shipping' => isset($_POST["free_shipping"]) ? (int) $_POST["free_shipping"] : 0
];

$targetData = [
    'coupon_id' => $id,
    'target_type' => $_POST["target_type"] ?? '', // 設為必填
    'target_value' => $_POST["target_value"] ?? '' // 設為必填
];

// --- 2. 資料驗證 ---
// 驗證邏輯與 doAdd.php 基本一致，因為現在都是必填項
if (empty($couponData['name'])) {
    alertAndBack("請輸入優惠卷名稱");
    exit;
}
if (empty($couponData['status'])) {
    alertAndBack("請選擇狀態");
    exit;
}
// ... 此處可加入與 doAdd.php 相同的其他 couponData 驗證 ...

// 規則相關驗證 (因為是必填，所以邏輯更簡單)
if (empty($ruleData['discount_type'])) {
    alertAndBack("請選擇折扣類型。");
    exit;
}
if ($ruleData['discount_value'] === null) {
    alertAndBack("請填寫折扣值。");
    exit;
}
if ($ruleData['discount_type'] === 'percent' && ($ruleData['discount_value'] <= 0 || $ruleData['discount_value'] > 100)) {
    alertAndBack("百分比折扣的折扣值須介於 1 到 100 之間。");
    exit;
}
if ($ruleData['discount_type'] === 'fixed' && $ruleData['discount_value'] <= 0) {
    alertAndBack("固定金額折扣的折扣值必須大於 0。");
    exit;
}

// 限制條件相關驗證
if (empty($targetData['target_type']) || empty($targetData['target_value'])) {
    alertAndBack("請完整選擇限制類型與次類型。");
    exit;
}


// --- 3. 資料庫操作 (使用交易) ---
try {
    // 開始交易
    $pdo->beginTransaction();

    // 步驟 A: 檢查優惠碼是否唯一 (需排除自己)
    if ($couponData['code'] !== null) {
        $sqlCodeCheck = "SELECT COUNT(*) FROM `coupons` WHERE `code` = :code AND `id` != :id";
        $stmtCode = $pdo->prepare($sqlCodeCheck);
        $stmtCode->execute([':code' => $couponData['code'], ':id' => $id]);
        if ($stmtCode->fetchColumn() > 0) {
            $pdo->rollBack();
            alertAndBack("錯誤：優惠碼 '{$couponData['code']}' 已經存在，請使用不同的優惠碼。");
            exit;
        }
    }

    // 步驟 B: 更新 coupons 資料表
    $sqlCoupon = "UPDATE `coupons` SET 
                    `name` = :name, `code` = :code, `content` = :content, `status` = :status, 
                    `total_quantity` = :total_quantity, `uses_per_instance` = :uses_per_instance, 
                    `start_at` = :start_at, `end_at` = :end_at
                  WHERE `id` = :id";
    $stmtCoupon = $pdo->prepare($sqlCoupon);
    $stmtCoupon->execute($couponData);

    // 步驟 C: 更新 coupon_rules 資料表
    $sqlRule = "UPDATE `coupon_rules` SET 
                    `min_spend` = :min_spend, `discount_type` = :discount_type, 
                    `discount_value` = :discount_value, `max_discount_amount` = :max_discount_amount, 
                    `free_shipping` = :free_shipping
                WHERE `coupon_id` = :coupon_id";
    $stmtRule = $pdo->prepare($sqlRule);
    $stmtRule->execute($ruleData);

    // 步驟 D: 更新 coupon_targets 資料表
    $sqlTarget = "UPDATE `coupon_targets` SET 
                    `target_type` = :target_type, `target_value` = :target_value 
                  WHERE `coupon_id` = :coupon_id";
    $stmtTarget = $pdo->prepare($sqlTarget);
    $stmtTarget->execute($targetData);

    // 若以上操作都成功，提交交易
    $pdo->commit();

    // 成功後跳轉回原編輯頁面，方便使用者查看結果
    alertGoTo("修改資料成功", "./update.php?id={$id}");

} catch (PDOException $e) {
    // 若發生任何資料庫錯誤，撤銷交易
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    alertAndBack("修改資料失敗：" . $e->getMessage());
    exit;
}