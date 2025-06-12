<?php
require_once "../components/connect.php";
require_once "../components/Utilities.php";

// 檢查請求來源是否正常
if (!isset($_POST["name"])) {
    alertGoTo("請從正常管道進入", "./index.php");
    exit();
}

// --- 1. 資料接收與整理 ---
// 使用 null coalescing operator (??) 和三元運算符來簡化資料接收
$couponData = [
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
    'min_spend' => empty($_POST["min_spend"]) ? null : (int) $_POST["min_spend"],
    'discount_type' => $_POST["discount_type"] ?? null,
    'discount_value' => isset($_POST["discount_value"]) && is_numeric($_POST["discount_value"]) ? (int) $_POST["discount_value"] : null,
    'max_discount_amount' => empty($_POST["max_discount_amount"]) ? null : (int) $_POST["max_discount_amount"],
    'free_shipping' => isset($_POST["free_shipping"]) ? (int) $_POST["free_shipping"] : 0
];

$targetData = [
    'target_type' => $_POST["target_type"] ?? null,
    'target_value' => $_POST["target_value"] ?? null
];


// --- 2. 資料驗證 ---
// 將驗證邏輯集中，使流程更清晰
if (empty($couponData['name'])) {
    alertAndBack("請輸入優惠卷名稱");
    exit;
}
if (empty($couponData['status'])) {
    alertAndBack("請選擇狀態");
    exit;
}
if ($couponData['total_quantity'] === null || $couponData['total_quantity'] < 0) {
    alertAndBack("請設定有效的總發放數 (必須大於等於 0)");
    exit;
}
if ($couponData['uses_per_instance'] === null || $couponData['uses_per_instance'] < 0) {
    alertAndBack("請設定有效的單張可用次數 (必須大於等於 0)");
    exit;
}

// 規則相關驗證
if ($ruleData['discount_type']) {
    if ($ruleData['discount_value'] === null) {
        alertAndBack("選擇折扣類型後，請填寫折扣值。");
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
} elseif ($ruleData['discount_value'] !== null) {
    alertAndBack("請先選擇折扣類型，再填寫折扣值。");
    exit;
}
if ($ruleData['min_spend'] !== null && $ruleData['min_spend'] < 0) {
    alertAndBack("「低消門檻」不能為負數。");
    exit;
}
if ($ruleData['max_discount_amount'] !== null && $ruleData['max_discount_amount'] < 0) {
    alertAndBack("「最大折扣金額」不能為負數。");
    exit;
}

// 限制條件相關驗證
if ($targetData['target_type'] && empty($targetData['target_value'])) {
    alertAndBack("選擇限制類型後，請選擇次類型。");
    exit;
}
if (empty($targetData['target_type']) && $targetData['target_value']) {
    alertAndBack("請先選擇限制類型，再選擇次類型。");
    exit;
}


// --- 3. 資料庫操作 (使用交易) ---
try {
    // 開始交易
    $pdo->beginTransaction();

    // 步驟 A: 檢查優惠碼是否唯一 (如果使用者有輸入)
    if ($couponData['code'] !== null) {
        $sqlCodeCheck = "SELECT COUNT(*) FROM `coupons` WHERE `code` = ?";
        $stmtCode = $pdo->prepare($sqlCodeCheck);
        $stmtCode->execute([$couponData['code']]);
        if ($stmtCode->fetchColumn() > 0) {
            // 因為此錯誤非系統異常，而是使用者輸入問題，所以可以自行 rollback 並提示
            $pdo->rollBack();
            alertAndBack("錯誤：優惠碼 '{$couponData['code']}' 已經存在，請使用不同的優惠碼。");
            exit;
        }
    }

    // 步驟 B: 新增資料到 coupons 資料表
    $sqlCoupon = "INSERT INTO `coupons` (`name`, `code`, `content`, `status`, `total_quantity`, `uses_per_instance`, `start_at`, `end_at`) 
                  VALUES (:name, :code, :content, :status, :total_quantity, :uses_per_instance, :start_at, :end_at)";
    $stmtCoupon = $pdo->prepare($sqlCoupon);
    $stmtCoupon->execute($couponData);
    $couponId = $pdo->lastInsertId(); // 取得剛剛新增的 coupon ID

    // 步驟 C: 如果有規則資料，新增到 coupon_rules 資料表
    if ($ruleData['discount_type'] !== null) {
        $ruleData['coupon_id'] = $couponId; // 注入關聯的 coupon_id
        $sqlRule = "INSERT INTO `coupon_rules` 
                        (`coupon_id`, `min_spend`, `discount_type`, `discount_value`, `max_discount_amount`, `free_shipping`) 
                    VALUES (:coupon_id, :min_spend, :discount_type, :discount_value, :max_discount_amount, :free_shipping)";
        $stmtRule = $pdo->prepare($sqlRule);
        $stmtRule->execute($ruleData);
    }

    // 步驟 D: 如果有目標資料，新增到 coupon_targets 資料表
    if ($targetData['target_type'] !== null) {
        $targetData['coupon_id'] = $couponId; // 注入關聯的 coupon_id
        $sqlTarget = "INSERT INTO `coupon_targets` (`coupon_id`, `target_type`, `target_value`) 
                      VALUES (:coupon_id, :target_type, :target_value)";
        $stmtTarget = $pdo->prepare($sqlTarget);
        $stmtTarget->execute($targetData);
    }

    // 若以上操作都成功，提交交易
    $pdo->commit();

    alertGoTo("新增資料成功", "./index.php");

} catch (PDOException $e) {
    // 若發生任何資料庫錯誤，撤銷交易
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    // 實際應用中應記錄錯誤日誌
    alertAndBack("新增資料失敗：" . $e->getMessage());
    exit;
}