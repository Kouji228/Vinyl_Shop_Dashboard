<?php
require_once "../components/connect.php";
require_once "../components/Utilities.php";

$pageTitle = "編輯會員";
$cssList = ["../css/index.css", "../css/add.css"];
include "../vars.php";
include "../template_top.php";
include "../template_main.php";

// 獲取會員ID
$id = isset($_GET['id']) ? $_GET['id'] : 0;

// 縣市資料
$sql = "SELECT * FROM `cities`";
$sql2 = "SELECT * FROM `districts` ORDER BY city_id, name";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt2 = $pdo->prepare($sql2);
    $stmt2->execute();
    $rows2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

    // 獲取會員資料
    $sql3 = "SELECT u.*, ui.img_path, ui.img_name 
             FROM users u 
             LEFT JOIN user_img ui ON u.id = ui.user_id 
             WHERE u.id = ?";
    $stmt3 = $pdo->prepare($sql3);
    $stmt3->execute([$id]);
    $user = $stmt3->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "找不到該會員資料<br>";
        echo "<a href='./index.php'>回會員列表</a>";
        exit;
    }

    // 獲取會員地址資料
    $sql4 = "SELECT * FROM user_addresses WHERE user_id = ?";
    $stmt4 = $pdo->prepare($sql4);
    $stmt4->execute([$id]);
    $addresses = $stmt4->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "系統錯誤，請恰管理人員<br>";
    echo "Error: {$e->getMessage()}<br>";
    echo "<a href='./index.php'>回會員列表</a>";
    exit;
}
?>

<style>
.address-item {
    background-color: #f8f9fa;
    padding: 15px;
    margin-bottom: 15px;
    border-radius: 5px;
    border: 1px solid #dee2e6;
}

.address-input-group {
    display: flex;
    gap: 10px;
    align-items: center;
}

.address-input-group input[type="text"] {
    flex: 1;
}

.address-actions {
    display: flex;
    align-items: center;
    gap: 15px;
}

.form-check {
    margin: 0;
    display: flex;
    align-items: center;
    gap: 5px;
}

.form-check-input {
    margin: 0;
}

.remove-address {
    padding: 6px 12px;
}

#addAddress {
    margin-top: 10px;
}
</style>

<div class="content-section">
    <div class="section-header">
        <h3 class="section-title">編輯會員</h3>
        <a href="./index.php" class="btn btn-secondary">回會員列表</a>
    </div>
    <form id="updateusers" action="./doupdate.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $user['id'] ?>">
        <div class="form-section">
            <h4 class="form-section-title">基本資訊</h4>
            <div class="form-row avatar-row">
                <div class="form-group avatar-group">
                    <label for="memberAvatar" class="form-label"></label>
                    <div class="avatar-upload-container">
                        <div class="avatar-preview">
                            <img id="avatarPreview" src="<?= !empty($user['img_path']) ? $user['img_path'] : './images/users_default.jpg' ?>" alt="">
                        </div>
                        <input type="file" id="memberAvatar" name="avatar" class="form-control" accept="image/*"
                            onchange="previewImage(this)">
                        <small class="form-text">支援 JPG、PNG、GIF 格式，檔案大小不超過 2MB</small>
                    </div>
                </div>
                <div class="form-group info-group">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="memberName" class="form-label required">會員姓名</label>
                            <input type="text" id="memberName" name="name" class="form-control" required value="<?= htmlspecialchars($user['name']) ?>">
                            <div class="error-message" id="nameError"></div>
                        </div>

                        <div class="form-group">
                            <label for="memberEmail" class="form-label required">Email</label>
                            <input type="email" id="memberEmail" name="email" class="form-control" required value="<?= htmlspecialchars($user['email']) ?>">
                            <div class="error-message" id="emailError"></div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="memberPhone" class="form-label">電話號碼</label>
                            <input type="tel" id="memberPhone" name="phone" class="form-control"
                                pattern="[0-9\-\+\s\(\)]{8,15}" placeholder="例：0912-345-678" value="<?= htmlspecialchars($user['phone']) ?>">
                            <div class="error-message" id="phoneError"></div>
                        </div>

                        <div class="form-group">
                            <label for="memberBirthday" class="form-label">生日</label>
                            <input type="date" id="memberBirthday" name="birthday" class="form-control" value="<?= $user['birthday'] ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="memberGender" class="form-label">性別</label>
                            <select id="memberGender" name="gender" class="form-control">
                                <option value="">請選擇</option>
                                <option value="男" <?= $user['gender'] == '男' ? 'selected' : '' ?>>男</option>
                                <option value="女" <?= $user['gender'] == '女' ? 'selected' : '' ?>>女</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="memberLevel" class="form-label required">會員等級</label>
                            <select id="memberLevel" name="level" class="form-control" required>
                                <option value="">請選擇等級</option>
                                <option value="一般會員" <?= $user['level'] == '一般會員' ? 'selected' : '' ?>>一般會員</option>
                                <option value="VIP會員" <?= $user['level'] == 'VIP會員' ? 'selected' : '' ?>>VIP會員</option>
                                <option value="黑膠收藏家" <?= $user['level'] == '黑膠收藏家' ? 'selected' : '' ?>>黑膠收藏家</option>
                            </select>
                            <div class="error-message" id="levelError"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-section">
            <h4 class="form-section-title">地址資訊</h4>

            <div class="form-row">
                <div class="form-group full-width">
                    <div id="addressList">
                        <?php foreach ($addresses as $index => $address): ?>
                        <div class="address-item">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="memberCity" class="form-label">縣市</label>
                                    <select name="city[]" class="form-control city-select" required>
                                        <option value="">請選擇縣市</option>
                                        <?php foreach ($rows as $row): ?>
                                            <option value="<?= $row["id"] ?>" <?= isset($address['city']) && $row["name"] == $address['city'] ? 'selected' : '' ?>><?= $row["name"] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="memberDistrict" class="form-label">區域</label>
                                    <select name="district[]" class="form-control district-select" required>
                                        <option value="">請選擇區域</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group full-width">
                                    <label for="memberAddress" class="form-label">詳細地址</label>
                                    <div class="address-input-group">
                                        <input type="text" name="address[]" class="form-control" placeholder="例：中山南路21號" value="<?= isset($address['address']) ? htmlspecialchars($address['address']) : '' ?>">
                                        <div class="address-actions">
                                            <div class="form-check">
                                                <input type="radio" name="default_address" value="<?= $index ?>" class="form-check-input" <?= isset($address['is_default']) && $address['is_default'] ? 'checked' : '' ?>>
                                                <label class="form-check-label">預設地址</label>
                                            </div>
                                            <button type="button" class="btn btn-danger remove-address" <?= $index === 0 ? 'style="display: none;"' : '' ?>>
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" class="btn btn-secondary" id="addAddress">
                        <i class="fas fa-plus"></i> 新增地址
                    </button>
                </div>
            </div>
        </div>

        <div class="form-section">
            <h4 class="form-section-title">帳戶設定</h4>

            <div class="form-row">
                <div class="form-group full-width">
                    <label for="memberAccount" class="form-label required">帳號</label>
                    <input type="email" id="memberAccount" name="account" class="form-control" required 
                           value="<?= htmlspecialchars($user['account']) ?>">
                    <div class="error-message" id="accountError"></div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="memberPassword" class="form-label">密碼</label>
                    <div class="password-field-container">
                        <input type="password" id="memberPassword" name="password" class="form-control" minlength="6"
                            placeholder="不修改請留空">
                        <button type="button" class="password-toggle">
                            <i class="fas fa-eye-slash"></i>
                        </button>
                    </div>
                    <div class="error-message" id="passwordError"></div>
                </div>

                <div class="form-group">
                    <label for="confirmPassword" class="form-label">確認密碼</label>
                    <div class="password-field-container">
                        <input type="password" id="confirmPassword" name="confirm_password" class="form-control">
                        <button type="button" class="password-toggle">
                            <i class="fas fa-eye-slash"></i>
                        </button>
                    </div>
                    <div class="error-message" id="confirmPasswordError"></div>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="button" class="btn btn-secondary" onclick="window.location.href='index.php'">
                <i class="fas fa-times"></i> 取消
            </button>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> 更新會員
            </button>
        </div>
    </form>
</div>

<script>
// 將 PHP 的區域資料轉換為 JavaScript 變數
const districts = <?= json_encode($rows2) ?>;
const addresses = <?= json_encode($addresses) ?>;

document.addEventListener('DOMContentLoaded', function() {
    // 初始化所有地址項目的區域選單
    document.querySelectorAll('.address-item').forEach((item, index) => {
        const citySelect = item.querySelector('.city-select');
        const districtSelect = item.querySelector('.district-select');
        const currentCity = citySelect.value;
        const currentDistrict = addresses[index] ? addresses[index].district : '';
        
        if (currentCity) {
            updateDistricts(currentCity, districtSelect, currentDistrict);
        }
    });

    // 縣市選擇事件
    document.querySelectorAll('.city-select').forEach(select => {
        select.addEventListener('change', function() {
            const districtSelect = this.closest('.address-item').querySelector('.district-select');
            updateDistricts(this.value, districtSelect);
        });
    });

    // 更新區域選單函數
    function updateDistricts(cityId, districtSelect, currentDistrict = '') {
        const filteredDistricts = districts.filter(district => district.city_id == cityId);
        districtSelect.innerHTML = "<option value=''>請選擇區域</option>";
        
        // 使用 Set 來追蹤已經添加的區域名稱
        const addedDistricts = new Set();
        
        filteredDistricts.forEach(district => {
            // 只有當區域名稱還沒有被添加過時才添加
            if (!addedDistricts.has(district.name)) {
                const option = document.createElement('option');
                option.value = district.name;
                option.textContent = district.name;
                if (district.name === currentDistrict) {
                    option.selected = true;
                }
                districtSelect.appendChild(option);
                addedDistricts.add(district.name);
            }
        });
    }

    // 圖片預覽功能
    function previewImage(input) {
        const preview = document.getElementById('avatarPreview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    document.getElementById('memberAvatar').addEventListener('change', function() {
        previewImage(this);
    });

    // Email 同步到帳號
    const emailInput = document.getElementById('memberEmail');
    const accountInput = document.getElementById('memberAccount');
    
    emailInput.addEventListener('input', function() {
        accountInput.value = this.value;
    });

    accountInput.addEventListener('input', function() {
        // 如果帳號被清空，則同步回 email 的值
        if (this.value === '') {
            this.value = emailInput.value;
        }
    });

    // 地址相關功能
    const addressList = document.getElementById('addressList');
    const addAddressBtn = document.getElementById('addAddress');

    // 新增地址
    addAddressBtn.addEventListener('click', function() {
        const addressItem = document.querySelector('.address-item').cloneNode(true);
        
        // 重置選擇和輸入值
        addressItem.querySelectorAll('select').forEach(select => {
            select.value = '';
        });
        addressItem.querySelector('input[type="text"]').value = '';
        
        // 更新預設地址radio的value
        const defaultAddressRadio = addressItem.querySelector('input[type="radio"]');
        defaultAddressRadio.value = addressList.children.length;
        defaultAddressRadio.checked = false;
        
        // 顯示刪除按鈕
        addressItem.querySelector('.remove-address').style.display = 'inline-block';
        
        // 重新綁定縣市選擇事件
        const citySelect = addressItem.querySelector('.city-select');
        citySelect.addEventListener('change', function() {
            updateDistricts(this.value, this.closest('.address-item').querySelector('.district-select'));
        });
        
        addressList.appendChild(addressItem);
    });

    // 刪除地址
    addressList.addEventListener('click', function(e) {
        if (e.target.closest('.remove-address')) {
            const addressItem = e.target.closest('.address-item');
            if (addressList.children.length > 1) {
                // 如果刪除的是預設地址，則將第一個地址設為預設
                if (addressItem.querySelector('input[type="radio"]').checked) {
                    addressList.querySelector('.address-item:first-child input[type="radio"]').checked = true;
                }
                addressItem.remove();
                
                // 重新設置所有radio的value
                document.querySelectorAll('.address-item').forEach((item, index) => {
                    item.querySelector('input[type="radio"]').value = index;
                });
            }
        }
    });

    // Password toggle functionality
    document.querySelectorAll('.password-toggle').forEach(function(button) {
        button.addEventListener('click', function() {
            const input = this.parentElement.querySelector('input');
            const icon = this.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        });
    });
});
</script>

<?php
include "../template_btm.php";
?>