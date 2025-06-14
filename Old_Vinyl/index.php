<?php
require_once "../components/connect.php";
require_once "../components/Utilities.php";

$pageTitle = "二手商品管理";
$cssList = ["../css/index.css", "../coupon/coupon.css", "./Old_Vinyl.css"]; //
include "../vars.php";
include "../template_top.php";
include "../template_main.php";

$values = [];
// 分頁
$perPage = 10; // 每頁顯示的資料筆數
$page = intval($_GET["page"] ?? 1);
$pageStart = ($page - 1) * $perPage;

// 設定排序字段和順序
$valid_columns = ['price', 'creatTime'];
$sort_column = isset($_GET['sort_by']) && in_array($_GET['sort_by'], $valid_columns) ? $_GET['sort_by'] : null;
$sort_order = isset($_GET['sort_order']) && $_GET['sort_order'] === 'desc' ? 'desc' : 'asc';
$next_sort_order = $sort_order === 'asc' ? 'desc' : 'asc';


// 搜尋功能
$search = $_GET["search"] ?? "";
if ($search != "") {
  $whereConditions[] = "(v.name LIKE :search OR v.desc LIKE :search OR cp.name LIKE :search)";
  $values["search"] = "%$search%";
}

// 主分類篩選
$mcid = intval($_GET["mcid"] ?? 0);
if ($mcid > 0) {
  $whereConditions[] = "mc.id = :mcid";
  $values["mcid"] = $mcid;
}

// 次分類篩選
$scid = intval($_GET["scid"] ?? 0);
if ($scid > 0) {
  $whereConditions[] = "sc.id = :scid";
  $values["scid"] = $scid;
}

// 狀態篩選
$status = intval($_GET["status"] ?? 0);
if ($status > 0) {
  $whereConditions[] = "st.id = :status";
  $values["status"] = $status;
}
// 狀況篩選
$condition = intval($_GET["condition"] ?? 0);
if ($condition > 0) {
  $whereConditions[] = "cd.id = :condition";
  $values["condition"] = $condition;
}

// 固定條件
$whereConditions[] = "v.is_valid = 1";

// 組建完整的 WHERE 子句
$whereClause = "WHERE " . implode(" AND ", $whereConditions);
$sqlAll = "SELECT COUNT(*) as total FROM `o_vinyl` v 
           LEFT JOIN `main_category` mc ON v.main_category_id = mc.id
           LEFT JOIN `company` cp ON v.company_id = cp.id
           LEFT JOIN `sub_category` sc ON v.sub_category_id = sc.id
           LEFT JOIN `status` st ON v.status_id = st.id
           LEFT JOIN `condition` cd ON v.condition_id = cd.id
           $whereClause ";
$valuesAll = $values;

// 假設有按升密降冪
if ($sort_column) {
  $orderByClause = "ORDER BY v.$sort_column $sort_order, v.id ASC";
} else {
  $orderByClause = "ORDER BY v.id ASC";
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
        $whereClause
        $orderByClause
        LIMIT $perPage OFFSET $pageStart";

;
$sqlMCate = "SELECT * FROM `main_category`";
$sqlSCate = "SELECT * FROM `sub_category`";
$sqlStatus = "SELECT * FROM `status`";
$sqlCondition = "SELECT * FROM `condition`";

try {
  $stmt = $pdo->prepare($sql);
  $stmt->execute($values);
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $stmtMCate = $pdo->prepare($sqlMCate);
  $stmtMCate->execute();
  $rowsMCate = $stmtMCate->fetchAll(PDO::FETCH_ASSOC);

  $stmtSCate = $pdo->prepare($sqlSCate);
  $stmtSCate->execute();
  $rowsSCate = $stmtSCate->fetchAll(PDO::FETCH_ASSOC);

  $stmtStatus = $pdo->prepare($sqlStatus);
  $stmtStatus->execute();
  $rowsStatus = $stmtStatus->fetchAll(PDO::FETCH_ASSOC);

  $stmtCondition = $pdo->prepare($sqlCondition);
  $stmtCondition->execute();
  $rowsCondition = $stmtCondition->fetchAll(PDO::FETCH_ASSOC);

  $stmtAll = $pdo->prepare($sqlAll);
  $stmtAll->execute($values);
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
    <a class="btn btn-sm btn-info   justify-content-start" href="./delete.php">
      <i class="fas fa-trash"></i> 回收桶
    </a>
  </div>
  <!-- 整合搜尋區域 -->
  <div class="controls-section d-flex align-items-end flex-wrap gap-2">

    <div class="search-box flex-grow-3 ml15px">
      <input name="search" type="text" class="form-control form-control-sm" placeholder="搜尋(專輯名稱、內文、公司名稱)">
      <i class="fas fa-search"></i>
    </div>

    <div class="filter-group flex-grow-1 ml15px">
      <select name="main_category_id" id="main_category_id" class="form-select">
        <option value="">選擇主分類</option>
        <?php foreach ($rowsMCate as $rowMCate): ?>
          <option value="<?= $rowMCate["id"] ?>" <?= ($mcid == $rowMCate["id"]) ? 'selected' : '' ?>>
            <?= htmlspecialchars($rowMCate['title']) ?>
          </option>
        <?php endforeach; ?>
      </select>


    </div>
    <!-- 次分類 -->
    <div class="filter-group flex-grow-1 ml15px">
      <select class="form-select" name="sub_category_id" id="sub_category_id">
        <option value="">選擇次分類</option>
        <?php foreach ($rowsSCate as $rowSCate): ?>
          <option value="<?= $rowSCate["id"] ?>" data-main="<?= $rowSCate["main_category_id"] ?>"
            <?= ($scid == $rowSCate["id"]) ? 'selected' : '' ?>>
            <?= htmlspecialchars($rowSCate['title']) ?>
          </option>
        <?php endforeach; ?>
      </select>

    </div>
    <!-- 狀態 -->
    <div class="filter-group flex-grow-1 ml15px">
      <select class="form-select" name="status_id" id="status_id">
        <option value="">選擇狀態</option>
        <?php foreach ($rowsStatus as $rowStatus): ?>
          <option value="<?= $rowStatus["id"] ?>" <?= ($status == $rowStatus["id"]) ? 'selected' : '' ?>>
            <?= htmlspecialchars($rowStatus['name']) ?>
          </option>
        <?php endforeach; ?>
      </select>
      <!-- 狀況 -->


    </div>
    <div class="filter-group ml15px">
      <select class="form-select" name="condition_id" id="condition_id">
        <option value="">選擇狀況</option>
        <?php foreach ($rowsCondition as $rowCondition): ?>
          <option value="<?= $rowCondition["id"] ?>" <?= ($condition == $rowCondition["id"]) ? 'selected' : '' ?>>
            <?= htmlspecialchars($rowCondition['name']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>


    <div class="form-actions controls-actions flex-grow-1">
      <button type="button" class="accept-filters btn btn-primary" id="omcSearchBtn">搜尋</button>
      <button type="button" class="clear-filters" onclick="window.location.href='index.php'">清除篩選</button>
    </div>


  </div>



  <div class="table-container table-responsive">
    <table class="table table-bordered table-striped align-middle table">
      <thead class="table-dark">
        <tr class="index_tr">
          <th class="index_sm">編號</th>
          <th class="index_img">照片</th>
          <th class="index_name">專輯名稱</th>
          <th class="index_sm">主分類</th>
          <th>次分類</th>
          <th class="index_sm">狀態</th>
          <th class="index_sm">狀況</th>
          <th class="index_sm">庫存</th>
          <th class="index_sm">尺寸</th>
          <th class="index_sm sortable ">
            <a
              href="?page=<?= $page ?>&search=<?= urlencode($search) ?>&mcid=<?= $mcid ?>&scid=<?= $scid ?>&status=<?= $status ?>&condition=<?= $condition ?>&sort_by=price&sort_order=<?= ($sort_column === 'price') ? $next_sort_order : 'asc' ?>">
              價格
              <?php if ($sort_column === 'price'): ?>
                <i class=" fas fa-caret-<?= $sort_order === 'asc' ? 'up' : 'down' ?> "></i>
              <?php else: ?>
                <i class="fas fa-sort"></i>
              <?php endif; ?>
            </a>

          </th>
          <th class=" sortable">
            <a
              href="?page=<?= $page ?>&search=<?= urlencode($search) ?>&mcid=<?= $mcid ?>&scid=<?= $scid ?>&status=<?= $status ?>&condition=<?= $condition ?>&sort_by=creatTime&sort_order=<?= ($sort_column === 'creatTime') ? $next_sort_order : 'asc' ?>">
              建立時間
              <?php if ($sort_column === 'creatTime'): ?>
                <i class="fas fa-caret-<?= $sort_order === 'asc' ? 'up' : 'down' ?>"></i>
              <?php else: ?>
                <i class="fas fa-sort"></i>
              <?php endif; ?>
            </a>
          <th class="index_sm">操作</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($rows as $index => $row): ?>
          <tr class="index_tr">
            <!-- 產品 -->
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
            <td class="name index_name" title="<?= htmlspecialchars($row["name"]) ?>">
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
            <td class="text-center  index_sm">
              <div class="action-buttons">
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
        onclick="window.location.href='?page=1&search=<?= urlencode($search) ?>&mcid=<?= $mcid ?>&scid=<?= $scid ?>&status=<?= $status ?>&condition=<?= $condition ?>&sort_by=<?= $sort_column; ?>&sort_order=<?= $sort_order; ?>'"><i
          class="fa-solid fa-angles-left"></i></button>
    <?php endif; ?>

    <!-- // 上一頁按鈕 -->
    <?php if ($page > 1): ?>
      <button class="pagination-btn"
        onclick="window.location.href='?page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>&mcid=<?= $mcid ?>&scid=<?= $scid ?>&status=<?= $status ?>&condition=<?= $condition ?>&sort_by=<?= $sort_column; ?>&sort_order=<?= $sort_order; ?>'">
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
        onclick="window.location.href='?page=<?= $i ?>&search=<?= urlencode($search) ?>&mcid=<?= $mcid ?>&scid=<?= $scid ?>&status=<?= $status ?>&condition=<?= $condition ?>&sort_by=<?= $sort_column; ?>&sort_order=<?= $sort_order; ?>'">
        <?= $i ?>
      </button>
    <?php endfor; ?>

    <!-- 下一頁按鈕 -->
    <?php if ($page < $totalPage): ?>
      <button class="pagination-btn"
        onclick="window.location.href='?page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>&mcid=<?= $mcid ?>&scid=<?= $scid ?>&status=<?= $status ?>&condition=<?= $condition ?>&sort_by=<?= $sort_column; ?>&sort_order=<?= $sort_order; ?>'">
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
        onclick="window.location.href='?page=<?= $totalPage ?>&search=<?= urlencode($search) ?>&mcid=<?= $mcid ?>&scid=<?= $scid ?>&status=<?= $status ?>&condition=<?= $condition ?>&sort_by=<?= $sort_column; ?>&sort_order=<?= $sort_order; ?>'">
        <i class="fa-solid fa-angles-right"></i>
      </button>
    <?php endif; ?>



  </div>
</div>












<script>
  const btnDels = document.querySelectorAll(".btn-del");
  const btnSearch = document.querySelector(".fa-search");
  const omcSearchBtn = document.querySelector("#omcSearchBtn");

  //搜尋
  btnSearch.addEventListener("click", function () {
    const query = document.querySelector("input[name=search]").value;
    window.location.href = `./index.php?search=${query}`;
  })
  //全域搜尋
  omcSearchBtn.addEventListener("click", function () {
    const params = new URLSearchParams();

    const search = document.querySelector("input[name=search]").value;
    const mcid = document.querySelector("select[name=main_category_id]").value;
    const scid = document.querySelector("select[name=sub_category_id]").value;
    const status = document.querySelector("select[name=status_id]").value;
    const condition = document.querySelector("select[name=condition_id]").value;
    if (search) params.append('search', search);
    if (mcid) params.append('mcid', mcid);
    if (scid) params.append('scid', scid);
    if (status) params.append('status', status);
    if (condition) params.append('condition', condition);

    window.location.href = `./index.php?${params.toString()}`;
  });



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

</script>
<?php
include "../template_btm.php";
?>