<?php
require_once "../vinyl_shop/connect.php";
require_once "../components/Utilities.php";

$pageTitle = "店面管理";
$cssList = ["../css/index.css", "../css/vinyl_shop.css"];
include "../vars.php";
include "../template_top.php";
include "../template_main.php";

// 分頁邏輯
$perPage = 10;
$page = intval($_GET["page"] ?? 1);
$pageStart = ($page - 1) * $perPage;

// 查詢已刪除的店面
$sql = "SELECT b.*,
        GROUP_CONCAT(DISTINCT h.name) as services
        FROM branch b
        LEFT JOIN branch_hashtag bh ON b.id = bh.branch_id
        LEFT JOIN hashtag h ON bh.hashtag_id = h.id
        WHERE b.is_deleted = 1
        GROUP BY b.id
        ORDER BY b.deleted_at DESC
        LIMIT :limit OFFSET :offset";

// 計算總筆數
$sqlCount = "SELECT COUNT(*) as total FROM branch WHERE is_deleted = 1";
$stmtCount = $pdo->prepare($sqlCount);
$stmtCount->execute();
$totalCount = $stmtCount->fetch(PDO::FETCH_ASSOC)['total'];
$totalPages = ceil($totalCount / $perPage);

// 分頁查詢
try {
    $stmt = $pdo->prepare($sql);
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
        <h3 class="section-title">店面資料回收站</h3>
        <span class="ms-auto">目前共 <?= $totalCount ?> 筆資料</span>
        <a href="/vinyl_shop/index.php" class="btn btn-secondary">返回店面列表</a>
    </div>

           <!-- 店面列表 -->
           <div class="table-container table-responsive">
        <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
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
                            <a href="#" class="btn btn-sm btn-success restore-btn" data-id="<?=$branch["id"]?>" title="還原"><i class="fas fa-undo"></i></a>
                            <a href="#" class="btn btn-sm btn-danger delete-btn" data-id="<?=$branch["id"]?>" title="永久刪除"><i class="fas fa-trash-alt"></i></a>
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
                <button class="pagination-btn" onclick="window.location.href='?page=<?= $page-1 ?>'">
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
                echo '<button class="pagination-btn" onclick="window.location.href=\'?page=1\'">1</button>';
                if ($startPage > 2) {
                    echo '<span class="pagination-ellipsis">...</span>';
                }
            }

            for ($i = $startPage; $i <= $endPage; $i++): ?>
                <button class="pagination-btn <?= $i == $page ? 'active' : '' ?>"
                        onclick="window.location.href='?page=<?= $i ?>'">
                    <?= $i ?>
                </button>
            <?php endfor;

            if ($endPage < $totalPages) {
                if ($endPage < $totalPages - 1) {
                    echo '<span class="pagination-ellipsis">...</span>';
                }
                echo '<button class="pagination-btn" onclick="window.location.href=\'?page=' . $totalPages . '\'">' . $totalPages . '</button>';
            }
            ?>

            <?php if ($page < $totalPages): ?>
                <button class="pagination-btn" onclick="window.location.href='?page=<?= $page+1 ?>'">
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

    <!-- 刪除確認對話框 -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">確認永久刪除</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <p>確定要永久刪除店面資料？</p>
                <p class="text-danger mb-0">此操作無法復原，所有相關資料都將被永久刪除。</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                    <a href="#" class="btn btn-danger" id="confirmDelete">確定刪除</a>
                </div>
        </div>
    </div>
</div>

<!-- 還原確認對話框 -->
<div class="modal fade" id="restoreModal" tabindex="-1" aria-labelledby="restoreModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="restoreModalLabel">確認還原</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>確定要還原此店面資料？</p>
                <p class="text-muted mb-0">此操作會將店面資料還原到正常列表。</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                <a href="#" class="btn btn-success" id="confirmRestore">確定還原</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
<script>

    // 初始化刪除確認對話框
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    const confirmDeleteBtn = document.getElementById('confirmDelete');

    // 初始化還原確認對話框
    const restoreModal = new bootstrap.Modal(document.getElementById('restoreModal'));
    const confirmRestoreBtn = document.getElementById('confirmRestore');

    // 為所有刪除按鈕添加點擊事件
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const branchId = btn.dataset.id;
            confirmDeleteBtn.href = `permanentDelete.php?id=${branchId}&permanent=1`;
            deleteModal.show();
        });
    });

    // 為所有還原按鈕添加點擊事件
    document.querySelectorAll('.restore-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const branchId = btn.dataset.id;
            confirmRestoreBtn.href = `doRestore.php?id=${branchId}`;
            restoreModal.show();
        });
    });
</script>

<?php
include "../template_btm.php";
?>
