<?php

require_once "../components/connect.php";
require_once "../components/Utilities.php";
require_once "./couponMaps.php"; // 引入共用的 Map 陣列

$pageTitle = "優惠卷管理";
$cssList = ["../css/index.css", "./coupon.css"]; //
include "../vars.php";
include "../template_top.php";
include "../template_main.php";

// --- 參數設定 ---
$perPage = 15; //
$page = isset($_GET["page"]) ? max(1, (int) $_GET["page"]) : 1;
$pageStart = ($page - 1) * $perPage; //

// --- 集中接收與管理所有篩選條件 ---
$filters = [
    'status_filter' => $_GET['status_filter'] ?? '',
    'search' => $_GET['search'] ?? '',
    'qType' => $_GET['qType'] ?? 'name',
    'date_start' => $_GET['date_start'] ?? '',
    'date_end' => $_GET['date_end'] ?? ''
];

// --- 排序參數處理 ---
$valid_columns = ['id', 'start_at', 'end_at'];
$sort_by = in_array($_GET['sort_by'] ?? '', $valid_columns) ? $_GET['sort_by'] : 'id';
$sort_order = (isset($_GET['sort_order']) && strtolower($_GET['sort_order']) === 'desc') ? 'desc' : 'asc';
$next_sort_order = ($sort_order === 'asc') ? 'desc' : 'asc';

// --- 動態建立 SQL WHERE 條件 ---
$whereConditions = ["coupons.`is_valid` = 1"]; // 基礎條件：只選取有效的優惠卷
$bindings = []; // 用於 PDO prepare statement 的參數綁定

// 狀態篩選
if (!empty($filters['status_filter'])) {
    $whereConditions[] = "coupons.`status` = :status_filter";
    $bindings[':status_filter'] = $filters['status_filter'];
}

// 關鍵字搜尋 (依據名稱或優惠碼)
if (!empty($filters['search']) && in_array($filters['qType'], ['name', 'code'])) {
    $columnToSearch = 'coupons.`' . $filters['qType'] . '`';
    $whereConditions[] = "$columnToSearch LIKE :search";
    $bindings[':search'] = "%" . $filters['search'] . "%";
}

// 日期區間篩選邏輯優化
if (!empty($filters['date_start'])) {
    $whereConditions[] = "(coupons.`end_at` >= :date_start OR coupons.`end_at` IS NULL)";
    $bindings[':date_start'] = $filters['date_start'] . " 00:00:00";
}
if (!empty($filters['date_end'])) {
    $whereConditions[] = "coupons.`start_at` <= :date_end";
    $bindings[':date_end'] = $filters['date_end'] . " 23:59:59";
}

$whereClause = "WHERE " . implode(" AND ", $whereConditions);

// --- 資料庫查詢 ---
try {
    // 查詢總筆數 (用於分頁)
    $sqlAll = "SELECT COUNT(coupons.id) as total FROM `coupons` LEFT JOIN `coupon_rules` ON coupons.id = coupon_rules.coupon_id $whereClause"; //
    $stmtAll = $pdo->prepare($sqlAll);
    $stmtAll->execute($bindings);
    $totalCount = $stmtAll->fetch(PDO::FETCH_ASSOC)['total'] ?? 0; //

    // 查詢當前頁面的資料
    $sql = "SELECT coupons.*,
                   coupon_rules.discount_value, 
                   coupon_rules.discount_type
            FROM `coupons`
            LEFT JOIN `coupon_rules` ON coupons.id = coupon_rules.coupon_id
            $whereClause
            ORDER BY coupons.{$sort_by} {$sort_order}
            LIMIT $perPage OFFSET $pageStart";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($bindings);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC); //

} catch (PDOException $e) {
    die("資料庫查詢失敗: " . $e->getMessage()); // 發生錯誤時中斷並顯示訊息
}

$totalPage = ceil($totalCount / $perPage); //
?>

<div class="content-section">
    <div class="section-header d-flex justify-content-between align-items-center">
        <h3 class="section-title">優惠卷列表</h3>
        <span class="ms-auto">目前共 <?= $totalCount ?> 筆資料</span>
        <a href="./add.php" class="btn btn-primary">增加資料</a>
    </div>

    <div class="controls-section">
        <div class="filter-group">
            <select name="qType" id="qTypeSelect" class="form-select">
                <option value="name" <?= ($filters['qType'] === 'name') ? 'selected' : '' ?>>名稱</option>
                <option value="code" <?= ($filters['qType'] === 'code') ? 'selected' : '' ?>>優惠碼</option>
            </select>
        </div>
        <div class="search-box">
            <input type="text" name="search" class="form-control" placeholder="關鍵字搜尋..."
                value="<?= htmlspecialchars($filters['search']) ?>" id="searchText">
        </div>
        <div class="filter-group">
            <select name="status_filter" id="statusFilterSelect" class="form-select">
                <option value="">全部狀態</option>
                <?php foreach ($statusMap as $value => $displayText): ?>
                    <option value="<?= htmlspecialchars($value) ?>" <?= ($filters['status_filter'] === $value) ? "selected" : "" ?>>
                        <?= htmlspecialchars($displayText) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="date-group">
            <input type="date" name="date_start" class="date-input"
                value="<?= htmlspecialchars($filters['date_start']) ?>" id="dateStartInput" title="開始日期">
            <input type="date" name="date_end" class="date-input" value="<?= htmlspecialchars($filters['date_end']) ?>"
                id="dateEndInput" title="結束日期">
        </div>

        <div class="form-actions controls-actions">
            <button id="btnCouponSearch" class="btn btn-primary">搜尋</button>
            <button type="button" class="clear-filters" onclick="window.location.href='index.php'">清除篩選</button>
        </div>
    </div>

    <div class="table-container table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th class="sortable-header <?php if ($sort_by === 'id')
                        echo 'sort-' . $sort_order; ?>" data-sort="id">編號</th>
                    <th>優惠卷名稱</th>
                    <th>優惠碼</th>
                    <th>折扣值</th>
                    <th>狀態</th>
                    <th>總數</th>
                    <th>可用次數</th>
                    <th class="sortable-header <?php if ($sort_by === 'start_at')
                        echo 'sort-' . $sort_order; ?>" data-sort="start_at">開始時間</th>
                    <th class="sortable-header <?php if ($sort_by === 'end_at')
                        echo 'sort-' . $sort_order; ?>" data-sort="end_at">結束時間</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($rows) > 0): ?>
                    <?php foreach ($rows as $index => $row): ?>
                        <tr>
                            <td><?= $index + 1 + ($page - 1) * $perPage ?></td>
                            <td><?= htmlspecialchars($row["name"]) ?></td>
                            <td>
                                <?php if (!empty($row["code"])): ?>
                                    <span class="coupon-code-badge"><?= htmlspecialchars($row["code"]) ?></span>
                                <?php else: ?>
                                    <span class="text-muted">無</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php
                                if ($row["discount_value"] !== null && $row["discount_value"] !== '') {
                                    echo htmlspecialchars($row["discount_value"]);
                                    if ($row["discount_type"] === 'percent') {
                                        echo '%';
                                    } elseif ($row["discount_type"] === 'fixed') {
                                        echo '元';
                                    }
                                } else {
                                    echo '<span class="text-muted">無</span>';
                                }
                                ?>
                            </td>
                            <td>
                                <span class="status-badge status-<?= htmlspecialchars(strtolower($row['status'])) ?>">
                                    <?= htmlspecialchars($statusMap[$row['status']] ?? '未知') ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($row["total_quantity"]) ?></td>
                            <td><?= htmlspecialchars($row["uses_per_instance"]) ?></td>
                            <td><?= htmlspecialchars($row["start_at"] ? date("Y-m-d H:i", strtotime($row["start_at"])) : 'N/A') ?>
                            </td>
                            <td><?= htmlspecialchars($row["end_at"] ? date("Y-m-d H:i", strtotime($row["end_at"])) : 'N/A') ?>
                            </td>
                            <td class="text-center">
                                <div class="action-buttons">
                                    <a class="btn btn-sm btn-info btn-icon-absolute"
                                        href="./coupon_details_page.php?id=<?= $row["id"] ?>" title="詳細">
                                        <i class="fas fa-fw fa-eye"></i>
                                    </a>
                                    <a class="btn btn-sm btn-warning btn-icon-absolute" href="./update.php?id=<?= $row["id"] ?>"
                                        title="修改">
                                        <i class="fas fa-fw fa-edit"></i>
                                    </a>
                                    <button class="btn btn-sm btn-danger btn-del btn-icon-absolute" data-id="<?= $row["id"] ?>"
                                        title="刪除">
                                        <i class="fas fa-fw fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="11" class="text-center">目前無資料</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if ($totalPage > 0): ?>
        <div class="pagination"> <?php if ($page > 1):
            $prevLinkParams = array_filter($filters);
            $prevLinkParams['page'] = $page - 1;
            $prevLinkParams['sort_by'] = $sort_by;
            $prevLinkParams['sort_order'] = $sort_order;
            ?>
                <a href="?<?= http_build_query($prevLinkParams) ?>" class="pagination-btn"><i
                        class="fas fa-chevron-left"></i></a>
            <?php else: ?>
                <button class="pagination-btn" disabled><i class="fas fa-chevron-left"></i></button>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPage; $i++):
                $pageLinkParams = array_filter($filters);
                $pageLinkParams['page'] = $i;
                $pageLinkParams['sort_by'] = $sort_by;
                $pageLinkParams['sort_order'] = $sort_order;
                ?>
                <a href="?<?= http_build_query($pageLinkParams) ?>"
                    class="pagination-btn <?= ($page == $i) ? "active" : "" ?>"><?= $i ?></a>
            <?php endfor; ?>

            <?php if ($page < $totalPage):
                $nextLinkParams = array_filter($filters);
                $nextLinkParams['page'] = $page + 1;
                $nextLinkParams['sort_by'] = $sort_by;
                $nextLinkParams['sort_order'] = $sort_order;
                ?>
                <a href="?<?= http_build_query($nextLinkParams) ?>" class="pagination-btn"><i
                        class="fas fa-chevron-right"></i></a>
            <?php else: ?>
                <button class="pagination-btn" disabled><i class="fas fa-chevron-right"></i></button>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<script>
    const btnDels = document.querySelectorAll(".btn-del");
    btnDels.forEach((btn) => {
        btn.addEventListener("click", doConfirm);
    });

    function doConfirm(e) {
        const btn = e.target.closest('.btn-del');
        if (btn && confirm("確定要刪除嗎?")) {
            window.location.href = `./doDelete.php?id=${btn.dataset.id}`;
        }
    }

    const btnCouponSearch = document.getElementById("btnCouponSearch");
    if (btnCouponSearch) {
        btnCouponSearch.addEventListener("click", function () {
            let params = new URLSearchParams();

            const statusVal = document.getElementById("statusFilterSelect").value;
            const qTypeVal = document.getElementById("qTypeSelect").value;
            const searchVal = document.getElementById("searchText").value;
            const dateStartVal = document.getElementById("dateStartInput").value;
            const dateEndVal = document.getElementById("dateEndInput").value;

            if (statusVal) {
                params.append('status_filter', statusVal);
            }
            if (searchVal) {
                params.append('search', searchVal);
                params.append('qType', qTypeVal);
            }
            if (dateStartVal) {
                params.append('date_start', dateStartVal);
            }
            if (dateEndVal) {
                params.append('date_end', dateEndVal);
            }

            window.location.href = 'index.php?' + params.toString();
        });
    }

    // 排序功能
    document.querySelectorAll('.sortable-header').forEach(header => {
        // 從 PHP 獲取初始的排序狀態
        const initialSortBy = "<?= $sort_by ?>";
        const initialSortOrder = "<?= $sort_order ?>";

        header.addEventListener('click', function () {
            const currentUrl = new URL(window.location.href);
            const clickedColumn = this.dataset.sort;

            let newSortOrder;
            if (clickedColumn === initialSortBy) {
                // 如果點擊的是當前排序的欄位，則切換排序順序
                newSortOrder = (initialSortOrder === 'asc') ? 'desc' : 'asc';
            } else {
                // 如果點擊的是新的欄位，則預設為升冪排序
                newSortOrder = 'asc';
            }
            currentUrl.searchParams.set('sort_by', clickedColumn);
            currentUrl.searchParams.set('sort_order', newSortOrder);

            window.location.href = currentUrl.toString();
        });
    });

</script>

<?php
include "../template_btm.php";
?>