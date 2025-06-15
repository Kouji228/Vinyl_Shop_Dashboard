<?php
session_start();
require_once "./components/connect.php";
require_once "./components/Utilities.php";

// 如果已經登入，直接跳轉到管理頁面
if (isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理者登入</title>
    <!-- Bootstrap 5.3.5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous" />

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet"
        crossorigin="anonymous" />

    <!-- Google 字體 -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@400;500;700&display=swap" rel="stylesheet" />

    <link href="./css/admin_login.css" rel="stylesheet">
</head>

<body>
    <div class="signup-wrapper">
        <div class="signup-box">
            <div class="left-image"></div>
            <div class="signup-form">
                <h2>管理者登入</h2>
                <p>歡迎回來，請登入您的帳號</p>
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <?= htmlspecialchars($_SESSION['error']) ?>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>
                <form method="POST" action="doadminlogin.php">
                    <div class="position-relative">
                        <input type="text" class="form-control" name="account" placeholder="管理者帳號" required>
                        <i class="fas fa-check form-check-icon"></i>
                    </div>
                    <div class="position-relative password-field-container">
                        <input type="password" class="form-control" id="adminPassword" name="password"
                            placeholder="管理者密碼" required>
                        <i class="fas fa-check form-check-icon"></i>
                        <button type="button" class="password-toggle">
                            <i class="fas fa-eye-slash"></i>
                        </button>
                    </div>
                    <button type="submit" class="btn btn-signup">
                        <i class="fas fa-sign-in-alt me-2"></i>
                        管理者登入
                    </button>
                    <div class="text-center mt-3">
                        <a href="user_login.php" class="text-muted">切換至使用者登入</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous">
        </script>
</body>

</html>