<?php
require_once "../components/connect.php";
require_once "../components/Utilities.php";

$pageTitle = "店面管理";
$cssList = ["../css/index.css"];
include "../vars.php";
include "../template_top.php";
include "../template_main.php";

?>

<div class="content-section">
        <div class="section-header d-flex justify-content-between align-items-center">
            <h3 class="section-title">店面列表</h3>
            <div class="d-flex gap-2">
                <a href="/vinyl_shop/form.php" class="btn btn-primary">新增店面</a>
            </div>
        </div>


           <!-- 文章列表 -->
           <div class="table-container table-responsive">
            <table class="table table-bordered table-striped align-middle ">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 50px;">
                            <input type="checkbox" class="form-check-input" id="selectAll">
                        </th>
                        <th>店名</th>
                        <th>地址</th>
                        <th>電話</th>
                        <th>營業時間</th>
                        <th>資料更新時間</th>
                        <th style="width: 120px;">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($result as $index => $article): ?>
                    <tr>
                        <td>
                            <input type="checkbox" class="form-check-input article-checkbox" value="<?=$article["id"]?>">
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
</div>

<?php
include "../template_btm.php";
?>



?>
