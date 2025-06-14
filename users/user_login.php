<?php
require_once "../components/connect.php";
require_once "../components/Utilities.php";

// 如果已經登入，重定向到首頁
if (isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}

$error = '';

// 處理登入表單提交
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = '請輸入電子郵件和密碼';
    } else {
        try {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND status = 'active'");
            $stmt->execute([$email]);
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
    <link href="../css/index.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            margin: 0;
            padding: 0;
            background: #f5f5f5;
        }



        .signup-wrapper {
            width: 100%;
            max-width: 1000px;
            margin: 2rem;
            position: relative;
            z-index: 1;
        }

        .signup-box {
            display: flex;
            background: var(--white);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .signup-form {
            flex: 1;
            padding: 3rem;
            background: var(--white);
        }

        .right-image {
            flex: 1;
            background: url('./images/jakob-rosen-KA1WM_yQGF8-unsplash.jpg') center/cover;
            position: relative;
        }

        .signup-form h2 {
            font-family: 'Playfair Display', serif;
            color: #333;
            font-size: 2rem;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .signup-form p {
            color: #666;
            margin-bottom: 2rem;
            font-size: 0.9rem;
        }

        .form-control {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            background: #f8f8f8;
            margin-bottom: 1rem;
        }

        .form-control:focus {
            border-color: #4a90e2;
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
            background: var(--white);
        }

        .position-relative {
            position: relative;
        }

        .form-check-icon {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #4CAF50;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .form-control:valid+.form-check-icon {
            opacity: 1;
        }

        .btn-signup {
            width: 100%;
            padding: 0.8rem;
            background: #4a90e2;
            color: var(--white);
            border: none;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 4px 16px rgba(74, 144, 226, 0.3);
            margin-top: 1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-signup:hover {
            background: #357abd;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(74, 144, 226, 0.4);
        }

        .error-message {
            color: #dc3545;
            margin-bottom: 1rem;
            text-align: center;
            padding: 0.75rem;
            background: rgba(220, 53, 69, 0.1);
            border-radius: 8px;
            font-size: 0.9rem;
        }

        .social-icons {
            text-align: center;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #eee;
        }

        .social-icons p {
            color: #666;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .social-icons i {
            font-size: 1.2rem;
            color: #666;
            margin: 0 0.75rem;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .social-icons i:hover {
            color: #4a90e2;
        }

        .text-muted {
            color: #666;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .text-muted:hover {
            color: #4a90e2;
        }

        @media (max-width: 768px) {
            .signup-box {
                flex-direction: column;
            }

            .right-image {
                display: none;
            }

            .signup-form {
                padding: 2rem;
            }
        }
    </style>
</head>

<body>


    <div class="signup-wrapper">
        <div class="signup-box">
            <div class="signup-form">
                <h2>使用者登入</h2>
                <p>歡迎回來，請登入您的帳號</p>
                <?php if ($error): ?>
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>
                <form method="POST" action="">
                    <div class="position-relative">
                        <input type="email" class="form-control" name="email" placeholder="電子郵件" required>
                        <i class="fas fa-check form-check-icon"></i>
                    </div>
                    <div class="position-relative password-field-container">
                        <input type="password" class="form-control" name="password" placeholder="密碼" required>
                        <i class="fas fa-check form-check-icon"></i>
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
                </form>
                <div class="social-icons">
                    <p>或使用以下方式登入</p>
                    <i class="fab fa-google"></i>
                    <i class="fab fa-facebook-f"></i>
                    <i class="fab fa-twitter"></i>
                </div>
            </div>
            <div class="right-image">            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Password toggle functionality
        document.querySelectorAll('.password-toggle').forEach(function(button) {
            button.addEventListener('click', function() {
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
</body>

</html>