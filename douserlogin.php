<?php
session_start();
require_once "./components/connect.php";
require_once "./components/Utilities.php";

if (!isset($_POST["account"])) {
    alertGoTo("請從正常管道進入", "./user_login.php"); 
    exit;
}

$account = trim($_POST["account"]);
$password = trim($_POST["password"]);

if(empty($account)){
    alertAndBack("請輸入帳號");
    exit;
}

if(empty($password)){
    alertAndBack("請輸入密碼");
    exit;
}

try {
    $sql = "SELECT * FROM `users` WHERE `account` = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$account]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($row) {
        if ($row['is_valid'] == 0) {
            alertAndBack("因您違反會員規定遭帳號停權，如需恢復請聯繫專員！謝謝！");
            exit;
        }
        
        if (password_verify($password, $row["password"])) {
            // 檢查資料庫欄位
            error_log("User data: " . print_r($row, true));
            
            $_SESSION["user"] = [
                "id" => $row["id"],
                "name" => $row["name"],
                "account" => $row["account"],
                "img" => $row["img"] ? "../images/users/" . $row["img"] : "../images/user.png"
            ];
            
            // 檢查 session 是否正確設置
            error_log("Session data: " . print_r($_SESSION["user"], true));
            
            $_SESSION['login_success'] = true;
            $_SESSION['welcome_name'] = $row["name"];
            header("Location: ./user_login.php");
            exit;
        } else {
            alertAndBack("帳號或密碼錯誤");
        }
    } else {
        alertAndBack("帳號或密碼錯誤");
    }
} catch (PDOException $e) {
    error_log("資料庫錯誤: " . $e->getMessage());
    alertAndBack("系統錯誤，請稍後再試");
}
?>

<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Echo&Flow商店-登入頁面</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../css/users_login.css">
</head>

<body>
    <div class="auth-container">
        <div class="logo-container">
            <img src="./images/eflogo.png" alt="黑膠唱片行" class="logo">
        </div>
        <div class="auth-image">
            <div class="slideshow">
                <div class="slide active" style="background-image: url('images/slide1.png');"></div>
                <div class="slide" style="background-image: url('images/slide2.png');"></div>
                <div class="slide" style="background-image: url('images/slide3.png');"></div>
            </div>
            <div class="slide-dots">
                <div class="dot active"></div>
                <div class="dot"></div>
                <div class="dot"></div>
            </div>
        </div>
        <div class="auth-form">
            <div class="form-container">
                <h2 class="form-title">登入帳號</h2>
                <?php if (isset($_SESSION['login_error'])): ?>
                    <div class="alert alert-danger">
                        <?php
                        echo $_SESSION['login_error'];
                        unset($_SESSION['login_error']);
                        ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($_SESSION['register_success'])): ?>
                    <div class="alert alert-success">
                        <?php
                        echo $_SESSION['register_success'];
                        unset($_SESSION['register_success']);
                        ?>
                    </div>
                <?php endif; ?>
                <form method="POST" action="douserlogin.php">
                    <div class="mb-3">
                        <input type="text" class="form-control" name="account" id="account" placeholder="帳號(請輸入email格式)" required>
                        <div id="account-feedback" class="form-text text-danger"></div>
                    </div>
                    <div class="position-relative password-field-container">
                        <input type="password" class="form-control" name="password" id="password" placeholder="密碼" required>
                        <button type="button" class="password-toggle">
                            <i class="fas fa-eye-slash"></i>
                        </button>
                        <div id="password-feedback" class="form-text text-danger"></div>
                    </div>
                    <button type="submit" class="btn btn-login">
                        登入
                    </button>
                    <div class="form-footer">
                        <a href="user_register.php">
                            還沒有帳號？立即註冊
                        </a>
                    </div>
                    <div class="admin-login">
                        <a href="admin_login.php">
                            <i class="fas fa-user-shield me-1"></i>管理者登入
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- 歡迎視窗 -->
    <div class="modal fade" id="welcomeModal" tabindex="-1" aria-labelledby="welcomeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="welcomeModalLabel">歡迎回來</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <i class="fas fa-check-circle text-success mb-3" style="font-size: 3rem;"></i>
                    <h4 class="mb-3"><?php echo isset($_SESSION['welcome_name']) ? htmlspecialchars($_SESSION['welcome_name']) : ''; ?>，歡迎回來！</h4>
                    <p class="text-muted">您已成功登入系統</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">開始購物</button>
                </div>
            </div>
        </div>
    </div>

    <!-- 停權提示視窗 -->
    <div class="modal fade" id="suspendedModal" tabindex="-1" aria-labelledby="suspendedModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="suspendedModalLabel">帳號停權通知</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <i class="fas fa-exclamation-triangle text-warning mb-3" style="font-size: 3rem;"></i>
                    <h4 class="mb-3">帳號已停權</h4>
                    <p class="text-muted">因您違反會員規定遭帳號停權，如需恢復請聯繫專員！謝謝！</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">我知道了</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // 檢查是否需要顯示歡迎視窗
        <?php if (isset($_SESSION['login_success']) && $_SESSION['login_success']): ?>
        document.addEventListener('DOMContentLoaded', function() {
            const welcomeModal = new bootstrap.Modal(document.getElementById('welcomeModal'));
            welcomeModal.show();
            
            // 監聽視窗關閉事件
            document.getElementById('welcomeModal').addEventListener('hidden.bs.modal', function () {
                window.location.href = 'admin_login.php';
            });
            
            <?php unset($_SESSION['login_success']); ?>
        });
        <?php endif; ?>

        // 檢查是否需要顯示停權視窗
        <?php if (isset($_SESSION['account_suspended'])): ?>
        document.addEventListener('DOMContentLoaded', function() {
            const suspendedModal = new bootstrap.Modal(document.getElementById('suspendedModal'));
            suspendedModal.show();
            <?php unset($_SESSION['account_suspended']); ?>
        });
        <?php endif; ?>

        // Email 格式驗證
        const accountInput = document.getElementById('account');
        const accountFeedback = document.getElementById('account-feedback');

        accountInput.addEventListener('input', function() {
            const email = this.value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (email && !emailRegex.test(email)) {
                accountFeedback.textContent = '請輸入有效的電子郵件地址';
                this.classList.add('is-invalid');
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
                this.classList.add('is-invalid');
            } else {
                passwordFeedback.textContent = '';
                this.classList.remove('is-invalid');
            }
        });

        //圖片輪播
        document.addEventListener('DOMContentLoaded', function() {
            const slides = document.querySelectorAll('.slide');
            const dots = document.querySelectorAll('.dot');
            let currentSlide = 0;
            const slideInterval = 5000; // 5秒切換一次

            function showSlide(index) {
                slides.forEach(slide => slide.classList.remove('active'));
                dots.forEach(dot => dot.classList.remove('active'));
                
                slides[index].classList.add('active');
                dots[index].classList.add('active');
            }

            function nextSlide() {
                currentSlide = (currentSlide + 1) % slides.length;
                showSlide(currentSlide);
            }

            // 點擊指示點切換輪播圖
            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    currentSlide = index;
                    showSlide(currentSlide);
                });
            });

            // 自動輪播
            setInterval(nextSlide, slideInterval);
        });

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
    </script>
</body>

</html> 