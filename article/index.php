<?php
require_once "../article/connect.php";
require_once "../components/Utilities.php";

$pageTitle = "文章管理";
$cssList = ["../css/index.css", "../css/article.css"];
include "../vars.php";
include "../template_top.php";
include "../template_main.php";



// 獲取篩選參數
$date1 = $_GET["date1"] ?? "";
$date2 = $_GET["date2"] ?? "";
$searchTitle = $_GET["titleKeyword"] ?? "";
$searchCategory = $_GET["categoryKeyword"] ?? "";
$searchTag = $_GET["tagKeyword"] ?? "";
$searchStatus = $_GET["statusKeyword"] ?? "";
$searchDate = isset($_GET["searchDate"]) ? true : false;
$sort_column = $_GET['sort_column'] ?? 'updated_at';
$sort_order = $_GET['sort_order'] ?? 'desc';

// 分頁邏輯
$perPage = 10;
$page = intval($_GET["page"] ?? 1);
$pageStart = ($page - 1) * $perPage;


// 獲取所有分類
try {
    $categoryStmt = $pdo->query("SELECT id, name FROM categories ORDER BY name ASC");
    $allCategories = $categoryStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "獲取分類時發生錯誤: " . $e->getMessage();
    $allCategories = [];
}
// 獲取所有標籤
try {
    $tagStmt = $pdo->query("SELECT id, name, color FROM tags ORDER BY name ASC");
    $allTags = $tagStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "獲取標籤時發生錯誤: " . $e->getMessage();
    $allTags = [];
}

// 初始化查詢條件和參數
$whereConditions = ["a.is_deleted = 0"];  // 添加軟刪除條件
$params = [];

// 標題搜尋
if (!empty($searchTitle)) {
    $whereConditions[] = "a.title LIKE :titleKeyword";
    $params[':titleKeyword'] = "%{$searchTitle}%";
}

// 分類搜尋
if (!empty($searchCategory)) {
    $whereConditions[] = "EXISTS (
        SELECT 1 FROM article_category ac2
        JOIN categories c2 ON ac2.category_id = c2.id
        WHERE ac2.article_id = a.id
        AND c2.id = :categoryId
    )";
    $params[':categoryId'] = $searchCategory;
}

// 標籤搜尋
if (!empty($searchTag)) {
    $whereConditions[] = "EXISTS (
        SELECT 1 FROM article_tag at2
        JOIN tags t2 ON at2.tag_id = t2.id
        WHERE at2.article_id = a.id
        AND t2.id = :tagId
    )";
    $params[':tagId'] = $searchTag;
}

// 狀態搜尋
if (!empty($searchStatus)) {
    $whereConditions[] = "s.status = :status";
    $params[':status'] = $searchStatus;
}

// 日期篩選
if (!empty($date1) || !empty($date2)) {
    if ($date1 != "" && $date2 != "") {
        $startDateTime = "{$date1} 00:00:00";
        $endDateTime = "{$date2} 23:59:59";
    } elseif ($date1 == "" && $date2 != "") {
        $startDateTime = "{$date2} 00:00:00";
        $endDateTime = "{$date2} 23:59:59";
    } elseif ($date2 == "" && $date1 != "") {
        $startDateTime = "{$date1} 00:00:00";
        $endDateTime = "{$date1} 23:59:59";
    }

    if (isset($startDateTime) && isset($endDateTime)) {
        $whereConditions[] = "a.updated_at BETWEEN :startDateTime AND :endDateTime";
        $params[':startDateTime'] = $startDateTime;
        $params[':endDateTime'] = $endDateTime;
    }
}



// 組合 WHERE 子句
$whereClause = !empty($whereConditions) ? "WHERE " . implode(" AND ", $whereConditions) : "";

// 排序子句
$orderClause = "ORDER BY a.{$sort_column} {$sort_order}";

// 查詢文章列表
$sql = "SELECT a.*, s.status, s.updated_at as status_updated_at,
        GROUP_CONCAT(DISTINCT CONCAT(t.name, ':', t.color) SEPARATOR '|') as tags,
        GROUP_CONCAT(DISTINCT c.name) as category
        FROM articles a
        LEFT JOIN article_statuses s ON a.id = s.article_id
        LEFT JOIN article_tag at ON a.id = at.article_id
        LEFT JOIN tags t ON at.tag_id = t.id
        LEFT JOIN article_category ac ON a.id = ac.article_id
        LEFT JOIN categories c ON ac.category_id = c.id
        $whereClause
        GROUP BY a.id, a.title, a.content, a.cover_image_url, a.created_at, a.updated_at, s.status, s.updated_at
        $orderClause
        LIMIT :limit OFFSET :offset";

// 計算總筆數的查詢
$sqlCount = "SELECT COUNT(DISTINCT a.id) as total
             FROM articles a
             LEFT JOIN article_statuses s ON a.id = s.article_id
             LEFT JOIN article_tag at ON a.id = at.article_id
             LEFT JOIN tags t ON at.tag_id = t.id
             LEFT JOIN article_category ac ON a.id = ac.article_id
             LEFT JOIN categories c ON ac.category_id = c.id
             $whereClause";

try {
    // 執行分頁查詢
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $pageStart, PDO::PARAM_INT);
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 計算總筆數
    $stmtCount = $pdo->prepare($sqlCount);
    foreach ($params as $key => $value) {
        $stmtCount->bindValue($key, $value);
    }
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
            <h3 class="section-title">文章列表</h3>
            <span class="ms-auto">目前共 <?= $totalCount ?> 筆資料
            <?php if (!empty($searchTitle) || !empty($searchCategory) || !empty($searchTag) || !empty($date1) || !empty($date2)): ?>
                (已篩選)
            <?php endif; ?></span>
            <div class="d-flex gap-2">
                <div class="batch-actions" style="display: none;">
                    <button type="button" class="btn btn-danger" id="batchDeleteBtn">
                        <i class="fas fa-trash-alt"></i> 批次刪除
                    </button>
                </div>
                <a href="/article/trash.php" class="btn btn-secondary">回收站</a>
                <a href="/article/form.php" class="btn btn-primary">新增文章</a>
            </div>
        </div>

        <!-- 整合搜尋區域 -->
        <div class="controls-section d-flex align-items-end flex-wrap gap-2">
            <div class="search-box flex-grow-1">
                <input name="titleKeyword" type="text" class="form-control" placeholder="搜尋標題關鍵字" value="<?= htmlspecialchars($_GET['titleKeyword'] ?? '') ?>">
                <i class="fas fa-search"></i>
            </div>
            <div class="filter-group">
                <select name="categoryKeyword">
                    <option value="">全部分類</option>
                    <?php foreach ($allCategories as $category): ?>
                        <option value="<?= $category['id'] ?>" <?= ($searchCategory == $category['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($category['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="filter-group">
                <select name="tagKeyword">
                    <option value="">全部標籤</option>
                    <?php foreach ($allTags as $tag): ?>
                        <option value="<?= $tag['id'] ?>" <?= ($searchTag == $tag['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($tag['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="filter-group">
                <select name="statusKeyword">
                    <option value="">文章狀態</option>
                    <option value="draft" <?= ($searchStatus == 'draft') ? 'selected' : '' ?>>草稿</option>
                    <option value="published" <?= ($searchStatus == 'published') ? 'selected' : '' ?>>已發布</option>
                    <option value="scheduled" <?= ($searchStatus == 'scheduled') ? 'selected' : '' ?>>排程發布</option>
                </select>
            </div>
            <div class="search-box">
                <div class="input-group">
                    <input name="date1" type="date" class="form-control" value="<?= htmlspecialchars($_GET['date1'] ?? '') ?>">
                    <span class="input-group-text">~</span>
                    <input name="date2" type="date" class="form-control" value="<?= htmlspecialchars($_GET['date2'] ?? '') ?>">
                </div>
            </div>
            <button type="button" class="accept-filters" id="articleSearchBtn">搜尋</button>
            <a href="index.php" class="clear-filters">清除篩選</a>
        </div>


        <!-- 文章列表 -->
        <div class="table-container table-responsive">
            <table class="table table-bordered table-striped align-middle ">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 50px;">
                            <input type="checkbox" class="form-check-input" id="selectAll">
                        </th>
                        <th style="width: 350px;">標題</th>
                        <th style="width: 150px;">文章封面</th>
                        <th>分類</th>
                        <th>標籤</th>
                        <th>更新時間
                            <a href="?sort_column=updated_at&sort_order=<?= ($sort_column === 'updated_at' && $sort_order === 'asc') ? 'desc' : 'asc' ?>
                                <?php if (!empty($searchTitle)) echo '&titleKeyword=' . urlencode($searchTitle); ?>
                                <?php if (!empty($searchCategory)) echo '&categoryKeyword=' . urlencode($searchCategory); ?>
                                <?php if (!empty($searchTag)) echo '&tagKeyword=' . urlencode($searchTag); ?>
                                <?php if (!empty($searchStatus)) echo '&statusKeyword=' . urlencode($searchStatus); ?>
                                <?php if (!empty($date1)) echo '&date1=' . urlencode($date1); ?>
                                <?php if (!empty($date2)) echo '&date2=' . urlencode($date2); ?>
                                " style="text-decoration:none; color:inherit;">
                                <?php if ($sort_column === 'updated_at') : ?>
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
                    <?php foreach ($result as $index => $article): ?>
                    <tr>
                        <td>
                            <input type="checkbox" class="form-check-input article-checkbox" value="<?=$article["id"]?>">
                        </td>
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
                        <td><?=$article["updated_at"]?></td>
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
                        <td width="120px">
                            <div class="action-buttons">
                                <a href="/article/form.php?id=<?=$article["id"]?>" class="btn btn-sm btn-warning" title="修改"><i class="fas fa-edit"></i></a>
                                <a href="#" class="btn btn-sm btn-danger delete-btn" data-id="<?=$article["id"]?>" title="刪除"><i class="fas fa-trash-alt"></i></a>
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
                <button class="pagination-btn" onclick="window.location.href='?page=<?= $page-1 ?>&date1=<?= urlencode($date1) ?>&date2=<?= urlencode($date2) ?>&titleKeyword=<?= urlencode($searchTitle) ?>&tagKeyword=<?= urlencode($searchTag) ?>'">
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
                echo '<button class="pagination-btn" onclick="window.location.href=\'?page=1&date1=' . urlencode($date1) . '&date2=' . urlencode($date2) . '&titleKeyword=' . urlencode($searchTitle) . '&tagKeyword=' . urlencode($searchTag) . '\'">1</button>';
                if ($startPage > 2) {
                    echo '<span class="pagination-ellipsis">...</span>';
                }
            }

            for ($i = $startPage; $i <= $endPage; $i++): ?>
                <button class="pagination-btn <?= $i == $page ? 'active' : '' ?>"
                        onclick="window.location.href='?page=<?= $i ?>&date1=<?= urlencode($date1) ?>&date2=<?= urlencode($date2) ?>&titleKeyword=<?= urlencode($searchTitle) ?>&tagKeyword=<?= urlencode($searchTag) ?>'">
                    <?= $i ?>
                </button>
            <?php endfor;

            if ($endPage < $totalPages) {
                if ($endPage < $totalPages - 1) {
                    echo '<span class="pagination-ellipsis">...</span>';
                }
                echo '<button class="pagination-btn" onclick="window.location.href=\'?page=' . $totalPages . '&date1=' . urlencode($date1) . '&date2=' . urlencode($date2) . '&titleKeyword=' . urlencode($searchTitle) . '&tagKeyword=' . urlencode($searchTag) . '\'">' . $totalPages . '</button>';
            }
            ?>

            <?php if ($page < $totalPages): ?>
                <button class="pagination-btn" onclick="window.location.href='?page=<?= $page+1 ?>&date1=<?= urlencode($date1) ?>&date2=<?= urlencode($date2) ?>&titleKeyword=<?= urlencode($searchTitle) ?>&tagKeyword=<?= urlencode($searchTag) ?>'">
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
                    <h5 class="modal-title" id="deleteModalLabel">確認刪除</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>確定要刪除這篇文章嗎？</p>
                    <p class="text-muted mb-0">此操作會將文章移至回收站，您可以稍後在回收站中恢復或永久刪除。</p>
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
                    <p>確定要刪除所選的文章？</p>
                    <p class="text-muted mb-0">此操作會將選中的文章移至回收站，您可以稍後在回收站中恢復或永久刪除。</p>
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
        const articleCheckboxes = document.querySelectorAll('.article-checkbox');
        const batchActions = document.querySelector('.batch-actions');
        const batchDeleteBtn = document.getElementById('batchDeleteBtn');
        const batchDeleteModal = new bootstrap.Modal(document.getElementById('batchDeleteModal'));

        // 更新批次操作按鈕的顯示狀態
        function updateBatchActions() {
            const checkedBoxes = document.querySelectorAll('.article-checkbox:checked');
            batchActions.style.display = checkedBoxes.length > 0 ? 'block' : 'none';
        }

        // 全選/取消全選
        selectAllCheckbox.addEventListener('change', (e) => {
            const isChecked = e.target.checked;
            articleCheckboxes.forEach(checkbox => {
                checkbox.checked = isChecked;
            });
            updateBatchActions();
        });

        // 當個別 checkbox 改變時
        articleCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                const allChecked = Array.from(articleCheckboxes).every(cb => cb.checked);
                selectAllCheckbox.checked = allChecked;
                updateBatchActions();
            });
        });

        // 批次刪除按鈕點擊事件
        batchDeleteBtn.addEventListener('click', () => {
            const checkedBoxes = document.querySelectorAll('.article-checkbox:checked');
            if (checkedBoxes.length > 0) {
                batchDeleteModal.show();
            }
        });

        // 確認批次刪除
        document.getElementById('confirmBatchDelete').addEventListener('click', async () => {
            const checkedBoxes = document.querySelectorAll('.article-checkbox:checked');
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

        // 刪除確認對話框
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        const confirmDeleteBtn = document.getElementById('confirmDelete');

        // 為所有刪除按鈕添加點擊事件
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const articleId = btn.dataset.id;
                confirmDeleteBtn.href = `doDelete.php?id=${articleId}`;
                deleteModal.show();
            });
        });

        // 新增：根據搜尋類型顯示/隱藏日期範圍
        document.querySelectorAll('input[name="searchDate"]').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const dateRange = document.querySelector('.date-range');
                const searchInput = document.querySelector('input[name="titleKeyword"]');
                if (this.checked) {
                    dateRange.style.display = 'flex';
                    searchInput.style.display = 'none';
                } else {
                    dateRange.style.display = 'none';
                    searchInput.style.display = 'block';
                }
            });
        });

        // 初始化時檢查搜尋類型
        var searchDateInput = document.querySelector('input[name="searchDate"]:checked');
        if (searchDateInput && searchDateInput.checked) {
            document.querySelector('.date-range').style.display = 'flex';
            document.querySelector('input[name="titleKeyword"]').style.display = 'none';
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('articleSearchBtn').addEventListener('click', function() {
                const params = new URLSearchParams();
                const title = document.querySelector('input[name="titleKeyword"]').value;
                const category = document.querySelector('select[name="categoryKeyword"]').value;
                const tag = document.querySelector('select[name="tagKeyword"]').value;
                const status = document.querySelector('select[name="statusKeyword"]').value;
                const date1 = document.querySelector('input[name="date1"]').value;
                const date2 = document.querySelector('input[name="date2"]').value;

                if (title) params.append('titleKeyword', title);
                if (category) params.append('categoryKeyword', category);
                if (tag) params.append('tagKeyword', tag);
                if (status) params.append('statusKeyword', status);
                if (date1) params.append('date1', date1);
                if (date2) params.append('date2', date2);

                window.location.href = 'index.php?' + params.toString();
            });
        });
    </script>


<?php
include "../template_btm.php";
?>
