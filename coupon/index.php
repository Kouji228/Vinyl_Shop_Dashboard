<?php

require_once "./connect.php";
require_once "./Utilities.php";

// 分頁功能
$perPage = 10;
$page = intval($_GET["page"] ?? 1);
$pageStart = ($page - 1) * $perPage;
$statusMap = [
    'active' => '生效中',
    'pending' => '待上架',
    'inactive' => '已停用'
];

// 獲取篩選參數
$statusFilter = $_GET['status_filter'] ?? '';
$search = $_GET['search'] ?? '';
$qType = $_GET['qType'] ?? 'name';
$dateStart = $_GET['date_start'] ?? '';
$dateEnd = $_GET['date_end'] ?? '';

$whereConditions = ["coupons.`is_valid` = 1"]; // 基本條件：只選取有效的優惠卷
$bindings = [];

// 狀態篩選
if (!empty($statusFilter)) {
    $whereConditions[] = "coupons.`status` = :status_filter";
    $bindings[':status_filter'] = $statusFilter;
}

// 日期篩選 (獨立處理)
if (!empty($dateStart) || !empty($dateEnd)) {
    // 情況 1: 同時提供了開始和結束日期
    if (!empty($dateStart) && !empty($dateEnd)) {
        $bindings[':filter_date_start_query'] = $dateStart . " 00:00:00";
        $bindings[':filter_date_end_query'] = $dateEnd . " 23:59:59";
        $whereConditions[] = "(coupons.`start_at` <= :filter_date_end_query AND coupons.`end_at` >= :filter_date_start_query)";
        // 情況 2: 只提供了開始日期
    } elseif (!empty($dateStart) && empty($dateEnd)) {
        $bindings[':filter_date_start_query'] = $dateStart . " 00:00:00";
        // 優惠卷的結束時間晚於或等於篩選的開始日期，或者優惠卷沒有結束日期 (視為持續有效)
        // 假設 coupons.end_at IS NULL 代表優惠卷沒有明確的結束日期
        $whereConditions[] = "(coupons.`end_at` >= :filter_date_start_query OR coupons.`end_at` IS NULL)";
        // 情況 3: 只提供了結束日期
    } elseif (empty($dateStart) && !empty($dateEnd)) {
        $bindings[':filter_date_end_query'] = $dateEnd . " 23:59:59";
        // 優惠卷的開始時間早於或等於篩選的結束日期
        $whereConditions[] = "coupons.`start_at` <= :filter_date_end_query";
    }
}
// 關鍵字搜尋 (獨立處理)
if (!empty($search) && ($qType === 'name' || $qType === 'code')) {
    $columnToSearch = ($qType === 'name') ? 'coupons.`name`' : 'coupons.`code`';
    $whereConditions[] = "$columnToSearch LIKE :search";
    $bindings[':search'] = "%" . $search . "%";
}

$whereClause = "";
if (count($whereConditions) > 0) {
    $whereClause = "WHERE " . implode(" AND ", $whereConditions);
}

$sql = "SELECT coupons.*,
               coupon_rules.discount_value, 
               coupon_rules.discount_type
        FROM `coupons`
        LEFT JOIN `coupon_rules` ON coupons.id = coupon_rules.coupon_id
        $whereClause
        ORDER BY coupons.id ASC
        -- ORDER BY coupons.id DESC
        LIMIT $perPage OFFSET $pageStart";

$sqlAll = "SELECT COUNT(coupons.id) as total FROM `coupons` LEFT JOIN `coupon_rules` ON coupons.id = coupon_rules.coupon_id $whereClause";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($bindings);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmtAll = $pdo->prepare($sqlAll);
    $stmtAll->execute($bindings);
    $totalCountResult = $stmtAll->fetch(PDO::FETCH_ASSOC);
    $totalCount = $totalCountResult['total'] ?? 0;

} catch (PDOException $e) {
    echo "錯誤: {{$e->getMessage()}}";
    exit;
}

$totalPage = ceil($totalCount / $perPage);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>優惠卷系統</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <style>
        .msg {
            display: flex;
            margin-bottom: 2px;
        }

        .id {
            width: 30px;
        }

        .name {
            flex: 1;
        }

        .code {
            flex: 1;
        }

        .content {
            flex: 2;
        }

        .status {
            flex: 1;
        }

        .total_quantity {
            flex: 1;
        }

        .per_user_limit {
            flex: 1;
        }

        .uses_per_instance {
            flex: 1;
        }

        .discount_value {
            flex: 1;
        }

        .start_at {
            width: 120px;
        }

        .end_at {
            width: 120px;
        }

        .time {
            width: 150px;
        }
    </style>
</head>

<body>
    <div class="container mt-3">
        <h1>優惠卷列表</h1>
        <div class="my-2 d-flex">
            <span class="me-auto align-self-center">目前共 <?= $totalCount ?> 筆資料</span>

            <div class="me-lg-1 mb-1 mb-lg-0 ms-auto">
                <div class="input-group input-group-sm">
                    <!-- 狀態篩選 -->
                    <span class="input-group-text">狀態</span>
                    <select name="status_filter" class="form-select form-select-sm" style="max-width: 120px;">
                        <option value="">全部</option>
                        <?php foreach ($statusMap as $value => $displayText): ?>
                            <option value="<?= htmlspecialchars($value) ?>" <?= ($statusFilter === $value) ? "selected" : "" ?>>
                                <?= htmlspecialchars($displayText) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <!-- 日期篩選 -->
                    <span class="input-group-text ms-2">活動區間</span>
                    <input type="date" name="date_start" class="form-control form-control-sm"
                        value="<?= htmlspecialchars($dateStart) ?>" id="dateStartInput">
                    <span class="input-group-text">~</span>
                    <input type="date" name="date_end" class="form-control form-control-sm"
                        value="<?= htmlspecialchars($dateEnd) ?>" id="dateEndInput">

                    <!-- 名稱/優惠碼 Radio & 關鍵字 -->
                    <span class="input-group-text ms-2">搜尋</span>
                    <div class="input-group-text">
                        <input name="qType" id="qTypeName" type="radio" class="form-check-input" value="name"
                            <?= ($qType === 'name' || empty($qType)) ? 'checked' : '' ?>>
                        <label for="qTypeName" class="ms-1">名稱</label>
                    </div>
                    <div class="input-group-text">
                        <input name="qType" id="qTypeCode" type="radio" class="form-check-input" value="code"
                            <?= $qType === 'code' ? 'checked' : '' ?>>
                        <label for="qTypeCode" class="ms-1">優惠碼</label>
                    </div>
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="關鍵字"
                        value="<?= htmlspecialchars($search) ?>" id="searchText">

                    <div id="btnCouponSearch" class="btn btn-primary btn-sm">搜尋</div>
                    <a href="index.php" class="btn btn-secondary btn-sm ms-1">清除</a>
                </div>
            </div>
            <a class="btn btn-primary btn-sm btn-add ms-2" href="./add.php">增加資料</a>
        </div>

        <div class="msg text-bg-dark ps-1">
            <div class="id">#</div>
            <div class="name">優惠卷名稱</div>
            <div class="code">優惠碼</div>
            <div class="content">優惠卷說明</div>
            <div class="discount_value">折扣值</div>
            <div class="status">狀態</div>
            <div class="total_quantity">總數</div>
            <!-- <div class="per_user_limit">限領張數</div> -->
            <div class="uses_per_instance">可用次數</div>
            <div class="start_at">開始時間</div>
            <div class="end_at">結束時間</div>
            <div class="time">操作</div>
        </div>

        <?php foreach ($rows as $index => $row): ?>
            <div class="msg">
                <div class="id"><?= $index + 1 + ($page - 1) * $perPage ?></div>
                <div class="name"><?= $row["name"] ?></div>
                <div class="code"><?= $row["code"] ?></div>
                <div class="content"><?= $row["content"] ?></div>
                <div class="discount_value">
                    <?php
                    if ($row["discount_value"] !== null && $row["discount_value"] !== '') {
                        echo htmlspecialchars($row["discount_value"]);
                        if ($row["discount_type"] === 'percent') {
                            echo '%';
                        } elseif ($row["discount_type"] === 'fixed') {
                            echo '元';
                        }
                    } else {
                        echo '無';
                    }
                    ?>
                </div>
                <div class="status">
                    <?= $statusMap[$row['status']] ?? '無狀態' ?>
                </div>

                <div class="total_quantity"><?= $row["total_quantity"] ?></div>
                <!-- <div class="per_user_limit">$row["per_user_limit"]</div> -->
                <div class="uses_per_instance"><?= $row["uses_per_instance"] ?></div>
                <div class="start_at"><?= $row["start_at"] ?></div>
                <div class="end_at"><?= $row["end_at"] ?></div>
                <div class="time">
                    <a class="btn btn-info btn-sm" href="./coupon_details_page.php?id=<?= $row["id"] ?>">詳細</a>
                    <a class="btn btn-warning btn-sm" href="./update.php?id=<?= $row["id"] ?>">修改</a>
                    <div class="btn btn-danger btn-sm btn-del" data-id="<?= $row["id"] ?>">刪除</div>
                </div>
            </div>
        <?php endforeach; ?>
        <!-- 分頁點擊切換 -->
        <ul class="pagination pagination-sm justify-content-center">
            <?php for ($i = 1; $i <= $totalPage; $i++): ?>
                <li class="page-item <?= $page == $i ? "active" : "" ?>">
                    <?php
                    $linkParams = ['page' => $i];
                    if (!empty($statusFilter))
                        $linkParams['status_filter'] = $statusFilter;

                    // 關鍵字搜尋參數
                    if (!empty($search)) {
                        $linkParams['search'] = $search;
                        $linkParams['qType'] = $qType;
                    } elseif (!empty($qType) && !empty($statusFilter) && $qType !== 'name') {
                        $linkParams['qType'] = $qType;
                    }
                    // 日期參數
                    if (!empty($dateStart))
                        $linkParams['date_start'] = $dateStart;
                    if (!empty($dateEnd))
                        $linkParams['date_end'] = $dateEnd;

                    $link = "?" . http_build_query($linkParams);
                    ?>
                    <a class="page-link" href="<?= $link ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
        </ul>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"></script>
    <script>
        // DOM Elements
        const statusSelect = document.querySelector("select[name=status_filter]");
        const btnCouponSearch = document.getElementById("btnCouponSearch");
        const qTypeRadios = document.querySelectorAll("input[name=qType]");
        const searchText = document.getElementById("searchText");
        const dateStartInput = document.getElementById("dateStartInput");
        const dateEndInput = document.getElementById("dateEndInput");

        const btnDels = document.querySelectorAll(".btn-del");
        btnDels.forEach((btn) => {
            btn.addEventListener("click", doConfirm);
        });


        function doConfirm(e) {
            const btn = e.target;
            if (confirm("確定要刪除嗎?")) {
                window.location.href = `./doDelete.php?id=${btn.dataset.id}`;
            }
        }


        // Main search button click handler
        if (btnCouponSearch) {
            btnCouponSearch.addEventListener("click", function () {
                let params = new URLSearchParams();

                const statusVal = statusSelect.value;
                const selectedQTypeRadio = document.querySelector("input[name=qType]:checked");
                const qTypeVal = selectedQTypeRadio ? selectedQTypeRadio.value : 'name';
                const searchVal = searchText.value;
                const dateStartVal = dateStartInput.value;
                const dateEndVal = dateEndInput.value;

                if (statusVal) {
                    params.append('status_filter', statusVal);
                }

                if (searchVal) {
                    params.append('search', searchVal);
                    params.append('qType', qTypeVal);
                } else if (qTypeVal && qTypeVal !== 'name') {
                    params.append('qType', qTypeVal);
                }

                // 日期參數
                if (dateStartVal) {
                    params.append('date_start', dateStartVal);
                }
                if (dateEndVal) {
                    params.append('date_end', dateEndVal);
                }

                window.location.href = 'index.php?' + params.toString();
            });
        }
    </script>
</body>

</html>