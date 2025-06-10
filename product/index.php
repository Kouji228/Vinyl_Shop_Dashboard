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
$valid_columns = ['id', 'price', 'title', 'author'];  // 根據你實際資料表欄位調整

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

if ($titleSearch) {
  $conditions[] = "title LIKE :title";
  $values["title"] = "%$titleSearch%";
}
if ($authorSearch) {
  $conditions[] = "vinyl_author.author LIKE :author_name";
  $values["author_name"] = "%$authorSearch%";
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


$whereSQL = "WHERE " . implode(" AND ", $conditions);

$perPage = 20;
$page = intval($_GET["page"] ?? 1);
$pageStart = ($page - 1) * $perPage;

$select = "vinyl.id AS id,title,vinyl_img.img_name AS img_name,author_id,vinyl_author.author AS author,company,price,stock,vinyl_genre.genre AS genre,vinyl_gender.gender AS gender,status_id FROM `vinyl` JOIN vinyl_author ON vinyl_author.id = vinyl.author_id JOIN vinyl_genre on vinyl_genre.id = vinyl.genre_id JOIN vinyl_gender on vinyl_gender.id = vinyl.gender_id JOIN vinyl_img on vinyl_img.shs_id = vinyl.shs_id";

$sql = "SELECT $select $whereSQL ORDER BY $sort_column $sort_order LIMIT $perPage OFFSET $pageStart";
$sqlAll = "SELECT $select  $whereSQL ";

$sqlAuthor = "SELECT * FROM vinyl_author";
$sqlGenre = "SELECT * FROM vinyl_genre";
$sqlGender = "SELECT * FROM vinyl_gender";
$sqlStatus = "SELECT * FROM vinyl_status";


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
} catch (PDOException $e) {
  echo "系統錯誤，請恰管理人員<br>";
  echo "錯誤: " . $e->getMessage();
  exit;
}
$genders = array_filter($rowsGender, fn($g) => $g["genre_id"] == $genre);

$totalPage = ceil($totalCount / $perPage);
?>


<!-- <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>黑膠唱片</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  <style>
    body {
      background-color: #1A1A1A;
      color: #F4F1EC;
    }

    .msg {
      display: flex;
      padding: 2px;
      padding-bottom: 3px;
      color: #e6c068;
      background-color: #1A1A1A;
      border: 1px solid #A3472A;
    }

    .msg .title:nth-child(odd) {
      border-right: 1px solid #e6c068;
    }

    .id {
      width: 40px;
      text-align: center;
    }

    .title {
      padding-left: 10px;
      flex: 1;

      a {
        color: #e6c068;
      }
    }

    .msg:nth-of-type(odd) {
      background-color: #0a0a0a;
    }

    .genre {
      width: 120px;
      /* text-align: center; */
      margin-left: 2px;
      margin-right: 2px;
    }

    .author {
      width: 320px;

      /* text-align: center; */
      a {
        color: #e6c068;
      }
    }

    .price,
    .stock {
      width: 75px;
      /* text-align: center; */
    }

    .time {
      width: 100px;
    }

    .sortable {
      display: flex;
      align-items: center;
      cursor: pointer;
      color: #fff;

      &#id {
        padding-left: 10px;
      }

      i {
        padding-left: 5px;
      }
    }

    .wpx200 {
      width: 200px;
    }
  </style>
</head> -->


<div class="content-section">

  <!-- 小標題 -->
  <div class="section-header d-flex justify-content-between align-items-center">
    <h3 class="section-title">黑膠商品列表</h3>
    <a href="./vinylAdd.php" class="btn btn-primary">增加黑膠唱片</a>
  </div>

  <!--搜尋與分類 -->
  <div class="controls-section">
    <div class="w-100 d-flex">
      <span class="">總共 <?= $totalCount ?> 筆資料, 每頁有 <?= $perPage ?> 筆資料</span>
      <div class="ms-auto d-flex w100">
        <select name="status" id="status" class="form-select">
          <?php foreach ($rowsStatus as $row): ?>
            <option value="<?= $row["id"] ?>" <?= ($status === null || $status === '') && $row["id"] == 1 ? 'selected' : ($status == $row["id"] ? 'selected' : '') ?>>
              <?= $row["status"] ?>
            </option>
          <?php endforeach ?>
        </select>
      </div>
    </div>

    <!-- 篩選與搜尋 -->
    <div class="w-100 flex-center gap-3">
      <div class="filter-group flex-center gap-3">
        <label for="genre" class="form-label">風格</label>

        <div class="col-auto">
          <select name="genre" id="genre" class="form-select w50">
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
          <select name="gender" id="gender" class="form-select">
            <option value="/" <?= empty($gender) ? 'selected' : '' ?>>全部</option>
            <?php foreach ($genders as $g): ?>
              <option value="<?= $g["id"] ?>" <?= $gender == $g["id"] ? "selected" : "" ?>>
                <?= $g["gender"] ?>
              </option>
            <?php endforeach ?>
          </select>
        </div>
      </div>

      <div class="search flex-center gap-2">
        <div class="col-auto flex-center">
          <label class="form-label" for="price1">價格</label>
        </div>
        <div class="col-auto w200">
          <input name="price1" id="price1" type="number" class="form-control " placeholder="<?= $price1 ?>">
        </div>
        <div class="col-auto"> ~ </div>
        <div class="col-auto w200">
          <input name="price2" type="number" class="form-control" placeholder="<?= $price2 ?>">
        </div>

        <div class="col-auto d-flex">
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="searchType" id="searchType1" value="title" checked>
            <label class="form-check-label" for="searchType1">專輯</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="searchType" id="searchType2" value="author">
            <label class="form-check-label" for="searchType2">創作者</label>
          </div>
        </div>

        <div class="col-auto">
          <?php
          $searchHolder = !empty($titleSearch) ? $titleSearch : (!empty($authorSearch) ? $authorSearch : "專輯或創作者");
          ?>
          <div class="search-box d-flex">
            <input name="search" type="text" class="form-control me-4"
              placeholder="<?= htmlspecialchars($searchHolder) ?>">
            <div class="btn btn-primary btn-search ps-5 wh50"><i class="fa fa-search"></i></div>
            <!-- <i class="fas fa-search btn-search"></i> -->
          </div>
        </div>
      </div>
    </div>

  </div>

  <!-- 商品列表 -->
  <div class="table-container table-responsive w-100">
    <table class="table table-bordered table-striped align-middle w-100 ">
      <thead class="table-dark">
        <tr>
          <th class="id sortable sortBy" id="id">
            編號
            <?php if ($sort_column === 'id'): ?>
              <i class="fa-solid fa-caret-<?= $sort_order === 'asc' ? 'up' : 'down'; ?>"></i>
            <?php endif; ?>
          </th>
          <th class="img">圖片</th>
          <th class="title sortable sortBy" id="title">專輯
            <?php if ($sort_column === 'title'): ?>
              <i class="fa-solid fa-caret-<?= $sort_order === 'asc' ? 'up' : 'down'; ?>"></i>
            <?php endif; ?>
          </th>
          <th class="author sortable sortBy" id="author">藝術家
            <?php if ($sort_column === 'author'): ?>
              <i class="fa-solid fa-caret-<?= $sort_order === 'asc' ? 'up' : 'down'; ?>"></i>
            <?php endif; ?>
          </th>
          <th class="price sortable sortBy" id="price">
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
              <td><?= htmlspecialchars($row["stock"]) ?></td>
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
      function makeLink($page, $genre, $gender, $author_id, $status, $price1, $price2, $titleSearch, $authorSearch, $sort_column, $sort_order)
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
        return "./index.php?" . implode("&", $params);
      }
      ?>

      <?php if ($totalCount > 0): ?>
        <a class="pagination-btn"
          href="<?= makeLink(1, $genre, $gender, $author_id, $status, $price1, $price2, $titleSearch, $authorSearch, $sort_column, $sort_order) ?>">
          <i class="fa-solid fa-angles-left"></i>
        </a>

        <?php if ($page > 1): ?>
          <a href="<?= makeLink($page - 1, $genre, $gender, $author_id, $status, $price1, $price2, $titleSearch, $authorSearch, $sort_column, $sort_order) ?>"
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
          <a class="pagination-btn <?= $page == $i ? "active" : "" ?>"
            href="<?= makeLink($i, $genre, $gender, $author_id, $status, $price1, $price2, $titleSearch, $authorSearch, $sort_column, $sort_order) ?>"><?= $i ?></a>
        <?php endfor; ?>

        <?php if ($page < $totalPage): ?>
          <a href="<?= makeLink($page + 1, $genre, $gender, $author_id, $status, $price1, $price2, $titleSearch, $authorSearch, $sort_column, $sort_order) ?>"
            class="pagination-btn"><i class="fas fa-chevron-right"></i></a>
        <?php endif; ?>

        <a class="pagination-btn"
          href="<?= makeLink($totalPage, $genre, $gender, $author_id, $status, $price1, $price2, $titleSearch, $authorSearch, $sort_column, $sort_order) ?>">
          <i class="fa-solid fa-angles-right"></i>
        </a>
      <?php endif; ?>

    </div>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>

<script>
  const btnDel = document.querySelectorAll('.btn-del');
  const btnRemove = document.querySelectorAll('.btn-remove');
  const btnRestock = document.querySelectorAll('.btn-restock');

  const btnSearch = document.querySelector(".btn-search");
  const inputPrice1 = document.querySelector("input[name=price1]");
  const inputPrice2 = document.querySelector("input[name=price2]");
  const inputText = document.querySelector("input[name=search]")

  const status = "<?= isset($_GET['status']) ? $_GET['status'] : '' ?>";
  const price1 = "<?= isset($_GET['price1']) ? $_GET['price1'] : '' ?>";
  const price2 = "<?= isset($_GET['price2']) ? $_GET['price2'] : '' ?>";
  const genre = "<?= isset($_GET['genre']) ? $_GET['genre'] : '' ?>";
  const gender = "<?= isset($_GET['gender']) ? $_GET['gender'] : '' ?>";
  const author = "<?= isset($_GET['author']) ? $_GET['author'] : '' ?>";
  const title = "<?= isset($_GET['title']) ? $_GET['title'] : '' ?>";
  const author_id = "<?= isset($_GET['author_id']) ? $_GET['author_id'] : '' ?>";

  const sort_column = "<?= $sort_column ?>";
  const sort_order = "<?= $sort_order ?>";
  const nextSortOrder = (sort_order === "asc") ? "desc" : "asc";

  const sortBy = document.querySelectorAll(".sortBy")

  const params = new URLSearchParams();
  if (status && status !== "undefined") params.append("status", status);
  if (genre && genre !== "undefined") params.append("genre", genre);
  if (gender && gender !== "undefined") params.append("gender", gender);
  if (price1 && price1 !== "undefined") params.append("price1", price1);
  if (price2 && price2 !== "undefined") params.append("price2", price2);
  if (author && author !== "undefined") params.append("author", author);
  if (title && title !== "undefined") params.append("title", title);
  if (author_id && author_id !== "undefined") params.append("author_id", author_id);


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

  btnSearch.addEventListener("click", () => {
    const queryType = document.querySelector('input[name=searchType]:checked').value;

    let params = [];

    // 處理價格區間
    if (inputPrice1.value !== "") {
      params.push(`price1=${encodeURIComponent(inputPrice1.value)}`);
    }
    if (inputPrice2.value !== "") {
      params.push(`price2=${encodeURIComponent(inputPrice2.value)}`);
    }

    // 處理搜尋字串
    if (inputText.value.trim() !== "") {
      if (queryType === "title") {
        params.push(`title=${encodeURIComponent(inputText.value.trim())}`);
      } else if (queryType === "author") {
        params.push(`author=${encodeURIComponent(inputText.value.trim())}`);
      }
    }

    // 組合 URL
    const queryString = params.join("&");
    const url = `./index.php?${queryString}`;

    // 導向新頁面
    window.location.href = url;
  });

  // 放你的 JS 代碼（包括 event listener）
  const genderSelect = document.getElementById("gender");
  const genreSelect = document.getElementById("genre");
  const statusSelect = document.getElementById("status")

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

</script>

<?php include "../template_btm.php"; ?>