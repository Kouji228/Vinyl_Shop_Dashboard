<?php
include "../components/connect.php";

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


<!DOCTYPE html>
<html lang="zh-TW">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $id ? '編輯文章' : '新增文章' ?></title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7"
      crossorigin="anonymous"
    />
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>
    <style>
      .ck-editor__editable_inline {
        width: 100% !important;
        min-height: 400px !important;
        height: 400px !important;
        box-sizing: border-box;
        max-width: 100%;
      }
      .tag-checkbox {
        margin-right: 10px;
      }
      .tag-container {
        max-height: 100px;
        overflow-x: auto;
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        padding: 10px;
        white-space: nowrap;
      }
      .tag-item {
        display: inline-block;
        margin-right: 15px;
        margin-bottom: 5px;
      }
      .tag-item:last-child {
        margin-right: 0;
      }
      .form-check {
        display: inline-block;
        margin-bottom: 0;
      }
      .cover-image-container {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 10px;
        background-color: #f8f9fa;
        border-radius: 0.375rem;
      }
      .cover-image-preview {
        width: 200px;
        height: 150px;
        object-fit: cover;
        border-radius: 4px;
        border: 1px solid #dee2e6;
      }
      .cover-image-input {
        flex: 1;
      }
      /* 圖片上傳按鈕樣式 */
      .ck.ck-button.ck-button_with-text {
        background-color: #0d6efd;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 4px;
        cursor: pointer;
      }
      .ck.ck-button.ck-button_with-text:hover {
        background-color: #0b5ed7;
      }
    </style>
  </head>

  <body>
    <div class="container">
      <h1><?= $id ? '編輯文章' : '新增文章' ?></h1>
      <div class="input-group mb-1">
        <div class="input-group-text">標題</div>
        <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($article['title'] ?? '') ?>" />
      </div>
      <div class="cover-image-container mb-3">
        <div class="input-group-text">封面圖片</div>
        <div class="cover-image-input">
          <input type="file" id="coverFileInput" accept="image/*" class="form-control mb-2">
          <input type="text" name="cover_image_url" class="form-control" value="<?= htmlspecialchars($article['cover_image_url'] ?? '') ?>" placeholder="請輸入圖片網址" />
        </div>
        <img src="<?= htmlspecialchars($article['cover_image_url'] ?? '') ?>" alt="封面圖片" class="cover-image-preview" style="max-width:200px;">
      </div>
      <div class="input-group mb-1">
        <div class="input-group-text">分類</div>
        <div class="tag-container flex-grow-1">
          <?php foreach ($categories as $category): ?>
            <div class="tag-item">
              <div class="form-check">
                <input class="form-check-input tag-checkbox" type="checkbox"
                       name="categories[]" value="<?=$category['id']?>"
                       id="category_<?=$category['id']?>"
                       <?= in_array($category['id'], $article['category_ids'] ?? []) ? 'checked' : '' ?>>
                <label class="form-check-label" for="tag_<?=$tag['id']?>">
                  <?=$category['name']?>
                </label>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="input-group mb-1">
        <div class="input-group-text">標籤</div>
          <div class="tag-container flex-grow-1">
            <?php foreach ($tags as $tag): ?>
              <div class="tag-item">
                <div class="form-check">
                  <input class="form-check-input tag-checkbox" type="checkbox"
                        name="tags[]" value="<?=$tag['id']?>"
                        id="tag_<?=$tag['id']?>"
                        <?= in_array($tag['id'], $article['tag_ids'] ?? []) ? 'checked' : '' ?>>
                  <label class="form-check-label" for="tag_<?=$tag['id']?>">
                    <?=$tag['name']?>
                  </label>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
      </div>
      <div id="editor">
        <?= $article['content'] ?? '<p>這裡是內容</p>' ?>
      </div>
      <div class="input-group mb-1">
        <div class="input-group-text">設定狀態</div>
        <select name="status" class="form-select" id="statusSelect">
          <option value="draft" <?= ($article['current_status'] ?? '') === 'draft' ? 'selected' : '' ?>>草稿</option>
          <option value="published" <?= ($article['current_status'] ?? '') === 'published' ? 'selected' : '' ?>>已發布</option>
          <option value="scheduled" <?= ($article['current_status'] ?? '') === 'scheduled' ? 'selected' : '' ?>>排程發布</option>
        </select>
      </div>
      <div class="input-group mb-1" id="scheduledDateGroup" style="display: none;">
        <div class="input-group-text">發布時間安排</div>
        <input type="datetime-local" name="scheduled_at" class="form-control"
               value="<?= !empty($article['scheduled_at']) ? date('Y-m-d\TH:i', strtotime($article['scheduled_at'])) : '' ?>" />
      </div>
      <div class="input-group mb-1" id="publishedDateGroup" style="display: none;">
        <div class="input-group-text">發布時間</div>
        <input type="text" class="form-control" readonly
               value="<?= !empty($article['status_updated_at']) ? date('Y-m-d H:i', strtotime($article['status_updated_at'])) : '' ?>" />
      </div>
      <div class="d-flex gap-2">
        <div class="btn btn-sm btn-primary btn-send">送出</div>
        <a href="./index.php" class="btn btn-sm btn-secondary">取消</a>
      </div>
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
  </body>
</html>
