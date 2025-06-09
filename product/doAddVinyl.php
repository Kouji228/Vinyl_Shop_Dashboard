<?php
require_once "./components/connect.php";
require_once "./components/utilities.php";

if (!isset($_POST["title"])) {
  alertGoTo("非法進入", "./index.php");
  exit;
}

$shs_id = htmlspecialchars($_POST["shs-id"]);
$title = trim(htmlspecialchars($_POST["title"]));
$author = trim(htmlspecialchars($_POST["author"]));
$price = intval($_POST["price"]);
$genre_id = intval($_POST["genre"]);
$gender_id = intval($_POST["gender"]);
$company = htmlspecialchars($_POST["company"]);
$release_date = htmlspecialchars($_POST["release_date"]);
$format = htmlspecialchars($_POST["format"]);
$stock = htmlspecialchars($_POST["stock"]);
$desc_text = htmlspecialchars($_POST["desc_text"]);
$playlist = htmlspecialchars($_POST["playlist"]);

if ($title == "" || $author == "") {
  alertGoBack("請輸入資訊");
  exit;
}

try {
  // 先查詢是否已存在作者
  $stmtAuthor = $pdo->prepare("SELECT id FROM vinyl_author WHERE author = ?");
  $stmtAuthor->execute([$author]);
  $authorResult = $stmtAuthor->fetch(PDO::FETCH_ASSOC);

  if ($authorResult) {
    $author_id = $authorResult["id"];
  } else {
    // 不存在就插入新的作者
    $stmtInsertAuthor = $pdo->prepare("INSERT INTO vinyl_author (author) VALUES (?)");
    $stmtInsertAuthor->execute([$author]);
    $author_id = $pdo->lastInsertId(); // 取得剛插入的 ID
  }

  // 其他欄位處理
  $status = ($stock == 0) ? 3 : (($release_date > date("Y-m-d")) ? 2 : 1);

  // 插入 vinyl 主表
  $sql = "INSERT INTO vinyl 
    (`shs_id`, `title`, `author_id`, `price`, `genre_id`, `gender_id`, `company`, `release_date`, `format`, `stock`, `status_id`, `desc_text`, `playlist`) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

  $values = [$shs_id, $title, $author_id, $price, $genre_id, $gender_id, $company, $release_date, $format, $stock, $status, $desc_text, $playlist];
  $stmt = $pdo->prepare($sql);
  $stmt->execute($values);

  
  if (isset($_FILES["myFile"]) && $_FILES["myFile"]["error"] === UPLOAD_ERR_OK) {
    $img=null;
    $timestamp = time();
    $ext = pathinfo($_FILES["myFile"]["name"], PATHINFO_EXTENSION);
    $img_name = "{$shs_id}_{$timestamp}.{$ext}";
    $file = "./img/{$img_name}";

    if(move_uploaded_file($_FILES["myFile"]["tmp_name"], $file)){
        $img = $img_name;
    }

    $sqlImg = "INSERT INTO vinyl_img (shs_id,img_name,img_path) VALUES (? ,? ,? );";
    $imgValues=[$shs_id,$img_name,$file];

    $stmtImg = $pdo->prepare($sqlImg);
    $stmtImg->execute($imgValues);
  }

  // 顯示成功訊息
  alertGoTo("新增專輯成功", "./index.php");

} catch (PDOException $e) {
  echo "資料庫錯誤：" . $e->getMessage();
  exit;
}
?>