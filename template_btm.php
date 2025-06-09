  
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script>
  function showSection(sectionId) {
    // Hide all sections
    const sections = document.querySelectorAll('.page-section');
    sections.forEach(section => {
      section.style.display = 'none';
    });

    // Remove active class from all nav items
    const navItems = document.querySelectorAll('.nav-item');
    navItems.forEach(item => {
      item.classList.remove('active');
    });

    // Show selected section
    document.getElementById(sectionId).style.display = 'block';

    // Add active class to clicked nav item
    event.target.closest('.nav-item').classList.add('active');

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
      if (titles[sectionId]) {
        document.getElementById('page-title').textContent = titles[sectionId];
      }

      // 將選取項目加上 active
      document.querySelectorAll('.nav-item').forEach(item => {
        item.classList.remove('active');
      });
      event.target.closest('.nav-item').classList.add('active');
    }
  }

  // Pagination functions
  let currentPage = 1;
  const totalPages = 5;

  function changePage(direction) {
    if (direction === 'prev' && currentPage > 1) {
      currentPage--;
    } else if (direction === 'next' && currentPage < totalPages) {
      currentPage++;
    }
    updatePagination();
  }

  function goToPage(page) {
    currentPage = page;
    updatePagination();
  }

  function updatePagination() {
    // Remove active class from all page buttons
    document.querySelectorAll('.pagination-btn').forEach(btn => {
      btn.classList.remove('active');
    });

    // Add active class to current page
    const pageButtons = document.querySelectorAll('.pagination-btn:not([id])');
    pageButtons.forEach((btn, index) => {
      if (parseInt(btn.textContent) === currentPage) {
        btn.classList.add('active');
      }
    });

    // Update prev/next button states
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');

    if (prevBtn) {
      prevBtn.disabled = currentPage === 1;
    }
    if (nextBtn) {
      nextBtn.disabled = currentPage === totalPages;
    }
  }

  // Add some interactive animations
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
    ?>
    <script src="<?= $js ?>"></script>
    <?php
  }
}
?>


</body>

</html>