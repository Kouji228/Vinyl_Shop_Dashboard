<?php
require_once "./connect.php";
require_once "./utilities.php";

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
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>新增二手黑膠</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>

<body>
  <div class="container mt-3">
    <h1>增加二手黑膠</h1>
    <form action="./doAdd.php" method="post" enctype="multipart/form-data">
      <div class="input-group mb-1">
         <span class="input-group-text">上傳商品圖片</span>
        <input class="form-control" type="file" name="myFile" accept=".png,.jpg,.jpeg">
      </div>
      <div class="input-group mb-1">
        <span class="input-group-text">專輯名稱</span>
        <input required name="name" type="text" class="form-control" placeholder="專輯名稱">
      </div>
      <div class="input-group mb-1">
        <span class="input-group-text">介紹</span>
        <input required name="desc" type="text" class="form-control" placeholder="介紹">
      </div>
      <div class="input-group mb-1">
        <span class="input-group-text">狀態</span>
        <select name="status_id"  class="form-select">
          <option value selected disabled>請選擇</option>
          <?php foreach ($rowsStatus as $rowStatus): ?>
            <option value="<?= $rowStatus["id"] ?>"><?= $rowStatus["name"] ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="input-group mb-1">
        <span class="input-group-text">狀況</span>
        <select name="condition_id"  class="form-select">
          <option value selected disabled>請選擇</option>
          <?php foreach ($rowsCondition as $rowCondition): ?>
            <option value="<?= $rowCondition["id"] ?>"><?= $rowCondition["name"] ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="input-group mb-1">
        <span class="input-group-text">庫存</span>
        <input required name="stock" type="text" class="form-control" placeholder="庫存數量">
      </div>
       <div class="input-group mb-1">
        <span class="input-group-text">尺寸</span>
         <select name="lp_id"  class="form-select">
          <option value selected disabled>請選擇</option>
          <?php foreach ($rowsLp as $rowLp): ?>
            <option value="<?= $rowLp["id"] ?>"><?= $rowLp["size"] ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="input-group mb-1">
        <span class="input-group-text">公司</span>
        <input required name="company" type="text" class="form-control" placeholder="公司名稱">
      <div class="input-group mb-1">
        <span class="input-group-text">價格</span>
        <input required name="price" type="text" class="form-control" placeholder="價格">
      </div>
      <div class="input-group mb-1">
        <span class="input-group-text">發行日</span>
        <input required name="release_date" type="date" class="form-control">
      </div>
      <div class="input-group mt-1 mb-2">
        <span class="input-group-text">主分類</span>
        <select name="main_category_id" id="main_category_id" class="form-select">
          <option value selected disabled>請選擇</option>
          <?php foreach ($rowsMCate as $rowMCate): ?>
            <option value="<?= $rowMCate["id"] ?>"><?= $rowMCate["title"] ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="input-group">
        <span class="input-group-text">次分類名稱</span>
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
  </script>
</body>

</html>