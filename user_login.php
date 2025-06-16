<?php
require_once "./components/connect.php";
require_once "./components/Utilities.php";

// 如果已經登入，重定向到首頁
if (isset($_SESSION['user_id'])) {
    header("Location: ./index.php");
    exit;
}

$error = '';

// 處理登入表單提交
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $account = $_POST['account'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($account) || empty($password)) {
        $error = '請輸入帳號和密碼';
    } else {
        try {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE account = ? AND status = 'active'");
            $stmt->execute([$account]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                // 登入成功
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                header("Location: ../index.php");
                exit;
            } else {
                $error = '電子郵件或密碼錯誤';
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
    <title>使用者登入</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="../css/users_login.css" rel="stylesheet">

</head>

<body>
    <div class="signup-wrapper">
        <div class="signup-box">
            <div class="signup-form">
                <h2>使用者登入</h2>
                <p>歡迎回來，請登入您的帳號</p>
                <?php if (isset($_SESSION['login_error'])): ?>
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <?= htmlspecialchars($_SESSION['login_error']) ?>
                    </div>
                    <?php unset($_SESSION['login_error']); ?>
                <?php endif; ?>
                <?php if (isset($_SESSION['register_success'])): ?>
                    <div class="success-message">
                        <i class="fas fa-check-circle me-2"></i>
                        <?= htmlspecialchars($_SESSION['register_success']) ?>
                    </div>
                    <?php unset($_SESSION['register_success']); ?>
                <?php endif; ?>
                <form method="POST" action="douserlogin.php">
                    <div class="position-relative">
                        <input type="text" class="form-control" name="account" placeholder="帳號" required>
                    </div>
                    <div class="position-relative password-field-container">
                        <input type="password" class="form-control" name="password" placeholder="密碼" required>
                        <button type="button" class="password-toggle">
                            <i class="fas fa-eye-slash"></i>
                        </button>
                    </div>
                    <button type="submit" class="btn btn-signup">
                        <i class="fas fa-sign-in-alt me-2"></i>
                        登入
                    </button>
                    <div class="text-center mt-3">
                        <a href="admin_login.php" class="text-muted">切換至管理者登入</a>
                    </div>
                    <div class="text-center mt-3">
                        <a href="user_register.php" class="btn btn-outline-primary">
                            <i class="fas fa-user-plus me-2"></i>註冊新帳號
                        </a>
                    </div>
                </form>
            </div>
            <div class="right-image"> </div>

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

        // 檢查是否有登入成功的訊息
        <?php if (isset($_SESSION['login_success']) && $_SESSION['login_success']): ?>
            // 創建並顯示歡迎彈跳視窗
            const welcomeModal = new bootstrap.Modal(document.createElement('div'));
            const modalHtml = `
            <div class="modal fade" id="welcomeModal" tabindex="-1" aria-labelledby="welcomeModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="welcomeModalLabel">歡迎登入</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            歡迎 <?= htmlspecialchars($_SESSION['welcome_name']) ?> 登入系統！
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="redirectToAdmin()">確定</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
            document.body.insertAdjacentHTML('beforeend', modalHtml);
            const modalElement = document.getElementById('welcomeModal');
            const modal = new bootstrap.Modal(modalElement);
            modal.show();

            // 重定向到管理員登入頁面
            function redirectToAdmin() {
                window.location.href = 'admin_login.php';
            }

            // 清除 session 變數
            <?php
            unset($_SESSION['login_success']);
            unset($_SESSION['welcome_name']);
            ?>
        <?php endif; ?>
    </script>
</body>

</html>