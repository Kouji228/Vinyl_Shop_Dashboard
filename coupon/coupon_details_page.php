<?php
require_once "../components/connect.php";
require_once "../components/Utilities.php";
require_once "./couponMaps.php";

// --- 樣板需要的設定 ---
$pageTitle = "優惠卷詳細資訊";
// 確保載入 index.css 和 coupon.css
$cssList = ["../css/index.css", "./coupon.css"];
include "../vars.php";
include "../template_top.php";
include "../template_main.php";

// --- PHP 資料處理邏輯 (與先前版本相同) ---
if (!isset($_GET["id"])) {
    alertGoTo("請從正常管道進入", "./index.php");
    exit;
}
$id = $_GET["id"];

$sql = "SELECT coupons.*, 
               coupon_rules.id AS rule_id, coupon_rules.min_spend, coupon_rules.discount_type, 
               coupon_rules.discount_value, coupon_rules.max_discount_amount, coupon_rules.free_shipping,
               coupon_targets.target_type, coupon_targets.target_value
        FROM `coupons`
        LEFT JOIN `coupon_rules` ON coupons.id = coupon_rules.coupon_id
        LEFT JOIN `coupon_targets` ON coupons.id = coupon_targets.coupon_id
        WHERE coupons.id = ? AND coupons.is_valid = 1";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $coupon = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$coupon) {
        alertGoTo("找不到指定的優惠卷或已被刪除。", "./index.php");
        exit;
    }

    $display = [];
    $display['status'] = $statusMap[$coupon['status']] ?? '未知狀態';
    $display['start_at'] = $coupon['start_at'] ? date('Y-m-d H:i', strtotime($coupon['start_at'])) : '未設定';
    $display['end_at'] = $coupon['end_at'] ? date('Y-m-d H:i', strtotime($coupon['end_at'])) : '未設定';
    $display['code'] = $coupon['code'] ?? '無';
    $display['content'] = nl2br(htmlspecialchars($coupon['content'] ?? '無'));

    if ($coupon['rule_id']) {
        $display['min_spend'] = $coupon['min_spend'] !== null ? '$' . number_format($coupon['min_spend']) . ' 元' : '無門檻';
        $display['discount_type'] = $discountTypeMap[$coupon['discount_type']] ?? '未定義';
        if ($coupon['discount_value'] !== null) {
            $unit = ($coupon['discount_type'] === 'percent') ? '%' : '元';
            $display['discount_value'] = $coupon['discount_value'] . ' ' . $unit;
        } else {
            $display['discount_value'] = '未設定';
        }
        $display['max_discount_amount'] = ($coupon['discount_type'] === 'percent' && $coupon['max_discount_amount'] !== null) ? '$' . number_format($coupon['max_discount_amount']) . ' 元' : '無上限';
        $display['free_shipping'] = ($coupon['free_shipping'] == 1) ? '是' : '否';
    }

    if (!empty($coupon['target_type'])) {
        $display['target_type'] = $targetTypeMap[$coupon['target_type']] ?? '未定義類型';
        $map = ($coupon['target_type'] === 'product') ? $targetProductMap : (($coupon['target_type'] === 'member') ? $targetMemberMap : null);
        if ($map && isset($coupon['target_value'])) {
            $display['target_value'] = $map[$coupon['target_value']] ?? '未定義次類型';
        }
    }

} catch (PDOException $e) {
    alertGoTo("查詢資料時發生錯誤：" . $e->getMessage(), "./index.php");
    exit;
}
?>

<div class="content-section">
    <div class="section-header">
        <h3 class="section-title">優惠卷詳細資訊</h3>
        <a href="./index.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> 返回列表
        </a>
    </div>

    <div class="details-card">
        <div class="details-header">
            <h4 class="details-main-title"><?= htmlspecialchars($coupon['name'] ?? 'N/A') ?></h4>
        </div>
        <div class="details-body">
            <div class="details-grid">
                <div class="details-column">
                    <h5 class="details-section-title">基本資料</h5>
                    <dl class="details-list">
                        <dt>優惠碼</dt>
                        <dd><?= htmlspecialchars($display['code']) ?></dd>

                        <dt>狀態</dt>
                        <dd><?= htmlspecialchars($display['status']) ?></dd>

                        <dt>總發放數量</dt>
                        <dd><?= htmlspecialchars($coupon['total_quantity'] ?? '未設定') ?></dd>

                        <dt>每張可用次數</dt>
                        <dd><?= htmlspecialchars($coupon['uses_per_instance'] ?? '未設定') ?></dd>

                        <dt>有效期間</dt>
                        <dd><?= htmlspecialchars($display['start_at']) ?> ~ <?= htmlspecialchars($display['end_at']) ?>
                        </dd>

                        <dt>優惠說明</dt>
                        <dd><?= $display['content'] ?></dd>
                    </dl>
                </div>
                <div class="details-column">
                    <h5 class="details-section-title">優惠與限制</h5>
                    <?php if (isset($coupon['rule_id'])): ?>
                        <dl class="details-list">
                            <dt>最低消費</dt>
                            <dd><?= htmlspecialchars($display['min_spend']) ?></dd>
                            <dt>折扣類型</dt>
                            <dd><?= htmlspecialchars($display['discount_type']) ?></dd>
                            <dt>折扣值</dt>
                            <dd><?= htmlspecialchars($display['discount_value']) ?></dd>
                            <dt>最高折抵</dt>
                            <dd><?= htmlspecialchars($display['max_discount_amount']) ?></dd>
                            <dt>免運費</dt>
                            <dd><?= htmlspecialchars($display['free_shipping']) ?></dd>
                        </dl>
                    <?php else: ?>
                        <p class="text-muted">未設定優惠條件。</p>
                    <?php endif; ?>

                    <?php if (isset($display['target_type'])): ?>
                        <dl class="details-list mt-4">
                            <dt>限制類型</dt>
                            <dd><?= htmlspecialchars($display['target_type']) ?></dd>
                            <?php if (isset($display['target_value'])): ?>
                                <dt>限制目標</dt>
                                <dd><?= htmlspecialchars($display['target_value']) ?></dd>
                            <?php endif; ?>
                        </dl>
                    <?php else: ?>
                        <p class="text-muted mt-4">未設定限制條件。</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// 引入統一的頁尾
include "../template_btm.php";
?>