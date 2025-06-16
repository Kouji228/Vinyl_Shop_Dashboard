<?php
require_once "./components/connect.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['account'])) {
    $account = trim($_POST['account']);
    
    try {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE account = ?");
        $stmt->execute([$account]);
        
        echo json_encode([
            'exists' => $stmt->rowCount() > 0
        ]);
    } catch (PDOException $e) {
        echo json_encode([
            'error' => '系統錯誤，請稍後再試'
        ]);
    }
} else {
    echo json_encode([
        'error' => '無效的請求'
    ]);
}
?>