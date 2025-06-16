<?php
require_once "../components/connect.php";
require_once "../components/utilities.php";

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

$perPage = 10;
$page = intval($_GET["page"] ?? 1);
$pageStart = ($page - 1) * $perPage;



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
        WHERE $searchSQL v.`is_valid` = 0 
        ORDER BY v.id 
        LIMIT $perPage OFFSET $pageStart";


$sqlAll = "SELECT COUNT(*) as total FROM `o_vinyl` v 
             LEFT JOIN `main_category` mc ON v.main_category_id = mc.id
             LEFT JOIN `company` cp ON v.company_id = cp.id
             LEFT JOIN `sub_category` sc ON v.sub_category_id = sc.id
             WHERE $searchSQL v.`is_valid` = 0";
$sqlCate = "SELECT * FROM `main_category`";



try {
  $stmt = $pdo->prepare($sql);
  $stmtAll = $pdo->prepare($sqlAll);

  if ($search != "") {
    $stmt->execute($values);
    $stmtAll->execute($values);
  } else {
    $stmt->execute();
    $stmtAll->execute();
  }

  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $totalCount = $stmtAll->fetchColumn();

  $stmtCate = $pdo->prepare($sqlCate);
  $stmtCate->execute();
  $rowsCate = $stmtCate->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  echo "錯誤: {$e->getMessage()}";
  exit;
}
$totalPage = ceil($totalCount / $perPage);
?>


<div class="content-section">
  <div class="section-header d-flex justify-content-between align-items-center">
    <h3 class="section-title">二手商品回收桶</h3>
    <span class="ms-auto">目前共 <?= $totalCount ?> 筆資料</span>
    <a href="./index.php" class="btn btn-secondary m-2">返回列表</a>
  </div>
  <!-- 搜尋篩選 -->
  <div class="controls-section">
    <!-- 搜尋 -->
    <div class="search-box">
      <input name="search" type="text" class="form-control form-control-sm" placeholder="搜尋(專輯名稱、內文、公司名稱)">
      <i class="fas fa-search"></i>
    </div>


  </div>

  <div class="table-container table-responsive">
    <table class="table table-bordered table-striped align-middle">
      <thead class="table-dark">
        <tr class="index_tr">
          <th class="index_sm">編號</th>
          <th class="index_img">照片</th>
          <th>專輯名稱</th>
          <th class="index_sm">主分類</th>
          <th>次分類</th>
          <th class="index_sm">狀態</th>
          <th class="index_sm">狀況</th>
          <th class="index_sm">庫存</th>
          <th class="index_sm">尺寸</th>
          <th class="index_sm">價格</th>

          <th>建立時間</th>
          <th class="index_sm">操作</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($rows as $index => $row): ?>
          <tr class="index_tr">
            <!-- 產品數量 -->
            <td class="index_sm"><?= $perPage * ($page - 1) + $index + 1 ?></td>
            <!-- 圖片 -->
            <td class="index_img">
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
            <!-- 分類 -->
            <td class="main_category  index_sm"><?= htmlspecialchars($row["main_category_title"] ?? '未分類') ?></td>
            <td class="sub_category"><?= htmlspecialchars($row["sub_category_title"] ?? '未分類') ?></td>
            <!-- 狀態 -->
            <td class="choice index_sm ">
              <span
                class="<?= ($row["status_id"] === '2') ? 'status-sold-out' : 'status-sold' ?>"><?= htmlspecialchars($row["status_name"] ?? '未知') ?></span>

            </td>
            <!-- 狀況 -->
            <td class="choice  index_sm"><?= htmlspecialchars($row["condition_name"] ?? '未知') ?></td>
            <!-- 庫存 -->
            <td class="choice index_sm"><?= intval($row["stock"] ?? 0) ?></td>

            <!-- 尺寸 -->
            <td class="choice index_sm"><?= htmlspecialchars($row["lp_size"] ?? '未知') ?></td>



            <!-- 價格 -->
            <td class="price index_sm">$<?= number_format($row["price"]) ?></td>





            <!-- 更新時間 -->
            <td class="choice"><?= $row["creatTime"] ?></td>

            <!-- 操錯 -->
            <td class="text-center index_sm">
              <div class="action-buttons">
                <button class="btn btn-danger btn-sm btn-del me-1 btn-icon-absolute" data-id="<?= $row["id"] ?>">
                    <i class="fa-solid fa-trash fa-fw " title="刪除"></i>
                </button>
                <a class="btn btn-warning btn-sm me-1 btn-icon-absolute" href="./doReturn.php?id=<?= $row["id"] ?>">
                  <i class="fa-solid fa-rotate-right"></i>
                </a>
              </div>
            </td>
           




          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>


<div class="pagination">
    <div class="pagination-info">
      第 <?= $page ?> 頁，共 <?= $totalPage ?> 頁
    </div>
    <?php
    // 計算分頁範圍
    $startPage = max(1, $page - 2);
    $endPage = min($totalPage, $startPage + 4); ?>

    <!-- // 第一頁 -->
    <?php if ($startPage > 1): ?>
      <button class="pagination-btn"
        onclick="window.location.href='?page=1&search=<?= urlencode($search) ?>'"><i
          class="fa-solid fa-angles-left"></i></button>
    <?php endif; ?>

    <!-- // 上一頁按鈕 -->
    <?php if ($page > 1): ?>
      <button class="pagination-btn"
        onclick="window.location.href='?page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>'">
        <i class="fas fa-chevron-left"></i>
      </button>
    <?php else: ?>
      <button class="pagination-btn" disabled>
        <i class="fas fa-chevron-left"></i>
      </button>
    <?php endif; ?>




    <!-- 中間頁面 -->
    <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
      <button class="pagination-btn <?= $i == $page ? 'active' : '' ?>"
        onclick="window.location.href='?page=<?= $i ?>&search=<?= urlencode($search) ?>'">
        <?= $i ?>
      </button>
    <?php endfor; ?>

    <!-- 下一頁按鈕 -->
    <?php if ($page < $totalPage): ?>
      <button class="pagination-btn"
        onclick="window.location.href='?page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>'">
        <i class="fas fa-chevron-right"></i>
      </button>
    <?php else: ?>
      <button class="pagination-btn" disabled>
        <i class="fas fa-chevron-right"></i>
      </button>
    <?php endif; ?>

    <!-- 最後一頁 -->
    <?php if ($endPage < $totalPage): ?>
      <button class="pagination-btn"
        onclick="window.location.href='?page=<?= $totalPage ?>&search=<?= urlencode($search) ?>'">
        <i class="fa-solid fa-angles-right"></i>
      </button>
    <?php endif; ?>



  </div>


</div>

<script>
  const btnSearch = document.querySelector(".fa-search");

  //搜尋
  btnSearch.addEventListener("click", function () {
    const query = document.querySelector("input[name=search]").value;
    window.location.href = `./delete.php?search=${query}`;
  })
  const btnDels = document.querySelectorAll(".btn-del");
  btnDels.forEach((btn) => {
    btn.addEventListener("click", doConfirm);
  });

  function doConfirm(e) {
    const btn = e.target.closest('.btn-del');
    if (confirm("確定要永久刪除?")) {
      window.location.href = `./doRelyDelete.php?id=${btn.dataset.id}`;
    }
  }
</script>

<?php
include "../template_btm.php";
?>