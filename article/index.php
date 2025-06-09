<?php
include "../components/connect.php";
include "../vars.php";

$pageTitle = "文章管理";

$cssList = ["../css/index.css", "../css/article.css"];
include "../template_top.php";
include "../template_main.php";



// 獲取篩選參數
$date1 = $_GET["date1"] ?? "";
$date2 = $_GET["date2"] ?? "";
$searchTitle = $_GET["titleKeyword"] ?? "";
$searchCategory = $_GET["categoryKeyword"] ?? "";
$searchTag = $_GET["tagKeyword"] ?? "";
$searchDate = isset($_GET["searchDate"]) ? true : false;
$page = intval($_GET["page"] ?? 1);
$perPage = 10;
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
$whereConditions = [];
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
        ORDER BY a.created_at DESC
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
        <h1>文章列表</h1>

        <!-- 整合搜尋區域 -->
        <div class="controls-section">
            <form method="GET" class="row g-3">
                <div class="col-12">
                    <div class="search-conditions mb-3">
                        <div class="row g-3">

                            <!-- 標題搜尋 -->
                            <div class="col-md-4">
                                <label class="form-label">標題搜尋</label>
                                <input name="titleKeyword" type="text" class="form-control" placeholder="輸入標題關鍵字" value="<?= htmlspecialchars($_GET['titleKeyword'] ?? '') ?>">
                            </div>


                            <!-- 分類搜尋 -->
                            <div class="col-md-4">
                                <label class="form-label">分類搜尋</label>
                                <select name="categoryKeyword" class="form-select">
                                    <option value="">選擇分類</option>
                                    <?php foreach ($allCategories as $category): ?>
                                        <option value="<?= $category['id'] ?>" <?= ($searchCategory == $category['id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($category['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- 標籤搜尋 -->
                            <div class="col-md-4">
                                <label class="form-label">標籤搜尋</label>
                                <select name="tagKeyword" class="form-select">
                                    <option value="">選擇標籤</option>
                                    <?php foreach ($allTags as $tag): ?>
                                        <option value="<?= $tag['id'] ?>" <?= ($searchTag == $tag['id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($tag['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- 日期搜尋 -->
                            <div class="col-md-4">
                                <label class="form-label">更新時間搜尋</label>
                                <div class="input-group">
                                    <input name="date1" type="date" class="form-control" value="<?= htmlspecialchars($_GET['date1'] ?? '') ?>">
                                    <span class="input-group-text">~</span>
                                    <input name="date2" type="date" class="form-control" value="<?= htmlspecialchars($_GET['date2'] ?? '') ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">搜尋</button>
                        <a href="index.php" class="btn btn-secondary">重置篩選條件</a>
                    </div>
                </div>
            </form>
        </div>

        <div class="d-flex">
            <a href="/article/form.php" class="btn btn-primary btn-sm ms-auto">新增文章</a>
        </div>

        <!-- 顯示總筆數 -->
        <div class="total-count">
            目前共 <?= $totalCount ?> 筆資料
            <?php if (!empty($searchTitle) || !empty($searchCategory) || !empty($searchTag) || !empty($date1) || !empty($date2)): ?>
                (已篩選)
            <?php endif; ?>
        </div>

        <!-- 文章列表 -->
        <div class="table-container table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 50px;">
                            <input type="checkbox" class="form-check-input" id="selectAll">
                        </th>
                        <th>標題</th>
                        <th>文章封面</th>
                        <th>分類</th>
                        <th>標籤</th>
                        <th>建立時間</th>
                        <th>更新時間</th>
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
                        <td><?=$article["title"]?></td>
                        <td>
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
                                    <span class="tag-badge" style="background-color: <?= htmlspecialchars($tagColor) ?>">
                                        <?= htmlspecialchars($tagName) ?>
                                    </span>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <span class="text-muted">無標籤</span>
                            <?php endif; ?>
                        </td>
                        <td><?=$article["created_at"]?></td>
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
                        <td>
                            <div class="action-buttons">
                                <a href="#" class="btn btn-danger btn-sm delete-btn" data-id="<?=$article["id"]?>">刪除</a>
                                <a href="/article/form.php?id=<?=$article["id"]?>" class="btn btn-primary btn-sm">修改</a>
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
                    確定要刪除這篇文章嗎？此操作無法復原。
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                    <a href="#" class="btn btn-danger" id="confirmDelete">確定刪除</a>
                </div>
            </div>
        </div>
    </div>

    <!-- 添加標籤選擇器的樣式 -->
    <style>
    .form-select option {
        padding: 8px;
        margin: 2px 0;
    }

    .form-select option:checked {
        background-color: var(--warm-brass);
        color: white;
    }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // 全選功能
        const selectAllCheckbox = document.getElementById('selectAll');
        const articleCheckboxes = document.querySelectorAll('.article-checkbox');

        // 全選/取消全選
        selectAllCheckbox.addEventListener('change', (e) => {
            const isChecked = e.target.checked;
            articleCheckboxes.forEach(checkbox => {
                checkbox.checked = isChecked;
            });
        });

        // 當所有文章都被選中時，自動勾選全選框
        articleCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                const allChecked = Array.from(articleCheckboxes).every(cb => cb.checked);
                selectAllCheckbox.checked = allChecked;
            });
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
        const currentSearchDate = document.querySelector('input[name="searchDate"]:checked').checked;
        if (currentSearchDate) {
            document.querySelector('.date-range').style.display = 'flex';
            document.querySelector('input[name="titleKeyword"]').style.display = 'none';
        }
    </script>


<?php
include "../template_btm.php";
?>
