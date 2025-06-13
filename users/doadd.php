<?php
// 引入必要的檔案
require_once "../components/connect.php";
require_once "../components/Utilities.php";

// 驗證請求方法是否為 POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    alertGoTo("請從正常管道進入", "users/index.php");
    exit;
}

// 定義必填欄位
$requiredFields = ['email', 'password', 'name', 'account', 'level'];
foreach ($requiredFields as $field) {
    if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
        alertAndBack("請填寫所有必填欄位");
        exit;
    }
}

// 清理並驗證輸入資料
// 使用 filter_var是將輸入的資料進行清理和驗證
// FILTER_SANITIZE_EMAIL 的作用是清理輸入的資料，去除 HTML 標籤和特殊字元
//trim() 的作用是去除輸入資料前後的空白字元
$email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);  // 清理並驗證 email
$account = filter_var(trim($_POST['account']), FILTER_SANITIZE_EMAIL);  // 清理並驗證帳號
$name = trim($_POST['name']);  // 清理姓名
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : null;  // 清理電話（選填）
$birthday = isset($_POST['birthday']) ? trim($_POST['birthday']) : null;  // 清理生日（選填）
$gender = isset($_POST['gender']) ? trim($_POST['gender']) : null;  // 清理性別（選填）
$level = trim($_POST['level']);  // 清理會員等級

// 驗證 email 格式
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {  // 使用 FILTER_VALIDATE_EMAIL 驗證 email 格式是否正確
    alertAndBack("請輸入有效的信箱");
    exit;
}

// 驗證帳號格式
if (!filter_var($account, FILTER_VALIDATE_EMAIL)) {  // 使用 FILTER_VALIDATE_EMAIL 驗證帳號格式是否正確
    alertAndBack("請輸入有效的帳號");
    exit;
}

// 驗證密碼長度
$password = trim($_POST['password']);
if (strlen($password) < 6 || strlen($password) > 20) {
    alertAndBack("密碼長度必須在6-20個字元之間");
    exit;
}

// 驗證密碼和確認密碼是否相同
$confirmPassword = trim($_POST['confirm_password']);
if ($password !== $confirmPassword) {
    alertAndBack("密碼和確認密碼必須相同");
    exit;
}

// 密碼加密
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

// 處理頭像上傳
$avatarFileName = null;
if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
    // 設定允許的檔案類型
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $maxFileSize = 2 * 1024 * 1024; // 2MB

    // 驗證檔案類型
    if (!in_array($_FILES['avatar']['type'], $allowedTypes)) {
        alertAndBack("只允許上傳 JPG、PNG、GIF 格式的圖片");
        exit;
    }

    // 驗證檔案大小
    if ($_FILES['avatar']['size'] > $maxFileSize) {
        alertAndBack("圖片大小不能超過 2MB");
        exit;
    }

    // 產生新的檔案名稱
    $timestamp = time();
    $ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
    $newFileName = "{$timestamp}.{$ext}";
    $uploadDir = "./uploads/";
    
    // 如果上傳目錄不存在，則建立
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // 移動上傳的檔案到指定目錄
    $file = $uploadDir . $newFileName;
    if (move_uploaded_file($_FILES['avatar']['tmp_name'], $file)) {
        $avatarFileName = $newFileName;
    }
}

// 檢查 email 和帳號是否已被使用
try {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ? OR account = ?");
    $stmt->execute([$email, $account]);
    if ($stmt->fetchColumn() > 0) {
        alertAndBack("此信箱或帳號已被使用");
        exit;
    }
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    alertAndBack("系統錯誤，請稍後再試");
    exit;
}

// 新增會員資料
try {
    // 插入基本會員資料
    $sql = "INSERT INTO users (account, name, email, password, phone, birthday, gender, level) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $account,
        $name,
        $email,
        $hashedPassword,
        $phone,
        $birthday,
        $gender,
        $level
    ]);

    // 取得新插入的會員 ID
    $userId = $pdo->lastInsertId();

    // 如果有上傳頭像，則新增頭像資料
    if ($avatarFileName) {
        $imgSql = "INSERT INTO user_img (user_id, img_path, img_name, file_size, file_type) 
                   VALUES (?, ?, ?, ?, ?)";
        $imgStmt = $pdo->prepare($imgSql);
        $imgStmt->execute([
            $userId,
            $uploadDir . $avatarFileName,
            $_FILES['avatar']['name'],
            $_FILES['avatar']['size'],
            $_FILES['avatar']['type']
        ]);
    }

    // 處理地址資料
    if (isset($_POST['city']) && is_array($_POST['city'])) {
        $addressSql = "INSERT INTO user_addresses (user_id, city, district, address, is_default) 
                      VALUES (?, ?, ?, ?, ?)";
        $addressStmt = $pdo->prepare($addressSql);

        foreach ($_POST['city'] as $index => $cityId) {
            if (!empty($cityId) && !empty($_POST['district'][$index]) && !empty($_POST['address'][$index])) {
                // 查詢縣市名稱
                $cityStmt = $pdo->prepare("SELECT name FROM cities WHERE id = ?");
                $cityStmt->execute([$cityId]);
                $cityName = $cityStmt->fetchColumn();

                // 查詢區域名稱
                $districtStmt = $pdo->prepare("SELECT name FROM districts WHERE id = ?");
                $districtStmt->execute([$_POST['district'][$index]]);
                $districtName = $districtStmt->fetchColumn();

                // 設定是否為預設地址
                $isDefault = isset($_POST['default_address']) && $_POST['default_address'] == $index ? 1 : 0;
                
                // 插入地址資料
                $addressStmt->execute([
                    $userId,
                    $cityName,
                    $districtName,
                    $_POST['address'][$index],
                    $isDefault
                ]);
            }
        }
    }

    // 新增成功，導向會員列表頁面
    alertGoTo("新增會員成功", "./index.php");
} catch (PDOException $e) {
    // 記錄錯誤並顯示錯誤訊息
    error_log("Database error: " . $e->getMessage());
    alertAndBack("系統錯誤，請稍後再試");
    exit;
}
?>