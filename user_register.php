<!-- 使用者註冊頁面 -->
<?php
require_once "./components/connect.php";
require_once "./components/Utilities.php";

// 如果已經登入，重定向到首頁
if (isset($_SESSION['user_id'])) {
    header("Location: ./index.php");
    exit;
}

$error = '';
$success = '';

// 處理註冊表單提交
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $account = $_POST['account'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $phone = $_POST['phone'] ?? '';

    // 驗證輸入
    if (empty($name) || empty($account) || empty($password) || empty($confirm_password) || empty($phone)) {
        $error = '所有欄位都必須填寫';
    } elseif ($password !== $confirm_password) {
        $error = '密碼不一致';
    } elseif (strlen($password) < 8) {
        $error = '密碼長度必須至少6個字符';
    } else {
        try {
            // 檢查郵箱是否已存在
            $stmt = $pdo->prepare("SELECT id FROM users WHERE account = ?");
            $stmt->execute([$account]);
            if ($stmt->rowCount() > 0) {
                $error = '該帳號已被註冊';
            } else {
                // 創建新用戶
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO users (name, account, password, phone, status, created_at) VALUES (?, ?, ?, ?, 'active', NOW())");
                if ($stmt->execute([$name, $account, $hashed_password, $phone])) {
                    $success = '註冊成功！請登入';
                    header("refresh:2;url=user_login.php");
                } else {
                    $error = '註冊失敗，請稍後再試';
                }
            }
        } catch (PDOException $e) {
            $error = '系統錯誤，請稍後再試';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>使用者註冊</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="../css/users_login.css" rel="stylesheet">

</head>

<body>
    <div class="signup-wrapper">
        <div class="signup-box">
            <div class="signup-form">
                <h2 class="mb-4">註冊新帳號</h2>
                <?php if (isset($_SESSION['register_error'])): ?>
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <?= htmlspecialchars($_SESSION['register_error']) ?>
                    </div>
                    <?php unset($_SESSION['register_error']); ?>
                <?php endif; ?>
                <?php if ($error): ?>
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>
                <?php if ($success): ?>
                    <div class="success-message">
                        <i class="fas fa-check-circle me-2"></i>
                        <?= htmlspecialchars($success) ?>
                    </div>
                <?php endif; ?>
                <form method="POST" action="douserregister.php">
                    <div class="mb-3">
                        <input type="text" class="form-control" name="name" placeholder="姓名" required>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" name="account" id="account" placeholder="帳號(請輸入email格式)"
                            required>
                        <div id="account-feedback" class="form-text"></div>
                    </div>
                    <div class="position-relative password-field-container">
                        <input type="password" class="form-control" name="password" placeholder="密碼(至少6個字元)" required>
                        <button type="button" class="password-toggle">
                            <i class="fas fa-eye-slash"></i>
                        </button>
                    </div>
                    <div class="position-relative password-field-container">
                        <input type="password" class="form-control" name="confirm_password" placeholder="確認密碼" required>
                        <button type="button" class="password-toggle">
                            <i class="fas fa-eye-slash"></i>
                        </button>
                    </div>
                    <div class="mb-3">
                        <input type="tel" class="form-control" name="phone" placeholder="電話" required>
                    </div>
                    <button type="submit" class="btn btn-signup">
                        <i class="fas fa-user-plus me-2"></i>註冊
                    </button>
                    <div class="text-center mt-3">
                        <a href="user_login.php" class="text-muted">
                            已有帳號？點此登入
                        </a>
                    </div>
                </form>
            </div>
            <div class="register-image"></div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // 密碼切換按鈕
        document.querySelectorAll('.password-toggle').forEach(function (button) {
            button.addEventListener('click', function () {
                const input = this.parentElement.querySelector('input');
                const icon = this.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                }
            });
        });

        // 檢查帳號是否已被註冊
        const accountInput = document.getElementById('account');
        const accountFeedback = document.getElementById('account-feedback');
        let checkTimeout;

        accountInput.addEventListener('input', function () {
            clearTimeout(checkTimeout);
            const account = this.value.trim();

            if (account === '') {
                accountFeedback.textContent = '';
                accountFeedback.className = 'form-text';
                return;
            }

            // 檢查是否為有效的email格式
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(account)) {
                accountFeedback.textContent = '請輸入有效的電子郵件格式';
                accountFeedback.className = 'form-text text-danger';
                return;
            }

            // 延遲500毫秒後再發送請求，避免頻繁請求
            checkTimeout = setTimeout(() => {
                fetch('check_account.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'account=' + encodeURIComponent(account)
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.exists) {
                            accountFeedback.textContent = '此帳號已被註冊';
                            accountFeedback.className = 'form-text text-danger';
                        } else {
                            accountFeedback.textContent = '此帳號可以使用';
                            accountFeedback.className = 'form-text text-success';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        accountFeedback.textContent = '檢查帳號時發生錯誤';
                        accountFeedback.className = 'form-text text-danger';
                    });
            }, 500);
        });
    </script>
</body>

</html>