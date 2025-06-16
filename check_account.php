<?php
require_once "./components/connect.php";
require_once "./components/Utilities.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $account = $_POST['account'] ?? '';

    if (empty($account)) {
        echo json_encode(['exists' => false]);
        exit;
    }

    try {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE account = ?");
        $stmt->execute([$account]);
        echo json_encode(['exists' => $stmt->rowCount() > 0]);
    } catch (PDOException $e) {
        echo json_encode(['error' => '系統錯誤']);
    }
} else {
    echo json_encode(['error' => '無效的請求方法']);
}
?>