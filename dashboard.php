<?php
require 'authentication.php';
require_once 'db_conn.php';

// auth check   
$user_id = $_SESSION['admin_id'];
$user_name = $_SESSION['name'];
$department_id = $_SESSION['department_id'];
$security_key = $_SESSION['security_key'];
if ($user_id == NULL || $security_key == NULL) {
  header('Location: index.php');
}
$user_role = $_SESSION['user_role'];
// Define the transaction types
$transaction_types = [
  1 => 'Allowances/Others',
  2 => 'CA (Prepayments)',
  3 => 'CA (SDO)',
  4 => 'General Services',
  5 => 'Other Professional Services',
  6 => 'Procurement',
  7 => 'Refund',
  8 => 'Registration Fees',
  9 => 'Remittances',
  10 => 'Salaries and Wages',
  11 => 'TVE',
  12 => 'Utility Expenses (Bills)',
];

// Prepare an array to hold counts for each transaction type
$voucher_counts = [];

// Query to get the count of vouchers by transaction type
foreach ($transaction_types as $transaction_id => $transaction_name) {
  $query = "SELECT COUNT(*) FROM task_info WHERE transaction_id = $transaction_id";
  $result = mysqli_query($conn, $query);
  if ($result) {
      $count = mysqli_fetch_array($result)[0];
      $voucher_counts[$transaction_name] = $count;
  }
}

// Query to get the total number of vouchers
$total_vouchers_query = "SELECT COUNT(*) FROM task_info";
$completed_query = "SELECT COUNT(*) FROM task_info WHERE status = 3";
$paid_query = "SELECT COUNT(*) FROM task_info WHERE status = 2";
$in_progress_query = "SELECT COUNT(*) FROM task_info WHERE status = 0";
$non_compliant_query = "SELECT COUNT(*) FROM task_info WHERE status = 1";

// Execute queries and fetch the counts
$total_vouchers_result = mysqli_query($conn, $total_vouchers_query);
$completed_result = mysqli_query($conn, $completed_query);
$paid_result = mysqli_query($conn, $paid_query);
$in_progress_result = mysqli_query($conn, $in_progress_query);
$non_compliant_result = mysqli_query($conn, $non_compliant_query);

$total_vouchers = mysqli_fetch_array($total_vouchers_result)[0];
$completed_vouchers = mysqli_fetch_array($completed_result)[0];
$paid_vouchers = mysqli_fetch_array($paid_result)[0];
$in_progress_vouchers = mysqli_fetch_array($in_progress_result)[0];
$non_compliant_vouchers = mysqli_fetch_array($non_compliant_result)[0];

// Initialize an array for monthly voucher counts by status
$monthly_data = [
  'For Compliance' => array_fill(1, 12, 0),
  'In Progress' => array_fill(1, 12, 0),
  'Paid' => array_fill(1, 12, 0),
  'Completed' => array_fill(1, 12, 0)
];

// Fetch vouchers grouped by month and status
$line_query = "
  SELECT 
      MONTH(t_start_time) AS month,
      YEAR(t_start_time) AS year,
      status,
      COUNT(*) AS count
  FROM task_info
  WHERE t_start_time IS NOT NULL
  GROUP BY YEAR(t_start_time), MONTH(t_start_time), status
  ORDER BY year, month
";

$line_result = mysqli_query($conn, $line_query);

// Assume the year of the first entry as the chart's title year
$chart_year = null;
$found_first_year = false;

while ($row = mysqli_fetch_assoc($line_result)) {
  $month = (int)$row['month'];
  $year = (int)$row['year'];
  $status = (int)$row['status'];
  $count = (int)$row['count'];

  if (!$found_first_year) {
      $chart_year = $year;
      $found_first_year = true;
  }

  switch ($status) {
      case 0:
          $monthly_data['In Progress'][$month] = $count;
          break;
      case 1:
          $monthly_data['For Compliance'][$month] = $count;
          break;
      case 2:
          $monthly_data['Paid'][$month] = $count;
          break;
      case 3:
          $monthly_data['Completed'][$month] = $count;
          break;
  }
}

// Generate month-year labels using the chart year
$monthYearLabels = [];
for ($i = 1; $i <= 12; $i++) {
  $monthYearLabels[] = date("M $chart_year", mktime(0, 0, 0, $i, 1));
}

// Close the database connection
mysqli_close($conn);
include 'include/header.php';
$page_name = "dashboard";
include 'include/sidebar.php';
?>
  <title>DENR-R8 DVTS | Dashboard</title>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Dashboard</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-info"><i class="fas fa-file-invoice-dollar"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Vouchers</span>
                <span class="info-box-number"><?= $total_vouchers; ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-success"><i class="far fa-check-circle"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Completed Vouchers</span>
                <span class="info-box-number"><?= $completed_vouchers; ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-primary"><i class="fas fa-money-bill-wave"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Paid Vouchers</span>
                <span class="info-box-number"><?= $paid_vouchers; ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-danger"><i class="fas fa-exclamation-circle"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">For Compliance Vouchers</span>
                <span class="info-box-number"><?= $non_compliant_vouchers; ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
                    <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-warning"><i class="fas fa-spinner fa-spin"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">In Progress Vouchers</span>
                <span class="info-box-number"><?= $in_progress_vouchers; ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
        <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            <!-- AREA CHART -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Area Chart</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="areaChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- DONUT CHART -->
            <div class="card card-danger">
              <div class="card-header">
                <h3 class="card-title">Donut Chart</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col (LEFT) -->
          <div class="col-md-6">

            <!-- STACKED BAR CHART -->
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Stacked Bar Chart</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="stackedBarChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

          </div>
          <!-- /.col (RIGHT) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
     <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<?php include 'include/footer.php'; ?>
<!-- Page specific script -->

<?php
  $currentMonth = (int)date('n'); // Current month number (1-12)
  $monthYearLabels = [];

  for ($i = 1; $i <= $currentMonth; $i++) {
    $monthYearLabels[] = date('M Y', mktime(0, 0, 0, $i, 1)); // Format: Jan 2025, Feb 2025, etc.
  }
?>

<script>
  // Month-Year Labels for X-axis
  const monthLabels = <?= json_encode($monthYearLabels); ?>;

  // Area Chart Data (total count per month across all statuses)
  const areaChartData = {
    labels: monthLabels,
    datasets: [{
      borderColor: 'rgba(60,141,188,0.8)',
      pointRadius: false,
      data: [
        <?php
          for ($i = 1; $i <= $currentMonth; $i++) {
            $total = ($monthly_data['In Progress'][$i] ?? 0) +
                     ($monthly_data['For Compliance'][$i] ?? 0) +
                     ($monthly_data['Paid'][$i] ?? 0) +
                     ($monthly_data['Completed'][$i] ?? 0);
            echo $total . ',';
          }
        ?>
      ]
    }]
  };
  const areaChartOptions = {
  responsive: true,
  scales: {
    x: {
      grid: {
        display: false // 🔴 Remove vertical lines
      }
    },
    y: {
      beginAtZero: true, // 🔵 Start Y-axis at 0
      ticks: {
        stepSize: 1,     // 🔵 Whole numbers only
        precision: 0     // 🔵 No decimal places
      }
    }
  }
};
  // Donut Chart Data
  const donutData = {
    labels: <?= json_encode(array_keys($voucher_counts)); ?>,
    datasets: [{
      data: <?= json_encode(array_values($voucher_counts)); ?>,
      backgroundColor: [
        '#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc',
        '#d2d6de', '#8e44ad', '#16a085', '#e74c3c', '#3498db',
        '#e67e22', '#1abc9c'
      ]
    }]
  };

  // Stacked Bar Chart Data
  const stackedBarData = {
    labels: <?= json_encode(array_keys($voucher_counts)); ?>,
    datasets: [{
      data: <?= json_encode(array_values($voucher_counts)); ?>,
      backgroundColor: [
        '#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc',
        '#d2d6de', '#8e44ad', '#16a085', '#e74c3c', '#3498db',
        '#e67e22', '#1abc9c'
      ]
    }]
  };

  // Chart Init
  $(function () {
    // AREA CHART
    var areaChartCanvas = $('#areaChart').get(0).getContext('2d');
    new Chart(areaChartCanvas, {
      type: 'line',
      data: areaChartData,
      options: {
        responsive: true,
        maintainAspectRatio: false,
        datasetFill: false
      }
    });

    // DONUT CHART
    var donutChartCanvas = $('#donutChart').get(0).getContext('2d');
    new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: {
        maintainAspectRatio: false,
        responsive: true,
      }
    });

    // STACKED BAR CHART
    var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d');
    new Chart(stackedBarChartCanvas, {
      type: 'bar',
      data: stackedBarData,
      options: {
        maintainAspectRatio: false,
        responsive: true,
      }
    });
  });
</script>
