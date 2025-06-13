<?php
// 新增主要程式
require_once "../components/connect.php";
require_once "../components/utilities.php";

if(!isset($_POST["name"])){
  alertGoTo("請從正常管道進入");
  exit;
}

$desc = $_POST["desc"];
$price = $_POST["price"];
$name = $_POST["name"];
$release_date = $_POST["release_date"];
$status_id= $_POST["status_id"];
$condition_id = $_POST["condition_id"];
$stock = $_POST["stock"];
$lp_id = $_POST["lp_id"];
$company = $_POST["company"];
$sqlCompanyName = "INSERT INTO `company` (`name`) VALUES (?);";
$stmtCompanyName = $pdo->prepare($sqlCompanyName);
$stmtCompanyName->execute([$company]);
$company_id = $pdo->lastInsertId();
$main_category_id = $_POST["main_category_id"];
$sub_category_id = $_POST["sub_category_id"];

if($name == ""){
  alertGoBack("請輸入專輯名稱");
  exit;
};

if($price == ""){
  alertGoBack("請輸入價格");
  exit;
};

if($release_date == ""){
  alertGoBack("請輸入發行日");
  exit;
};

if($main_category_id == ""){
  alertGoBack("請選擇主分類");
  exit;
};
if($sub_category_id == ""){
  alertGoBack("請選擇次分類");
  exit;
};
if($status_id == ""){
  alertGoBack("請選擇狀態");
  exit;
};
if($condition_id == ""){
  alertGoBack("請選擇商品狀況");
  exit;
};
if($company == ""){
  alertGoBack("請輸入公司名稱");
  exit;
};
if($lp_id == ""){
  alertGoBack("請選擇尺寸");
  exit;
};

$img = null;
$image_id = null;
if(isset($_FILES["myFile"]) && $_FILES["myFile"]["error"] == 0){
  $timestamp = time();
  $ext = pathinfo($_FILES["myFile"]["name"], PATHINFO_EXTENSION);
  $newFileName = "{$timestamp}.{$ext}";
  $file = "./uploads/{$newFileName}";
  if(move_uploaded_file($_FILES["myFile"]["tmp_name"], $file)){
    $img = $newFileName;
    // 1. 先插入 images
    $sqlImg = "INSERT INTO `images` (`url`) VALUES (?);";
    $stmtImg = $pdo->prepare($sqlImg);
    $stmtImg->execute([$img]);
    $image_id = $pdo->lastInsertId();
  }
}

// 2. 插入 o_vinyl，image_id 也要帶進去
$sql = "INSERT INTO `o_vinyl` (`image_id`, `name`, `desc`, `status_id`, `condition_id`, `stock`, `lp_id`, `company_id`, `price`, `release_date`, `main_category_id`, `sub_category_id`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
$values = [$image_id, $name, $desc, $status_id, $condition_id, $stock, $lp_id, $company_id, $price, $release_date, $main_category_id, $sub_category_id];


$sqlName= "SELECT COUNT(*) as count FROM `o_vinyl` WHERE `name` = ?;";


try {
  $stmtName = $pdo->prepare($sqlName);
  $stmtName->execute([$name]);
  // $row = $stmtEmail->fetch(PDO::FETCH_ASSOC);
  // $count = $row["count"];
  $count = $stmtName->fetchColumn();
  if($count > 0){
    alertGoBack("此商品已經建立過");
    exit;
  }

  $stmt = $pdo->prepare($sql);
  $stmt->execute($values);
} catch (PDOException $e) {
  echo "錯誤: {{$e->getMessage()}}";
  exit;
}

alertGoTo("新增資料成功", "./index.php");