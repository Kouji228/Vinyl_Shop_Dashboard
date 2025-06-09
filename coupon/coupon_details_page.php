<?php
require_once "./connect.php";
require_once "./Utilities.php"; // 用於 alertGoTo 等函式

if (!isset($_GET["id"])) {
    alertGoTo("請從正常管道進入", "./index.php");
    exit;
}

$id = $_GET["id"];

$discountTypeMap = [
    'fixed' => '固定金額',
    'percent' => '百分比'
];

// 用於顯示文字的映射
$statusMap = [
    'active' => '生效中',
    'pending' => '待上架',
    'inactive' => '已停用'
];


$sql = "SELECT c.*, 
               cr.id AS rule_id, cr.min_spend, cr.discount_type, cr.discount_value, cr.max_discount_amount, cr.free_shipping 
        FROM `coupons` c
        LEFT JOIN `coupon_rules` cr ON c.id = cr.coupon_id
        WHERE c.`id` = ? AND c.`is_valid` = 1"; // 假設只顯示 is_valid = 1 的優惠卷

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $coupon = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$coupon) {
        alertGoTo("找不到指定的優惠卷或已被刪除。", "./index.php");
        exit;
    }

    // 準備顯示用的文字
    $coupon['status_text'] = $statusMap[$coupon['status']] ?? '未知狀態';
    if ($coupon['rule_id'] && isset($coupon['discount_type'])) { // 檢查 discount_type 是否存在
        $coupon['discount_type_text'] = $discountTypeMap[$coupon['discount_type']] ?? '未定義類型';
    }

} catch (PDOException $e) {
    alertGoTo("查詢資料時發生錯誤，請稍後再試。", "./index.php");
    exit;
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>優惠卷詳細資訊 - <?= htmlspecialchars($coupon['name'] ?? '詳細資料') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-3 mb-5">
        <h1>優惠卷詳細資訊</h1>
        <div class="card">
            <div class="card-header">
                <h3><?= htmlspecialchars($coupon['name'] ?? 'N/A') ?></h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="card-title mb-3">基本資料</h5>
                        <dl class="row">
                            <dt class="col-sm-4">ID:</dt>
                            <dd class="col-sm-8"><?= htmlspecialchars($coupon['id']) ?></dd>

                            <dt class="col-sm-4">優惠碼:</dt>
                            <dd class="col-sm-8"><?= htmlspecialchars($coupon['code'] ?? '無') ?></dd>

                            <dt class="col-sm-4">說明:</dt>
                            <dd class="col-sm-8"><?= nl2br(htmlspecialchars($coupon['content'] ?? '無')) ?></dd>

                            <dt class="col-sm-4">狀態:</dt>
                            <dd class="col-sm-8"><?= htmlspecialchars($coupon['status_text']) ?></dd>

                            <dt class="col-sm-4">總發放數量:</dt>
                            <dd class="col-sm-8"><?= $coupon['total_quantity'] !== null ? htmlspecialchars($coupon['total_quantity']) : '未設定' ?></dd>

                            <dt class="col-sm-4">每張可用次數:</dt>
                            <dd class="col-sm-8"><?= $coupon['uses_per_instance'] !== null ? htmlspecialchars($coupon['uses_per_instance']) : '未設定' ?></dd>

                            <dt class="col-sm-4">開始時間:</dt>
                            <dd class="col-sm-8"><?= htmlspecialchars($coupon['start_at'] ?? '未設定') ?></dd>

                            <dt class="col-sm-4">結束時間:</dt>
                            <dd class="col-sm-8"><?= htmlspecialchars($coupon['end_at'] ?? '未設定') ?></dd>

                            <dt class="col-sm-4">建立時間:</dt>
                            <dd class="col-sm-8"><?= htmlspecialchars($coupon['created_at'] ?? 'N/A') ?></dd>

                            <dt class="col-sm-4">最後更新時間:</dt>
                            <dd class="col-sm-8"><?= htmlspecialchars($coupon['updated_at'] ?? 'N/A') ?></dd>
                        </dl>
                    </div>
                    <div class="col-md-6">
                        <h5 class="card-title mb-3">優惠條件</h5>
                        <?php if ($coupon['rule_id']): ?>
                            <dl class="row">
                                <dt class="col-sm-5">規則 ID:</dt>
                                <dd class="col-sm-7"><?= htmlspecialchars($coupon['rule_id']) ?></dd>

                                <dt class="col-sm-5">最低消費門檻:</dt>
                                <dd class="col-sm-7"><?= $coupon['min_spend'] !== null ? htmlspecialchars($coupon['min_spend']) . ' 元' : '無門檻' ?></dd>

                                <dt class="col-sm-5">折扣類型:</dt>
                                <dd class="col-sm-7"><?= htmlspecialchars($coupon['discount_type_text'] ?? '未設定') ?></dd>

                                <dt class="col-sm-5">折扣值:</dt>
                                <dd class="col-sm-7">
                                    <?= $coupon['discount_value'] !== null ? htmlspecialchars($coupon['discount_value']) : 'N/A' ?>
                                    <?= $coupon['discount_type'] === 'percent' ? '%' : ($coupon['discount_type'] === 'fixed' ? '元' : '') ?>
                                </dd>

                                <dt class="col-sm-5">最大折扣金額 (百分比時):</dt>
                                <dd class="col-sm-7">
                                    <?= ($coupon['discount_type'] === 'percent' && $coupon['max_discount_amount'] !== null) ? htmlspecialchars($coupon['max_discount_amount']) . ' 元' : '無上限' ?>
                                </dd>

                                <dt class="col-sm-5">免運費:</dt>
                                <dd class="col-sm-7"><?= $coupon['free_shipping'] == 1 ? '是' : '否' ?></dd>
                            </dl>
                        <?php else: ?>
                            <p>未設定優惠條件。</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="card-footer text-muted">
                <a href="./index.php" class="btn btn-primary">返回列表</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"></script>
</body>

</html>