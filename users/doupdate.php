<?php
// 引入必要的檔案
require_once "./connect.php";
require_once "../components/Utilities.php";

// 檢查是否為 POST 請求
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

// 獲取並驗證基本資料
$id = 0;
if (isset($_POST['id'])) {
    $id = (int)$_POST['id'];
}

$name = '';
if (isset($_POST['name'])) {
    $name = trim($_POST['name']);
}

$email = '';
if (isset($_POST['email'])) {
    $email = trim($_POST['email']);
}

$phone = '';
if (isset($_POST['phone'])) {
    $phone = trim($_POST['phone']);
}

$birthday = '';
if (isset($_POST['birthday'])) {
    $birthday = trim($_POST['birthday']);
}

$gender = '';
if (isset($_POST['gender'])) {
    $gender = trim($_POST['gender']);
}

$level = '';
if (isset($_POST['level'])) {
    $level = trim($_POST['level']);
}

$account = '';
if (isset($_POST['account'])) {
    $account = trim($_POST['account']);
}

$password = '';
if (isset($_POST['password'])) {
    $password = trim($_POST['password']);
}

$confirm_password = '';
if (isset($_POST['confirm_password'])) {
    $confirm_password = trim($_POST['confirm_password']);
}

// 驗證必填欄位
$error_messages = array();

if (empty($name)) {
    $error_messages[] = "會員姓名為必填欄位";
}

if (empty($email)) {
    $error_messages[] = "Email為必填欄位";
}

if (empty($level)) {
    $error_messages[] = "會員等級為必填欄位";
}

if (empty($account)) {
    $error_messages[] = "帳號為必填欄位";
}

// 驗證 Email 格式
if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error_messages[] = "Email格式不正確";
}

// 驗證帳號格式
if (!empty($account) && !filter_var($account, FILTER_VALIDATE_EMAIL)) {
    $error_messages[] = "帳號格式不正確";
}

// 驗證密碼
if (!empty($password)) {
    if (strlen($password) < 6) {
        $error_messages[] = "密碼長度至少需要6個字元";
    }
    if ($password !== $confirm_password) {
        $error_messages[] = "兩次輸入的密碼不一致，請重新輸入";
    }
} else if (!empty($confirm_password)) {
    // 如果只填了確認密碼但沒填密碼
    $error_messages[] = "請輸入密碼";
}

// 如果有錯誤訊息，導回編輯頁面並顯示錯誤
if (!empty($error_messages)) {
    $_SESSION['error'] = implode("<br>", $error_messages);
    echo "<script>
        alert('" . implode("\\n", $error_messages) . "');
        window.location.href = 'update.php?id=" . $id . "';
    </script>";
    exit;
}

try {
    $pdo->beginTransaction();

    // 處理頭像上傳
    $avatar = '';
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $allowedTypes = array('image/jpeg', 'image/png', 'image/gif');
        $maxSize = 2 * 1024 * 1024; // 2MB

        if (!in_array($_FILES['avatar']['type'], $allowedTypes)) {
            throw new Exception("只允許上傳 JPG、PNG、GIF 格式的圖片");
        }

        if ($_FILES['avatar']['size'] > $maxSize) {
            throw new Exception("圖片大小不能超過 2MB");
        }

        $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
        $avatar = uniqid() . '.' . $extension;
        $uploadPath = './uploads/' . $avatar;

        if (!move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadPath)) {
            throw new Exception("圖片上傳失敗");
        }

        // 檢查是否已有頭像記錄
        $checkImgSql = "SELECT id FROM user_img WHERE user_id = ?";
        $checkImgStmt = $pdo->prepare($checkImgSql);
        $checkImgStmt->execute(array($id));
        $existingImg = $checkImgStmt->fetch(PDO::FETCH_ASSOC);

        if ($existingImg) {
            // 更新現有記錄
            $imgSql = "UPDATE user_img SET 
                      img_path = ?, 
                      img_name = ?, 
                      file_size = ?, 
                      file_type = ?,
                      updated_at = CURRENT_TIMESTAMP
                      WHERE user_id = ?";
            $imgStmt = $pdo->prepare($imgSql);
            $imgStmt->execute(array(
                $uploadPath,
                $_FILES['avatar']['name'],
                $_FILES['avatar']['size'],
                $_FILES['avatar']['type'],
                $id
            ));
        } else {
            // 新增記錄
            $imgSql = "INSERT INTO user_img (user_id, img_path, img_name, file_size, file_type) 
                      VALUES (?, ?, ?, ?, ?)";
            $imgStmt = $pdo->prepare($imgSql);
            $imgStmt->execute(array(
                $id,
                $uploadPath,
                $_FILES['avatar']['name'],
                $_FILES['avatar']['size'],
                $_FILES['avatar']['type']
            ));
        }
    }

    // 更新用戶基本資料
    $updateFields = array();
    $params = array();

    $updateFields[] = "name = ?";
    $params[] = $name;

    $updateFields[] = "email = ?";
    $params[] = $email;

    $updateFields[] = "phone = ?";
    $params[] = $phone;

    $updateFields[] = "birthday = ?";
    $params[] = $birthday;

    $updateFields[] = "gender = ?";
    $params[] = $gender;

    $updateFields[] = "level = ?";
    $params[] = $level;

    $updateFields[] = "account = ?";
    $params[] = $account;

    // 如果有修改密碼，加入更新
    if (!empty($password)) {
        $updateFields[] = "password = ?";
        $params[] = password_hash($password, PASSWORD_DEFAULT);
    }

    // 組合 SQL 語句
    $sql = "UPDATE users SET " . implode(", ", $updateFields) . " WHERE id = ?";
    $params[] = $id;

    // 執行更新
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    // 處理地址資料
    // 先刪除舊的地址資料
    $deleteAddressSql = "DELETE FROM user_addresses WHERE user_id = ?";
    $stmt = $pdo->prepare($deleteAddressSql);
    $stmt->execute(array($id));

    // 插入新的地址資料
    if (isset($_POST['city']) && is_array($_POST['city'])) {
        $insertAddressSql = "INSERT INTO user_addresses (user_id, city, district, address, is_default) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($insertAddressSql);
        
        foreach ($_POST['city'] as $index => $cityId) {
            // 獲取縣市名稱
            $cityStmt = $pdo->prepare("SELECT name FROM cities WHERE id = ?");
            $cityStmt->execute(array($cityId));
            $city = $cityStmt->fetchColumn();
            
            if (!$city) {
                throw new Exception("無效的縣市ID");
            }

            $district = $_POST['district'][$index];
            $address = $_POST['address'][$index];
            $is_default = (isset($_POST['default_address']) && $_POST['default_address'] == $index) ? 1 : 0;
            
            $addressParams = array($id, $city, $district, $address, $is_default);
            $stmt->execute($addressParams);
        }
    }

    // 提交交易
    $pdo->commit();
    
    // 設定成功訊息並停留在編輯頁面
    $_SESSION['success'] = "會員資料更新成功";
    echo "<script>
        alert('會員資料更新成功！');
        window.location.href = 'update.php?id=" . $id . "';
    </script>";
    exit;

} catch (Exception $e) {
    // 發生錯誤時回滾交易
    $pdo->rollBack();
    
    // 設定錯誤訊息並導回編輯頁面
    $_SESSION['error'] = "更新失敗：" . $e->getMessage();
    header("Location: update.php?id=" . $id);
    exit;
}
?> 