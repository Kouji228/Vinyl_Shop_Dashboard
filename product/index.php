<?php
// ? 首頁資訊
// session_start();
// if(!isset($_SESSION["user"])){
//     header("location: ./login.php");
//     exit;
// }

require_once "../components/connect.php";
require_once "../components/Utilities.php";


$pageTitle = "黑膠商品列表";
$cssList = ["../css/index.css", "css/product.css"];
include "../vars.php";
include "../template_top.php";
include "../template_main.php";

$genre = intval($_GET["genre"] ?? 0);
$gender = intval($_GET["gender"] ?? 0);
$status = isset($_GET["status"]) ? intval($_GET["status"]) : null;

// ? 修改排序
// 1. 定義允許排序的欄位
$valid_columns = ['id', 'price', 'title', 'author'];

// 2. 取得 GET 參數
$sort_by = $_GET['sort_by'] ?? '';
$sort_order = ($_GET['sort_order'] ?? 'asc') === 'desc' ? 'desc' : 'asc';

// 3. 判斷 sort_by 是否在允許欄位中，否則預設 'id'
$sort_column = in_array($sort_by, $valid_columns) ? $sort_by : 'id';

$conditions = [];
$values = [];

if ($genre != 0) {
  $conditions[] = "vinyl.genre_id = :genre";
  $values["genre"] = $genre;
}
if ($gender != 0) {
  $conditions[] = "vinyl.gender_id = :gender";
  $values["gender"] = $gender;
}

if (isset($_GET["status"]) && $_GET["status"] !== "") {
  $status = intval($_GET["status"]);
  $conditions[] = "status_id = :status";
  $values["status"] = $status;
} else {
  $conditions[] = "status_id = 1"; // 預設狀態
}

$author_id = $_GET["author_id"] ?? "";
if ($author_id) {
  $conditions[] = "vinyl.author_id = :author_id";
  $values["author_id"] = $author_id;
}

$titleSearch = $_GET["title"] ?? "";
$authorSearch = $_GET["author"] ?? "";

$company = $_GET["company"] ?? "";
$format = $_GET["format"] ?? "";
$stock = $_GET["stock"] ?? "";

if ($titleSearch) {
  $conditions[] = "title LIKE :title";
  $values["title"] = "%$titleSearch%";
}
if ($authorSearch) {
  $conditions[] = "vinyl_author.author LIKE :author_name";
  $values["author_name"] = "%$authorSearch%";
}

if ($company) {
  $conditions[] = "company LIKE :company";
  $values["company"] = "%$company%";
}
if ($format) {
  $conditions[] = "format = :format";
  $values["format"] = $format;
}
if ($stock !== "") {
  $conditions[] = "stock >= :stock";
  $values["stock"] = (int) $stock;
}

$price1 = $_GET["price1"] ?? "";
$price2 = $_GET["price2"] ?? "";

if ($price1 !== "" || $price2 !== "") {
  $startPrice = $price1 !== "" ? (float) $price1 : 0;
  $endPrice = $price2 !== "" ? (float) $price2 : 100000;

  $conditions[] = "(price BETWEEN :startPrice AND :endPrice)";
  $values["startPrice"] = $startPrice;
  $values["endPrice"] = $endPrice;
}

$date1 = $_GET["date1"] ?? "";
$date2 = $_GET["date2"] ?? "";

if ($date1 !== "" || $date2 !== "") {
  $startDate = $date1 !== "" ? $date1 : '0000-01-01';
  $endDate = $date2 !== "" ? $date2 : '9999-12-31';

  $conditions[] = "(release_date BETWEEN :startDate AND :endDate)";
  $values["startDate"] = $startDate;
  $values["endDate"] = $endDate;
}

$whereSQL = "WHERE " . implode(" AND ", $conditions);

$perPage = $_GET["perPage"] ?? 20;
$page = intval($_GET["page"] ?? 1);
$pageStart = ($page - 1) * $perPage;

$select = "vinyl.id AS id,title,vinyl_img.img_name AS img_name,author_id,vinyl_author.author AS author,company,price,stock,vinyl_genre.genre AS genre,vinyl_gender.gender AS gender,status_id FROM `vinyl` JOIN vinyl_author ON vinyl_author.id = vinyl.author_id JOIN vinyl_genre on vinyl_genre.id = vinyl.genre_id JOIN vinyl_gender on vinyl_gender.id = vinyl.gender_id JOIN vinyl_img on vinyl_img.shs_id = vinyl.shs_id";

$sql = "SELECT $select $whereSQL ORDER BY $sort_column $sort_order LIMIT $perPage OFFSET $pageStart";
$sqlAll = "SELECT $select  $whereSQL ";

$sqlAuthor = "SELECT * FROM vinyl_author";
$sqlGenre = "SELECT * FROM vinyl_genre";
$sqlGender = "SELECT * FROM vinyl_gender";
$sqlStatus = "SELECT * FROM vinyl_status";

$sqlVinyl = "SELECT * FROM vinyl where status_id = 1";

try {
  $stmt = $pdo->prepare($sql);
  $stmt->execute($values);
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $stmtGenre = $pdo->prepare($sqlGenre);
  $stmtGenre->execute();
  $rowsGenre = $stmtGenre->fetchAll(PDO::FETCH_ASSOC);

  $stmtGender = $pdo->prepare($sqlGender);
  $stmtGender->execute();
  $rowsGender = $stmtGender->fetchAll(PDO::FETCH_ASSOC);

  $stmtStatus = $pdo->prepare($sqlStatus);
  $stmtStatus->execute();
  $rowsStatus = $stmtStatus->fetchAll(PDO::FETCH_ASSOC);

  $stmtAll = $pdo->prepare($sqlAll);
  $stmtAll->execute($values);
  $totalCount = $stmtAll->rowCount();

  $stmtAuthor = $pdo->prepare($sqlAuthor);
  $stmtAuthor->execute();
  $rowsAuthor = $stmtAuthor->fetchAll(PDO::FETCH_ASSOC);

  $stmtVinyl = $pdo->prepare($sqlVinyl);
  $stmtVinyl->execute();
  $rowsVinyl = $stmtVinyl->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  echo "系統錯誤，請恰管理人員<br>";
  echo "錯誤: " . $e->getMessage();
  exit;
}
$genders = array_filter($rowsGender, fn($g) => $g["genre_id"] == $genre);

$totalPage = ceil($totalCount / $perPage);
?>


<div class="content-section">

  <!-- 小標題 -->
  <div class="section-header d-flex justify-content-between align-items-center">
    <?php
    if (isset($status) && $status !== '') {
      foreach ($rowsStatus as $row) {
        if ($row["id"] == $status) {
          $statusName = $row["status"];
          break;
        }
      }
    } else {
      $statusName = "上架";
    }
    ?>
    <h3 class="section-title"><?= $statusName ?>商品列表</h3>
    <span class="fs-5 ms-auto me-3 flex-center">總共 <?= $totalCount ?> 個商品</span>
    <a href="./vinylAdd.php" class="btn btn-primary">增加黑膠唱片</a>
  </div>

  <!--搜尋與分類 -->
  <div class="controls-section">
    <div class="w-100 d-flex">
      <button type="button" class="btn clear-filters me-1"><a class="text-decoration-none text-white"
          href="./">清除搜尋</a></button>
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">進階搜尋</button>
      <span class="fs-5 ms-3 flex-center">每頁有 <?= $perPage ?> 個商品</span>
      <div class="ms-auto d-flex w200">
        <select name="perpage" id="perpageNum" class="form-select w100 me-2">
          <option value="20" <?= $perPage == 20 ? "selected" : "" ?>>20</option>
          <option value="50" <?= $perPage == 50 ? "selected" : "" ?>>50</option>
          <option value="100" <?= $perPage == 100 ? "selected" : "" ?>>100</option>
        </select>
        <select name="status" id="status" class="form-select w100 ms-auto">
          <?php foreach ($rowsStatus as $row): ?>
            <option value="<?= $row["id"] ?>" <?= ($status === null || $status === '') && $row["id"] == 1 ? 'selected' : ($status == $row["id"] ? 'selected' : '') ?>>
              <?= $row["status"] ?>
            </option>
          <?php endforeach ?>
        </select>
      </div>
    </div>

    <!-- 篩選與搜尋 -->
    <div class="filter-group gap-3">
      <label for="genre" class="form-label">風格</label>

      <div class="col-auto">
        <select name="genre" id="genre" class="form-select w25">
          <option value="" <?= empty($genre) ? 'selected' : '' ?>>全部</option>
          <?php foreach ($rowsGenre as $row): ?>
            <option value="<?= $row["id"] ?>" <?= $genre == $row["id"] ? "selected" : "" ?>>
              <?= $row["genre"] ?>
            </option>
          <?php endforeach ?>
        </select>
      </div>

      <div class="col-auto">
        <label for="gender" class="form-label">類別</label>
      </div>
      <div class="col-auto">
        <select name="gender" id="gender" class="form-select w25">
          <option value="/" <?= empty($gender) ? 'selected' : '' ?>>全部</option>
          <?php foreach ($genders as $g): ?>
            <option value="<?= $g["id"] ?>" <?= $gender == $g["id"] ? "selected" : "" ?>>
              <?= $g["gender"] ?>
            </option>
          <?php endforeach ?>
        </select>
      </div>
    </div>

    <div class="price flex-center">
      <div class="col-auto flex-center">
        <label class="form-label me-3" for="price1">價格</label>
      </div>
      <div class="col-auto w150">
        <input name="price1" id="price1" type="number" class="form-control " placeholder="<?= $price1 ?>">
      </div>
      <div class="col-auto mx-2"> ~ </div>
      <div class="col-auto w150">
        <input name="price2" type="number" class="form-control" placeholder="<?= $price2 ?>">
      </div>
    </div>

    <div class="search flex-center flex-grow-1">
      <div class="input-group  flex-center">
        <?php
        $searchHolder = !empty($titleSearch) ? $titleSearch : (!empty($authorSearch) ? $authorSearch : "專輯或創作者");
        ?>
        <label class="form-label me-3 w-auto" for="searchType">搜尋</label>
        <select class="rounded-start form-select flex-center" name="searchType" id="searchType">
          <option value="title">專輯</option>
          <option value="author">創作者</option>
        </select>
        <input name="search" type="text" class="form-control rounded-end searchInput"
          placeholder="<?= htmlspecialchars($searchHolder) ?>" list="titleList">
        <datalist id="titleList">
          <?php foreach ($rowsVinyl as $row): ?>
            <option value="<?= $row["title"] ?>"></option>
          <?php endforeach ?>
        </datalist>

        <!-- <i class="fas fa-search btn-search"></i> -->
      </div>
      <div class="btn btn-primary btn-search ms-2 flex-center wh50"><i class="fa fa-search"></i></div>
    </div>

  </div>

  <!-- 商品列表 -->
  <div class="table-container table-responsive w-100">
    <table class="table table-bordered table-striped align-middle w-100 ">
      <thead class="table-dark">
        <tr>
          <th class="id sortable sortBy cursor-pointer" id="id">
            編號
            <?php if ($sort_column === 'id'): ?>
              <i class="fa-solid fa-caret-<?= $sort_order === 'asc' ? 'up' : 'down'; ?>"></i>
            <?php endif; ?>
          </th>
          <th class="img">圖片</th>
          <th class="title sortable sortBy cursor-pointer" id="title">專輯
            <?php if ($sort_column === 'title'): ?>
              <i class="fa-solid fa-caret-<?= $sort_order === 'asc' ? 'up' : 'down'; ?>"></i>
            <?php endif; ?>
          </th>
          <th class="author sortable sortBy cursor-pointer" id="author">藝術家
            <?php if ($sort_column === 'author'): ?>
              <i class="fa-solid fa-caret-<?= $sort_order === 'asc' ? 'up' : 'down'; ?>"></i>
            <?php endif; ?>
          </th>
          <th class="price sortable sortBy cursor-pointer" id="price">
            價格
            <?php if ($sort_column === 'price'): ?>
              <i class="fa-solid fa-caret-<?= $sort_order === 'asc' ? 'up' : 'down'; ?>"></i>
            <?php endif; ?>
          </th>
          <th class="stock">庫存</th>
          <th class="genre">風格</th>
          <th class="gender">類別</th>
          <th class="time text-center">操作</th>
        </tr>
      </thead>
      <tbody>
        <?php if (count($rows) > 0): ?>
          <?php foreach ($rows as $index => $row): ?>
            <tr>
              <td><?= $index + 1 + ($page - 1) * $perPage ?></td>
              <td><img class="wh50" src="/product/img/<?= $row["img_name"] ?>" alt="" srcset=""></td>
              <td class="title">
                <a href="./vinylDetail.php?id=<?= $row["id"] ?>">
                  <?= htmlspecialchars($row["title"]) ?>
                </a>
              </td>
              <td class="author">
                <a href="./index.php?author_id=<?= $row["author_id"] ?>">
                  <?= htmlspecialchars($row["author"]) ?>
                </a>
              </td>
              <td><?= htmlspecialchars($row["price"]) ?></td>
              <td>
                <?= htmlspecialchars($row["stock"]) ?>
              </td>
              <td><?= htmlspecialchars($row["genre"]) ?></td>
              <td><?= htmlspecialchars($row["gender"]) ?></td>

              <td class="time">
                <?php if ($row["status_id"] == 0): ?>
                  <div class="btn btn-success btn-sm btn-restock" data-id="<?= $row["id"] ?>"
                    data-title="<?= $row["title"] ?>">
                    上架</div>
                  <div class="btn btn-danger btn-sm btn-del" data-id="<?= $row["id"] ?>" data-title="<?= $row["title"] ?>">
                    刪除
                  </div>
                <?php else: ?>
                  <div class="btn btn-danger btn-sm btn-remove" data-id="<?= $row["id"] ?>" data-title="<?= $row["title"] ?>">
                    下架</div>
                  <a class="btn btn-warning btn-sm" href="./vinylUpdate.php?id=<?= $row["id"] ?>">
                    <!-- <i class="fas fa-edit"></i> -->
                    編輯
                  </a>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="9" class="text-center">目前無資料</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- 分頁 -->
  <div class="w-100">
    <div class="pagination  d-flex justify-content-center">
      <?php
      function makeLink($page, $genre, $gender, $author_id, $status, $price1, $price2, $titleSearch, $authorSearch, $sort_column, $sort_order, $company, $stock, $format, $date1, $date2, $perPage)
      {
        $params = ["page={$page}"];
        if ($genre > 0)
          $params[] = "genre={$genre}";
        if ($gender > 0)
          $params[] = "gender={$gender}";
        if ($status > -1)
          $params[] = "status={$status}";
        if ($author_id !== "")
          $params[] = "author_id={$author_id}";
        if ($price1 !== "")
          $params[] = "price1={$price1}";
        if ($price2 !== "")
          $params[] = "price2={$price2}";
        if ($titleSearch)
          $params[] = "title={$titleSearch}";
        if ($authorSearch)
          $params[] = "author={$authorSearch}";
        if ($sort_column)
          $params[] = "sort_by={$sort_column}";
        if ($sort_order)
          $params[] = "sort_order={$sort_order}";
        if ($company)
          $params[] = "company={$company}";
        if ($stock)
          $params[] = "stock={$stock}";
        if ($format)
          $params[] = "format={$format}";
        if ($date1)
          $params[] = "date1={$date1}";
        if ($date2)
          $params[] = "date2={$date2}";
        if ($perPage)
          $params[] = "perPage={$perPage}";
        return "./index.php?" . implode("&", $params);
      }
      ?>

      <?php if ($totalCount > 0): ?>
        <a class="pagination-btn"
          href="<?= makeLink(1, $genre, $gender, $author_id, $status, $price1, $price2, $titleSearch, $authorSearch, $sort_column, $sort_order, $company, $stock, $format, $date1, $date2, $perPage) ?>">
          <i class="fa-solid fa-angles-left"></i>
        </a>

        <?php if ($page > 1): ?>
          <a href="<?= makeLink($page - 1, $genre, $gender, $author_id, $status, $price1, $price2, $titleSearch, $authorSearch, $sort_column, $sort_order, $company, $stock, $format, $date1, $date2, $perPage) ?>"
            class="pagination-btn"><i class="fas fa-chevron-left"></i></a>
        <?php endif; ?>

        <?php
        if ($totalPage <= 5) {
          $start = 1;
          $end = $totalPage;
        } else {
          if ($page <= 2) {
            $start = 1;
            $end = 5;
          } elseif ($page >= $totalPage - 1) {
            $start = $totalPage - 4;
            $end = $totalPage;
          } else {
            $start = $page - 2;
            $end = $page + 2;
          }
        }
        for ($i = $start; $i <= $end; $i++): ?>
          <a class="pagination-btn text-decoration-none <?= $page == $i ? "active" : "" ?>"
            href="<?= makeLink($i, $genre, $gender, $author_id, $status, $price1, $price2, $titleSearch, $authorSearch, $sort_column, $sort_order, $company, $stock, $format, $date1, $date2, $perPage) ?>"><?= $i ?></a>
        <?php endfor; ?>

        <?php if ($page < $totalPage): ?>
          <a href="<?= makeLink($page + 1, $genre, $gender, $author_id, $status, $price1, $price2, $titleSearch, $authorSearch, $sort_column, $sort_order, $company, $stock, $format, $date1, $date2, $perPage) ?>"
            class="pagination-btn"><i class="fas fa-chevron-right"></i></a>
        <?php endif; ?>

        <a class="pagination-btn"
          href="<?= makeLink($totalPage, $genre, $gender, $author_id, $status, $price1, $price2, $titleSearch, $authorSearch, $sort_column, $sort_order, $company, $stock, $format, $date1, $date2, $perPage) ?>">
          <i class="fa-solid fa-angles-right"></i>
        </a>
      <?php endif; ?>

    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered"">
    <div class=" modal-content">
    <div class="modal-header bg-dark text-white">
      <h1 class="modal-title fs-5" id="exampleModalLabel">進階搜尋</h1>
      <button type="button" class="btn-close btn-white" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body">
      <div class="form-group info-group">
        <div class="form-row">
          <div class="form-group">
            <label class="form-label" for="modal_status">狀態</label>
            <select name="modal_status" id="modal_status" class="form-select">
              <?php foreach ($rowsStatus as $row): ?>
                <option value="<?= $row["id"] ?>" <?= ($status === null || $status === '') && $row["id"] == 1 ? 'selected' : ($status == $row["id"] ? 'selected' : '') ?>>
                  <?= $row["status"] ?>
                </option>
              <?php endforeach ?>
            </select>

          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label" for="modal_title">唱片名稱</label>
            <input name="modal_title" id="modal_title" type="text" class="form-control" placeholder="唱片名稱"
              <?= $titleSearch ? 'value="' . htmlspecialchars($titleSearch) . '"' : '' ?> list="titleList">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="modal_author" class="form-label">藝術家</label>
            <input name="modal_author" id="modal_author" type="text" class="form-control" placeholder="創作者名稱"
              <?= $authorSearch ? 'value="' . htmlspecialchars($authorSearch) . '"' : '' ?> list="authorList">
            <datalist id="authorList">
              <?php foreach ($rowsAuthor as $row): ?>
                <option value="<?= $row["author"] ?>"></option>
              <?php endforeach ?>
            </datalist>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="modal_company" class="form-label">公司</label>
            <input name="modal_company" id="modal_company" type="text" class="form-control" placeholder="公司名稱"
              <?= $company ? 'value="' . htmlspecialchars($company) . '"' : '' ?>>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label" for="modal_genre">風格</label>
            <select name="modal_genre" id="modal_genre" class="form-select">
              <option value="" <?= empty($genre) ? 'selected' : '' ?>>全部</option>
              <?php foreach ($rowsGenre as $row): ?>
                <option value="<?= $row["id"] ?>" <?= $genre == $row["id"] ? "selected" : "" ?>>
                  <?= $row["genre"] ?>
                </option>
              <?php endforeach ?>
            </select>
          </div>

          <div class="form-group">
            <label class="form-label" for="modal_gender">類別</label>
            <select name="modal_gender" id="modal_gender" class="form-select">
              <option value selected disabled>請選擇</option>
            </select>
            <!-- <div class="error-message" id="levelError"></div> -->
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label" for="modal_price1">最小價格</label>
            <input name="modal_price" id="modal_price1" type="number" class="form-control" placeholder="最小價格" <?= $price1 ? 'value="' . htmlspecialchars($price1) . '"' : '' ?>>
          </div>

          <div class="form-group">
            <label class="form-label" for="modal_price2">最大價格</label>
            <input name="modal_price" id="modal_price2" type="number" class="form-control" placeholder="最大價格" <?= $price2 ? 'value="' . htmlspecialchars($price2) . '"' : '' ?>>
          </div>


        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label" for="modal_stock">庫存</label>
            <input name="modal_stock" id="modal_stock" type="number" class="form-control" placeholder="庫存數量" <?= $stock ? 'value="' . htmlspecialchars($stock) . '"' : '' ?>>
            <!-- <div class="error-message" id="levelError"></div> -->
          </div>
          <div class="form-group">
            <label class="form-label" for="modal_format">規格</label>
            <input name="modal_format" id="modal_format" type="text" class="form-control" placeholder="LP數量 ex: 1LP"
              <?= $format ? 'value="' . htmlspecialchars($format) . '"' : '' ?>>
            <!-- <div class="error-message" id="levelError"></div> -->
          </div>

        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label" for="modal_date1">最小日期</label>
            <input name="modal_date1" id="modal_date1" type="date" class="form-control" <?= $date1 ? 'value="' . htmlspecialchars($date1) . '"' : '' ?>>
          </div>
          <div class="form-group">
            <label class="form-label" for="modal_date1">最大日期</label>
            <input name="modal_date2" id="modal_date2" type="date" class="form-control" <?= $date2 ? 'value="' . htmlspecialchars($date2) . '"' : '' ?>>
          </div>

        </div>
      </div>
    </div>

    <div class="modal-footer bg-dark">
      <button type="button" class="btn clear-filters me-1 btn-clear">清除篩選</button>
      <button type="button" class="btn btn-primary ms-auto filter-advance">搜尋</button>
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
    </div>
  </div>
</div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>

<script>
  const btnDel = document.querySelectorAll('.btn-del');
  const btnRemove = document.querySelectorAll('.btn-remove');
  const btnRestock = document.querySelectorAll('.btn-restock');
  const idSelect = document.querySelectorAll("th.id")

  const btnSearch = document.querySelector(".btn-search");
  const inputPrice1 = document.querySelector("input[name=price1]");
  const inputPrice2 = document.querySelector("input[name=price2]");
  const inputText = document.querySelector("input[name=search]")
  const queryType = document.querySelector('select[name=searchType]').value;

  const sort_column = "<?= $sort_column ?>";
  const sort_order = "<?= $sort_order ?>";
  const nextSortOrder = (sort_order === "asc") ? "desc" : "asc";

  const sortBy = document.querySelectorAll(".sortBy")

  const params = new URLSearchParams(window.location.search); // ← 用現有網址初始化

  const status = "<?= isset($_GET['status']) ? addslashes($_GET['status']) : '' ?>";
  const price1 = "<?= isset($_GET['price1']) ? addslashes($_GET['price1']) : '' ?>";
  const price2 = "<?= isset($_GET['price2']) ? addslashes($_GET['price2']) : '' ?>";
  const genre = "<?= isset($_GET['genre']) ? addslashes($_GET['genre']) : '' ?>";
  const gender = "<?= isset($_GET['gender']) ? addslashes($_GET['gender']) : '' ?>";
  const author = "<?= isset($_GET['author']) ? addslashes($_GET['author']) : '' ?>";
  const title = "<?= isset($_GET['title']) ? addslashes($_GET['title']) : '' ?>";
  const author_id = "<?= isset($_GET['author_id']) ? addslashes($_GET['author_id']) : '' ?>";

  if (status && status !== "undefined") params.set("status", status);
  if (genre && genre !== "undefined") params.set("genre", genre);
  if (gender && gender !== "undefined") params.set("gender", gender);
  if (price1 && price1 !== "undefined") params.set("price1", price1);
  if (price2 && price2 !== "undefined") params.set("price2", price2);
  if (author && author !== "undefined") params.set("author", author);
  if (title && title !== "undefined") params.set("title", title);
  if (author_id && author_id !== "undefined") params.set("author_id", author_id);


  btnDel.forEach((btn) => {
    btn.addEventListener("click", doConfirmDel);
  })

  btnRemove.forEach((btn) => {
    btn.addEventListener("click", doConfirmRemove);
  })

  btnRestock.forEach((btn) => {
    btn.addEventListener("click", () => {
      window.location.href = `./doRestockVinyl.php?id=${btn.dataset.id}`
    });
  })

  function doConfirmDel(e) {
    const btn = e.target
    // console.log(btn.dataset.id);
    if (confirm(btn.dataset.title + " 確定刪除嗎?")) {
      window.location.href = `./doDeleteVinyl.php?id=${btn.dataset.id}`
    }
  }

  function doConfirmRemove(e) {
    const btn = e.target
    // console.log(btn.dataset.id);
    if (confirm(btn.dataset.title + " 確定下架嗎?")) {
      window.location.href = `./doRemoveVinyl.php?id=${btn.dataset.id}`
    }
  }

  // idSelect.forEach("click",()=>{
  //   // s
  // })

  // !!　搜尋
  searchType.addEventListener('change', function () {
    if (this.value === 'author') {
      inputText.setAttribute('list', 'authorList');
    } else {
      inputText.setAttribute('list', 'titleList');
    }
  });

  btnSearch.addEventListener("click", () => {

    // 先移除舊的 title / author 參數，避免殘留
    params.delete("title");
    params.delete("author");
    params.delete("price1");
    params.delete("price2"); 

    // 處理價格區間
    if (inputPrice1.value !== "") {
      params.set("price1", encodeURIComponent(inputPrice1.value));
    }
    if (inputPrice2.value !== "") {
      params.set("price2", encodeURIComponent(inputPrice2.value));
    }

    console.log(queryType);

    // 處理搜尋字串
    const keyword = inputText.value.trim();
    if (keyword !== "") {
      if (searchType.value === "title") {
        params.set("title", keyword);
      } else if (searchType.value === "author") {
        params.set("author", keyword);
      }
    }

    // 其他篩選條件（status、price1…）如果之前已放進 params，會一併保留
    window.location.href = `index.php?${params.toString()}`;
  });

  // 放你的 JS 代碼（包括 event listener）
  const genderSelect = document.getElementById("gender");
  const genreSelect = document.getElementById("genre");
  const statusSelect = document.getElementById("status")
  const perPageSelect = document.getElementById("perpageNum")

  const genderOptionsRaw = <?= json_encode($rowsGender) ?>;

  // 轉換為 genre_id => [gender, gender, ...]
  const genderOptions = {};
  genderOptionsRaw.forEach(row => {
    const genreId = row.genre_id;

    if (!genderOptions[genreId]) {
      genderOptions[genreId] = [];
    }
    genderOptions[genreId].push({
      id: row.id,
      gender: row.gender
    });
    // console.log(genderOptions[genreId]);

  });

  genreSelect.addEventListener("change", function () {
    if (this.value) {
      window.location.href = "index.php?genre=" + this.value;
    } else {
      window.location.href = "index.php";
    }
  });

  genderSelect.addEventListener("change", function () {
    const genre = genreSelect.value;
    const gender = this.value;

    // 更新參數
    if (genre) params.set("genre", genre);
    else params.delete("genre");

    if (gender) params.set("gender", gender);
    else params.delete("gender");

    // 重新組裝 URL，將 genre 和 gender 放前面
    const finalParams = new URLSearchParams();

    // 先放 genre 和 gender
    if (params.has("genre")) finalParams.set("genre", params.get("genre"));
    if (params.has("gender")) finalParams.set("gender", params.get("gender"));

    // 再放其他參數（不重複 genre 和 gender）
    for (const [key, value] of params.entries()) {
      if (key !== "genre" && key !== "gender") {
        finalParams.append(key, value);
      }
    }

    window.location.href = `index.php?${finalParams.toString()}`;
  });

  statusSelect.addEventListener("change", function () {
    if (this.value) {
      params.set("status", this.value);
    } else {
      params.delete("status");
    }

    window.location.href = "index.php?" + params.toString();
  });

  perPageSelect.addEventListener("change", function () {
    if (this.value) {
      params.set("perPage", this.value);
    } else {
      params.delete("status");
    }

    window.location.href = "index.php?" + params.toString();
  });

  sortBy.forEach((btn) => {
    btn.addEventListener("click", function (e) {
      console.log(e);
      const clickedColumn = e.currentTarget.id;
      const newSortOrder =
        clickedColumn === sort_column && sort_order === "asc" ? "desc" : "asc";

      params.set("sort_by", clickedColumn);
      params.set("sort_order", newSortOrder);

      window.location.href = `index.php?${params.toString()}`;
    });

  })

  // !! modal
  const filter_advance = document.querySelector('.filter-advance');

  const modal_genre = document.querySelector('#modal_genre');
  const modal_gender = document.querySelector('#modal_gender');
  const btnClear = document.querySelector(".btn-clear")

  modal_genre.addEventListener("change", function () {
    const genreId = this.value;
    const genders = genderOptions[genreId] || [];

    console.log(genreId);

    // 清空原本選項
    modal_gender.innerHTML = '<option value selected disabled>請選擇</option>';

    // 加入新的選項
    genders.forEach(g => {
      const opt = document.createElement("option");
      opt.value = g.id;
      opt.textContent = g.gender;
      modal_gender.appendChild(opt);
    });
  });

  filter_advance.addEventListener("click", () => {
    const params = new URLSearchParams();

    // 定義所有 input/select 欄位 ID（請確保這些 ID 與 HTML 對應）
    const fields = [
      "modal_status",
      "modal_title",
      "modal_author",
      "modal_company",
      "modal_genre",
      "modal_gender",
      "modal_price1",
      "modal_price2",
      "modal_stock",
      "modal_format",
      "modal_date1",
      "modal_date2"
    ];

    // 逐一處理每個欄位
    fields.forEach(id => {
      const el = document.getElementById(id);
      if (el && el.value.trim() !== "") {
        const key = id.replace(/^modal_/, ""); // 去掉 modal_
        params.append(key, el.value.trim());
      }
    });

    // 導向新網址，帶上參數（你可以改成你要的 php 檔案名稱）
    window.location.href = `index.php?${params.toString()}`;
  })

  btnClear.addEventListener("click", () => {
    const params = new URLSearchParams();

    // 定義所有 input/select 欄位 ID（請確保這些 ID 與 HTML 對應）
    const fields = [
      "modal_status",
      "modal_title",
      "modal_author",
      "modal_company",
      "modal_genre",
      "modal_gender",
      "modal_price1",
      "modal_price2",
      "modal_stock",
      "modal_format",
      "modal_date1",
      "modal_date2"
    ];

    // 逐一處理每個欄位
    fields.forEach(id => {
      if (id === "modal_status") return;
      const el = document.getElementById(id);
      if (el && el.value.trim() !== "") {
        el.value = ""
      }
    });
  })
</script>

<?php include "../template_btm.php"; ?>