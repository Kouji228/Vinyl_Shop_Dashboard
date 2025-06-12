<?php
// ? 更新黑膠分頁
require_once "../components/connect.php";
require_once "../components/Utilities.php";

$pageTitle = "修改黑膠唱片";
$cssList = ["../css/index.css", "css/product.css"];
include "../vars.php";
include "../template_top.php";
include "../template_main.php";

$id = $_GET["id"];

$sqlGenre = "SELECT * FROM vinyl_genre";
$sqlGender = "SELECT * FROM vinyl_gender";
$sqlAuthorList = "SELECT * FROM vinyl_author";

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

    $stmtAuthorList = $pdo->prepare($sqlAuthorList);
    $stmtAuthorList->execute();
    $rowsAuthorList = $stmtAuthorList->fetchAll(PDO::FETCH_ASSOC);

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
        <h3 class="section-title">修改<?= $rowsVinyl["title"] ?></h3>
        <a href="./index.php" class="btn btn-secondary">回商品列表</a>
    </div>

    <form action="./doUpdateVinyl.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $rowsVinyl["id"] ?>">
        <input type="hidden" name="shs_id" value="<?= $rowsVinyl["shs_id"] ?>">
        <!-- 唱片 -->
        <div class="form-section">
            <div class="form-row avatar-row">
                <div class="form-group avatar-group">
                    <!-- <label for="memberAvatar" class="form-label"></label> -->
                    <div class="avatar-upload-container">
                        <div class="avatar-preview" id="previewImage">
                            <img id="previewImage" class="img-fluid mb-4 rounded-3" src="./img/<?= $rowsImg[0]["img_name"] ?>"
                                alt="" srcset="">
                        </div>
                        <input name="myFile" id="imageInput" type="file" class="form-control" accept=".png,.jpg,.jpeg">
                        <small class="form-text">支援 JPG、PNG、GIF 格式，檔案大小不超過 2MB</small>
                    </div>
                </div>

                <div class="form-group info-group">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">唱片名稱</label>
                            <input name="title" type="text" class="form-control"
                                placeholder="<?= $rowsVinyl["title"] ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">狀態</label>
                            <select name="status" id="status" class="form-select">
                                <?php $status = $rowsVinyl["status_id"] ?>
                                <?php foreach ($rowsStatus as $row): ?>
                                    <option value="<?= $row["id"] ?>" <?= $row["id"] == $status ? 'selected' : "" ?>>
                                        <?= $row["status"] ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>

                    <!-- 藝術家 / 公司 / 價格 -->

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">藝術家</label>
                            <input name="author" type="text" class="form-control"
                                placeholder="<?= $rowsAuthor["author"] ?>" list="authorList">
                            <datalist id="authorList">
                                <?php foreach ($rowsAuthorList as $row): ?>
                                    <option value="<?= htmlspecialchars($row["author"]) ?>"></option>
                                <?php endforeach ?>
                            </datalist>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">公司</label>
                            <input name="company" type="text" class="form-control"
                                placeholder="<?= $rowsVinyl["company"] ?>">
                        </div>
                    </div>


                    <!-- 風格 / 類別 -->
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">風格</label>
                            <select name="genre" id="genre" class="form-select" required>
                                <?php foreach ($rows as $row): ?>
                                    <option value="<?= $row["id"] ?>" <?= $row["id"] == $rowsVinyl["genre_id"] ? 'selected' : "" ?>><?= $row["genre"] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">類別</label>
                            <select name="gender" id="gender" class="form-select" required>
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
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">庫存</label>
                            <input name="stock" type="number" class="form-control"
                                placeholder="<?= $rowsVinyl["stock"] ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">價格</label>
                            <input name="price" type="number" class="form-control"
                                placeholder="<?= $rowsVinyl["price"] ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">發行日期</label>
                            <input name="release_date" type="date" class="form-control"
                                value="<?= $rowsVinyl["release_date"] ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">規格</label>
                            <input name="format" type="text" class="form-control"
                                placeholder="<?= $rowsVinyl["format"] ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-section mb-3">
            <label class="form-label">介紹</label>
            <textarea name="desc_text" class="form-control"
                rows="4"><?= htmlspecialchars($rowsVinyl["desc_text"]) ?></textarea>
        </div>

        <div class="form-section mb-3">
            <label class="form-label">歌曲清單</label>
            <textarea name="playlist" class="form-control"
                rows="6"><?= htmlspecialchars($rowsVinyl["playlist"]) ?></textarea>
        </div>

        <!-- 按鈕 -->
        <div class="text-end">
            <button type="submit" class="btn btn-info">送出</button>
            <a class="btn btn-secondary" href="./index.php">取消</a>
        </div>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
    crossorigin="anonymous"></script>
<script>

    // 放你的 JS 代碼（包括 event listener）
    const genderSelect = document.getElementById("gender");
    const genreSelect = document.getElementById("genre");
    const input = document.getElementById('imageInput');
    const preview = document.getElementById('previewImage');

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
    });

    genreSelect.addEventListener("change", function () {
        const genreId = this.value;
        const genders = genderOptions[genreId] || [];

        console.log(genreId);

        // 清空原本選項
        genderSelect.innerHTML = '<option value selected disabled>請選擇</option>';

        // 加入新的選項
        genders.forEach(g => {
            const opt = document.createElement("option");
            opt.value = g.id;
            opt.textContent = g.gender;
            genderSelect.appendChild(opt);
        });
    });

    input.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                // 清空原本圖片
                preview.innerHTML = '';

                // 建立新圖片
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'img-fluid my-3 rounded-3   ';
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        }
    });

</script>
<?php include "../template_btm.php"; ?>