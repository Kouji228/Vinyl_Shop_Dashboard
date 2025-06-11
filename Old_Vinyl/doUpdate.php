<?php
// 修改會員主要程式
require_once "./connect.php";
require_once "./Utilities.php";

if(!isset($_POST["id"])){
  alertGoTo("請從正常管道進入", "./index.php");
  exit;
}

$id = $_POST["id"];
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
$set = [];
$values = [":id"=>$id];

if($main_category_id !== "") {
  $set[] = "`main_category_id` = :main_category_id";
  $values[":main_category_id"] = $main_category_id;
}
if($sub_category_id !== "") {
  $set[] = "`sub_category_id` = :sub_category_id";
  $values[":sub_category_id"] = $sub_category_id;
}
if($desc !== "") {
  $set[] = "`desc` = :desc";
  $values[":desc"] = $desc;
}
if($price !== "") {
  $set[] = "`price` = :price";
  $values[":price"] = $price;
}
if($name !== "") {
  $set[] = "`name` = :name";
  $values[":name"] = $name;
}
if($release_date !== "") {
  $set[] = "`release_date` = :release_date";
  $values[":release_date"] = $release_date;
}
if($status_id !== "") {
  $set[] = "`status_id` = :status_id";
  $values[":status_id"] = $status_id;
}
if($condition_id !== "") {
  $set[] = "`condition_id` = :condition_id";
  $values[":condition_id"] = $condition_id;
}
if($stock !== "") {
  $set[] = "`stock` = :stock";
  $values[":stock"] = $stock;
}
if($lp_id !== "") {
  $set[] = "`lp_id` = :lp_id";
  $values[":lp_id"] = $lp_id;
}
if($company !== "") {
  $set[] = "`company_id` = :company_id";
  $values[":company_id"] = $company_id;
}
if(isset($_FILES["myFile"]) && $_FILES["myFile"]["error"] == 0){
  $img = null;
  $timestamp = time();
  $ext = pathinfo($_FILES["myFile"]["name"], PATHINFO_EXTENSION);
  $newFileName = "{$timestamp}.{$ext}";
  $file = "./uploads/{$newFileName}";
  if(move_uploaded_file($_FILES["myFile"]["tmp_name"], $file)){
    $img = $newFileName;
     $sqlImg = "INSERT INTO `images` (`url`) VALUES (?);";
    $stmtImg = $pdo->prepare($sqlImg);
    $stmtImg->execute([$img]);
    $image_id = $pdo->lastInsertId();
  }
  $set[] = "`image_id` = :image_id";
  $values[":image_id"] = $image_id;
}


if(count($set) == 0){
  alertGoBack("沒有修改任何欄位");
}

$sql = "UPDATE `o_vinyl` SET " .implode(", ", $set) ." WHERE `id` = :id";

try {
  $stmt = $pdo->prepare($sql);
  $stmt->execute($values);
} catch (PDOException $e) {
  echo "錯誤: {{$e->getMessage()}}";
  exit;
}

alertGoTo("修改資料成功", "./index.php");
// alertGoTo("修改資料成功", "./update.php?id={$id}");