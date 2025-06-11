<?php
require_once "./connect.php";
require_once "./Utilities.php";

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
        WHERE v.`is_valid` = 0 
        ORDER BY v.id 
        LIMIT $perPage OFFSET $pageStart";


$sqlAll = "SELECT COUNT(*) as total FROM `o_vinyl` WHERE `is_valid` = 1";
$sqlCate = "SELECT * FROM `main_category`";

try {
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

   $stmtCate = $pdo->prepare($sqlCate);
  $stmtCate->execute();
  $rowsCate = $stmtCate->fetchAll(PDO::FETCH_ASSOC);

  $stmtAll = $pdo->prepare($sqlAll);
  $stmtAll->execute();
  $totalCount = $stmtAll->fetchColumn();
} catch (PDOException $e) {
  echo "錯誤: {$e->getMessage()}";
  exit;
}
$totalPage = ceil($totalCount / $perPage);
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>二手商品首頁</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
  <!-- Font Awesome CDN -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    .msg {
      display: flex;
      align-items: center;
      margin-bottom: 2px;
      padding: 8px 5px;
      border-bottom: 1px solid #eee;
      min-height: 40px;
    }

    .msg:first-child {
      font-weight: bold;
      background-color: #f8f9fa;
      border-bottom: 2px solid #dee2e6;
    }

    .id {
      width: 40px;
      flex-shrink: 0;
      text-align: center;
    }

    .img {
      width: 120px;
      flex-shrink: 0;
      padding-right: 10px;
      text-align: center;
    }

    .img img {
      width: 100%;
      height: 80px;
      object-fit: cover;
      border-radius: 4px;
    }

    .name {
      width: 150px;
      flex-shrink: 0;
      padding-right: 10px;
      word-wrap: break-word;
      overflow-wrap: break-word;
    }

    .desc {
      flex: 1;
      min-width: 100px;
      padding-right: 10px;
      word-wrap: break-word;
      overflow-wrap: break-word;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .choice {
      width: 60px;
      flex-shrink: 0;
      text-align: center;
      padding-right: 5px;
      font-size: 0.9em;
    }

    .price {
      width: 80px;
      flex-shrink: 0;
      text-align: right;
      padding-right: 10px;
    }

    .release_date {
      width: 90px;
      flex-shrink: 0;
      text-align: center;
    }

    .main_category {
      width: 80px;
      flex-shrink: 0;
      text-align: center;
      padding-right: 5px;
    }

    .sub_category {
      width: 100px;
      flex-shrink: 0;
      text-align: center;
      padding-right: 10px;
    }

    .actions {
      width: 200px;
      flex-shrink: 0;
      text-align: right;
    }

    .actions .btn {
      font-size: 0.8em;
      padding: 0.25rem 0.5rem;
    }
  </style>
</head>

<body>
  <div class="container-fluid mt-3">
    <h1>二手商品列表</h1>
    <div class="my-2 d-flex">
      <span class="me-auto">目前共 <?= $totalCount ?> 筆資料</span>
      <a class="btn btn-primary btn-sm btn-add" href="./index.php">
        <i class="fa-solid fa-house"></i></i> 回首頁
      </a>
    </div>

    <!-- 表頭 -->
    <div class="msg ps-1">
      <div class="id">#</div>
      <div class="img">照片</div>
      <div class="name">專輯名稱</div>
      <div class="desc">介紹</div>
      <div class="choice">狀態</div>
      <div class="choice">狀況</div>
      <div class="choice">庫存</div>
      <div class="choice">尺寸</div>
      <div class="choice">公司</div>
      <div class="price">價格</div>
      <div class="release_date">發行日</div>
      <div class="main_category">主分類</div>
      <div class="sub_category">次分類</div>
       <div class="choice">建立時間</div>
       <div class="actions">操作</div>
    </div>

    <!-- 資料列 -->
    <?php foreach ($rows as $index => $row): ?>
      <div class="msg">
        <div class="id"><?=$row["id"]?></div>
        
        <!-- 圖片 -->
        <div class="img">
          <?php if (!empty($row["imge_url"])): ?>
            <?php if (filter_var($row["imge_url"], FILTER_VALIDATE_URL)): ?>
              <img src="<?= htmlspecialchars($row["imge_url"]) ?>" alt="專輯圖片">
            <?php else: ?>
              <img src="./uploads/<?= htmlspecialchars($row["imge_url"]) ?>" alt="專輯圖片">
            <?php endif; ?>
          <?php else: ?>
            <img src="./uploads/no-image.png" alt="無圖片">
          <?php endif; ?>
        </div>

        <!-- 專輯名稱 -->
        <div class="name" title="<?= htmlspecialchars($row["name"]) ?>">
          <?= htmlspecialchars($row["name"]) ?>
        </div>

        <!-- 簡介 -->
        <div class="desc" title="<?= htmlspecialchars($row["desc"] ?? '') ?>">
          <?= htmlspecialchars($row["desc"] ?? '') ?>
        </div>

        <!-- 狀態 -->
        <div class="choice"><?= htmlspecialchars($row["status_name"] ?? '未知') ?></div>
        
        <!-- 狀況 -->
        <div class="choice"><?= htmlspecialchars($row["condition_name"] ?? '未知') ?></div>
        
        <!-- 庫存 -->
        <div class="choice"><?= intval($row["stock"] ?? 0) ?></div>
        
        <!-- 尺寸 -->
        <div class="choice"><?= htmlspecialchars($row["lp_size"] ?? '未知') ?></div>
        
        <!-- 公司 -->
        <div class="choice" title="<?= htmlspecialchars($row["company_name"] ?? '未知公司') ?>">
          <?= htmlspecialchars($row["company_name"] ?? '未知') ?>
        </div>

        <!-- 價格 -->
        <div class="price">$<?= number_format($row["price"]) ?></div>
        
        <div class="release_date"><?= $row["release_date"] ?></div>
        <div class="main_category"><?= htmlspecialchars($row["main_category_title"] ?? '未分類') ?></div>
        <div class="sub_category"><?= htmlspecialchars($row["sub_category_title"] ?? '未分類') ?></div>
        <!-- 更新時間 -->
        <div class="choice"><?= $row["creatTime"]?></div>
        
        <div class="actions">
          <button class="btn btn-danger btn-sm btn-del me-1" data-id="<?= $row["id"] ?>">
            <i class="fas fa-trash"></i> 刪除
          </button>
          <a class="btn btn-warning btn-sm me-1" href="./doReturn.php?id=<?= $row["id"] ?>">
            <i class="fa-solid fa-rotate-right"></i>復原
          </a>
        </div>
      </div>
    <?php endforeach; ?>

    <!-- 分頁 -->
    <nav aria-label="分頁導航" class="mt-4">
      <ul class="pagination pagination-sm justify-content-center">
        <?php for ($i = 1; $i <= $totalPage; $i++): ?>
          <li class="page-item <?= $page == $i ? "active" : "" ?>">
            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
          </li>
        <?php endfor; ?>
      </ul>
    </nav>
         
           
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
    crossorigin="anonymous"></script>
  <script>
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
</body>

</html>
