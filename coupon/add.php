<?php

require_once "./connect.php";
require_once "./Utilities.php";

// 定義狀態映射
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
        <h1>新增優惠卷</h1>
        <form action="./doAdd.php" method="post" enctype="multipart/form-data">
            <div class="input-group mb-1">
                <span class="input-group-text">優惠卷名稱</span>
                <input name="name" type="text" class="form-control" placeholder="優惠卷名稱">
            </div>

            <div class="input-group mb-1">
                <span class="input-group-text">優惠碼</span>
                <input name="code" type="text" class="form-control" placeholder="優惠碼設定">
            </div>

            <div class="input-group mb-1">
                <span class="input-group-text">優惠卷說明</span>
                <input name="content" type="text" class="form-control" placeholder="優惠描述" rows="3">
            </div>

            <div class="input-group mb-1">
                <span class="input-group-text">狀態</span>
                <select name="status" class="form-select">
                    <option value="" selected disabled>請選擇</option>
                    <?php foreach ($statusMap as $value => $displayText): ?>
                        <option value="<?= htmlspecialchars($value) ?>"><?= htmlspecialchars($displayText) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="input-group mb-1">
                <span class="input-group-text">總發放數量</span>
                <input name="total_quantity" type="number" class="form-control" placeholder="總發放數量">
            </div>

            <!-- <div class="input-group mb-1">
                <span class="input-group-text">每人限領張數</span>
                <input name="per_user_limit" type="number" class="form-control" placeholder="每人限領張數">
            </div> -->

            <div class="input-group mb-1">
                <span class="input-group-text">每張可用次數</span>
                <input name="uses_per_instance" type="number" class="form-control" placeholder="每張可用次數">
            </div>

            <div class="input-group mb-1">
                <span class="input-group-text">開始時間</span>
                <input name="start_at" type="datetime-local" class="form-control">
                <span class="input-group-text">結束時間</span>
                <input name="end_at" type="datetime-local" class="form-control">
            </div>

            <!-- 規則區 -->
            <h2 class="mt-4 h5">優惠條件</h2>
            <div class="input-group mb-1">
                <span class="input-group-text">低消門檻</span>
                <input name="min_spend" type="number" class="form-control" placeholder="可不填寫，為無門檻">
            </div>
            <div class="input-group mb-1">
                <span class="input-group-text">折扣類型</span>

                <select name="discount_type" class="form-select">
                    <option value="" selected disabled>請選擇</option>
                    <?php foreach ($discountTypeMap as $value => $displayText): ?>
                        <option value="<?= htmlspecialchars($value) ?>"><?= htmlspecialchars($displayText) ?></option>
                    <?php endforeach; ?>
                </select>

                <span class="input-group-text">折扣值(整數)</span>
                <input name="discount_value" type="number" class="form-control" placeholder="折扣金額 或 百分比(例:10為10%)">

                <span class="input-group-text">最大折扣金額</span>
                <input name="max_discount_amount" type="number" class="form-control" placeholder="可不填寫，為無上限">
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
    <script>
        const targetProductMapJs = <?= json_encode($targetProductMap) ?>;
        const targetMemberMapJs = <?= json_encode($targetMemberMap) ?>;

        document.addEventListener('DOMContentLoaded', function () {
            const targetTypeSelect = document.getElementById('target_type_select');
            const targetValueGroup = document.getElementById('target_value_group');
            const targetValueSelect = document.getElementById('target_value_select');

            targetTypeSelect.addEventListener('change', function () {
                const selectedType = this.value;

                // Reset target_value select
                targetValueSelect.innerHTML = '<option value="" selected disabled>請選擇</option>'; // Clear previous options and add default
                targetValueSelect.disabled = true;

                let optionsMap = null;

                if (selectedType === 'product') {
                    optionsMap = targetProductMapJs;
                } else if (selectedType === 'member') {
                    optionsMap = targetMemberMapJs;
                }

                if (optionsMap) {
                    for (const value in optionsMap) {
                        if (optionsMap.hasOwnProperty(value)) {
                            const option = document.createElement('option');
                            option.value = value;
                            option.textContent = optionsMap[value];
                            targetValueSelect.appendChild(option);
                        }
                    }
                    targetValueSelect.disabled = false;
                }
            });
        });
    </script>
</body>

</html>