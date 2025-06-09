</main>
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
    crossorigin="anonymous"
></script>

<script>
    // 側邊欄切換功能
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.querySelector('.mobile-overlay');
        sidebar.classList.toggle('open');
        overlay.classList.toggle('active');
    }

    function closeSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.querySelector('.mobile-overlay');
        sidebar.classList.remove('open');
        overlay.classList.remove('active');
    }

    // 頁面切換功能
    function showSection(sectionId) {
        // 隱藏所有 section
        const sections = document.querySelectorAll('.page-section');
        sections.forEach(section => {
            section.style.display = 'none';
        });

        // 顯示對應 section
        const target = document.getElementById(sectionId);
        if (target) target.style.display = 'block';

        // 更新標題
        const titles = {
            'members': '會員管理',
            'products': '商品管理',
            'secondhand': '二手商品管理',
            'coupons': '優惠券管理',
            'articles': '文章管理',
            'stores': '店面管理',
            'settings': '系統設定',
            'logout': '登出'
        };

        if (titles[sectionId]) {
            const pageTitle = document.getElementById('page-title');
            if (pageTitle) pageTitle.textContent = titles[sectionId];
        }

        // 更新導航項目狀態
        document.querySelectorAll('.nav-item').forEach(item => {
            item.classList.remove('active');
        });
        const activeItem = event.target.closest('.nav-item');
        if (activeItem) activeItem.classList.add('active');
    }

    // 動畫效果
    document.addEventListener('DOMContentLoaded', function () {
        const statCards = document.querySelectorAll('.stat-card');
        statCards.forEach((card, index) => {
            setTimeout(() => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'all 0.6s ease';

                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 100);
            }, index * 150);
        });
    });
</script>

<?php
if (isset($jsList)) {
    foreach ($jsList as $js) {
        echo '<script src="' . $js . '"></script>';
    }
}
?>

</body>
</html>
