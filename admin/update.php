<?php
require_once "../components/connect.php";
require_once "../components/Utilities.php";

$pageTitle = "管理員帳號設定";
$cssList = ["../css/index.css", "../css/add.css", "./users.css"];
include "../vars.php";
include "../template_top.php";
include "../template_main.php";

if (!isset($_GET['id'])) {
    alertGoTo("沒有使用者", "index.php");
    exit;
}
$id = intval($_GET['id']);
$sql = "SELECT * FROM admins WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$admin) {
    alertGoTo("找不到管理員", "index.php");
    exit;
}
?>

<div class="content-section">
    <div class="section-header">
        <h3 class="section-title">編輯管理員</h3>
        <a href="./index.php" class="btn btn-secondary">回管理員列表</a>
    </div>

    <form action="doupdate.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $admin['id'] ?>">
        <div class="mb-3">
            <div class="form-group avatar-group">
                <label for="memberAvatar" class="form-label"></label>
                <div class="avatar-upload-container">
                    <div class="avatar-preview">
                        <img id="avatarPreview" src="<?= htmlspecialchars($admin['img'] ? $admin['img'] : './admindefault.jpeg') ?>" alt="">
                    </div>
                    <input type="file" id="memberAvatar" name="img" class="form-control" accept="image/*" onchange="previewImage(this)">
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">名稱</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($admin['name']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="account" class="form-label">帳號</label>
            <input type="text" class="form-control" id="account" name="account" value="<?= htmlspecialchars($admin['account']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">密碼（如不修改請留空）</label>
            <div class="password-field-container">
                <input type="password" class="form-control" id="password" name="password">
                <button type="button" class="password-toggle">
                    <i class="fas fa-eye-slash"></i>
                </button>
            </div>
        </div>
        <div class="form-actions">
            <button type="button" class="btn btn-secondary" onclick="window.location.href='index.php'">
                <i class="fas fa-times"></i> 取消
            </button>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> 儲存
            </button>
        </div>
    </form>
</div>

<script>
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
    document.getElementById('memberAvatar').addEventListener('change', function () {
        previewImage(this);
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
</script>

<?php
include "../template_btm.php";
?>
