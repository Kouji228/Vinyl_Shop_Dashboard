<?php
// session_start();
// if(!isset($_SESSION["user"])){
//     header("location: ./login.php");
//     exit;
// }

require_once "../components/connect.php";
require_once "../components/utilities.php";

$genre = intval($_GET["genre"] ?? 0);
$gender = intval($_GET["gender"] ?? 0);
$status = isset($_GET["status"]) ? intval($_GET["status"]) : null;

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

$author_id=$_GET["author_id"] ?? "";
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

$select = "vinyl.id AS id,title,author_id,vinyl_author.author AS author,company,price,stock,vinyl_gender.gender AS gender FROM `vinyl` JOIN vinyl_author ON vinyl_author.id = vinyl.author_id JOIN vinyl_gender on vinyl_gender.id = vinyl.gender_id";

$sql = "SELECT $select $whereSQL LIMIT $perPage OFFSET $pageStart";
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

<!-- <pre><?php var_dump($sql, $values); ?></pre> -->

<!doctype html>
<html lang="en">

<head>
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
      width: 50px;
      text-align: center;
    }

    .title {
      padding-left: 10px;
      flex: 1;

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
      a{
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

    .wpx200 {
      width: 200px;
    }
  </style>
</head>

<body>
  <div class="container mt-3">

    <div class="d-flex">
      <h1>黑膠商品列表</h1>
      <div class="ms-auto">
        <a class="btn btn-primary btn-sm btn-add" href="./vinylAdd.php">增加黑膠唱片</a>
      </div>
    </div>
    <!-- <div class="d-flex">
        <img class="head" src="./users/uploads/<?= $_SESSION["user"]["img"] ?>" alt="">
        <div class="ms-3"><?= $_SESSION["user"]["name"] ?> 您好 !</div>
        <a href="./users/doLogout.php" class="btn btn-danger btn-sm ms-auto">登出</a>
    </div> -->


    <div class="my-2 d-flex align-items-center">
      <span class="me-auto">目前共 <?= $totalCount ?> 筆資料</span>

      <div class="me-1-lg-1 mb-1 mb-lg-0 ms-auto">
        <div class="input-group input-group-sm">

          <div class="input-group-text">
            <label for="searchType3">價格區間</label>
          </div>
          <input name="price1" type="number" class="form-control" placeholder="<?= $price1 ?>">
          <div class="input-group-text"> ~
          </div>
          <input name="price2" type="number" class="form-control" placeholder="<?= $price2 ?>">

          <div class="input-group-text">
            <input name="searchType" id="searchType1" type="radio" class="form-check-input" value="title" checked>
            <label for="searchType1" class="me-2">專輯</label>
            <input name="searchType" id="searchType2" type="radio" class="form-check-input" value="author">
            <label for="searchType2">創作者</label>
          </div>
          <?php
          $searchHolder = !empty($titleSearch) ? $titleSearch : (!empty($authorSearch) ? $authorSearch : "專輯或創作者");
          ?>
          <input name="search" type="text" class="form-control form-control-sm"
            placeholder="<?= htmlspecialchars($searchHolder) ?>">
          <div class="btn btn-primary btn-sm btn-search me-2">搜尋</div>



        </div>
      </div>

    </div>

    <div class="row mb-3">
      <div class="col-md-4">
        <label class="form-label">風格</label>
        <select name="genre" id="genre" class="form-select">
          <option value="" <?= empty($genre) ? 'selected' : '' ?>>全部</option>
          <?php foreach ($rowsGenre as $row): ?>
            <option value="<?= $row["id"] ?>" <?= $genre == $row["id"] ? "selected" : "" ?>>
              <?= $row["genre"] ?>
            </option>
          <?php endforeach ?>
        </select>
      </div>

      <div class="col-md-4">
        <label class="form-label">類別</label>
        <select name="gender" id="gender" class="form-select">
          <option value="" <?= empty($gender) ? 'selected' : '' ?>>全部</option>
          <?php foreach ($genders as $g): ?>
            <option value="<?= $g["id"] ?>" <?= $gender == $g["id"] ? "selected" : "" ?>>
              <?= $g["gender"] ?>
            </option>
          <?php endforeach ?>
        </select>
      </div>

      <div class="col-md-4">
        <label class="form-label">狀態</label>
        <select name="status" id="status" class="form-select">
          <option value="" disabled <?= ($status === null || $status === '') ? 'selected' : '' ?>>請選擇狀態</option>
          <?php foreach ($rowsStatus as $row): ?>
            <option value="<?= $row["id"] ?>" <?= ($status === null || $status === '') && $row["id"] == 1 ? 'selected' : ($status == $row["id"] ? 'selected' : '') ?>>
              <?= $row["status"] ?>
            </option>
          <?php endforeach ?>
        </select>
      </div>
    </div>

    <div class="p-2 rounded-2 rounded-top-0">
      <div class="msg text-bg-dark ps-1">
        <div class="id">#</div>
        <div class="title">專輯</div>
        <div class="author">藝術家</div>
        <div class="price">價格</div>
        <div class="stock">庫存</div>
        <div class="genre">類別</div>
        <div class="time text-center">操作</div>
      </div>

      <?php foreach ($rows as $index => $row): ?>
        <div class="msg">
          <div class="id"><?= $index + 1 + ($page - 1) * $perPage ?></div>
          <div class="title"><?= $row["title"] ?></div>
          <div class="author"><a href="./index.php?author_id=<?= $row["author_id"] ?>">
              <?= $row["author"] ?> </a></div>
          <div class="price"><?= $row["price"] ?></div>
          <div class="stock"><?= $row["stock"] ?></div>
          <div class="genre"><?= $row["gender"] ?></div>

          <div class="time">
            <div class="btn btn-danger btn-sm btn-del" data-id="<?= $row["id"] ?>" data-title="<?= $row["title"] ?>">下架
            </div>
            <a class="btn btn-warning btn-sm" href="./vinylUpdate.php?id=<?= $row["id"] ?>">修改</a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- page -->
    <?php
    function makeLink($page, $genre, $gender,$author_id, $status, $price1, $price2, $titleSearch, $authorSearch)
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
      return "./index.php?" . implode("&", $params);
    }
    ?>

    <ul class="pagination justify-content-center my-4">
      <li class="page-item">
        <a class="page-link"
          href="<?= makeLink(1, $genre, $gender,$author_id, $status, $price1, $price2, $titleSearch, $authorSearch) ?>">
          <i class="fa-solid fa-angles-left"></i>
        </a>
      </li>

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
        <li class="page-item <?= $page == $i ? "active" : "" ?>">
          <a class="page-link"
            href="<?= makeLink($i, $genre, $gender, $author_id,$status, $price1, $price2, $titleSearch, $authorSearch) ?>"><?= $i ?></a>
        </li>
      <?php endfor; ?>

      <li class="page-item">
        <a class="page-link"
          href="<?= makeLink($totalPage, $genre, $gender, $author_id,$status, $price1, $price2, $titleSearch, $authorSearch) ?>">
          <i class="fa-solid fa-angles-right"></i>
        </a>
      </li>
    </ul>

  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
    crossorigin="anonymous"></script>

  <script>
    const btnDel = document.querySelectorAll('.btn-del');
    const btnSearch = document.querySelector(".btn-search");
    const inputPrice1 = document.querySelector("input[name=price1]");
    const inputPrice2 = document.querySelector("input[name=price2]");
    const inputText = document.querySelector("input[name=search]")

    btnDel.forEach((btn) => {
      btn.addEventListener("click", doConfirm);
    })

    function doConfirm(e) {
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

      if (this.value) {
        window.location.href = "index.php?genre=" + genre + "&gender=" + gender;
      } else {
        window.location.href = "index.php?genre=" + genre
      }

    });

    statusSelect.addEventListener("change", function () {
      window.location.href = "index.php?status=" + this.value;
    });

  </script>
</body>

</html>

<!-- <pre>
  <?= var_dump($rowsGenre) ?>
</pre>

<pre>
  <?= var_dump($rowsGender) ?>
</pre> -->

<!-- <?php
echo "status: $status";
echo "<pre>";
print_r($conditions);
print_r($values);
echo "</pre>";
?> -->