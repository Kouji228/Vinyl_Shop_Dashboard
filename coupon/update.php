<?php
require_once "./connect.php";
require_once "./Utilities.php";

if (!isset($_GET["id"])) {
    alertGoTo("請從正常管道進入", "./index.php");
    exit;
}

$statusMap = [
    'pending' => '待上架',
    'active' => '生效中',
    'inactive' => '已停用'
];
// 定義折扣類型映射
$discountTypeMap = [
    'fixed' => '固定金額',
    'percent' => '百分比'
];
// 定義免運費選項映射
$freeShippingMap = [
    '0' => '否',
    '1' => '是'
];

$targetTypeMap = [
    'product' => '產品類型',
    'member' => '會員行為'
];

$targetProductMap = [
    '99' => '全品項',
    '1' => '古典',
    '2' => '發燒',
    '3' => '爵士',
    '4' => '西洋',
    '5' => '華語',
    '6' => '日韓',
    '7' => '原聲帶'
];

$targetMemberMap = [
    'm0' => '生日',
    'm1' => '周年禮金',
    'm2' => '回饋金',
    'm3' => 'VIP贈送'
];

$id = $_GET["id"];
// 修改 SQL 以獲取優惠卷及其規則
$sql = "SELECT coupons.*, 
               coupon_rules.id AS rule_id, coupon_rules.min_spend, coupon_rules.discount_type, coupon_rules.discount_value, coupon_rules.max_discount_amount, coupon_rules.free_shipping 
        FROM `coupons`
        LEFT JOIN `coupon_rules` ON coupons.id = coupon_rules.coupon_id
        WHERE coupons.`is_valid` = 1 AND coupons.`id` = ?";
try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$row) {
        alertGoTo("沒有這張優惠卷", "./");
    }
} catch (PDOException $e) {
    echo "錯誤: {{$e->getMessage()}}";
    exit;
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>新增優惠卷</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-3">
        <h1>修改優惠卷</h1>
        <form action="./doUpdate.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $row["id"] ?>">
            <input type="hidden" name="rule_id" value="<?= $row["rule_id"] ?>">
            <div class="input-group mb-1">
                <span class="input-group-text">優惠卷名稱</span>
                <input value="<?= $row["name"] ?>" name="name" type="text" class="form-control" placeholder="優惠卷名稱">
            </div>

            <div class="input-group mb-1">
                <span class="input-group-text">優惠碼</span>
                <input value="<?= $row["code"] ?>" name="code" type="text" class="form-control" placeholder="優惠碼設定">
            </div>

            <div class="input-group mb-1">
                <span class="input-group-text">優惠卷說明</span>
                <input value="<?= $row["content"] ?>" name="content" type="text" class="form-control" placeholder="優惠描述"
                    rows="3">
            </div>

            <div class="input-group mb-1">
                <span class="input-group-text">狀態</span>
                <select name="status" class="form-select">
                    <option value="" disabled <?= (!isset($row["status"]) || $row["status"] === "") ? "selected" : "" ?>>
                        請選擇</option>
                    <?php foreach ($statusMap as $value => $displayText): ?>
                        <option value="<?= htmlspecialchars($value) ?>" <?= (($row["status"] ?? '') === $value) ? "selected" : "" ?>>
                            <?= htmlspecialchars($displayText) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="input-group mb-1">
                <span class="input-group-text">總發放數量</span>
                <input value="<?= $row["total_quantity"] ?>" name="total_quantity" type="number" class="form-control"
                    placeholder="總發放數量">
            </div>

            <!-- <div class="input-group mb-1">
                <span class="input-group-text">每人限領張數</span>
                <input name="per_user_limit" type="number" class="form-control" placeholder="每人限領張數">
            </div> -->

            <div class="input-group mb-1">
                <span class="input-group-text">每張可用次數</span>
                <input value="<?= $row["uses_per_instance"] ?>" name="uses_per_instance" type="number"
                    class="form-control" placeholder="每張可用次數">
            </div>

            <div class="input-group mb-1">
                <span class="input-group-text">開始時間</span>
                <input value="<?= $row["start_at"] ?>" name="start_at" type="datetime-local" class="form-control">
                <span class="input-group-text">結束時間</span>
                <input value="<?= $row["end_at"] ?>" name="end_at" type="datetime-local" class="form-control">

            </div>

            <!-- 規則區 -->
            <h2 class="mt-4 h5">優惠條件</h2>
            <div class="input-group mb-1">
                <span class="input-group-text">低消門檻</span>
                <input name="min_spend" type="number" class="form-control" placeholder="可不填寫，為無門檻 "
                    value="<?= htmlspecialchars($row['min_spend'] ?? '') ?>">
            </div>
            <div class="input-group mb-1">
                <span class="input-group-text">折扣類型</span>
                <select name="discount_type" class="form-select">
                    <option value="" <?= !isset($row['discount_type']) || $row['discount_type'] === '' ? 'selected' : '' ?>
                        disabled>請選擇</option>
                    <?php foreach ($discountTypeMap as $value => $displayText): ?>
                        <option value="<?= htmlspecialchars($value) ?>" <?= (($row["discount_type"] ?? '') === $value) ? "selected" : "" ?>>
                            <?= htmlspecialchars($displayText) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <span class="input-group-text">折扣值(整數)</span>
                <input name="discount_value" type="number" class="form-control" placeholder="折扣金額 或 百分比(例:10為10%)"
                    value="<?= htmlspecialchars($row['discount_value'] ?? '') ?>">

                <span class="input-group-text">最大折扣金額</span>
                <input name="max_discount_amount" type="number" class="form-control" placeholder="可不填寫，為無上限 "
                    value="<?= htmlspecialchars($row['max_discount_amount'] ?? '') ?>">
            </div>

            <div class="input-group mb-1">
                <span class="input-group-text">免運費</span>
                <select name="free_shipping" class="form-select">
                    <?php foreach ($freeShippingMap as $value => $displayText): ?>
                        <option value="<?= htmlspecialchars($value) ?>" <?= ((string) ($row["free_shipping"] ?? '0') === $value) ? "selected" : "" ?>>
                            <?= htmlspecialchars($displayText) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="input-group mb-1">
                <span class="input-group-text">免運費</span>
                <select name="free_shipping" class="form-select">
                    <?php foreach ($freeShippingMap as $value => $displayText): ?>
                        <option value="<?= htmlspecialchars($value) ?>" <?= ($value === '0') ? 'selected' : '' ?>>
                            <?= htmlspecialchars($displayText) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            
            <div class="input-group mb-1">
                <span class="input-group-text">限制類型</span>
                <select name="target_type" id="target_type_select" class="form-select">
                    <option value="" selected disabled>請選擇</option>
                    <?php foreach ($targetTypeMap as $value => $displayText): ?>
                        <option value="<?= htmlspecialchars($value) ?>"><?= htmlspecialchars($displayText) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Dynamic Sub-type based on Target Type -->
            <div id="target_value_group" class="input-group mb-1">
                <span class="input-group-text">次類型</span>
                <select name="target_value" id="target_value_select" class="form-select">
                    <option value="" selected disabled>請選擇</option>
                    <!-- Options will be populated by JavaScript -->
                </select>
            </div>
            <!-- 規則區 -->

            <div class="mt-1 text-end">
                <button type="submit" class="btn btn-info btn-send">送出</button>
                <a class="btn btn-primary" href="./index.php">取消</a>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"></script>
</body>

</html>