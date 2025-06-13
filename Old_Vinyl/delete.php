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


$sqlAll = "SELECT COUNT(*) as total FROM `o_vinyl` WHERE $searchSQL `is_valid` =0 ";
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
    <h3 class="section-title">已刪除二手商品</h3>
    <span class="ms-auto">目前共 <?= $totalCount ?> 筆資料</span>
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
                <button class="btn btn-danger btn-sm btn-del me-1" data-id="<?= $row["id"] ?>">
                  <i class="fas fa-trash"></i> 刪除
                </button>
                <a class="btn btn-warning btn-sm me-1" href="./doReturn.php?id=<?= $row["id"] ?>">
                  <i class="fa-solid fa-rotate-right"></i>復原
                </a>
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
        href="./delete.php?page=<?= $i ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
    <?php endfor; ?>
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