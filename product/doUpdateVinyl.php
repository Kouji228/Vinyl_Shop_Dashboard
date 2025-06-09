<?php
// ? 更新資料庫
require_once "../components/connect.php";
require_once "../components/Utilities.php";

if (!isset($_POST["id"])) {
    alertGoTo("非法進入", "./index.php");
    exit;
}

$id = htmlspecialchars($_POST["id"]);
$shs_id = htmlspecialchars($_POST["shs_id"]);
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

$status = htmlspecialchars($_POST["status"]);

$set = [];
$values = ["id" => $id];

if ($title !== "") {
    $set[] = "title = :title";
    $values[':title'] = $title;
}
if ($author !== '') {
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

    $set[] = 'author_id = :author_id';
    $values['author_id'] = $author_id;
}
if ($_POST["price"] !== "") {
    $set[] = "price = :price";
    $values[':price'] = $price;
}
if ($genre_id) {
    $set[] = 'genre_id = :genre_id';
    $values['genre_id'] = $genre_id;
}
if ($gender_id) {
    $set[] = 'gender_id = :gender_id';
    $values['gender_id'] = $gender_id;
}
if ($company !== '') {
    $set[] = 'company=:company';
    $values['company'] = $company;
}
if ($release_date !== "") {
    $set[] = "release_date =:date";
    $values["date"] = $release_date;
}
if ($format !== "") {
    $set[] = "format = :format";
    $values["format"] = $format;
}
if ($stock !== "") {
    $set[] = "stock = :stock";
    $values["stock"] = $stock;
}
if ($desc_text !== "") {
    $set[] = "desc_text = :desc";
    $values["desc"] = $desc_text;
}
if ($playlist !== "") {
    $set[] = "playlist = :playlist";
    $values["playlist"] = $playlist;
}
if ($status !== "") {
    $set[] = "status_id = :status";
    $values["status"] = $status;
}

try {
    // 插入 vinyl 主表
    $sql = "Update vinyl set " . implode(", ", $set) . " where id = :id";


    $stmt = $pdo->prepare($sql);
    $stmt->execute($values);

    //  ? 更改圖片與資料
    if (isset($_FILES["myFile"]) && $_FILES["myFile"]["error"] === UPLOAD_ERR_OK) {
        $sqlImg = "SELECT * from vinyl_img where shs_id =?";

        $stmtImg = $pdo->prepare($sqlImg);
        $stmtImg->execute([$shs_id]);
        $rowsImg=$stmtImg->fetchAll(PDO::FETCH_ASSOC);

        $timestamp = time();
        $ext = pathinfo($_FILES["myFile"]["name"], PATHINFO_EXTENSION);
        $img_name = "{$shs_id}_{$timestamp}.{$ext}";
        $file = "./img/{$img_name}";

        if (count($rowsImg) > 0) {
            // 已有圖片，刪除舊檔案
            $oldImgName = $rowsImg[0]["img_name"];
            $oldImgPath = "./img/{$oldImgName}";
            if(file_exists($oldImgPath)){
                unlink($oldImgPath);
            }
            
             // 更新圖片資料
            $sqlUpdateImg = "UPDATE vinyl_img SET img_name = :name, img_path = :path WHERE shs_id = :id";
            $stmtUpdateImg = $pdo->prepare($sqlUpdateImg);
            $stmtUpdateImg->execute([
                ":name" => $img_name,
                ":path" => $file,
                ":id" => $shs_id
            ]);
            
        } else {
            if (move_uploaded_file($_FILES["myFile"]["tmp_name"], $file)) {
                $sqlInsertImg = "INSERT INTO vinyl_img (shs_id, img_name, img_path) VALUES (?, ?, ?)";
                $stmtInsertImg = $pdo->prepare($sqlInsertImg);
                $stmtInsertImg->execute([$shs_id, $img_name, $file]);
            }
        }
        if(move_uploaded_file($_FILES["myFile"]["tmp_name"], $file)){
        $img = $img_name;
    }
    }

    // 顯示成功訊息
    alertGoTo("修改專輯成功", "./index.php");

} catch (PDOException $e) {
    echo "資料庫錯誤：" . $e->getMessage();
    exit;
}
?>