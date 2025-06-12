<?php
require_once "./connect.php";
require_once "./utilities.php";

$pageTitle = "二手商品管理";
$cssList = ["../css/index.css", "../coupon/coupon.css", "./Old_Vinyl.css"]; //
include "../vars.php";
include "../template_top.php";
include "../template_main.php";


$sqlMCate = "SELECT * FROM `main_category`";
$sqlSCate = "SELECT * FROM `sub_category`";
$sqlLp = "SELECT * FROM `lp`";
$sqlStatus = "SELECT * FROM `status`";
$sqlCondition = "SELECT * FROM `condition`";
try {

  $stmtMCate = $pdo->prepare($sqlMCate);
  $stmtMCate->execute();
  $rowsMCate = $stmtMCate->fetchAll(PDO::FETCH_ASSOC);

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

} catch (PDOException $e) {
  echo "系統錯誤，請恰管理人員<br>";
  echo "Error: {$e->getMessage()}<br>";
  clickGoTo("回上一頁", "./add.php");
  exit;
}
?>

<div class="content-section">
  <!-- 標題 -->
  <div class="section-header">
    <h3 class="section-title">新增商品</h3>
    <a href="./index.php" class="btn btn-secondary">返回列表</a>
  </div>
  <form action="./doAdd.php" method="post" enctype="multipart/form-data">
    <div class="form-section ">
      <div class="d-flex ovup">
        <div class="ovupimg">
          <div class="form-row">
            <div class="form-group pd_img">
              <img class="preview" src="./uploads/no-image.png" alt="">
              <input class="form-control pd_img" type="file" name="myFile" id="myFile" accept=".png,.jpg,.jpeg">
            </div>
          </div>
        </div>
        <div class="ovupword">
          <!-- 名稱 -->
          <div class="form-row">
            <div class="form-group">
              <label for="name" class="form-label required">專輯名稱</label>
              <input required name="name" type="text" class="form-control" placeholder="專輯名稱">
            </div>
          </div>
          <!-- 狀態與狀況-->
          <div class="form-row">

            <!-- 狀態 -->
            <div class="form-group">
              <label for="status_id" class="form-label required">狀態</label>
              <select name="status_id" class="form-select">
                <option value selected disabled>請選擇</option>
                <?php foreach ($rowsStatus as $rowStatus): ?>
                  <option value="<?= $rowStatus["id"] ?>"><?= $rowStatus["name"] ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <!-- 狀況 -->
            <div class="form-group">
              <label for="condition_id" class="form-label required">狀況</label>
              <select name="condition_id" class="form-select">
                <option value selected disabled>請選擇</option>
                <?php foreach ($rowsCondition as $rowCondition): ?>
                  <option value="<?= $rowCondition["id"] ?>"><?= $rowCondition["name"] ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <!--庫存與公司  -->
          <div class="form-row">
            <!-- 庫存 -->
            <div class="form-group">
              <label for="stock" class="form-label required">庫存</label>
              <input required name="stock" type="text" class="form-control" placeholder="庫存數量">
            </div>
            <!-- 公司名稱 -->

            <div class="form-group">
              <label for="company" class="form-label ">公司名稱</label>
              <input required name="company" type="text" class="form-control" placeholder="公司名稱">
            </div>
          </div>
          <!-- 尺寸 與發行日 -->
          <div class="form-row">
            <div class="form-group">
              <label for="lp_id" class="form-label required">尺寸</label>
              <select name="lp_id" class="form-select">
                <option value selected disabled>請選擇</option>
                <?php foreach ($rowsLp as $rowLp): ?>
                  <option value="<?= $rowLp["id"] ?>"><?= $rowLp["size"] ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <!-- 發行日 -->
            <div class="form-group">
              <label for="release_date" class="form-label ">發行日</label>
              <input required name="release_date" type="date" class="form-control">
            </div>
          </div>

          <!-- 價格 -->
          <div class="form-row">
            <div class="form-group">
              <label for="price" class="form-label required">價格</label>
              <input required name="price" type="text" class="form-control" placeholder="價格">

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
                  <option value="<?= $rowMCate["id"] ?>"><?= $rowMCate["title"] ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <!-- 次分類 -->
            <div class="form-group">
              <label for="sub_category_id" class="form-label required">次分類</label>
              <select class="form-select" name="sub_category_id" id="sub_category_id">
                <option value="" selected disabled>請選擇</option>
                <?php foreach ($rowsSCate as $rowSCate): ?>
                  <option value="<?= $rowSCate["id"] ?>" data-main="<?= $rowSCate["main_category_id"] ?>">
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
          <textarea  name="desc" type="text" class="form-control" placeholder="介紹"></textarea>
        </div>
      </div>

    </div>

    <div class="form-actions">
      <button type="submit" class="btn btn-primary ">
        <i class="fa-solid fa-square-plus"></i>增加商品
      </button>
      <a class="btn btn-danger" href="./index.php">
        <i class="fas fa-times"></i> 取消
      </a>
    </div>
  </form>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
<script>

  //監聽主分類選擇變化
  document.getElementById('main_category_id').addEventListener('change', function () {
    //main id是選擇的主分類ID
    var mainId = this.value;
    var subSelect = document.getElementById('sub_category_id');
    var optionsArray = Array.from(subSelect.options);
    optionsArray.forEach(function (opt) {
      if (!opt.value) {
        opt.style.display = '';
        return;
      }
      opt.style.display = (opt.getAttribute('data-main') === mainId) ? '' : 'none';
    });
    subSelect.value = '';
  });
document.getElementById('myFile').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.querySelector('.preview').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});
</script>
</body>

</html>