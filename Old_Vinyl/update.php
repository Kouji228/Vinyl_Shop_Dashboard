<?php
require_once "./connect.php";
require_once "./Utilities.php";

$pageTitle = "二手商品管理";
$cssList = ["../css/index.css", "../coupon/coupon.css", "./Old_Vinyl.css"]; //
include "../vars.php";
include "../template_top.php";
include "../template_main.php";


if (!isset($_GET["id"])) {
  alertGoTo("請從正常管道進入", "./index.php");
  exit;
}

$id = $_GET["id"];
$sqlMCate = "SELECT * FROM `main_category`";
$sqlSCate = "SELECT * FROM `sub_category`";
$sqlLp = "SELECT * FROM `lp`";
$sqlStatus = "SELECT * FROM `status`";
$sqlCondition = "SELECT * FROM `condition`";
$sql = "SELECT v.*, 
               img.url as image_url
        FROM `o_vinyl` v 
        LEFT JOIN `images` img ON v.image_id = img.id
        WHERE  v.`is_valid` = 1 AND v.id = ?
        ORDER BY v.id ";
$sqlCompany = "SELECT * FROM `company`";

try {
  $stmtMCate = $pdo->prepare($sqlMCate);
  $stmtMCate->execute();
  $rowsMCate = $stmtMCate->fetchAll(PDO::FETCH_ASSOC);

  $stmtCompany = $pdo->prepare($sqlCompany);
  $stmtCompany->execute();
  $rowsCompany = $stmtCompany->fetchAll(PDO::FETCH_ASSOC);

  $stmtSCate = $pdo->prepare($sqlSCate);
  $stmtSCate->execute();
  $rowsSCate = $stmtSCate->fetchAll(PDO::FETCH_ASSOC);

  $stmtLp = $pdo->prepare($sqlLp);
  $stmtLp->execute();
  $rowsLp = $stmtLp->fetchAll(PDO::FETCH_ASSOC);

  $stmtCondition = $pdo->prepare($sqlCondition);
  $stmtCondition->execute();
  $rowsCondition = $stmtCondition->fetchAll(PDO::FETCH_ASSOC);

  $stmtStatus = $pdo->prepare($sqlStatus);
  $stmtStatus->execute();
  $rowsStatus = $stmtStatus->fetchAll(PDO::FETCH_ASSOC);

  $stmt = $pdo->prepare($sql);
  $stmt->execute([$id]);
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  if (!$row) {
    alertGoTo("沒有這個商品", "./");
  }
} catch (PDOException $e) {
  echo "錯誤: {$e->getMessage()}";
  exit;
}
$companyName = '';
foreach ($rowsCompany as $company) {
  if ($company['id'] == $row['company_id']) {
    $companyName = $company['name'];
    break;
  }
}
?>
<div class="content-section">
  <div class="section-header">
    <h3 class="section-title">商品編號: <?= htmlspecialchars($row['id']) ?>-<?= htmlspecialchars($row['name']) ?></h3>
    <a href="./index.php" class="btn btn-secondary">返回列表</a>
  </div>
  <form action="./doUpdate.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $row["id"] ?>">

    <div class="form-section">
      <!-- 專產品圖片 -->
      <div class="form-row">
        <div class="form-group pd_img"><?php if (!empty($row["image_url"])): ?>
            <?php if (filter_var($row["image_url"], FILTER_VALIDATE_URL)): ?>
              <img src="<?= htmlspecialchars($row["image_url"]) ?>" alt="專輯圖片">
            <?php else: ?>
              <img src="./uploads/<?= htmlspecialchars($row["image_url"]) ?>" alt="專輯圖片">
            <?php endif; ?>
          <?php else: ?>
            <img src="./uploads/no-image.png" alt="無圖片">
          <?php endif; ?>
          <input class="form-control pd_img" type="file" name="myFile" accept=".png,.jpg,.jpeg">
        </div>
      </div>
      <!-- 專輯名稱 -->
      <div class="form-row">
        <div class="form-group">
          <label for="couponName" class="form-label required">專輯名稱</label>
          <input required name="name" type="text" class="form-control" placeholder="專輯名稱" value="<?= $row["name"] ?>">
        </div>
      </div>
      <!-- 介紹 -->
      <div class="form-row">
        <div class="form-group">
          <label for="couponName" class="form-label required">介紹</label>
          <input required name="desc" type="text" class="form-control" placeholder="介紹" value="<?= $row["desc"] ?>">
        </div>
      </div>
      <div class="form-row">
        <!-- 狀態 -->
        <div class="form-group">
          <label for="couponName" class="form-label required">狀態</label>
          <select name="status_id" class="form-select">
            <option value selected disabled>請選擇</option>
            <?php foreach ($rowsStatus as $rowStatus): ?>
              <option value="<?= $rowStatus["id"] ?>" <?= ($rowStatus["id"] == $row["status_id"]) ? "selected" : "" ?>>
                <?= $rowStatus["name"] ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <!-- 狀況 -->
        <div class="form-group">
          <label for="couponName" class="form-label required">狀況</label>
          <select name="condition_id" class="form-select">
            <option value selected disabled>請選擇</option>
            <?php foreach ($rowsCondition as $rowCondition): ?>
              <option value="<?= $rowCondition["id"] ?>" <?= ($rowCondition["id"] == $row["condition_id"]) ? "selected" : "" ?>>
                <?= $rowCondition["name"] ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
      <!-- 庫存 -->
      <div class="form-row">
        <div class="form-group">
          <label for="couponName" class="form-label required">庫存</label>
          <input required name="stock" type="text" class="form-control" placeholder="庫存數量" value="<?= $row["stock"] ?>">
        </div>
      </div>
      <!-- 尺寸 -->
      <div class="form-row">
        <div class="form-group">
          <label for="couponName" class="form-label required">尺寸</label>
          <select name="lp_id" class="form-select">
            <option value selected disabled>請選擇</option>
            <?php foreach ($rowsLp as $rowLp): ?>
              <option value="<?= $rowLp["id"] ?>" <?= ($rowLp["id"] == $row["lp_id"]) ? "selected" : "" ?>>
                <?= $rowLp["size"] ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
      <!-- 公司名稱 -->
      <div class="form-row">
        <div class="form-group">
          <label for="couponName" class="form-label required">公司名稱</label>
          <input required name="company" type="text" class="form-control" placeholder="公司名稱"
            value="<?= $companyName ?>">
        </div>
      </div>
      <!-- 價格 -->
      <div class="form-row">
        <div class="form-group">
          <label for="couponName" class="form-label required">價格</label>
          <input required name="price" type="text" class="form-control" placeholder="價格" value="<?= $row["price"] ?>">
        </div>
      </div>
      <!-- 發行日 -->
      <div class="form-row">
        <div class="form-group">
          <label for="couponName" class="form-label required">發行日</label>
          <input required name="release_date" type="date" class="form-control" value="<?= $row["release_date"] ?>">
        </div>
      </div>
      <!-- 分類 -->
      <div class="form-row">
        <!-- 主分類 -->
        <div class="form-group">
          <label for="couponName" class="form-label required">主分類</label>
          <select name="main_category_id" id="main_category_id" class="form-select">
            <option value selected disabled>請選擇</option>
            <?php foreach ($rowsMCate as $rowMCate): ?>
              <option value="<?= $rowMCate["id"] ?>" <?= ($rowMCate["id"] == $row["main_category_id"]) ? "selected" : "" ?>>
                <?= $rowMCate["title"] ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <!-- 次分類 -->
        <div class="form-group">
          <label for="couponName" class="form-label required">次分類</label>
          <select class="form-select" name="sub_category_id" id="sub_category_id">
            <option value="" selected disabled>請選擇</option>
            <?php foreach ($rowsSCate as $rowSCate): ?>
              <option value="<?= $rowSCate["id"] ?>" data-main="<?= $rowSCate["main_category_id"] ?>"
                <?= ($rowSCate["id"] == $row["sub_category_id"]) ? "selected" : "" ?>>
                <?= $rowSCate["title"] ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
      <div class="mt-1 text-end">
        <button type="submit" class="btn btn-info btn-send">送出</button>
        <a class="btn btn-primary" href="./index.php">取消</a>
      </div>
  </form>
</div>


<script>
  //監聽主分類選擇變化
  document.getElementById('main_category_id').addEventListener('change', function () {
    var mainId = this.value;
    var subSelect = document.getElementById('sub_category_id');
    var optionsArray = [...subSelect.options]; // 使用展開運算符

    optionsArray.forEach(function (opt) {
      if (!opt.value) {
        opt.style.display = '';
        return;
      }
      opt.style.display = (opt.getAttribute('data-main') === mainId) ? '' : 'none';
    });

    // 如果目前選中的次分類不屬於新的主分類，則重置
    var currentSubId = subSelect.value;
    var currentSubOption = subSelect.querySelector('option[value="' + currentSubId + '"]');
    if (currentSubOption && currentSubOption.getAttribute('data-main') !== mainId) {
      subSelect.value = '';
    }
  });

  // 頁面載入完成後立即觸發一次，確保次分類正確顯示
  window.addEventListener('load', function () {
    var mainSelect = document.getElementById('main_category_id');
    if (mainSelect.value) {
      mainSelect.dispatchEvent(new Event('change'));
    }
  });
</script>
<?php
include "../template_btm.php";
?>