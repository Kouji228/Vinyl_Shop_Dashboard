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
    $birthday = $_POST['birthday'] ?? '';
    $gender = $_POST['gender'] ?? '';

    // 驗證輸入
    if (empty($name) || empty($account) || empty($password) || empty($confirm_password) || empty($phone) || empty($birthday) || empty($gender)) {
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
    <title>Echo&Flow商店-註冊頁面</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../css/register.css">
</head>

<body>
    <div class="auth-container">
        <div class="logo-container">
            <img src="./images/eflogo.png" alt="黑膠唱片行" class="logo">
        </div>
        <div class="auth-image"></div>
        <div class="auth-form">
            <div class="form-container">
                <h2 class="form-title">註冊帳號</h2>
                <?php if (isset($_SESSION['register_error'])): ?>
                    <div class="alert alert-danger">
                        <?php
                        echo $_SESSION['register_error'];
                        unset($_SESSION['register_error']);
                        ?>
                    </div>
                <?php endif; ?>
                <form method="POST" action="douserregister.php">
                    <div class="mb-3">
                        <input type="text" class="form-control" name="name" placeholder="姓名" required>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" name="account" id="account" placeholder="帳號(請輸入email格式)" required>
                        <div id="account-feedback" class="form-text"></div>
                    </div>
                    <div class="position-relative password-field-container">
                        <input type="password" class="form-control" name="password" id="password" placeholder="密碼(至少6個字元)" required>
                        <button type="button" class="password-toggle">
                            <i class="fas fa-eye-slash"></i>
                        </button>
                        <div id="password-feedback" class="form-text"></div>
                    </div>
                    <div class="position-relative password-field-container">
                        <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="確認密碼" required>
                        <button type="button" class="password-toggle">
                            <i class="fas fa-eye-slash"></i>
                        </button>
                        <div id="confirm-password-feedback" class="form-text"></div>
                    </div>
                    <div class="form-group">
                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="手機號碼" required>
                    </div>
                    <div class="form-group">
                        <label for="birthday">生日</label>
                        <input type="date" class="form-control" id="birthday" name="birthday" required>
                    </div>
                    <div class="form-group">
                        <label for="gender">性別</label>
                        <select class="form-control" id="gender" name="gender" required>
                            <option value="">請選擇性別</option>
                            <option value="男">男</option>
                            <option value="女">女</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-signup">
                        註冊
                    </button>
                    <div class="form-footer">
                        <a href="user_login.php">
                            已有帳號？立即登入
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // 密碼顯示切換
        document.querySelectorAll('.password-toggle').forEach(button => {
            button.addEventListener('click', function() {
                const input = this.previousElementSibling;
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

        // 帳號格式驗證和檢查是否已註冊
        const accountInput = document.getElementById('account');
        const accountFeedback = document.getElementById('account-feedback');

        accountInput.addEventListener('input', function() {
            const email = this.value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (email && !emailRegex.test(email)) {
                accountFeedback.textContent = '請輸入有效的電子郵件地址';
                accountFeedback.style.color = '#ff4747';
                this.classList.add('is-invalid');
            } else if (email) {
                // 檢查帳號是否已被註冊
                fetch('check_account.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'account=' + encodeURIComponent(email)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        accountFeedback.textContent = '該帳號已被註冊';
                        accountFeedback.style.color = '#ff4747';
                        this.classList.add('is-invalid');
                    } else {
                        accountFeedback.textContent = '帳號可用';
                        accountFeedback.style.color = '#28a745';
                        this.classList.remove('is-invalid');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            } else {
                accountFeedback.textContent = '';
                this.classList.remove('is-invalid');
            }
        });

        // 密碼長度驗證
        const passwordInput = document.getElementById('password');
        const passwordFeedback = document.getElementById('password-feedback');

        passwordInput.addEventListener('input', function() {
            const password = this.value;
            
            if (password && password.length < 6) {
                passwordFeedback.textContent = '密碼長度必須至少6個字符';
                passwordFeedback.style.color = '#ff4747';
                this.classList.add('is-invalid');
            } else if (password) {
                passwordFeedback.textContent = '密碼長度符合要求';
                passwordFeedback.style.color = '#28a745';
                this.classList.remove('is-invalid');
            } else {
                passwordFeedback.textContent = '';
                this.classList.remove('is-invalid');
            }

            // 如果確認密碼欄位有值，也要檢查是否匹配
            const confirmPassword = document.getElementById('confirm_password').value;
            if (confirmPassword) {
                checkPasswordMatch(password, confirmPassword);
            }
        });

        // 確認密碼驗證
        const confirmPasswordInput = document.getElementById('confirm_password');
        const confirmPasswordFeedback = document.getElementById('confirm-password-feedback');

        function checkPasswordMatch(password, confirmPassword) {
            if (confirmPassword && password !== confirmPassword) {
                confirmPasswordFeedback.textContent = '密碼不一致';
                confirmPasswordFeedback.style.color = '#ff4747';
                confirmPasswordInput.classList.add('is-invalid');
            } else if (confirmPassword) {
                confirmPasswordFeedback.textContent = '密碼一致';
                confirmPasswordFeedback.style.color = '#28a745';
                confirmPasswordInput.classList.remove('is-invalid');
            } else {
                confirmPasswordFeedback.textContent = '';
                confirmPasswordInput.classList.remove('is-invalid');
            }
        }

        confirmPasswordInput.addEventListener('input', function() {
            const password = passwordInput.value;
            const confirmPassword = this.value;
            checkPasswordMatch(password, confirmPassword);
        });
    </script>
</body>

</html>