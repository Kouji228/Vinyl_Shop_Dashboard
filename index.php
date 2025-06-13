<?php
require_once "components/Utilities.php";
require_once "components/connect.php";
include "vars.php";
$cssList = ["css/index.css"];
include "template_top.php";
include "template_main.php";

// Get counts from different sections
try {
    // Get total users count
    $sqlUsers = "SELECT COUNT(*) as total FROM users WHERE is_valid = 1";
    $stmtUsers = $pdo->prepare($sqlUsers);
    $stmtUsers->execute();
    $usersCount = $stmtUsers->fetch(PDO::FETCH_ASSOC)['total'];

    // Get total products count
    $sqlProducts = "SELECT COUNT(*) as total FROM vinyl WHERE status_id = 1";
    $stmtProducts = $pdo->prepare($sqlProducts);
    $stmtProducts->execute();
    $productsCount = $stmtProducts->fetch(PDO::FETCH_ASSOC)['total'];

    // Get total old vinyl count
    $sqlOldVinyl = "SELECT COUNT(*) as total FROM o_vinyl WHERE is_valid = 1";
    $stmtOldVinyl = $pdo->prepare($sqlOldVinyl);
    $stmtOldVinyl->execute();
    $oldVinylCount = $stmtOldVinyl->fetch(PDO::FETCH_ASSOC)['total'];

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>

<div class="dashboard-bg">
  <div class="dashboard-grid">
    <!-- Top 4 Stat Cards -->
    <div class="stat-card stat-blue">
      <div class="stat-label">NEW USERS</div>
      <div class="stat-value"><?= $usersCount ?></div>
    </div>
    <div class="stat-card stat-green">
      <div class="stat-label">FOLLOWERS</div>
      <div class="stat-value"><?= $productsCount ?></div>
    </div>
    <div class="stat-card stat-pink">
      <div class="stat-label">TOTAL SALES</div>
      <div class="stat-value"><?= $oldVinylCount ?></div>
    </div>
    <div class="stat-card stat-yellow">
      <div class="stat-label">NEW FAVS</div>
      <div class="stat-value">245,324</div>
    </div>
    <!-- Monthly Visits Bar Chart (Fake) -->
    <div class="chart-card chart-wide">
      <div class="chart-title chart-pink">MONTHLY VISITS</div>
      <div class="bar-chart">
        <div class="bar bar-blue" style="height: 60%"></div>
        <div class="bar bar-yellow" style="height: 45%"></div>
        <div class="bar bar-green" style="height: 30%"></div>
        <div class="bar bar-pink" style="height: 55%"></div>
        <div class="bar bar-blue" style="height: 80%"></div>
        <div class="bar bar-yellow" style="height: 50%"></div>
        <div class="bar bar-green" style="height: 40%"></div>
        <div class="bar bar-pink" style="height: 70%"></div>
      </div>
    </div>
    <!-- Sales Progress Bars -->
    <div class="chart-card">
      <div class="chart-title chart-blue">SALES</div>
      <div class="progress-label">Lorem</div>
      <div class="progress-bar"><div class="progress-fill bar-pink" style="width: 60%"></div></div>
      <div class="progress-label">Ipsum</div>
      <div class="progress-bar"><div class="progress-fill bar-yellow" style="width: 80%"></div></div>
      <div class="progress-label">Sit amet</div>
      <div class="progress-bar"><div class="progress-fill bar-blue" style="width: 50%"></div></div>
      <div class="progress-label">Consectetuer</div>
      <div class="progress-bar"><div class="progress-fill bar-green" style="width: 90%"></div></div>
    </div>
    <!-- Sales Line Chart (Fake) -->
    <div class="chart-card">
      <div class="chart-title chart-green">SALES</div>
      <svg viewBox="0 0 200 60" class="line-chart">
        <polyline fill="none" stroke="#1de9b6" stroke-width="4" points="0,50 20,40 40,45 60,30 80,35 100,20 120,25 140,10 160,20 180,5 200,15"/>
        <line x1="0" y1="55" x2="200" y2="55" stroke="#eee" stroke-width="1"/>
      </svg>
    </div>
    <!-- Sections Donut Chart (Fake) -->
    <div class="chart-card">
      <div class="chart-title chart-yellow">SECTIONS</div>
      <svg viewBox="0 0 60 60" class="donut-chart">
        <circle cx="30" cy="30" r="25" fill="none" stroke="#eee" stroke-width="8"/>
        <circle cx="30" cy="30" r="25" fill="none" stroke="#ffb300" stroke-width="8" stroke-dasharray="40 120" stroke-dashoffset="0"/>
        <circle cx="30" cy="30" r="25" fill="none" stroke="#ff4081" stroke-width="8" stroke-dasharray="30 130" stroke-dashoffset="-40"/>
        <circle cx="30" cy="30" r="25" fill="none" stroke="#1de9b6" stroke-width="8" stroke-dasharray="20 140" stroke-dashoffset="-70"/>
        <circle cx="30" cy="30" r="25" fill="none" stroke="#448aff" stroke-width="8" stroke-dasharray="30 130" stroke-dashoffset="-90"/>
      </svg>
    </div>
    <!-- New Users List -->
    <div class="chart-card">
      <div class="chart-title chart-pink">NEW USERS</div>
      <div class="user-list">
        <div class="user-row"><span>Lorem ipsum</span><span>$5.25</span></div>
        <div class="user-row"><span>Sit amet</span><span>$4.35</span></div>
        <div class="user-row"><span>Consectetuer</span><span>$3.75</span></div>
        <div class="user-row"><span>Adipiscing</span><span>$2.55</span></div>
        <div class="user-row"><span>Lorem ipsum</span><span>$6.45</span></div>
      </div>
      <button class="read-more">READ MORE</button>
    </div>
  </div>
</div>

<style>
.dashboard-bg {
  background: #181e2a;
  min-height: 100vh;
  padding: 40px 0;
}
.dashboard-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  grid-template-rows: 120px 220px 180px;
  gap: 24px;
  max-width: 1200px;
  margin: 0 auto;
}
.stat-card {
  border-radius: 16px;
  background: #fff;
  box-shadow: 0 2px 8px rgba(0,0,0,0.08);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  font-family: 'Montserrat', Arial, sans-serif;
  font-weight: 600;
  font-size: 1.1rem;
  letter-spacing: 1px;
}
.stat-label {
  font-size: 1rem;
  opacity: 0.7;
  margin-bottom: 6px;
}
.stat-value {
  font-size: 2.1rem;
  font-weight: 700;
  letter-spacing: 2px;
}
.stat-blue { border-top: 8px solid #448aff; }
.stat-green { border-top: 8px solid #1de9b6; }
.stat-pink { border-top: 8px solid #ff4081; }
.stat-yellow { border-top: 8px solid #ffb300; }

.chart-card {
  border-radius: 16px;
  background: #fff;
  box-shadow: 0 2px 8px rgba(0,0,0,0.08);
  padding: 18px 22px 18px 22px;
  display: flex;
  flex-direction: column;
  justify-content: flex-start;
  font-family: 'Montserrat', Arial, sans-serif;
  font-size: 1rem;
  position: relative;
}
.chart-wide {
  grid-column: span 2;
  grid-row: 2 / 3;
}
.chart-title {
  font-size: 1.1rem;
  font-weight: 700;
  margin-bottom: 12px;
  letter-spacing: 1px;
  text-align: left;
}
.chart-pink { color: #ff4081; }
.chart-blue { color: #448aff; }
.chart-green { color: #1de9b6; }
.chart-yellow { color: #ffb300; }

.bar-chart {
  display: flex;
  align-items: flex-end;
  height: 120px;
  gap: 10px;
  width: 100%;
  margin-top: 10px;
}
.bar {
  width: 18px;
  border-radius: 8px 8px 0 0;
  background: #eee;
  transition: height 0.3s;
}
.bar-blue { background: #448aff; }
.bar-green { background: #1de9b6; }
.bar-pink { background: #ff4081; }
.bar-yellow { background: #ffb300; }

.progress-label {
  font-size: 0.95rem;
  margin-top: 8px;
  margin-bottom: 2px;
  color: #333;
}
.progress-bar {
  background: #eee;
  border-radius: 8px;
  height: 12px;
  margin-bottom: 8px;
  width: 100%;
  overflow: hidden;
}
.progress-fill {
  height: 100%;
  border-radius: 8px;
}

.line-chart {
  width: 100%;
  height: 60px;
  margin-top: 10px;
}
.donut-chart {
  width: 80px;
  height: 80px;
  display: block;
  margin: 0 auto;
}
.user-list {
  margin-top: 8px;
}
.user-row {
  display: flex;
  justify-content: space-between;
  font-size: 1rem;
  margin-bottom: 6px;
  color: #333;
}
.read-more {
  margin-top: 12px;
  background: #ff4081;
  color: #fff;
  border: none;
  border-radius: 8px;
  padding: 6px 18px;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  transition: background 0.2s;
}
.read-more:hover {
  background: #e73370;
}
@media (max-width: 1100px) {
  .dashboard-grid {
    grid-template-columns: repeat(2, 1fr);
    grid-template-rows: repeat(6, 180px);
  }
  .chart-wide {
    grid-column: span 2;
  }
}
@media (max-width: 700px) {
  .dashboard-grid {
    grid-template-columns: 1fr;
    grid-template-rows: repeat(10, 160px);
    gap: 16px;
  }
  .chart-wide {
    grid-column: span 1;
  }
}
</style>

<?php include "template_btm.php"; ?>
