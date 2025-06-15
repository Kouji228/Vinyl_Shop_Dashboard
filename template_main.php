
<div class="header page-section">
  <h2 id="page-title"><?= isset($pageTitle) ? htmlspecialchars($pageTitle) : "Echo&Flow後台管理頁面" ?></h2>
  <div class="user-info">
    <div class="user-avatar">
      <img src="<?= isset($_SESSION['admin']['img']) ? htmlspecialchars($_SESSION['admin']['img']) : '../images/admin.png' ?>" alt="管理員頭像" class="avatar-img">
    </div>
    <span>歡迎 <?= isset($_SESSION['admin']['name']) ? htmlspecialchars($_SESSION['admin']['name']) : '管理員' ?> 登入</span>
  </div>
</div>
