<?php
require_once "./connect.php";
require_once "./Utilities.php";

$pageTitle = "二手商品管理";
$cssList = ["../css/index.css", "../coupon/coupon.css", "./Old_Vinyl.css"]; //
include "../vars.php";
include "../template_top.php";
include "../template_main.php";

//搜尋功能
$search = ($_GET["search"] ?? "");
$values = [];
$searchSQL = "";
if ($search != "") {
  $searchSQL = "(v.name LIKE :search OR v.desc LIKE :search OR cp.name LIKE :search ) AND ";
  $values["search"] = "%$search%";
}
// 分頁
$perPage = 10; // 每頁顯示的資料筆數
$page = intval($_GET["page"] ?? 1);
$pageStart = ($page - 1) * $perPage;
// 篩選主類別
$cid = intval($_GET["cid"] ?? 0);

// 如果有分類ID，則加入 WHERE 條件
if ($cid == 0) {
  $cateSQL = "";
  $sqlAll = "SELECT COUNT(*) as total FROM `o_vinyl` v 
             LEFT JOIN `main_category` mc ON v.main_category_id = mc.id
             LEFT JOIN `company` cp ON v.company_id = cp.id
             LEFT JOIN `sub_category` sc ON v.sub_category_id = sc.id
             WHERE $searchSQL v.`is_valid` = 1";
  $valuesAll = $values;
} else {
  $cateSQL = "mc.id= :cid and";
  $values["cid"] = $cid;
  $sqlAll = "SELECT COUNT(*) as total FROM `o_vinyl` v 
             LEFT JOIN `main_category` mc ON v.main_category_id = mc.id
             LEFT JOIN `company` cp ON v.company_id = cp.id
             LEFT JOIN `sub_category` sc ON v.sub_category_id = sc.id
             WHERE $cateSQL $searchSQL v.`is_valid` = 1";
  $valuesAll = $values;
}

// 取得黑膠資料，使用 JOIN 來取得分類名稱
$sql = "SELECT v.*, 
               mc.title as main_category_title, 
               sc.title as sub_category_title,
               img.url as imge_url,
               cp.name as company_name,
               lp.size as lp_size,
               cd.name as condition_name,
               st.name as status_name
        FROM `o_vinyl` v 
        LEFT JOIN `main_category` mc ON v.main_category_id = mc.id
        LEFT JOIN `sub_category` sc ON v.sub_category_id = sc.id
        LEFT JOIN `images` img ON v.image_id = img.id
        LEFT JOIN `company` cp ON v.company_id = cp.id
        LEFT JOIN `lp` ON v.lp_id = lp.id
        LEFT JOIN `condition` cd ON v.condition_id = cd.id
        LEFT JOIN `status` st ON v.status_id = st.id
        WHERE $cateSQL $searchSQL v.`is_valid` = 1 
        ORDER BY v.id 
        LIMIT $perPage OFFSET $pageStart";

;
$sqlCate = "SELECT * FROM `main_category`";

try {
  $stmt = $pdo->prepare($sql);
  $stmt->execute($values);
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $stmtCate = $pdo->prepare($sqlCate);
  $stmtCate->execute();
  $rowsCate = $stmtCate->fetchAll(PDO::FETCH_ASSOC);

  $stmtAll = $pdo->prepare($sqlAll);
  $stmtAll->execute($valuesAll);
  $totalCount = $stmtAll->fetchColumn();
} catch (PDOException $e) {
  echo "錯誤: {$e->getMessage()}";
  exit;
}
$totalPage = ceil($totalCount / $perPage);
?>

<div class="content-section">
  <div class="section-header d-flex justify-content-between align-items-center">
    <h3 class="section-title">二手商品列表</h3>
    <span class="ms-auto">目前共 <?= $totalCount ?> 筆資料</span>
    <a href="./add.php" class="btn btn-primary">增加資料</a>
  </div>
  <!-- 搜尋篩選 -->
  <div class="controls-section">
    <!-- 搜尋 -->
    <div class="search-box">
      <input name="search" type="text" class="form-control form-control-sm" placeholder="搜尋">
      <i class="fas fa-search"></i>
    </div>
    <!-- 篩選bar -->
    <!-- 分類 -->
    <div class="nav nav-tabs">
      <a class="nav-link <?= $cid == 0 ? "active" : "" ?>" href="./index.php">全部</a>
      <?php foreach ($rowsCate as $rowCate): ?>
        <a class="nav-link <?= $cid == $rowCate["id"] ? "active" : "" ?>" href="./index.php?cid=<?= $rowCate["id"] ?>">
          <?= htmlspecialchars($rowCate["title"]) ?>
        </a>
      <?php endforeach; ?>
    </div>

  </div>

  <div class="table-container table-responsive">
    <table class="table table-bordered table-striped align-middle">
      <thead class="table-dark">
        <tr>
          <th>#</th>
          <th>照片</th>
          <th>專輯名稱</th>
          <th>狀態</th>
          <th>狀況</th>
          <th>庫存</th>
          <th>尺寸</th>
          <th>公司</th>
          <th>價格</th>
          <th>發行日</th>
          <th>主分類</th>
          <th>次分類</th>
          <th>建立時間</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($rows as $index => $row): ?>
          <tr>
            <!-- 產品數量 -->
            <td><?= $perPage * ($page - 1) + $index + 1 ?></td>
            <!-- 圖片 -->
            <td class="img">
              <?php if (!empty($row["imge_url"])): ?>
                <?php if (filter_var($row["imge_url"], FILTER_VALIDATE_URL)): ?>
                  <img src="<?= htmlspecialchars($row["imge_url"]) ?>" alt="專輯圖片">
                <?php else: ?>
                  <img src="./uploads/<?= htmlspecialchars($row["imge_url"]) ?>" alt="專輯圖片">
                <?php endif; ?>
              <?php else: ?>
                <img src="./uploads/no-image.png" alt="無圖片">
              <?php endif; ?>
            </td>

            <!-- 專輯名稱 -->
            <td class="name" title="<?= htmlspecialchars($row["name"]) ?>">
              <?= htmlspecialchars($row["name"]) ?>
            </td>
            <!-- 狀態 -->
            <td class="choice"><?= htmlspecialchars($row["status_name"] ?? '未知') ?></td>

            <!-- 狀況 -->
            <td class="choice"><?= htmlspecialchars($row["condition_name"] ?? '未知') ?></td>

            <!-- 庫存 -->
            <td class="choice"><?= intval($row["stock"] ?? 0) ?></td>

            <!-- 尺寸 -->
            <td class="choice"><?= htmlspecialchars($row["lp_size"] ?? '未知') ?></td>

            <!-- 公司 -->
            <td class="choice" title="<?= htmlspecialchars($row["company_name"] ?? '未知公司') ?>">
              <?= htmlspecialchars($row["company_name"] ?? '未知') ?>
            </td>

            <!-- 價格 -->
            <td class="price">$<?= number_format($row["price"]) ?></td>

            <td class="release_date"><?= $row["release_date"] ?></td>
            <td class="main_category"><?= htmlspecialchars($row["main_category_title"] ?? '未分類') ?></td>
            <td class="sub_category"><?= htmlspecialchars($row["sub_category_title"] ?? '未分類') ?></td>
            <!-- 更新時間 -->
            <td class="choice"><?= $row["creatTime"] ?></td>

            <!-- 操錯 -->
            <td class="text-center">
              <div class="action-buttons">
                <a class="btn btn-sm btn-info btn-icon-absolute" href="./view.php?id=<?= $row["id"] ?>" title="詳細">
                  <i class="fas fa-fw fa-eye"></i>
                </a>
                <a class="btn btn-sm btn-warning btn-icon-absolute" href="./update.php?id=<?= $row["id"] ?>" title="修改">
                  <i class="fas fa-fw fa-edit"></i>
                </a>
                <button class="btn btn-sm btn-danger btn-del btn-icon-absolute" data-id="<?= $row["id"] ?>">
                  <i class="fa-solid fa-trash fa-fw " title="刪除"></i>
                </button>
              </div>
            </td>




          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <!-- 分頁 -->
  <div class="pagination">
    <?php for ($i = 1; $i <= $totalPage; $i++): ?>
      <a class="pagination-btn <?= $page == $i ? "active" : "" ?>"
        href="./index.php?page=<?= $i ?>&cid=<?= $cid > 0 ? $cid : 0 ?>&search=<?= $search !== "" ? $search : "" ?>"><?= $i ?></a>
    <?php endfor; ?>
  </div>
  <div class="delcon"><a class="btn btn-warning btn-sm justify-content-start" href="./delete.php">
    <i class="fas fa-trash"></i> 回收桶
  </a></div>
</div>















<script>
  const btnDels = document.querySelectorAll(".btn-del");
  const btnSearch = document.querySelector(".fa-search");

  //搜尋
  btnSearch.addEventListener("click", function () {
    const query = document.querySelector("input[name=search]").value;
    window.location.href = `./index.php?search=${query}`;
  })

  //刪除
  btnDels.forEach((btn) => {
    btn.addEventListener("click", doConfirm);
  });

  function doConfirm(e) {
    const btn = e.target.closest('.btn-del');
    if (confirm("確定要刪除嗎?")) {
      window.location.href = `./doSoftDelete.php?id=${btn.dataset.id}`;
    }
  }

</script>
<?php
include "../template_btm.php";
?>