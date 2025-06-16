<?php

require_once "../components/connect.php";
require_once "../components/Utilities.php";
require_once "./couponMaps.php"; // 引入共用的 Map 陣列

$pageTitle = "新增優惠卷";
$cssList = ["../css/index.css", "../css/add.css", "./coupon.css"];
include "../vars.php";
include "../template_top.php";
include "../template_main.php";

?>
<div class="content-section">
    <div class="section-header">
        <h3 class="section-title">新增優惠卷</h3>
        <a href="./index.php" class="btn btn-secondary">返回列表</a>
    </div>

    <form action="./doAdd.php" method="post" enctype="multipart/form-data">
        <div class="form-section">
            <h4 class="form-section-title">基本資訊</h4>
            <div class="form-row">
                <div class="form-group">
                    <label for="couponName" class="form-label required">優惠卷名稱</label>
                    <input id="couponName" name="name" type="text" class="form-control" placeholder="優惠卷名稱" required>
                </div>
                <div class="form-group">
                    <label for="couponCode" class="form-label">優惠碼 (不可重複)</label>
                    <input id="couponCode" name="code" type="text" class="form-control" placeholder="優惠碼設定 (可選)">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group full-width">
                    <label for="couponContent" class="form-label">優惠卷說明</label>
                    <textarea id="couponContent" name="content" class="form-control" placeholder="優惠內容描述"
                        rows="3"></textarea>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="couponStatus" class="form-label required">狀態</label>
                    <select id="couponStatus" name="status" class="form-select" required>
                        <option value="" selected disabled>請選擇</option>
                        <?php foreach ($statusMap as $value => $displayText): ?>
                            <option value="<?= htmlspecialchars($value) ?>"><?= htmlspecialchars($displayText) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="couponTotalQuantity" class="form-label required">總發放數量</label>
                    <input id="couponTotalQuantity" name="total_quantity" type="number" class="form-control"
                        placeholder="總發放數量" required min="0">
                </div>
                <div class="form-group">
                    <label for="couponUsesPerInstance" class="form-label required">每張可用次數</label>
                    <input id="couponUsesPerInstance" name="uses_per_instance" type="number" class="form-control"
                        placeholder="每張可用次數" required min="0">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="couponStartAt" class="form-label">開始時間</label>
                    <input id="couponStartAt" name="start_at" type="datetime-local" class="form-control">
                </div>
                <div class="form-group">
                    <label for="couponEndAt" class="form-label">結束時間</label>
                    <input id="couponEndAt" name="end_at" type="datetime-local" class="form-control">
                </div>
            </div>
        </div>

        <div class="form-section">
            <h4 class="form-section-title">優惠條件</h4>
            <div class="form-row">
                <div class="form-group">
                    <label for="ruleMinSpend" class="form-label">低消門檻</label>
                    <input id="ruleMinSpend" name="min_spend" type="number" class="form-control" placeholder="可不填寫，為無門檻"
                        min="0">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="ruleDiscountType" class="form-label required">折扣類型</label>
                    <select id="ruleDiscountType" name="discount_type" class="form-select" required>
                        <option value="" selected disabled>請選擇</option>
                        <?php foreach ($discountTypeMap as $value => $displayText): ?>
                            <option value="<?= htmlspecialchars($value) ?>"><?= htmlspecialchars($displayText) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="ruleDiscountValue" class="form-label required">折扣值 (整數)</label>
                    <input id="ruleDiscountValue" name="discount_value" type="number" class="form-control"
                        placeholder="金額或百分比(例:10為10%為9折)" required>
                </div>
                <div class="form-group">
                    <label for="ruleMaxDiscountAmount" class="form-label">最大折扣金額</label>
                    <input id="ruleMaxDiscountAmount" name="max_discount_amount" type="number" class="form-control"
                        placeholder="百分比折扣時適用 (可選)" min="0">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="ruleFreeShipping" class="form-label">免運費</label>
                    <select id="ruleFreeShipping" name="free_shipping" class="form-select">
                        <?php foreach ($freeShippingMap as $value => $displayText): ?>
                            <option value="<?= htmlspecialchars($value) ?>" <?= ($value === '0') ? 'selected' : '' ?>>
                                <?= htmlspecialchars($displayText) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-section">
            <h4 class="form-section-title">限制條件</h4>
            <div class="form-row">
                <div class="form-group">
                    <label for="targetTypeSelect" class="form-label required">限制類型</label>
                    <select name="target_type" id="target_type_select" class="form-select" required>
                        <option value="" selected disabled>請選擇</option>
                        <?php foreach ($targetTypeMap as $value => $displayText): ?>
                            <option value="<?= htmlspecialchars($value) ?>"><?= htmlspecialchars($displayText) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="targetValueSelect" class="form-label required">次類型</label>
                    <select name="target_value" id="target_value_select" class="form-select" required disabled>
                        <option value="" selected disabled>請先選擇限制類型</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> 儲存優惠卷
            </button>
            <button type="reset" class="btn btn-secondary">
                <i class="fas fa-undo"></i> 重置
            </button>
            <a class="btn btn-danger" href="./index.php">
                <i class="fas fa-times"></i> 取消
            </a>
        </div>

    </form>
</div>

<script>
    // 將 PHP 陣列轉換為 JavaScript 可用的物件
    const targetProductMapJs = <?= json_encode($targetProductMap) ?>;
    const targetMemberMapJs = <?= json_encode($targetMemberMap) ?>;

    document.addEventListener('DOMContentLoaded', function () {
        const targetTypeSelect = document.getElementById('target_type_select');
        const targetValueSelect = document.getElementById('target_value_select');

        // 當「限制類型」改變時，更新「次類型」的選項
        targetTypeSelect.addEventListener('change', function () {
            const selectedType = this.value;

            // 清空並禁用次類型選單
            targetValueSelect.innerHTML = '<option value="" selected disabled>請選擇</option>';
            targetValueSelect.disabled = true;

            let optionsMap = null;
            if (selectedType === 'product') {
                optionsMap = targetProductMapJs;
            } else if (selectedType === 'member') {
                optionsMap = targetMemberMapJs;
            }

            // 如果有對應的選項，則填入並啟用選單
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
<?php
include "../template_btm.php";
?>