<!DOCTYPE html>
<html lang="zh-Hant">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= $pageTitle ?? "Echo & Flow 管理後台" ?></title>

  <!-- Bootstrap CSS -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Bootstrap Icons (使用 CDN 較方便更新) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet"
    crossorigin="anonymous" />

  <!-- Google 字體 -->
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC&display=swap" rel="stylesheet" />

  <!-- 載入其他自訂 CSS -->
  <?php if (isset($cssList)): ?>
    <?php foreach ($cssList as $css): ?>
      <link rel="stylesheet" href="<?= $css ?>" />
    <?php endforeach; ?>
  <?php endif; ?>
</head>

<body>

  <button class="mobile-toggle" onclick="toggleSidebar()">
    <span class="bi bi-list"></span>
  </button>

  <div class="mobile-overlay" onclick="closeSidebar()"></div>

  <div class="container d-flex">
    <!-- 側邊欄 -->
    <nav class="sidebar" id="sidebar">
      <div class="logo">
        <img src="../images/eflogo.png" alt="Echo & Flow Logo" class="logo-image" />
      </div>

      <nav class="sidebar-nav">
        <?php foreach ($menu_items as $item): ?>
          <a href="<?= $item['link'] ?? '#' ?>" class="nav-item" onclick="showSection('<?= $item['id'] ?>')">
            <i class="<?= $item['icon'] ?>"></i>
            <span><?= $item['label'] ?></span>
          </a>
        <?php endforeach; ?>
      </nav>
    </nav>

    <!-- 這裡開啟 main-content，template_main.php 會直接插入內容 -->
    <main class="main-content flex-grow-1">
    