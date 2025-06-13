<?php
require_once "../components/connect.php";
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

// 排序邏輯
$sortColumn = $_GET["sort"] ?? "created_at";
$sortOrder = $_GET["order"] ?? "DESC";

// 允許排序的欄位
$allowedSortColumns = ["name", "email", "phone", "level", "created_at", "is_valid"];

// 驗證排序欄位
if (!in_array($sortColumn, $allowedSortColumns)) {
    $sortColumn = "created_at";
}

// 驗證排序方向
$sortOrder = strtoupper($sortOrder) === "ASC" ? "ASC" : "DESC";

//整理主sql
$sql = "SELECT * FROM `users` WHERE 1=1 ";
$sqlAll = "SELECT * FROM `users` WHERE 1=1 ";

// 獲取狀態過濾器
$status = $_GET["status"] ?? "";

// 獲取等級過濾器
$level = $_GET["level"] ?? "";

// 獲取搜尋參數
$search = $_GET["search"] ?? "";

if ($status === "suspended") {
    $sql .= "AND `is_valid` = 0 ";
    $sqlAll .= "AND `is_valid` = 0 ";
} elseif ($status === "active") {
    $sql .= "AND `is_valid` = 1 ";
    $sqlAll .= "AND `is_valid` = 1 ";
}

// 添加等級過濾
if (!empty($level)) {
    $sql .= "AND `level` = ? ";
    $sqlAll .= "AND `level` = ? ";
}

// 添加搜尋條件
if (!empty($search)) {
    $searchTerm = "%" . $search . "%";
    $sql .= "AND (`name` LIKE ? OR `email` LIKE ? OR `phone` LIKE ?) ";
    $sqlAll .= "AND (`name` LIKE ? OR `email` LIKE ? OR `phone` LIKE ?) ";
}

// 添加排序
$sql .= "ORDER BY `$sortColumn` $sortOrder ";
$sqlAll .= "ORDER BY `$sortColumn` $sortOrder ";

$sql .= "LIMIT $perPage OFFSET $pageStart";

try {
    $stmt = $pdo->prepare($sql);
    $stmtAll = $pdo->prepare($sqlAll);

    $params = [];
    if (!empty($level)) {
        $params[] = $level;
    }
    if (!empty($search)) {
        $params = array_merge($params, [$searchTerm, $searchTerm, $searchTerm]);
    }

    if (!empty($params)) {
        $stmt->execute($params);
        $stmtAll->execute($params);
    } else {
        $stmt->execute();
        $stmtAll->execute();
    }

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $totalCount = $stmtAll->rowCount();
} catch (PDOException $e) {
    echo "錯誤: " . $e->getMessage();
    exit;
}

$totalPage = ceil($totalCount / $perPage);
?>

<div class="content-section">
    <div class="section-header d-flex justify-content-between align-items-center">
        <h3 class="section-title">會員列表</h3>
        <div class="d-flex align-items-center gap-3">
            <!-- <a href="./add.php" class="btn btn-primary">新增會員</a> -->
        </div>
    </div>
    <div class="controls-section">
        <div class="search-box">
            <form action="" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control" placeholder="搜尋會員姓名、Email或電話..."
                    value="<?= htmlspecialchars($search ?? '') ?>">
                <i class="fas fa-search search-icon" onclick="submitSearch()"></i>
            </form>
        </div>
        <div class="filter-group">
            <select id="levelFilter" onchange="handleLevelChange(this)">
                <option value="" <?= empty($level) ? 'selected' : '' ?>>全部等級</option>
                <option value="一般會員" <?= $level === '一般會員' ? 'selected' : '' ?>>一般會員</option>
                <option value="VIP會員" <?= $level === 'VIP會員' ? 'selected' : '' ?>>VIP會員</option>
                <option value="黑膠收藏家" <?= $level === '黑膠收藏家' ? 'selected' : '' ?>>黑膠收藏家</option>
            </select>

            <!-- 新增的跳轉下拉選單 -->
            <select id="statusFilter" onchange="handleStatusChange(this)">
                <option value="" <?= empty($status) ? 'selected' : '' ?>>全部會員</option>
                <option value="active" <?= $status === 'active' ? 'selected' : '' ?>>啟用中會員</option>
                <option value="suspended" <?= $status === 'suspended' ? 'selected' : '' ?>>查看停權會員</option>
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
                    <th>
                        <a href="?sort=level&order=<?= $sortColumn === 'level' && $sortOrder === 'ASC' ? 'DESC' : 'ASC' ?>" class="text-white text-decoration-none">
                            等級
                            <?php if ($sortColumn === 'level'): ?>
                                <i class="fas fa-sort-<?= $sortOrder === 'ASC' ? 'up' : 'down' ?>"></i>
                            <?php else: ?>
                                <i class="fas fa-sort"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th>
                        <a href="?sort=created_at&order=<?= $sortColumn === 'created_at' && $sortOrder === 'ASC' ? 'DESC' : 'ASC' ?>" class="text-white text-decoration-none">
                            註冊時間
                            <?php if ($sortColumn === 'created_at'): ?>
                                <i class="fas fa-sort-<?= $sortOrder === 'ASC' ? 'up' : 'down' ?>"></i>
                            <?php else: ?>
                                <i class="fas fa-sort"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th>
                        <a href="?sort=is_valid&order=<?= $sortColumn === 'is_valid' && $sortOrder === 'ASC' ? 'DESC' : 'ASC' ?>" class="text-white text-decoration-none">
                            帳號狀態
                            <?php if ($sortColumn === 'is_valid'): ?>
                                <i class="fas fa-sort-<?= $sortOrder === 'ASC' ? 'up' : 'down' ?>"></i>
                            <?php else: ?>
                                <i class="fas fa-sort"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($rows) > 0): ?>
                    <?php foreach ($rows as $index => $row): ?>
                        <tr>
                            <td><?= $index + 1 + ($page - 1) * $perPage ?></td>
                            <td><?= htmlspecialchars($row["name"] ?? '') ?></td>
                            <td><?= htmlspecialchars($row["email"] ?? '') ?></td>
                            <td><?= htmlspecialchars($row["phone"] ?? '') ?></td>
                            <td><?= htmlspecialchars($row["level"] ?? '') ?></td>
                            <td><?= htmlspecialchars($row["created_at"] ?? '') ?></td>
                            <td>
                                <?php if ($row["is_valid"] == 1): ?>
                                    <span class="badge bg-success">啟用中</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">已停權</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="update.php?id=<?= $row["id"] ?>" class="btn btn-sm btn-warning" title="修改">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <?php if ($row["is_valid"] == 1): ?>
                                    <button class="btn btn-sm btn-danger btn-suspend" data-id="<?= $row["id"] ?>" title="停權">
                                        <i class="fas fa-ban"></i>
                                    </button>
                                <?php else: ?>
                                    <button class="btn btn-sm btn-success btn-restore" data-id="<?= $row["id"] ?>" title="恢復">
                                        <i class="fas fa-undo"></i>
                                    </button>
                                <?php endif; ?>
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
            <a href="?page=<?= $page - 1 ?>&sort=<?= $sortColumn ?>&order=<?= $sortOrder ?>" class="pagination-btn"><i
                    class="fas fa-chevron-left"></i></a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPage; $i++): ?>
            <a href="?page=<?= $i ?>&sort=<?= $sortColumn ?>&order=<?= $sortOrder ?>"
                class="pagination-btn <?= ($page == $i) ? "active" : "" ?>"><?= $i ?></a>
        <?php endfor; ?>

        <?php if ($page < $totalPage): ?>
            <a href="?page=<?= $page + 1 ?>&sort=<?= $sortColumn ?>&order=<?= $sortOrder ?>" class="pagination-btn"><i
                    class="fas fa-chevron-right"></i></a>
        <?php endif; ?>
    </div>

    <script>
        const btnSuspend = document.querySelectorAll(".btn-suspend");
        btnSuspend.forEach((btn) => {
            btn.addEventListener("click", function () {
                const id = this.dataset.id;
                if (confirm("確定要停權該會員？停權後該會員將無法登入系統。")) {
                    window.location.href = `./doSuspend.php?id=${id}`;
                }
            });
        });

        const btnRestore = document.querySelectorAll(".btn-restore");
        btnRestore.forEach((btn) => {
            btn.addEventListener("click", function () {
                const id = this.dataset.id;
                if (confirm("確定要恢復該會員的權限？")) {
                    window.location.href = `./doRestore.php?id=${id}`;
                }
            });
        });

        // 處理狀態篩選
        function handleStatusChange(select) {
            const status = select.value;
            const currentUrl = new URL(window.location.href);

            if (status) {
                currentUrl.searchParams.set('status', status);
            } else {
                currentUrl.searchParams.delete('status');
            }

            // 重置分頁到第一頁
            currentUrl.searchParams.set('page', '1');

            window.location.href = currentUrl.toString();
        }

        // 處理等級篩選
        function handleLevelChange(select) {
            const level = select.value;
            const currentUrl = new URL(window.location.href);

            if (level) {
                currentUrl.searchParams.set('level', level);
            } else {
                currentUrl.searchParams.delete('level');
            }

            // 重置分頁到第一頁
            currentUrl.searchParams.set('page', '1');

            window.location.href = currentUrl.toString();
        }

        // 處理排序變更
        function handleSortChange(select) {
            const value = select.value;
            if (!value) return;

            const [column, order] = value.split('_');
            const currentUrl = new URL(window.location.href);

            currentUrl.searchParams.set('sort', column);
            currentUrl.searchParams.set('order', order);

            // 重置分頁到第一頁
            currentUrl.searchParams.set('page', '1');

            window.location.href = currentUrl.toString();
        }

        // 清除所有篩選
        function clearFilters() {
            const currentUrl = new URL(window.location.href);
            currentUrl.searchParams.delete('search');
            currentUrl.searchParams.delete('level');
            currentUrl.searchParams.delete('status');
            currentUrl.searchParams.delete('page');
            currentUrl.searchParams.delete('sort');
            currentUrl.searchParams.delete('order');
            window.location.href = currentUrl.toString();
        }

        // 處理搜尋提交
        function submitSearch() {
            const searchInput = document.querySelector('input[name="search"]');
            const form = searchInput.closest('form');
            form.submit();
        }
    </script>

    <?php include "../template_btm.php"; ?>