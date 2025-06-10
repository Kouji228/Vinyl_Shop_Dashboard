<?php
require_once "connect.php";
require_once "../components/Utilities.php";


$pageTitle = "會員管理";
$cssList = ["../css/index.css", "../css/add.css"];
include "../vars.php";
include "../template_top.php";
include "../template_main.php";
?>

<div class="content-section">
    <div class="section-header">
        <h3 class="section-title">新增會員</h3>
        <a href="./index.php" class="btn btn-secondary">回會員列表</a>
    </div>
    <form id="addusers" action="./doadd.php" method="POST" enctype="multipart/form-data">
        <div class="form-section">
            <h4 class="form-section-title">基本資訊</h4>
            <div class="form-row avatar-row">
                <div class="form-group avatar-group">
                    <label for="memberAvatar" class="form-label"></label>
                    <div class="avatar-upload-container">
                        <div class="avatar-preview">
                            <img id="avatarPreview" src="" alt="預覽圖片">
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
                            <input type="text" id="memberName" name="name" class="form-control" required>
                            <div class="error-message" id="nameError"></div>
                        </div>

                        <div class="form-group">
                            <label for="memberEmail" class="form-label required">Email</label>
                            <input type="email" id="memberEmail" name="email" class="form-control" required>
                            <div class="error-message" id="emailError"></div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="memberPhone" class="form-label">電話號碼</label>
                            <input type="tel" id="memberPhone" name="phone" class="form-control"
                                pattern="[0-9\-\+\s\(\)]{8,15}" placeholder="例：0912-345-678">
                            <div class="error-message" id="phoneError"></div>
                        </div>

                        <div class="form-group">
                            <label for="memberBirthday" class="form-label">生日</label>
                            <input type="date" id="memberBirthday" name="birthday" class="form-control">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="memberGender" class="form-label">性別</label>
                            <select id="memberGender" name="gender" class="form-control">
                                <option value="">請選擇</option>
                                <option value="男">男</option>
                                <option value="女">女</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="memberLevel" class="form-label required">會員等級</label>
                            <select id="memberLevel" name="level" class="form-control" required>
                                <option value="">請選擇等級</option>
                                <option value="一般會員">一般會員</option>
                                <option value="VIP會員">VIP會員</option>
                                <option value="黑膠收藏家">黑膠收藏家</option>
                            </select>
                            <div class="error-message" id="levelError"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="form-section">
            <h4 class="form-section-title">聯絡資訊</h4>

            <div class="form-row">
                <div class="form-group">
                    <label for="memberCity" class="form-label">縣市</label>
                    <select id="memberCity" name="city" class="form-control" required>
                        <option value="">請選擇縣市</option>
                        <option value="台北市">台北市</option>
                        <option value="新北市">新北市</option>
                        <option value="桃園市">桃園市</option>
                        <option value="台中市">台中市</option>
                        <option value="台南市">台南市</option>
                        <option value="高雄市">高雄市</option>
                        <option value="基隆市">基隆市</option>
                        <option value="新竹市">新竹市</option>
                        <option value="嘉義市">嘉義市</option>
                        <option value="新竹縣">新竹縣</option>
                        <option value="苗栗縣">苗栗縣</option>
                        <option value="彰化縣">彰化縣</option>
                        <option value="南投縣">南投縣</option>
                        <option value="雲林縣">雲林縣</option>
                        <option value="嘉義縣">嘉義縣</option>
                        <option value="屏東縣">屏東縣</option>
                        <option value="宜蘭縣">宜蘭縣</option>
                        <option value="花蓮縣">花蓮縣</option>
                        <option value="台東縣">台東縣</option>
                        <option value="澎湖縣">澎湖縣</option>
                        <option value="金門縣">金門縣</option>
                        <option value="連江縣">連江縣</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="memberDistrict" class="form-label">區域</label>
                    <select id="memberDistrict" name="district" class="form-control" required>
                        <option value="">請先選擇縣市</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group full-width">
                    <label for="memberAddress" class="form-label">詳細地址</label>
                    <input type="text" id="memberAddress" name="address" class="form-control" placeholder="例：中山南路21號">
                </div>
            </div>
        </div>

        <div class="form-section">
            <h4 class="form-section-title">帳戶設定</h4>

            <div class="form-row">
                <div class="form-group">
                    <label for="memberPassword" class="form-label required">密碼</label>
                    <input type="password" id="memberPassword" name="password" class="form-control" minlength="6"
                        required placeholder="至少6個字元">
                    <div class="error-message" id="passwordError"></div>
                </div>

                <div class="form-group">
                    <label for="confirmPassword" class="form-label required">確認密碼</label>
                    <input type="password" id="confirmPassword" name="confirm_password" class="form-control" required>
                    <div class="error-message" id="confirmPasswordError"></div>
                </div>
            </div>
        </div>



        <div class="form-actions">
            <button type="button" class="btn btn-secondary" onclick="window.location.href='usersindex.php'">
                <i class="fas fa-times"></i> 取消
            </button>
            <button type="reset" class="btn btn-outline-secondary">
                <i class="fas fa-undo"></i> 重置
            </button>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> 儲存會員
            </button>
    </form>
</div>

<script>
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

    // 縣市區域連動
    const cityDistricts = {
        '台北市': ['中正區', '大同區', '中山區', '松山區', '大安區', '萬華區', '信義區', '士林區', '北投區', '內湖區', '南港區', '文山區'],
        '新北市': ['板橋區', '三重區', '中和區', '永和區', '新莊區', '新店區', '樹林區', '鶯歌區', '三峽區', '淡水區', '汐止區', '瑞芳區', '土城區', '蘆洲區', '五股區', '泰山區', '林口區', '深坑區', '石碇區', '坪林區', '三芝區', '石門區', '八里區', '平溪區', '雙溪區', '貢寮區', '金山區', '萬里區', '烏來區'],
        '桃園市': ['桃園區', '中壢區', '平鎮區', '八德區', '楊梅區', '蘆竹區', '大溪區', '龍潭區', '龜山區', '大園區', '觀音區', '新屋區', '復興區'],
        '台中市': ['中區', '東區', '南區', '西區', '北區', '北屯區', '西屯區', '南屯區', '太平區', '大里區', '霧峰區', '烏日區', '豐原區', '后里區', '石岡區', '東勢區', '和平區', '新社區', '潭子區', '大雅區', '神岡區', '大肚區', '沙鹿區', '龍井區', '梧棲區', '清水區', '大甲區', '外埔區', '大安區'],
        '台南市': ['中西區', '東區', '南區', '北區', '安平區', '安南區', '永康區', '歸仁區', '新化區', '左鎮區', '玉井區', '楠西區', '南化區', '仁德區', '關廟區', '龍崎區', '官田區', '麻豆區', '佳里區', '西港區', '七股區', '將軍區', '學甲區', '北門區', '新營區', '後壁區', '白河區', '東山區', '六甲區', '下營區', '柳營區', '鹽水區', '善化區', '大內區', '山上區', '新市區', '安定區'],
        '高雄市': ['楠梓區', '左營區', '鼓山區', '三民區', '鹽埕區', '前金區', '新興區', '苓雅區', '前鎮區', '旗津區', '小港區', '鳳山區', '大寮區', '鳥松區', '林園區', '仁武區', '大樹區', '大社區', '岡山區', '路竹區', '橋頭區', '梓官區', '彌陀區', '永安區', '燕巢區', '田寮區', '阿蓮區', '茄萣區', '湖內區', '旗山區', '美濃區', '內門區', '杉林區', '甲仙區', '六龜區', '茂林區', '桃源區', '那瑪夏區'],
        '基隆市': ['中正區', '七堵區', '暖暖區', '仁愛區', '中山區', '安樂區', '信義區'],
        '新竹市': ['東區', '北區', '香山區'],
        '嘉義市': ['東區', '西區'],
        '新竹縣': ['竹北市', '竹東鎮', '新埔鎮', '關西鎮', '湖口鄉', '新豐鄉', '芎林鄉', '橫山鄉', '北埔鄉', '寶山鄉', '峨眉鄉', '尖石鄉', '五峰鄉'],
        '苗栗縣': ['苗栗市', '頭份市', '竹南鎮', '後龍鎮', '通霄鎮', '苑裡鎮', '卓蘭鎮', '造橋鄉', '西湖鄉', '頭屋鄉', '公館鄉', '大湖鄉', '泰安鄉', '銅鑼鄉', '三義鄉', '西湖鄉', '南庄鄉', '頭屋鄉'],
        '彰化縣': ['彰化市', '員林市', '和美鎮', '鹿港鎮', '溪湖鎮', '二林鎮', '田中鎮', '北斗鎮', '花壇鄉', '芬園鄉', '大村鄉', '永靖鄉', '伸港鄉', '線西鄉', '福興鄉', '秀水鄉', '埔心鄉', '埔鹽鄉', '大城鄉', '芳苑鄉', '竹塘鄉', '社頭鄉', '二水鄉', '田尾鄉', '埤頭鄉', '溪州鄉'],
        '南投縣': ['南投市', '埔里鎮', '草屯鎮', '竹山鎮', '集集鎮', '名間鄉', '鹿谷鄉', '中寮鄉', '魚池鄉', '國姓鄉', '水里鄉', '信義鄉', '仁愛鄉'],
        '雲林縣': ['斗六市', '斗南鎮', '虎尾鎮', '西螺鎮', '土庫鎮', '北港鎮', '古坑鄉', '大埤鄉', '莿桐鄉', '林內鄉', '二崙鄉', '崙背鄉', '麥寮鄉', '東勢鄉', '褒忠鄉', '台西鄉', '元長鄉', '四湖鄉', '口湖鄉', '水林鄉'],
        '嘉義縣': ['太保市', '朴子市', '布袋鎮', '大林鎮', '民雄鄉', '溪口鄉', '新港鄉', '六腳鄉', '東石鄉', '義竹鄉', '鹿草鄉', '水上鄉', '中埔鄉', '竹崎鄉', '梅山鄉', '番路鄉', '大埔鄉', '阿里山鄉'],
        '屏東縣': ['屏東市', '潮州鎮', '東港鎮', '恆春鎮', '萬丹鄉', '長治鄉', '麟洛鄉', '九如鄉', '里港鄉', '鹽埔鄉', '高樹鄉', '萬巒鄉', '內埔鄉', '竹田鄉', '新埤鄉', '枋寮鄉', '新園鄉', '崁頂鄉', '林邊鄉', '南州鄉', '佳冬鄉', '琉球鄉', '車城鄉', '滿州鄉', '枋山鄉', '三地門鄉', '霧台鄉', '瑪家鄉', '泰武鄉', '來義鄉', '春日鄉', '獅子鄉', '牡丹鄉'],
        '宜蘭縣': ['宜蘭市', '羅東鎮', '蘇澳鎮', '頭城鎮', '礁溪鄉', '壯圍鄉', '員山鄉', '冬山鄉', '五結鄉', '三星鄉', '大同鄉', '南澳鄉'],
        '花蓮縣': ['花蓮市', '鳳林鎮', '玉里鎮', '新城鄉', '吉安鄉', '壽豐鄉', '光復鄉', '豐濱鄉', '瑞穗鄉', '富里鄉', '秀林鄉', '萬榮鄉', '卓溪鄉'],
        '台東縣': ['台東市', '成功鎮', '關山鎮', '卑南鄉', '鹿野鄉', '池上鄉', '東河鄉', '長濱鄉', '太麻里鄉', '大武鄉', '綠島鄉', '海端鄉', '延平鄉', '金峰鄉', '達仁鄉', '蘭嶼鄉'],
        '澎湖縣': ['馬公市', '湖西鄉', '白沙鄉', '西嶼鄉', '望安鄉', '七美鄉'],
        '金門縣': ['金城鎮', '金湖鎮', '金沙鎮', '金寧鄉', '烈嶼鄉', '烏坵鄉'],
        '連江縣': ['南竿鄉', '北竿鄉', '莒光鄉', '東引鄉']
    };

    document.getElementById('memberCity').addEventListener('change', function () {
        const districtSelect = document.getElementById('memberDistrict');
        const selectedCity = this.value;

        // 清空現有選項
        districtSelect.innerHTML = '<option value="">請選擇區域</option>';

        if (selectedCity && cityDistricts[selectedCity]) {
            // 添加新的選項
            cityDistricts[selectedCity].forEach(district => {
                const option = document.createElement('option');
                option.value = district;
                option.textContent = district;
                districtSelect.appendChild(option);
            });
        }
    });
</script>

<?php
include "../template_btm.php";
?>