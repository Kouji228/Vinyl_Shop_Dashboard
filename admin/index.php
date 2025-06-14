<?php
require_once "../components/connect.php";
require_once "../components/Utilities.php";

$pageTitle = "管理員帳號設定";
$cssList = ["../css/index.css"];
include "../vars.php";
include "../template_top.php";
include "../template_main.php";

$sql = "SELECT * FROM admins ORDER BY id DESC";
$stmt = $pdo->query($sql);
$admins = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<div class="content-section">
    <div class="section-header d-flex justify-content-between align-items-center">
        <h3 class="section-title">管理員列表</h3>
        <a href="add.php" class="btn btn-primary">新增管理員</a>
    </div>

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>編號</th>
                <th>名稱</th>
                <th>帳號</th>
                <th>建立時間</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($admins as $admin): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($admin['name']) ?></td>
                    <td><?= htmlspecialchars($admin['account']) ?></td>
                    <td><?= $admin['created_at'] ?></td>
                    <td>
                        <a href="update.php?id=<?= $admin['id'] ?>" class="btn btn-sm btn-warning">編輯</a>
                        <a href="doDelete.php?id=<?= $admin['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('確定要刪除嗎？');">刪除</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>

</html>