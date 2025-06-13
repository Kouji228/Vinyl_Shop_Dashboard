<?php
require_once "../components/connect.php";
require_once "../components/Utilities.php";

$pageTitle = "店面管理";
$cssList = ["../css/index.css", "../css/vinyl_shop.css"];
include "../vars.php";
include "../template_top.php";
include "../template_main.php";

// 獲取篩選參數
$searchTitle = $_GET["titleKeyword"] ?? "";
$selectedDistrict = $_GET["district"] ?? "";

// 分頁邏輯
$perPage = 10;
$page = intval($_GET["page"] ?? 1);
$pageStart = ($page - 1) * $perPage;

// 構建 WHERE 條件
$whereConditions = ["deleted_at IS NULL"];
$params = [];

// 標題搜尋
if (!empty($searchTitle)) {
    $whereConditions[] = "name LIKE :titleKeyword";
    $params[':titleKeyword'] = "%{$searchTitle}%";
}

// 區域篩選
if (!empty($selectedDistrict)) {
    $whereConditions[] = "address LIKE :district";
    $params[':district'] = "%{$selectedDistrict}%";
}

// 組合 WHERE 子句
$whereClause = implode(" AND ", $whereConditions);

// 計算總筆數
$sqlCount = "SELECT COUNT(*) as total FROM branch WHERE " . $whereClause;
$stmtCount = $pdo->prepare($sqlCount);
foreach ($params as $key => $value) {
    $stmtCount->bindValue($key, $value);
}
$stmtCount->execute();
$totalCount = $stmtCount->fetch(PDO::FETCH_ASSOC)['total'];
$totalPages = ceil($totalCount / $perPage);

// 分頁查詢
$sql = "SELECT * FROM branch WHERE " . $whereClause . " LIMIT :limit OFFSET :offset";
try {
    $stmt = $pdo->prepare($sql);
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $pageStart, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "錯誤: " . $e->getMessage();
    exit;
}

?>

    <div class="content-section">
        <div class="section-header d-flex justify-content-between align-items-center">
            <h3 class="section-title">店面列表</h3>
            <span class="ms-auto">目前共 <?= $totalCount ?> 筆資料
            <?php if (!empty($searchTitle) || !empty($selectedDistrict)): ?>
                (已篩選)
            <?php endif; ?></span>
            <div class="d-flex gap-2">
                <div class="batch-actions" style="display: none;">
                    <button type="button" class="btn btn-danger" id="batchDeleteBtn">
                        <i class="fas fa-trash-alt"></i> 批次刪除
                    </button>
                </div>
                <a href="/vinyl_shop/trash.php" class="btn btn-secondary">回收站</a>
                <a href="/vinyl_shop/form.php" class="btn btn-primary">新增店面</a>
            </div>
        </div>

            <!-- 整合搜尋區域 -->
            <div class="controls-section d-flex align-items-end flex-wrap gap-2">
                <div class="search-box flex-grow-1">
                    <input name="titleKeyword" type="text" class="form-control" placeholder="搜尋店名關鍵字" value="<?= htmlspecialchars($_GET['titleKeyword'] ?? '') ?>">
                    <i class="fas fa-search"></i>
                </div>

                <div class="filter-group">
                    <select name="district" style="width: 150px;">
                        <option value="">選擇城市</option>
                        <option value="台北市" <?= $selectedDistrict === '台北市' ? 'selected' : '' ?>>台北市</option>
                        <option value="新北市" <?= $selectedDistrict === '新北市' ? 'selected' : '' ?>>新北市</option>
                        <option value="桃園市" <?= $selectedDistrict === '桃園市' ? 'selected' : '' ?>>桃園市</option>
                    </select>
                </div>
                <button type="button" class="accept-filters" id="vinylShopSearchBtn">搜尋</button>
                <a href="index.php" class="clear-filters">清除篩選</a>
            </div>


           <!-- 店面列表 -->
           <div class="table-container table-responsive">
            <table class="table table-bordered table-striped align-middle ">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 50px;">
                            <input type="checkbox" class="form-check-input" id="selectAll">
                        </th>
                        <th style="width: 200px;">店名</th>
                        <th style="width: 300px;">地址</th>
                        <th style="width: 120px;">電話</th>
                        <th style="width: 200px;">營業星期</th>
                        <th style="width: 150px;">營業時間</th>
                        <th style="width: 120px;">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($result as $index => $branch): ?>
                    <tr>
                        <td>
                            <input type="checkbox" class="form-check-input branch-checkbox" value="<?=$branch["id"]?>">
                        </td>
                        <td style="width: 200px;" class="text-truncate" title="<?=$branch["name"]?>"><?=$branch["name"]?></td>
                        <td style="width: 300px;" class="text-truncate" title="<?=$branch["address"]?>"><?=$branch["address"]?></td>
                        <td style="width: 120px;"><?=$branch["phone"]?></td>

                        <td style="width: 200px;">
                        <?php
                        $weekdays = explode(',', $branch['weekdays']);
                        $weekdayNames = [
                            '1' => '週一',
                            '2' => '週二',
                            '3' => '週三',
                            '4' => '週四',
                            '5' => '週五',
                            '6' => '週六',
                            '7' => '週日'
                        ];
                        $displayWeekdays = array_map(function($day) use ($weekdayNames) {
                            return $weekdayNames[$day] ?? $day;
                        }, $weekdays);
                        echo implode(', ', $displayWeekdays);
                        ?>
                    </td>
                    <td style="width: 150px;"><?=$branch["business_hours"]?></td>
                        <td style="width: 120px;">
                        <div class="action-buttons">
                                <a href="/vinyl_shop/form.php?id=<?=$branch["id"]?>" class="btn btn-sm btn-warning" title="修改"><i class="fas fa-edit"></i></a>
                                <a href="#" class="btn btn-sm btn-danger delete-btn" data-id="<?=$branch["id"]?>" title="刪除"><i class="fas fa-trash-alt"></i></a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

                <!-- 分頁導航 -->
                <?php if ($totalPages > 1): ?>
        <div class="pagination">
            <div class="pagination-info">
                第 <?= $page ?> 頁，共 <?= $totalPages ?> 頁
            </div>
            <?php if ($page > 1): ?>
                <button class="pagination-btn" onclick="window.location.href='?page=<?= $page-1 ?><?= !empty($searchTitle) ? '&titleKeyword=' . urlencode($searchTitle) : '' ?><?= !empty($selectedDistrict) ? '&district=' . urlencode($selectedDistrict) : '' ?>'">
                    <i class="fas fa-chevron-left"></i>
                </button>
            <?php else: ?>
                <button class="pagination-btn" disabled>
                    <i class="fas fa-chevron-left"></i>
                </button>
            <?php endif; ?>

            <?php
            $startPage = max(1, $page - 2);
            $endPage = min($totalPages, $page + 2);

            if ($startPage > 1) {
                echo '<button class="pagination-btn" onclick="window.location.href=\'?page=1' . (!empty($searchTitle) ? '&titleKeyword=' . urlencode($searchTitle) : '') . (!empty($selectedDistrict) ? '&district=' . urlencode($selectedDistrict) : '') . '\'">1</button>';
                if ($startPage > 2) {
                    echo '<span class="pagination-ellipsis">...</span>';
                }
            }

            for ($i = $startPage; $i <= $endPage; $i++): ?>
                <button class="pagination-btn <?= $i == $page ? 'active' : '' ?>"
                        onclick="window.location.href='?page=<?= $i ?><?= !empty($searchTitle) ? '&titleKeyword=' . urlencode($searchTitle) : '' ?><?= !empty($selectedDistrict) ? '&district=' . urlencode($selectedDistrict) : '' ?>'">
                    <?= $i ?>
                </button>
            <?php endfor;

            if ($endPage < $totalPages) {
                if ($endPage < $totalPages - 1) {
                    echo '<span class="pagination-ellipsis">...</span>';
                }
                echo '<button class="pagination-btn" onclick="window.location.href=\'?page=' . $totalPages . (!empty($searchTitle) ? '&titleKeyword=' . urlencode($searchTitle) : '') . (!empty($selectedDistrict) ? '&district=' . urlencode($selectedDistrict) : '') . '\'">' . $totalPages . '</button>';
            }
            ?>

            <?php if ($page < $totalPages): ?>
                <button class="pagination-btn" onclick="window.location.href='?page=<?= $page+1 ?><?= !empty($searchTitle) ? '&titleKeyword=' . urlencode($searchTitle) : '' ?><?= !empty($selectedDistrict) ? '&district=' . urlencode($selectedDistrict) : '' ?>'">
                    <i class="fas fa-chevron-right"></i>
                </button>
            <?php else: ?>
                <button class="pagination-btn" disabled>
                    <i class="fas fa-chevron-right"></i>
                </button>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>

    <!-- 單項刪除確認對話框 -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">確認刪除</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>確定要刪除此店面資料？</p>
                    <p class="text-muted mb-0">此操作會將店面資料移至回收站，您可以稍後在回收站中恢復或永久刪除。</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                    <a href="#" class="btn btn-danger" id="confirmDelete">確定刪除</a>
                </div>
            </div>
        </div>
    </div>

    <!-- 批次刪除確認對話框 -->
    <div class="modal fade" id="batchDeleteModal" tabindex="-1" aria-labelledby="batchDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="batchDeleteModalLabel">確認批次刪除</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>確定要刪除所選的店面資料？</p>
                    <p class="text-muted mb-0">此操作會將選中的店面資料移至回收站，您可以稍後在回收站中恢復或永久刪除。</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-danger" id="confirmBatchDelete">確定刪除</button>
                </div>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
<script>
        // 全選功能
        const selectAllCheckbox = document.getElementById('selectAll');
        const branchCheckboxes = document.querySelectorAll('.branch-checkbox');
        const batchActions = document.querySelector('.batch-actions');
        const batchDeleteBtn = document.getElementById('batchDeleteBtn');
        const batchDeleteModal = new bootstrap.Modal(document.getElementById('batchDeleteModal'));
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));

        // 更新批次操作按鈕的顯示狀態
        function updateBatchActions() {
            const checkedBoxes = document.querySelectorAll('.branch-checkbox:checked');
            batchActions.style.display = checkedBoxes.length > 0 ? 'block' : 'none';
        }

        // 全選/取消全選
        selectAllCheckbox.addEventListener('change', (e) => {
            const isChecked = e.target.checked;
            branchCheckboxes.forEach(checkbox => {
                checkbox.checked = isChecked;
            });
            updateBatchActions();
        });

        // 當個別 checkbox 改變時
        branchCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                const allChecked = Array.from(branchCheckboxes).every(cb => cb.checked);
                selectAllCheckbox.checked = allChecked;
                updateBatchActions();
            });
        });

        // 批次刪除按鈕點擊事件
        batchDeleteBtn.addEventListener('click', () => {
            const checkedBoxes = document.querySelectorAll('.branch-checkbox:checked');
            if (checkedBoxes.length > 0) {
                batchDeleteModal.show();
            }
        });

        // 確認批次刪除
        document.getElementById('confirmBatchDelete').addEventListener('click', async () => {
            const checkedBoxes = document.querySelectorAll('.branch-checkbox:checked');
            const ids = Array.from(checkedBoxes).map(cb => cb.value);

            try {
                const response = await fetch('doBatchDelete.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ ids: ids })
                });

                const result = await response.json();
                if (result.success) {
                    window.location.reload();
                } else {
                    alert(result.message || '操作失敗');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('發生錯誤，請稍後再試');
            }

            batchDeleteModal.hide();
        });

        // 單項刪除按鈕點擊事件
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const branchId = btn.dataset.id;
                document.getElementById('confirmDelete').href = `doDelete.php?id=${branchId}`;
                deleteModal.show();
            });
        });

        // 初始化時檢查搜尋類型
        var searchDateInput = document.querySelector('input[name="searchDate"]:checked');
        if (searchDateInput && searchDateInput.checked) {
            document.querySelector('.date-range').style.display = 'flex';
            document.querySelector('input[name="titleKeyword"]').style.display = 'none';
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('vinylShopSearchBtn').addEventListener('click', function() {
                const params = new URLSearchParams();
                const title = document.querySelector('input[name="titleKeyword"]').value;
                const district = document.querySelector('select[name="district"]').value;

                if (title) params.append('titleKeyword', title);
                if (district) params.append('district', district);

                window.location.href = 'index.php?' + params.toString();
            });

            // 添加 Enter 鍵搜尋功能
            document.querySelector('input[name="titleKeyword"]').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    document.getElementById('vinylShopSearchBtn').click();
                }
            });

            // 在縣市選擇框也添加 Enter 鍵搜尋功能
            document.querySelector('select[name="district"]').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    document.getElementById('vinylShopSearchBtn').click();
                }
            });
        });
</script>


<?php
include "../template_btm.php";
?>
