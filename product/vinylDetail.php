<?php
// ? 唱片資訊分頁
require_once "../components/connect.php";
require_once "../components/Utilities.php";

$pageTitle = "黑膠唱片詳細資料";
$cssList = ["../css/index.css", "css/product.css"];
include "../vars.php";
include "../template_top.php";
include "../template_main.php";

$id = $_GET["id"];

$sqlGenre = "SELECT * FROM vinyl_genre";
$sqlGender = "SELECT * FROM vinyl_gender";

$sqlVinyl = "SELECT * FROM vinyl WHERE id = ?";
$sqlAuthor = "SELECT * FROM vinyl_author where id = ?";
$sqlImg = "SELECT * FROM vinyl_img where shs_id = ?";
$sqlStatus = "SELECT * FROM vinyl_status";

try {
    $stmt = $pdo->prepare($sqlGenre);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmtVinyl = $pdo->prepare($sqlVinyl);
    $stmtVinyl->execute([$id]);
    $rowsVinyl = $stmtVinyl->fetch(PDO::FETCH_ASSOC);

    $stmtAuthor = $pdo->prepare($sqlAuthor);
    $stmtAuthor->execute([$rowsVinyl["author_id"]]);
    $rowsAuthor = $stmtAuthor->fetch(PDO::FETCH_ASSOC);

    $stmtStatus = $pdo->prepare($sqlStatus);
    $stmtStatus->execute();
    $rowsStatus = $stmtStatus->fetchAll(PDO::FETCH_ASSOC);

    $stmtImg = $pdo->prepare($sqlImg);
    $stmtImg->execute([$rowsVinyl["shs_id"]]);
    $rowsImg = $stmtImg->fetchAll(PDO::FETCH_ASSOC);

    $stmtGender = $pdo->prepare($sqlGender);
    $stmtGender->execute();
    $rowsGender = $stmtGender->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // echo "錯誤: {{$e->getMessage()}} <br>";
    // exit;
    $errorMsg = $e->getMessage();
}

?>


<div class="content-section">
    <!-- 小標題 -->
    <div class="section-header">
        <h3 class="section-title"><?= $rowsVinyl["title"] ?></h3>
        <a href="./index.php" class="btn btn-secondary">回商品列表</a>
    </div>
    
    <div class="row">
        <div class="col-md-3" id="previewImage">
            <?php if ($rowsImg): ?>
                <img class="img-fluid my-3" src="./img/<?= $rowsImg[0]["img_name"] ?>" alt="" srcset="">
            <?php endif; ?>
        </div>

        <div class="col-md-1"></div>

        <div class="col-md-8">
            <form method="post" enctype="multipart/form-data">
                <!-- 唱片 -->
                <div class="row mb-3">
                    <div class="col-md-10">
                        <label class="form-label col-4">唱片名稱</label>
                        <input name="title" type="text" class="form-control" value="<?= $rowsVinyl["title"] ?>"
                            readonly>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">狀態</label>
                        <select name="status" id="status" class="form-select" disabled>
                            <?php $status = $rowsVinyl["status_id"] ?>
                            <?php foreach ($rowsStatus as $row): ?>
                                <?php if ($status == $row["id"]): ?>
                                    <option>
                                        <?= $row["status"] ?>
                                    </option>
                                <?php endif ?>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>

                <!-- 藝術家 / 公司 / 價格 -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">藝術家</label>
                        <input name="author" type="text" class="form-control" value="<?= $rowsAuthor["author"] ?>"
                            readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">公司</label>
                        <input name="company" type="text" class="form-control" value="<?= $rowsVinyl["company"] ?>"
                            readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">價格</label>
                        <input name="price" type="number" class="form-control" value="<?= $rowsVinyl["price"] ?>"
                            readonly>
                    </div>
                </div>

                <!-- 風格 / 類別 -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">風格</label>
                        <select name="genre" id="genre" class="form-select" disabled>
                            <?php foreach ($rows as $row): ?>
                                <?php if ($rowsVinyl["genre_id"] == $row["id"]): ?>
                                    <option><?= $row["genre"] ?></option>
                                <?php endif ?>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">類別</label>
                        <select name="gender" id="gender" class="form-select" disabled>
                            <?php foreach ($rowsGender as $row): ?>
                                <?php if ($row["genre_id"] == $rowsVinyl["genre_id"]): ?>
                                    <option value="<?= $row["id"] ?>">
                                        <?= $row["gender"] ?>
                                    </option>
                                <?php endif; ?>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>

                <!-- 發行日期 / 規格 / 庫存 -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">發行日期</label>
                        <input name="release_date" type="date" class="form-control"
                            value="<?= $rowsVinyl["release_date"] ?>" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">規格</label>
                        <input name="format" type="text" class="form-control" value="<?= $rowsVinyl["format"] ?>"
                            readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">庫存</label>
                        <input name="stock" type="number" class="form-control" value="<?= $rowsVinyl["stock"] ?>"
                            readonly>
                    </div>
                </div>


                <div class="mb-3">
                    <label class="form-label">介紹</label>
                    <textarea name="desc_text" class="form-control" rows="6"
                        readonly><?= htmlspecialchars($rowsVinyl["desc_text"]) ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">歌曲清單</label>
                    <textarea name="playlist" class="form-control" rows="6"
                        readonly><?= htmlspecialchars($rowsVinyl["playlist"]) ?></textarea>
                </div>

                <!-- 按鈕 -->
                <div class="text-end">
                    <a class="btn btn-secondary" href="./index.php">取消</a>
                </div>
            </form>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous">
    </script>
<?php include "../template_btm.php"; ?>