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

    <form method="post" enctype="multipart/form-data">
        <!-- 唱片 -->
        <div class="form-section">
            <!-- <h4 class="form-section-title">基本資訊</h4> -->
            <div class="form-row avatar-row">
                <div class="form-group avatar-group">
                    <!-- <label for="memberAvatar" class="form-label"></label> -->
                    <div class="avatar-upload-container">
                        <?php if ($rowsImg): ?>
                            <img class="img-fluid my-3 rounded-3" src="./img/<?= $rowsImg[0]["img_name"] ?>" alt="" srcset="">
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group info-group">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label ">唱片名稱</label>
                            <input name="title" type="text" class="form-control" placeholder="唱片名稱"
                                value="<?= $rowsVinyl["title"] ?>" readonly>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="author" class="form-label">藝術家</label>
                            <input name="author" id="author" type="text" class="form-control"
                                value="<?= $rowsAuthor["author"] ?>" readonly>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="company" class="form-label">公司</label>
                            <input name="company" id="company" type="text" class="form-control"
                                value="<?= $rowsVinyl["company"] ?>" readonly>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">風格</label>
                            <select name="genre" id="genre" class="form-select" disabled>
                                <?php foreach ($rows as $row): ?>
                                    <?php if ($rowsVinyl["genre_id"] == $row["id"]): ?>
                                        <option><?= $row["genre"] ?></option>
                                    <?php endif ?>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="form-group">
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

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">價格</label>
                            <input name="price" type="number" class="form-control" readonly
                                value="<?= $rowsVinyl["price"] ?>">
                        </div>

                        <div class="form-group">
                            <label class="form-label">庫存</label>
                            <input name="stock" type="number" class="form-control" value="<?= $rowsVinyl["stock"] ?>"
                                readonly>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">發行日期</label>
                            <input name="release_date" type="date" class="form-control"
                                value="<?= $rowsVinyl["release_date"] ?>" readonly>
                        </div>

                        <div class="form-group">
                            <label class="form-label">規格</label>
                            <input name="format" type="text" class="form-control" value="<?= $rowsVinyl["format"] ?>"
                                readonly>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
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

                </div>
            </div>
        </div>


        <div class="form-section">
            <div class="form-row">
                <div class="form-group mb-3">
                    <label class="form-label">介紹</label>
                    <textarea name="desc_text" class="form-control" rows="6"
                        readonly><?= htmlspecialchars($rowsVinyl["desc_text"]) ?></textarea>
                </div>
            </div>
        </div>

        <div class="form-section">
            <div class="form-group mb-3">
                <label class="form-label">歌曲清單</label>
                <textarea name="playlist" class="form-control" rows="6"
                    readonly><?= htmlspecialchars($rowsVinyl["playlist"]) ?></textarea>
            </div>
        </div>

        <!-- 按鈕 -->
        <div class="text-end">
            <a class="btn btn-secondary" href="./index.php">取消</a>
        </div>
    </form>




</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous">
    </script>
<?php include "../template_btm.php"; ?>