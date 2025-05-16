<?php
require 'authentication.php';

// Assuming the user ID is stored in the session after login
$user_id = $_SESSION['admin_id'];

// Fetch the user's avatar from the database based on the logged-in user
$sql = "SELECT profile_image, username, fullname FROM tbl_admin WHERE user_id = :user_id";
$stmt = $obj_admin->db->prepare($sql);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();

// Fetch the user's avatar path
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$profile_img = $user['profile_image']; // Assuming 'avatar' is the column storing the image path
$username = $user['username'];
$fullname = $user['fullname'];

// Set a fallback image if no avatar is found
if (empty($profile_img)) {
    $profile_img = 'assets/img/avtar.jpg'; // Default avatar image
}

include 'header.php';
?>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="assets/img/denrlogo1.0.svg" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="dashboard.php" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="dashboard.php" class="brand-link">
      <img src="assets/img/denr.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-dark">DENR-R8 DVTS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <!-- Display profile image, default to avatar.jpg if not found -->
          <img src="<?php echo $profile_img; ?>" class="img-circle elevation-2" alt="User Image" onerror="this.onerror=null;this.src='assets/img/avtar.jpg';">
        </div>
        <div class="info">
          <!-- Display the user's full name -->
          <a href="profile.php" class="d-block"><?php echo $fullname; ?></a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="dashboard.php" class="nav-link <?php if($page_name=='dashboard') echo 'active'; ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <!-- Task Management -->
          <?php $tasks = ['pending-dv','dv-registry','completed-dv']; $open   = in_array($page_name, $tasks);?>
          <li class="nav-item <?php if($open) echo 'menu-open'; ?>">
            <a href="#" class="nav-link <?php if($open) echo 'active'; ?>">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Task Management
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="pending-dv.php" class="nav-link <?php if($page_name=='pending-dv') echo 'active'; ?>">
                  <i class="nav-icon fas fa-hourglass-half"></i>
                  <p>Pending DV</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="dv-registry.php" class="nav-link <?php if($page_name=='dv-registry') echo 'active'; ?>">
                  <i class="nav-icon fas fa-clipboard-list"></i>
                  <p>DV Registry</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="completed-dv.php" class="nav-link <?php if($page_name=='completed-dv') echo 'active'; ?>">
                  <i class="nav-icon fas fa-check-circle"></i>
                  <p>Completed DV</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="transmittal-report.php" class="nav-link">
              <i class="nav-icon fas fa-exchange-alt"></i>
              <p>
                Transmittal Report
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <!-- Administration -->
          <?php  if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 1):
            $tasks = ['manage-admin','manage-employee','manage-payee','manage-transaction']; $open   = in_array($page_name, $tasks);?>
          <li class="nav-item <?php if($open) echo 'menu-open'; ?>">
            <a href="#" class="nav-link <?php if($open) echo 'active'; ?>">
              <i class="nav-icon fas fa-tools"></i>
              <p>
                Administrator
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">4</span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="manage-admin.php" class="nav-link <?php if($page_name=='manage-admin') echo 'active'; ?>">
                  <i class="nav-icon fas fa-user-cog"></i>
                  <p>Manage Admin</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="manage-employee.php" class="nav-link <?php if($page_name=='manage-employee') echo 'active'; ?>">
                  <i class="nav-icon fas fa-users"></i>
                  <p>Manage Employee</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="manage-payee.php" class="nav-link <?php if($page_name=='manage-payee') echo 'active'; ?>">
                  <i class="nav-icon fas fa-address-book"></i>
                  <p>Manage Payee</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="manage-transaction.php" class="nav-link <?php if($page_name=='manage-transaction') echo 'active'; ?>">
                  <i class="nav-icon fas fa-money-check-alt"></i>
                  <p>Manage Transaction</p>
                </a>
              </li>
            </ul>
          </li>
          <?php endif ?>
          <li class="nav-item">
            <a href="?logout=logout" class="nav-link" onclick="return confirm('Are you sure you want to log out?');">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p>Logout</p>
            </a>
            </li>
          </li>
        </ul>
      </nav>

<?php include 'footer.php'; ?>
