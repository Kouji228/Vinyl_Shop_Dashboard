<?php
// 引入必要的檔案
require_once "./components/connect.php";
require_once "./components/Utilities.php";

// 引入頁面模板和樣式
include "vars.php";
$cssList = ["css/index.css"];
include "template_top.php";
include "template_main.php";

// 獲取會員總數統計
$sqlMembers = "SELECT COUNT(*) as total FROM `users` WHERE `is_valid` = 1";
$stmtMembers = $pdo->prepare($sqlMembers);
$stmtMembers->execute();
$totalMembers = $stmtMembers->fetch(PDO::FETCH_ASSOC)['total'];

// 獲取商品總數統計
$sqlProducts = "SELECT COUNT(*) as total FROM `vinyl` WHERE `status_id` = 1";
$stmtProducts = $pdo->prepare($sqlProducts);
$stmtProducts->execute();
$totalProducts = $stmtProducts->fetch(PDO::FETCH_ASSOC)['total'];

// 獲取二手商品總數統計
$sqlSecondHand = "SELECT COUNT(*) as total FROM `o_vinyl` WHERE `is_valid` = 1";
$stmtSecondHand = $pdo->prepare($sqlSecondHand);
$stmtSecondHand->execute();
$totalSecondHand = $stmtSecondHand->fetch(PDO::FETCH_ASSOC)['total'];

// 獲取會員性別比例統計
$sqlGender = "SELECT 
    CASE 
        WHEN gender = '男' THEN '男'
        WHEN gender = '女' THEN '女'
    END as gender,
    COUNT(*) as count 
    FROM `users` 
    WHERE `is_valid` = 1 
    AND gender IN ('男', '女')
    GROUP BY gender";
$stmtGender = $pdo->prepare($sqlGender);
$stmtGender->execute();
$genderStats = $stmtGender->fetchAll(PDO::FETCH_ASSOC);

// 獲取商品分類統計
$sqlCategories = "SELECT g.genre as name, COUNT(v.id) as count 
                 FROM vinyl_genre g 
                 LEFT JOIN vinyl v ON g.id = v.genre_id 
                 WHERE v.status_id = 1 
                 GROUP BY g.id, g.genre";
$stmtCategories = $pdo->prepare($sqlCategories);
$stmtCategories->execute();
$categoryStats = $stmtCategories->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- 主要內容容器 -->
<div class="container-fluid py-4">
    <!-- 統計卡片區域 -->
    <div class="row mb-4">
        <!-- 總用戶數卡片 -->
        <div class="col-md-4">
            <a href="users/index.php" class="text-decoration-none">
                <div class="card stat-card h-100">
                    <div class="card-body d-flex align-items-center">
                        <i class="fas fa-users fa-2x me-3"></i>
                        <div>
                            <h5 class="card-title mb-0">總用戶數</h5>
                            <p class="stat-number mb-0"><?= $totalMembers ?></p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <!-- 商品總數卡片 -->
        <div class="col-md-4">
            <a href="product/index.php" class="text-decoration-none">
                <div class="card stat-card h-100">
                    <div class="card-body d-flex align-items-center">
                        <i class="fas fa-compact-disc fa-2x me-3"></i>
                        <div>
                            <h5 class="card-title mb-0">商品總數</h5>
                            <p class="stat-number mb-0"><?= $totalProducts ?></p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <!-- 二手商品數卡片 -->
        <div class="col-md-4">
            <a href="Old_Vinyl/index.php" class="text-decoration-none">
                <div class="card stat-card h-100">
                    <div class="card-body d-flex align-items-center">
                        <i class="fas fa-repeat fa-2x me-3"></i>
                        <div>
                            <h5 class="card-title mb-0">二手商品數</h5>
                            <p class="stat-number mb-0"><?= $totalSecondHand ?></p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- 圖表區域 -->
    <div class="row">
        <!-- 會員性別比例圖表 -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">會員性別比例</h5>
                </div>
                <div class="card-body">
                    <canvas id="genderChart"></canvas>
                </div>
            </div>
        </div>

        <!-- 商品分類分析圖表 -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">商品種類分析</h5>
                </div>
                <div class="card-body">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- 引入 Chart.js 圖表庫 -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
<script>
    // 註冊 datalabels 插件
    Chart.register(ChartDataLabels);
    
    // 會員性別比例圖表配置
    const genderCtx = document.getElementById('genderChart').getContext('2d');
    new Chart(genderCtx, {
        type: 'pie', // 設定圖表類型為圓餅圖
        data: {
            labels: <?= json_encode(array_column($genderStats, 'gender')) ?>, // 設定標籤
            datasets: [{
                data: <?= json_encode(array_column($genderStats, 'count')) ?>, // 設定數據
                backgroundColor: [
                    'rgba(184, 142, 60, 0.8)',   // 深金色 - 男性
                    'rgba(234, 190, 120, 0.8)'   // 淺金色 - 女性
                ],
                borderColor: [
                    'rgba(184, 142, 60, 1)',
                    'rgba(234, 190, 120, 1)'
                ],
                borderWidth: 1 // 設定邊框寬度
            }]
        },
        options: {
            responsive: true, // 設定為響應式
            maintainAspectRatio: false, // 不保持寬高比
            plugins: {
                legend: {
                    position: 'bottom' // 圖例位置設在底部
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            // 自定義提示框內容
                            const label = context.label || '';
                            const value = context.raw || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return `${label}: ${value}人 (${percentage}%)`;
                        }
                    }
                },
                datalabels: {
                    color: '#fff',
                    font: {
                        weight: 'bold',
                        size: 14
                    },
                    formatter: function(value) {
                        return value + '人';
                    }
                }
            }
        }
    });

    // 商品分類分析圖表配置
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    new Chart(categoryCtx, {
        type: 'bar', // 設定圖表類型為長條圖
        data: {
            labels: <?= json_encode(array_column($categoryStats, 'name')) ?>, // 設定標籤
            datasets: [{
                label: '商品數量', // 設定數據集標籤
                data: <?= json_encode(array_column($categoryStats, 'count')) ?>, // 設定數據
                backgroundColor: 'rgba(209, 166, 90, 0.8)', // 設定背景顏色
                borderColor: 'rgba(209, 166, 90, 1)', // 設定邊框顏色
                borderWidth: 1 // 設定邊框寬度
            }]
        },
        options: {
            responsive: true, // 設定為響應式
            maintainAspectRatio: false, // 不保持寬高比
            plugins: {
                legend: {
                    display: false // 隱藏圖例
                },
                datalabels: {
                    display: false // 完全禁用數據標籤
                }
            },
            scales: {
                y: {
                    beginAtZero: true, // Y軸從0開始
                    ticks: {
                        stepSize: 1 // 設定刻度間距
                    }
                }
            }
        }
    });
</script>

<?php
// 引入頁面底部模板
include "template_btm.php";
?>