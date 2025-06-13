<?php
require_once "../components/connect.php";
require_once "../components/utilities.php";

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
       <div class="d-flex ovup">
        <!-- 專產品圖片 -->
        <div class="ovupimg">
          <div class="form-row">
            <div class="form-group pd_img">
              <?php if (!empty($row["image_url"])): ?>
                <?php if (filter_var($row["image_url"], FILTER_VALIDATE_URL)): ?>
                  <img src="<?= htmlspecialchars($row["image_url"]) ?>" alt="專輯圖片">
                <?php else: ?>
                  <img src="./uploads/<?= htmlspecialchars($row["image_url"]) ?>" alt="專輯圖片">
                <?php endif; ?>
              <?php else: ?>
                <img src="./uploads/no-image.png" alt="無圖片">
              <?php endif; ?>
              <input class="form-control pd_img" type="file" name="myFile" id="myFile" accept=".png,.jpg,.jpeg">
            </div>
          </div>
        </div>
        <div class="ovupword">
          <div class="form-row">
            <div class="form-group">
              <label for="name" class="form-label required">專輯名稱</label>
              <input required name="name" type="text" class="form-control" id="name" placeholder="專輯名稱"
                value="<?= $row["name"] ?>">
            </div>
          </div>

          <div class="form-row">
            <!-- 狀態 -->
            <div class="form-group">
              <label for="status_id" class="form-label required">狀態</label>
              <select name="status_id" id="status_id" class="form-select">
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
              <label for="condition_id" class="form-label required">狀況</label>
              <select name="condition_id" id="condition_id" class="form-select">
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
              <label for="stock" class="form-label required">庫存</label>
              <input required name="stock" type="text" class="form-control" id="stock" placeholder="庫存數量"
                value="<?= $row["stock"] ?>">
            </div>
            <!-- 公司名稱 -->

            <div class="form-group">
              <label for="company" class="form-label ">公司名稱</label>
              <input required name="company" type="text" class="form-control" id="company" placeholder="公司名稱"
                value="<?= $companyName ?>">
            </div>

          </div>
          <!-- 尺寸 -->
          <div class="form-row">
            <div class="form-group">
              <label for="lp_id" class="form-label required">尺寸</label>
              <select name="lp_id" id="lp_id" class="form-select">
                <option value selected disabled>請選擇</option>
                <?php foreach ($rowsLp as $rowLp): ?>
                  <option value="<?= $rowLp["id"] ?>" <?= ($rowLp["id"] == $row["lp_id"]) ? "selected" : "" ?>>
                    <?= $rowLp["size"] ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <!-- 發行日 -->
            <div class="form-group">
              <label for="release_date" class="form-label ">發行日</label>
              <input required name="release_date" type="date" class="form-control" id="release_date" value="<?= $row["release_date"] ?>">
            </div>
          </div>

          <!-- 價格 -->
          <div class="form-row">
            <div class="form-group">
              <label for="price" class="form-label required">價格</label>
              <input required name="price" type="text" class="form-control" id="price" placeholder="價格"
                value="<?= $row["price"] ?>">
            </div>
          </div>

          <!-- 分類 -->
          <div class="form-row">
            <!-- 主分類 -->
            <div class="form-group">
              <label for="main_category_id" class="form-label required">主分類</label>
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
              <label for="sub_category_id" class="form-label required">次分類</label>
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
          
        </div>
        
      </div>

      <!-- 介紹 -->
      <div class="form-row desc">
        <div class="form-group">
          <label for="desc" class="form-label ">介紹</label>
          <textarea required name="desc" id="desc" class="form-control" placeholder="介紹"><?= $row["desc"] ?></textarea>
        </div>
      </div>
    </div>
     
 <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> 更新資料
            </button>
            <a class="btn btn-secondary" href="./index.php">
                <i class="fas fa-times"></i> 取消
            </a>
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

  //調整介紹欄位高度
  document.addEventListener("input",function (e) {
  if(e.target.tagName==="textarea"){
    event.target.style.height = 'auto'; // 重置高度
  }
  })
  // 頁面載入時自動調整高度
window.addEventListener('load', function () {
  var textareas = document.querySelectorAll('textarea');
  textareas.forEach(function (textarea) {
    textarea.style.height = 'auto'; // 重置高度
    textarea.style.height = textarea.scrollHeight + 'px'; // 根據內容調整高度
  });
});

</script>

<?php
include "../template_btm.php";
?>