<?php
include "../article/connect.php";
include "../components/Utilities.php";

$pageTitle = "文章管理";
$cssList = ["../css/index.css", "../css/add.css","../css/articleAdd.css"];
include "../vars.php";
include "../template_top.php";
include "../template_main.php";

$id = $_GET['id'] ?? null;
$article = null;

if ($id) {
    // 載入文章資料
    $sql = "SELECT a.*,
            GROUP_CONCAT(DISTINCT at.tag_id) as tag_ids,
            GROUP_CONCAT(DISTINCT ac.category_id) as category_ids,
            ast.status as current_status,
            ast.updated_at as status_updated_at
            FROM articles a
            LEFT JOIN article_tag at ON a.id = at.article_id
            LEFT JOIN article_category ac ON a.id = ac.article_id
            LEFT JOIN article_statuses ast ON a.id = ast.article_id
            WHERE a.id = ?
            GROUP BY a.id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $article = $stmt->fetch(PDO::FETCH_ASSOC);

    // 將分類 ID 字串轉換為陣列
    if (!empty($article['category_ids'])) {
        $article['category_ids'] = explode(',', $article['category_ids']);
    } else {
        $article['category_ids'] = [];
    }

    // 將標籤 ID 字串轉換為陣列
    if (!empty($article['tag_ids'])) {
        $article['tag_ids'] = explode(',', $article['tag_ids']);
    } else {
        $article['tag_ids'] = [];
    }
}

// 載入標籤資料
$sqlTags = "SELECT * FROM tags";
$stmtTags = $pdo->prepare($sqlTags);
$stmtTags->execute();
$tags = $stmtTags->fetchAll(PDO::FETCH_ASSOC);

// 載入分類資料
$sqlCategories = "SELECT * FROM categories";
$stmtCategories = $pdo->prepare($sqlCategories);
$stmtCategories->execute();
$categories = $stmtCategories->fetchAll(PDO::FETCH_ASSOC);
?>



<head>
    <title><?= $id ? '編輯文章' : '新增文章' ?></title>
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>
</head>

    <div class="content-section">
      <div class="section-header">
        <h3 class="section-title"><?= $id ? '編輯文章' : '新增文章' ?></h3>
        <a href="./index.php" class="btn btn-secondary">回文章列表</a>
      </div>
      <form id="articleForm" method="POST" enctype="multipart/form-data">
        <div class="form-section">
          <h4 class="form-section-title">文章內容</h4>
          <div class="form-row">
            <div class="form-group flex-grow-1">
              <label class="form-label required">標題</label>
              <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($article['title'] ?? '') ?>" required />
            </div>
          </div>
          <div class="form-row">
            <div class="form-group flex-grow-1">
              <label class="form-label">封面圖片</label>
              <input type="file" id="coverFileInput" accept="image/*" class="form-control mb-2">
              <input type="text" name="cover_image_url" class="form-control" value="<?= htmlspecialchars($article['cover_image_url'] ?? '') ?>" placeholder="請輸入圖片網址" />
              <img src="<?= htmlspecialchars($article['cover_image_url'] ?? '') ?>" alt="封面圖片" class="cover-image-preview mt-2" style="max-width:200px;">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group flex-grow-1">
              <label class="form-label">分類</label>
              <div class="tag-container">
                <?php foreach ($categories as $category): ?>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input tag-checkbox" type="checkbox"
                           name="categories[]" value="<?=$category['id']?>"
                           id="category_<?=$category['id']?>"
                           <?= in_array($category['id'], $article['category_ids'] ?? []) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="category_<?=$category['id']?>">
                      <?=$category['name']?>
                    </label>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group flex-grow-1">
              <label class="form-label">標籤</label>
              <div class="tag-container">
                <?php foreach ($tags as $tag): ?>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input tag-checkbox" type="checkbox"
                          name="tags[]" value="<?=$tag['id']?>"
                          id="tag_<?=$tag['id']?>"
                          <?= in_array($tag['id'], $article['tag_ids'] ?? []) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="tag_<?=$tag['id']?>">
                      <?=$tag['name']?>
                    </label>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group flex-grow-1">
              <label class="form-label">內文</label>
              <div id="editor">
                <?= $article['content'] ?? '<p>這裡是內容</p>' ?>
              </div>
            </div>
          </div>
        </div>
        <div class="form-section">
          <h4 class="form-section-title">狀態設定</h4>
          <div class="form-row row g-3">
            <div class="form-group col-12 col-md-6">
              <label class="form-label">設定狀態</label>
              <select name="status" class="form-select" id="statusSelect">
                <option value="draft" <?= ($article['current_status'] ?? '') === 'draft' ? 'selected' : '' ?>>草稿</option>
                <option value="published" <?= ($article['current_status'] ?? '') === 'published' ? 'selected' : '' ?>>已發布</option>
                <option value="scheduled" <?= ($article['current_status'] ?? '') === 'scheduled' ? 'selected' : '' ?>>排程發布</option>
              </select>
            </div>
            <div class="form-group col-12 col-md-6" id="scheduledDateGroup" style="display: none;">
              <label class="form-label">發布時間安排</label>
              <input type="datetime-local" name="scheduled_at" class="form-control"
                    value="<?= !empty($article['scheduled_at']) ? date('Y-m-d\TH:i', strtotime($article['scheduled_at'])) : '' ?>" />
            </div>
            <div class="form-group col-12 col-md-6" id="publishedDateGroup" style="display: none;">
              <label class="form-label">實際發布時間</label>
              <input type="text" class="form-control" readonly
                    value="<?= !empty($article['status_updated_at']) ? date('Y-m-d H:i', strtotime($article['status_updated_at'])) : '' ?>" />
            </div>
          </div>
        </div>
        <div class="form-actions">
          <button type="button" class="btn btn-secondary" onclick="window.location.href='./index.php'">
            <i class="fas fa-times"></i> 取消
          </button>
          <button type="submit" class="btn btn-primary btn-send">
            <i class="fas fa-save"></i> 儲存文章
          </button>
        </div>
      </form>
    </div>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
      crossorigin="anonymous"
    ></script>
    <script>
      // ===== 全域變數定義 =====
      let editorInstance;
      const btnSend = document.querySelector('.btn-send');
      const saveURL = <?= $id ? "'./doEdit.php'" : "'./doAdd.php'" ?>;
      const inputTitle = document.querySelector('[name=title]');
      const articleId = <?= $id ? $id : 'null' ?>;
      const MAX_IMAGE_SIZE = 5 * 1024 * 1024; // 5MB
      const statusSelect = document.getElementById('statusSelect');
      const scheduledDateGroup = document.getElementById('scheduledDateGroup');
      const publishedDateGroup = document.getElementById('publishedDateGroup');

      // 根據狀態顯示/隱藏預計發布時間
      function toggleScheduledDate() {
        const status = statusSelect.value;
        scheduledDateGroup.style.display = status === 'scheduled' ? 'flex' : 'none';
        publishedDateGroup.style.display = status === 'published' ? 'flex' : 'none';
      }

      // 監聽狀態變更
      statusSelect.addEventListener('change', toggleScheduledDate);
      // 初始化顯示狀態
      toggleScheduledDate();

      // ===== 表單提交處理 =====
      console.log('送出按鈕已綁定');
      btnSend.addEventListener('click', (e) => {
        console.log('送出按鈕被點擊');
        const formData = new FormData();
        formData.append('title', inputTitle.value);
        formData.append('content', editorInstance.getData());
        formData.append('status', document.querySelector('[name=status]').value);
        formData.append('cover_image_url', document.querySelector('[name=cover_image_url]').value);
        formData.append('scheduled_at', document.querySelector('[name=scheduled_at]').value);
        if (articleId) {
          formData.append('id', articleId);
        }

        // 獲取所有選中的標籤
        const selectedTags = Array.from(document.querySelectorAll('input[name="tags[]"]:checked'))
          .map(checkbox => checkbox.value);
        formData.append('tags', JSON.stringify(selectedTags));

        // 獲取所有選中的分類
        const selectedCategories = Array.from(document.querySelectorAll('input[name="categories[]"]:checked'))
          .map(checkbox => checkbox.value);
        formData.append('categories', JSON.stringify(selectedCategories));

        // 發送表單數據到後端
        fetch(saveURL, {
          method: 'POST',
          body: formData,
        })
          .then(response => response.json())
          .then(data => {
            if (data.success && data.redirect) {
              alert(data.message || '操作成功');
              window.location = data.redirect;
            } else {
              alert(data.message || '操作失敗');
            }
          })
          .catch(error => {
            console.error('Error:', error);
            alert('發生錯誤，請稍後再試');
          });
      });

      // ===== CKEditor 圖片上傳適配器 =====
      class MyUploadAdapter {
        constructor(loader) {
          this.loader = loader;
        }

        upload() {
          return this.loader.file.then(
            (file) =>
              new Promise((resolve, reject) => {
                // 前端檢查檔案大小
                if (file.size > MAX_IMAGE_SIZE) {
                  alert('圖片大小不能超過 5MB');
                  reject('圖片大小不能超過 5MB');
                  return;
                }

                const data = new FormData();
                data.append('upload', file);

                fetch('upload.php', {
                  method: 'POST',
                  body: data,
                })
                  .then((response) => response.json())
                  .then((data) => {
                    if (data.error) {
                      reject(data.error.message);
                    } else {
                      resolve({
                        default: data.url,
                      });
                    }
                  })
                  .catch((err) => {
                    reject(err);
                  });
              }),
          );
        }

        abort() {
          // 如果用戶取消上傳，這個方法會被調用
        }
      }

      // ===== CKEditor 插件註冊 =====
      function MyCustomUploadAdapterPlugin(editor) {
        editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
          return new MyUploadAdapter(loader);
        };
      }

      // ===== CKEditor 初始化 =====
      ClassicEditor.create(document.querySelector('#editor'), {
        extraPlugins: [MyCustomUploadAdapterPlugin],
        toolbar: {
          items: [
            'heading',
            '|',
            'bold',
            'italic',
            'link',
            'bulletedList',
            'numberedList',
            '|',
            'imageUpload',
            'blockQuote',
            'insertTable',
            'undo',
            'redo'
          ]
        },
        image: {
          toolbar: [
            'imageTextAlternative',
            'imageStyle:inline',
            'imageStyle:block',
            'imageStyle:side'
          ],
          upload: {
            types: ['jpeg', 'png', 'gif']
          }
        },
        table: {
          contentToolbar: [
            'tableColumn',
            'tableRow',
            'mergeTableCells'
          ]
        }
      })
        .then((editor) => {
          editorInstance = editor;
        })
        .catch((error) => {
          console.error(error);
        });

      const fileInput = document.getElementById('coverFileInput');
      const coverInput = document.querySelector('[name="cover_image_url"]');
      const coverPreview = document.querySelector('.cover-image-preview');

      fileInput.addEventListener('change', function() {
        const file = fileInput.files[0];
        if (file) {
          // 預覽
          const reader = new FileReader();
          reader.onload = function(e) {
            coverPreview.src = e.target.result;
            coverPreview.classList.remove('d-none');
          };
          reader.readAsDataURL(file);

          // 上傳到伺服器
          const data = new FormData();
          data.append('upload', file);
          data.append('is_cover', 'true');
          if (articleId) {
            data.append('article_id', articleId);
          }
          fetch('upload.php', {
            method: 'POST',
            body: data,
          })
            .then(response => response.json())
            .then(data => {
              if (data.url) {
                coverInput.value = data.url; // 自動填入網址
              } else if (data.error) {
                alert(data.error.message || '圖片上傳失敗');
              }
            })
            .catch(() => {
              alert('圖片上傳失敗');
            });
        }
      });
    </script>


<?php
include "../template_btm.php";
?>
