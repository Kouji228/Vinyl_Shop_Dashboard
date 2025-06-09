<?php
require_once "connect.php";
require_once "../components/Utilities.php";


$pageTitle = "會員管理";
$cssList = ["../css/index.css"];
include "../vars.php";
include "../template_top.php";
include "../template_main.php";


// 分頁邏輯
$perPage = 25;
$page = intval($_GET["page"] ?? 1);
$pageStart = ($page - 1) * $perPage;

//整理主sql
$sql = "SELECT * FROM `users` WHERE `is_valid` = 1 LIMIT $perPage OFFSET $pageStart";
$sqlAll = "SELECT * FROM `users` WHERE `is_valid` = 1 ";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmtAll = $pdo->prepare($sqlAll);
    $stmtAll->execute();

    $totalCount = $stmtAll->rowCount();
} catch (PDOException $e) {
    echo "錯誤: {{$e->getMessage()}}";
    exit;
}

$totalPage = ceil($totalCount / $perPage);
?>

<div class="content-section">
    <div class="section-header d-flex justify-content-between align-items-center">
        <h3 class="section-title">會員列表</h3>
        <a href="./add.php" class="btn btn-primary">新增會員</a>
    </div>
    <div class="controls-section">
        <div class="search-box">
            <input type="text" id="memberSearch" placeholder="搜尋會員姓名、Email或編號..." onkeyup="searchMembers()">
            <i class="fas fa-search"></i>
        </div>
        <div class="filter-group">
            <select id="levelFilter" onchange="filterMembers()">
                <option value="">全部等級</option>
                <option value="一般會員">一般會員</option>
                <option value="VIP會員">VIP會員</option>
                <option value="黑膠收藏家">黑膠收藏家</option>
            </select>
            <select id="dateFilter" onchange="filterMembers()">
                <option value="">註冊時間</option>
                <option value="recent">近30天</option>
                <option value="month">近3個月</option>
                <option value="year">近一年</option>
            </select>

            <!-- 新增的跳轉下拉選單 -->
            <select id="statusFilter" onchange="handleStatusChange(this)">
                <option value="">帳號狀態</option>
                <option value="active">啟用中會員</option>
                <option value="suspended">查看停權會員</option>
            </select>
            <button class="clear-filters" onclick="clearFilters()">清除篩選</button>
        </div>
    </div>



    <!-- 會員列表表格 -->
    <div class="table-container table-responsive">
        <table class="table table-bordered table-striped align-middle ">
            <thead class="table-dark">
                <tr>
                    <th>編號</th>
                    <th>姓名</th>
                    <th>Email</th>
                    <th>電話</th>
                    <th>等級</th>
                    <th>註冊時間</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($rows) > 0): ?>
                    <?php foreach ($rows as $index => $row): ?>
                        <tr>
                            <td><?= $index + 1 + ($page - 1) * $perPage ?></td>
                            <td><?= htmlspecialchars($row["name"]) ?></td>
                            <td><?= htmlspecialchars($row["email"]) ?></td>
                            <td><?= htmlspecialchars($row["phone"]) ?></td>
                            <td><?= htmlspecialchars($row["level"]) ?></td>
                            <td><?= htmlspecialchars($row["created_at"]) ?></td>
                            <td>
                                <a href="update.php?id=<?= $row["id"] ?>" class="btn btn-sm btn-warning" title="修改">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-sm btn-danger btn-del" data-id="<?= $row["id"] ?>" title="刪除">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">目前無資料</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- 分頁 -->
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1 ?>" class="pagination-btn"><i class="fas fa-chevron-left"></i></a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPage; $i++): ?>
            <a href="?page=<?= $i ?>" class="pagination-btn <?= ($page == $i) ? "active" : "" ?>"><?= $i ?></a>
        <?php endfor; ?>

        <?php if ($page < $totalPage): ?>
            <a href="?page=<?= $page + 1 ?>" class="pagination-btn"><i class="fas fa-chevron-right"></i></a>
        <?php endif; ?>
    </div>

    <script>
        const btnDels = document.querySelectorAll(".btn-del");
        btnDels.forEach((btn) => {
            btn.addEventListener("click", function () {
                const id = this.dataset.id;
                if (confirm("確定要刪除該會員？")) {
                    window.location.href = `./doDelete.php?id=${id}`;
                }
            });
        });

    </script>

    <?php include "../template_btm.php"; ?>