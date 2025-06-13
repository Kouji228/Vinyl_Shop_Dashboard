<?php
require_once "../components/connect.php";
include "../components/Utilities.php";

$pageTitle = "店面管理";
$cssList = ["../css/index.css", "../css/add.css", "../css/vinyl_shopAdd.css"];
include "../vars.php";
include "../template_top.php";
include "../template_main.php";

// 添加 Flatpickr CSS 和 JS
echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">';
echo '<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>';
echo '<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/zh-tw.js"></script>';

// 初始化變數
$id = $_GET['id'] ?? null;
$branch = null;
$tags = [];
$selectedTags = [];
$branchImages = [];

// 載入店面資料
if ($id) {
    $sql = "SELECT b.*, GROUP_CONCAT(h.name) as services
            FROM branch b
            LEFT JOIN branch_hashtag bh ON b.id = bh.branch_id
            LEFT JOIN hashtag h ON bh.hashtag_id = h.id
            WHERE b.id = ? AND b.deleted_at IS NULL
            GROUP BY b.id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $branch = $stmt->fetch(PDO::FETCH_ASSOC);

    // 獲取已選擇的標籤
    $sqlSelectedTags = "SELECT hashtag_id FROM branch_hashtag WHERE branch_id = ?";
    $stmtSelectedTags = $pdo->prepare($sqlSelectedTags);
    $stmtSelectedTags->execute([$id]);
    $selectedTags = $stmtSelectedTags->fetchAll(PDO::FETCH_COLUMN);

    // 載入店面圖片
    $sqlImages = "SELECT * FROM branch_image WHERE branch_id = ? ORDER BY id ASC";
    $stmtImages = $pdo->prepare($sqlImages);
    $stmtImages->execute([$id]);
    $branchImages = $stmtImages->fetchAll(PDO::FETCH_ASSOC);
}

// 載入所有標籤
$sqlTags = "SELECT * FROM hashtag";
$stmtTags = $pdo->prepare($sqlTags);
$stmtTags->execute();
$tags = $stmtTags->fetchAll(PDO::FETCH_ASSOC);
?>

    <div class="content-section">
      <div class="section-header">
        <h3 class="section-title"><?= $id ? '編輯店面' : '新增店面' ?></h3>
        <a href="./index.php" class="btn btn-secondary">回店面列表</a>
      </div>
      <form id="branchForm" method="POST">
        <?php if ($id): ?>
            <input type="hidden" name="id" value="<?= $id ?>">
        <?php endif; ?>
        <div class="form-section">
          <h4 class="form-section-title">店面資料</h4>
          <div class="form-row">
            <div class="form-group flex-grow-1">
              <label class="form-label required">店名</label>
              <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($branch['name'] ?? '') ?>" required />
            </div>
          </div>
          <div class="form-row">
            <div class="form-group flex-grow-1">
              <label class="form-label required">地址</label>
              <input type="text" name="address" class="form-control" value="<?= htmlspecialchars($branch['address'] ?? '') ?>" required />
            </div>
          </div>
          <div class="form-row">
            <div class="form-group flex-grow-1">
              <label class="form-label required">電話</label>
              <input type="tel" name="phone" class="form-control" value="<?= htmlspecialchars($branch['phone'] ?? '') ?>" required />
            </div>
          </div>
          <div class="form-row">
            <div class="form-group flex-grow-1">
              <label class="form-label required">座標</label>
              <div class="input-group">
                <input type="text" name="coordinates" class="form-control" placeholder="例如：25.033964, 121.564472" value="<?= isset($branch['latitude']) && isset($branch['longitude']) ? htmlspecialchars($branch['latitude'] . ', ' . $branch['longitude']) : '' ?>" required />
                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
              </div>
              <small class="form-text text-muted">請從 Google Maps 複製座標數據，格式為：緯度, 經度</small>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group flex-grow-1">
              <label class="form-label required">營業星期</label>
              <div class="d-flex flex-wrap gap-2">
                <?php
                $weekdays = [
                    '1' => '週一',
                    '2' => '週二',
                    '3' => '週三',
                    '4' => '週四',
                    '5' => '週五',
                    '6' => '週六',
                    '7' => '週日'
                ];
                $selectedWeekdays = !empty($branch['weekdays']) ? explode(',', $branch['weekdays']) : ['1', '2', '3', '4', '5'];
                foreach ($weekdays as $value => $label):
                ?>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input"
                           name="weekdays[]" value="<?= $value ?>"
                           <?= in_array($value, $selectedWeekdays) ? 'checked' : '' ?>>
                    <label class="form-check-label"><?= $label ?></label>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group flex-grow-1">
              <label class="form-label required">營業時間</label>
              <div class="d-flex gap-3 align-items-center">
                <div class="flex-grow-1">
                  <div class="input-group">
                    <span class="input-group-text">開始時間</span>
                    <input type="text" id="startTime" class="form-control" placeholder="09:30" />
                  </div>
                </div>
                <div class="flex-grow-1">
                  <div class="input-group">
                    <span class="input-group-text">結束時間</span>
                    <input type="text" id="endTime" class="form-control" placeholder="18:30" />
                  </div>
                </div>
                <button class="btn btn-outline-primary" type="button" id="addTimeRange">
                  <i class="fas fa-plus"></i> 新增
                </button>
              </div>
              <div id="timeRanges" class="mt-2">
                <!-- 時段將在這裡動態添加 -->
              </div>
              <input type="hidden" name="business_hours" id="businessHours" value="<?= htmlspecialchars($branch['business_hours'] ?? '') ?>" required />
            </div>
          </div>
          <div class="form-row">
            <div class="form-group flex-grow-1">
              <label class="form-label required">提供服務</label>
              <div class="d-flex flex-wrap gap-2">
                <?php foreach ($tags as $tag): ?>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input"
                               name="services[]" value="<?= $tag['id'] ?>"
                               <?= in_array($tag['id'], $selectedTags) ? 'checked' : '' ?>>
                        <label class="form-check-label"><?= htmlspecialchars($tag['name']) ?></label>
                    </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
          <div class="form-group flex-grow-1">
              <label class="form-label">店舖圖片</label>
              <div class="mb-3">
                <input type="file" id="coverFileInput" accept="image/*" class="form-control" multiple>
                <small class="form-text text-muted">可以選擇多張圖片上傳</small>
              </div>
              <div id="imagePreviewContainer" class="d-flex flex-wrap gap-2 mb-3">
                <?php foreach ($branchImages as $image): ?>
                <div class="position-relative">
                    <img src="<?= htmlspecialchars($image['url']) ?>" alt="店舖圖片" class="img-thumbnail" style="width: 150px; height: 150px; object-fit: cover;">
                    <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1" onclick="removeImage(this, <?= $image['id'] ?>)">×</button>
                    <input type="hidden" name="images[<?= $image['id'] ?>][url]" value="<?= htmlspecialchars($image['url']) ?>">
                    <input type="hidden" name="images[<?= $image['id'] ?>][description]" value="<?= htmlspecialchars($image['description'] ?? '') ?>">
                </div>
                <?php endforeach; ?>
              </div>
          </div>
        </div>
        <div class="form-actions">
          <button type="button" class="btn btn-secondary" onclick="window.location.href='./index.php'">
            <i class="fas fa-times"></i> 取消
          </button>
          <button type="submit" class="btn btn-primary btn-send">
            <i class="fas fa-save"></i> 儲存
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
      const btnSend = document.querySelector('.btn-send');
      const saveURL = <?= $id ? "'./doEdit.php'" : "'./doAdd.php'" ?>;
      const branchId = <?= $id ? $id : 'null' ?>;

      // ===== 表單提交處理 =====
      btnSend.addEventListener('click', (e) => {
        e.preventDefault();

        // 表單驗證
        if (!validateForm()) {
          return;
        }

        // 禁用提交按鈕，防止重複提交
        btnSend.disabled = true;

        // 獲取表單數據
        const formData = new FormData(document.getElementById('branchForm'));

        // 處理座標數據
        const coordinates = formData.get('coordinates').trim();
        const [latitude, longitude] = coordinates.split(',').map(coord => coord.trim());

        // 移除原始的 coordinates 欄位
        formData.delete('coordinates');

        // 添加拆分後的緯度和經度
        formData.append('latitude', latitude);
        formData.append('longitude', longitude);

        // 發送請求
        fetch(saveURL, {
          method: 'POST',
          body: formData
        })
          .then(response => response.json())
          .then(data => {
          if (data.success) {
              alert(data.message || '操作成功');
            window.location.href = './index.php';
            } else {
              alert(data.message || '操作失敗');
            btnSend.disabled = false;
            }
          })
          .catch(error => {
            console.error('Error:', error);
            alert('發生錯誤，請稍後再試');
          btnSend.disabled = false;
          });
      });

      // ===== 表單驗證 =====
      function validateForm() {
        const name = document.querySelector('[name="name"]').value.trim();
        const address = document.querySelector('[name="address"]').value.trim();
        const phone = document.querySelector('[name="phone"]').value.trim();
        const coordinates = document.querySelector('[name="coordinates"]').value.trim();
        const businessHours = document.querySelector('[name="business_hours"]').value.trim();
        const services = document.querySelectorAll('[name="services[]"]:checked');
        const weekdays = document.querySelectorAll('[name="weekdays[]"]:checked');

        if (!name) {
          alert('請輸入店名');
          return false;
        }
        if (!address) {
          alert('請輸入地址');
          return false;
        }
        if (!phone) {
          alert('請輸入電話');
          return false;
        }
        if (!coordinates) {
          alert('請輸入座標');
          return false;
        }
        // 驗證座標格式
        const coordPattern = /^-?\d+\.\d+,\s*-?\d+\.\d+$/;
        if (!coordPattern.test(coordinates)) {
          alert('座標格式不正確，請使用「緯度, 經度」的格式，例如：25.033964, 121.564472');
          return false;
        }
        if (!businessHours) {
          alert('請輸入營業時間');
          return false;
        }
        if (services.length === 0) {
          alert('請至少選擇一項服務');
          return false;
        }
        if (weekdays.length === 0) {
          alert('請至少選擇一個營業星期');
          return false;
        }

        return true;
      }

      // 圖片預覽和上傳處理
      document.getElementById('coverFileInput').addEventListener('change', async function(e) {
        const files = e.target.files;
        const previewContainer = document.getElementById('imagePreviewContainer');

        for (let file of files) {
            if (file.type.startsWith('image/')) {
                const formData = new FormData();
                formData.append('upload', file);

                try {
                    const response = await fetch('./upload.php', {
                        method: 'POST',
                        body: formData
                    });
                    const result = await response.json();

                    if (result.uploaded) {
                        const timestamp = Date.now();
                        const div = document.createElement('div');
                        div.className = 'position-relative';
                        div.innerHTML = `
                            <img src="${result.url}" alt="預覽圖片" class="img-thumbnail" style="width: 150px; height: 150px; object-fit: cover;">
                            <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1" onclick="removeImage(this)">×</button>
                            <input type="hidden" name="images[new_${timestamp}][url]" value="${result.url}">
                            <input type="hidden" name="images[new_${timestamp}][description]" value="photo of shop">
                        `;
                        previewContainer.appendChild(div);
                    } else {
                        alert(result.error?.message || '圖片上傳失敗');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('圖片上傳失敗，請稍後再試');
                }
            }
        }
      });

      // 移除圖片
      function removeImage(button, imageId = null) {
        if (imageId) {
            // 如果是已存在的圖片，添加到待刪除列表
            const deleteInput = document.createElement('input');
            deleteInput.type = 'hidden';
            deleteInput.name = 'delete_images[]';
            deleteInput.value = imageId;
            document.getElementById('branchForm').appendChild(deleteInput);
        }
        button.parentElement.remove();
      }

      // 初始化時間選擇器
      let timeRanges = [];
      const businessHoursInput = document.getElementById('businessHours');
      const timeRangesContainer = document.getElementById('timeRanges');

      // 解析現有的營業時間
      if (businessHoursInput.value) {
          timeRanges = businessHoursInput.value.split(';').filter(range => range.trim());
          updateTimeRangesDisplay();
      }

      // 初始化開始時間選擇器
      const startTimePicker = flatpickr("#startTime", {
          enableTime: true,
          noCalendar: true,
          dateFormat: "H:i",
          time_24hr: true,
          locale: "zh-tw",
          minuteIncrement: 30,
          defaultHour: 9,
          defaultMinute: 30
      });

      // 初始化結束時間選擇器
      const endTimePicker = flatpickr("#endTime", {
          enableTime: true,
          noCalendar: true,
          dateFormat: "H:i",
          time_24hr: true,
          locale: "zh-tw",
          minuteIncrement: 30,
          defaultHour: 18,
          defaultMinute: 30
      });

      // 添加時段按鈕點擊事件
      document.getElementById('addTimeRange').addEventListener('click', function() {
          const startTime = startTimePicker.selectedDates[0];
          const endTime = endTimePicker.selectedDates[0];

          if (!startTime || !endTime) {
              alert('請選擇開始和結束時間');
              return;
          }

          const timeRange = `${formatTime(startTime)}-${formatTime(endTime)}`;

          // 檢查時間範圍是否有效
          if (startTime >= endTime) {
              alert('結束時間必須晚於開始時間');
              return;
          }

          // 檢查是否與現有時間範圍重疊
          if (isTimeRangeOverlap(timeRange)) {
              alert('此時間範圍與現有時間範圍重疊');
              return;
          }

          if (!timeRanges.includes(timeRange)) {
              timeRanges.push(timeRange);
              updateTimeRangesDisplay();
          }
      });

      // 格式化時間
      function formatTime(date) {
          return date.toLocaleTimeString('zh-TW', {
              hour: '2-digit',
              minute: '2-digit',
              hour12: false
          });
      }

      // 檢查時間範圍是否重疊
      function isTimeRangeOverlap(newRange) {
          const [newStart, newEnd] = newRange.split('-').map(time => {
              const [hours, minutes] = time.split(':').map(Number);
              return hours * 60 + minutes;
          });

          return timeRanges.some(range => {
              const [start, end] = range.split('-').map(time => {
                  const [hours, minutes] = time.split(':').map(Number);
                  return hours * 60 + minutes;
              });

              return (newStart >= start && newStart < end) ||
                     (newEnd > start && newEnd <= end) ||
                     (newStart <= start && newEnd >= end);
          });
      }

      // 更新時段顯示
      function updateTimeRangesDisplay() {
          timeRangesContainer.innerHTML = '';
          timeRanges.forEach((range, index) => {
              const div = document.createElement('div');
              div.className = 'd-flex align-items-center gap-2 mb-2';
              div.innerHTML = `
                  <span class="badge bg-primary">${range}</span>
                  <button type="button" class="btn btn-sm btn-danger" onclick="removeTimeRange(${index})">
                      <i class="fas fa-times"></i>
                  </button>
              `;
              timeRangesContainer.appendChild(div);
          });

          // 更新隱藏輸入框的值
          businessHoursInput.value = timeRanges.join(';');
      }

      // 移除時段
      function removeTimeRange(index) {
          timeRanges.splice(index, 1);
          updateTimeRangesDisplay();
      }
    </script>


<?php
include "../template_btm.php";
?>
