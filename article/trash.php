<?php
require_once "../components/connect.php";
require_once "../components/Utilities.php";

$pageTitle = "文章管理";
$cssList = ["../css/index.css", "../css/article.css"];
include "../vars.php";
include "../template_top.php";
include "../template_main.php";

// 獲取篩選參數
$allowed_columns = ['deleted_at', 'updated_at', 'created_at', 'title'];
$sort_column = $_GET['sort_column'] ?? 'deleted_at';
$sort_column = in_array($sort_column, $allowed_columns) ? $sort_column : 'deleted_at';
$sort_order = $_GET['sort_order'] ?? 'desc';

// 分頁邏輯
$perPage = 10;
$page = intval($_GET["page"] ?? 1);
$pageStart = ($page - 1) * $perPage;

// 排序子句
$orderClause = "ORDER BY a.{$sort_column} {$sort_order}";

// 查詢已刪除的文章
$sql = "SELECT a.*, s.status, s.updated_at as status_updated_at,
        GROUP_CONCAT(DISTINCT CONCAT(t.name, ':', t.color) SEPARATOR '|') as tags,
        GROUP_CONCAT(DISTINCT c.name) as category
        FROM articles a
        LEFT JOIN article_statuses s ON a.id = s.article_id
        LEFT JOIN article_tag at ON a.id = at.article_id
        LEFT JOIN tags t ON at.tag_id = t.id
        LEFT JOIN article_category ac ON a.id = ac.article_id
        LEFT JOIN categories c ON ac.category_id = c.id
        WHERE a.is_deleted = 1
        GROUP BY a.id, a.title, a.content, a.cover_image_url, a.created_at, a.updated_at, a.deleted_at, s.status, s.updated_at
        $orderClause
        LIMIT :limit OFFSET :offset";

// 計算總筆數
$sqlCount = "SELECT COUNT(DISTINCT a.id) as total
             FROM articles a
             WHERE a.is_deleted = 1";

try {
    // 執行分頁查詢
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $pageStart, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 計算總筆數
    $stmtCount = $pdo->prepare($sqlCount);
    $stmtCount->execute();
    $totalCount = $stmtCount->fetch(PDO::FETCH_ASSOC)['total'];
    $totalPages = ceil($totalCount / $perPage);

} catch (PDOException $e) {
    echo "錯誤: " . $e->getMessage();
    exit;
}
?>

<div class="content-section">
    <div class="section-header d-flex justify-content-between align-items-center">
        <h3 class="section-title">文章回收站</h3>
        <span class="ms-auto">目前共 <?= $totalCount ?> 筆資料</span>
        <a href="/article/index.php" class="btn btn-secondary">返回文章列表</a>
    </div>

    <!-- 文章列表 -->
    <div class="table-container table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>

                    <th style="width: 350px;">標題</th>
                    <th style="width: 150px;">文章封面</th>
                    <th>分類</th>
                    <th>標籤</th>
                    <th>刪除時間
                    <a href="?sort_column=deleted_at&sort_order=<?= ($sort_column === 'deleted_at' && $sort_order === 'asc') ? 'desc' : 'asc' ?>" style="text-decoration:none; color:inherit;">
                            <?php if ($sort_column === 'deleted_at') : ?>
                                <i class="bi bi-caret-<?= $sort_order === 'asc' ? 'up' : 'down'; ?>-fill"></i>
                            <?php else: ?>
                                <i class="bi bi-caret-down"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th>狀態</th>
                    <th style="width: 120px;">操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $article): ?>
                <tr>

                    <td style="width: 350px;"><?=$article["title"]?></td>
                    <td style="width: 150px;">
                        <div class="image-container">
                            <?php if (!empty($article["cover_image_url"])): ?>
                                <img src="<?=$article["cover_image_url"]?>" alt="封面圖片" class="thumbnail">
                            <?php else: ?>
                                <div class="thumbnail bg-light d-flex align-items-center justify-content-center">
                                    <span class="text-muted">無圖片</span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td>
                        <?php if (!empty($article["category"])): ?>
                            <?php foreach (explode(',', $article["category"]) as $category): ?>
                                <span class="category-badge"><?= htmlspecialchars($category) ?></span>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <span class="text-muted">無分類</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (!empty($article["tags"])): ?>
                            <?php
                            $tagPairs = explode('|', $article["tags"]);
                            foreach ($tagPairs as $tagPair):
                                list($tagName, $tagColor) = explode(':', $tagPair);
                            ?>
                                <span class="tag-badge">
                                    <?= htmlspecialchars($tagName) ?>
                                </span>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <span class="text-muted">無標籤</span>
                        <?php endif; ?>
                    </td>
                    <td><?=$article["deleted_at"]?></td>
                    <td>
                        <?php if (!empty($article["status"])): ?>
                            <span class="status-badge status-<?=$article["status"]?>">
                                <?php
                                switch($article["status"]) {
                                    case 'draft':
                                        echo '草稿';
                                        break;
                                    case 'published':
                                        echo '已發布';
                                        break;
                                    case 'scheduled':
                                        echo '排程發布';
                                        break;
                                    default:
                                        echo $article["status"];
                                }
                                ?>
                            </span>
                        <?php else: ?>
                            <span class="status-badge status-draft">未設置</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="#" class="btn btn-sm btn-success restore-btn" data-id="<?=$article["id"]?>" title="恢復"><i class="fas fa-undo"></i></a>
                            <a href="#" class="btn btn-sm btn-danger permanent-delete-btn" data-id="<?=$article["id"]?>" title="永久刪除"><i class="fas fa-trash-alt"></i></a>
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

<!-- 永久刪除確認對話框 -->
<div class="modal fade" id="permanentDeleteModal" tabindex="-1" aria-labelledby="permanentDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="permanentDeleteModalLabel">確認永久刪除</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-danger mb-2"><i class="fas fa-exclamation-triangle"></i> 警告：此操作無法復原！</p>
                <p>確定要永久刪除這篇文章嗎？</p>
                <p class="text-muted mb-0">此操作將：</p>
                <ul class="text-muted mb-0">
                    <li>永久刪除文章內容</li>
                    <li>刪除所有相關的分類和標籤關聯</li>
                    <li>刪除所有相關的圖片</li>
                    <li>刪除所有相關的狀態記錄</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                <a href="#" class="btn btn-danger" id="confirmPermanentDelete">確定永久刪除</a>
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
                <p>確定要還原此文章？</p>
                <p class="text-muted mb-0">此操作會將文章還原到正常列表。</p>
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
    // 永久刪除確認對話框
    const permanentDeleteModal = new bootstrap.Modal(document.getElementById('permanentDeleteModal'));
    const confirmPermanentDeleteBtn = document.getElementById('confirmPermanentDelete');

    // 還原確認對話框
    const restoreModal = new bootstrap.Modal(document.getElementById('restoreModal'));
    const confirmRestoreBtn = document.getElementById('confirmRestore');

    // 為所有永久刪除按鈕添加點擊事件
    document.querySelectorAll('.permanent-delete-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const articleId = btn.dataset.id;
            confirmPermanentDeleteBtn.href = `permanentDelete.php?id=${articleId}`;
            permanentDeleteModal.show();
        });
    });

    // 為所有還原按鈕添加點擊事件
    document.querySelectorAll('.restore-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const articleId = btn.dataset.id;
            confirmRestoreBtn.href = `doRestore.php?id=${articleId}`;
            restoreModal.show();
        });
    });
</script>

<?php
include "../template_btm.php";
?>
