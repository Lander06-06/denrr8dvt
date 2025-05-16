<?php
require 'authentication.php'; // admin authentication check 
require 'db_conn.php';

// auth check
  $user_id = $_SESSION['admin_id'];
  $user_name = $_SESSION['name'];
  $department_id = $_SESSION['department_id'];
  $security_key = $_SESSION['security_key'];
if ($user_id == NULL || $security_key == NULL) {
    header('Location: index.php');
}

// check admin
  $user_role = $_SESSION['user_role'];


  if (isset($_GET['delete_task'])) {
    $action_id = $_GET['task_id'];

    // Fetch dv_no before deleting
    $stmt = $conn->prepare("SELECT dv_no FROM task_info WHERE task_id = ?");
    $stmt->bind_param("i", $action_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $task = $result->fetch_assoc();
    $dv_no = $task['dv_no'] ?? 'N/A';

    // Toast with dv_no
    $_SESSION['toast_message'] = "Task with DV No. {$dv_no} deleted successfully!";
    $_SESSION['toast_type'] = "success"; // can be "info", "error", etc.

    // Proceed with deletion
    $sql = "DELETE FROM task_info WHERE task_id = :id";
    $sent_po = "completed-dv.php";
    $obj_admin->delete_data_by_this_method($sql, $action_id, $sent_po);
    exit();
}

if (isset($_POST['add_task_post'])) {
    // Add new task
    $obj_admin->add_new_task($_POST);

    // Get the assign_to ID and DV number from POST
    $assign_to_id = $_POST['assign_to'];  // This is the ID of the user
    $dv_no = $_POST['dv_no'];

    // Fetch the full name of the user based on the ID
    $stmt = $conn->prepare("SELECT fullname FROM tbl_admin WHERE user_id = ?");
    $stmt->bind_param("i", $assign_to_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    // Check if a full name was found
    $assign_to = $user['fullname'] ?? 'Unknown';  // Default to 'Unknown' if not found

    // Fetch the payee email based on the payee ID or task information
    $payee_id = $_POST['payee_id'];  // Assuming you're sending the payee_id from the form

    $stmt_payee = $conn->prepare("SELECT payee_email FROM payee WHERE payee_id = ?");
    $stmt_payee->bind_param("i", $payee_id);
    $stmt_payee->execute();
    $result_payee = $stmt_payee->get_result();
    $payee = $result_payee->fetch_assoc();
    
    // Get the payee email
    $payee_email = $payee['payee_email'] ?? ''; // Default to empty if not found

    // Format the toast message
    $_SESSION['toast_message'] = "Task added successfully and assigned to {$assign_to} with DV No. {$dv_no}.";
    $_SESSION['toast_type'] = "success";

    exit();
}

  $page_name="completed-dv";
  include("include/header.php");
include("include/sidebar.php");
?>
  <title>DENR-R8 DVTS | COMPLETED DV</title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Completed DV Table</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Completed DV Table</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
        <!-- Main content -->
        <section class="content">
    <div class="container-fluid">
        <div class="row">
        <div class="col-12">
            <div class="card">
            <div class="card-header">
                <h3 class="card-title">List of Completed DV's</h3>
            </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>Date of Creation</th>
                        <th>DV No.</th>
                        <th>Created by</th>
                        <th>JEV No.</th>
                        <th>Payee Name</th>
                        <th class="description-column">DV Description</th>
                        <th>Net Amount</th>
                        <th>ACIC Batch No.</th>
                        <th>Transaction Ref No.</th>
                        <th>Assign To</th>
                        <th>Status</th>
                        <th>Location</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
                        if ($user_role == 1) {
                            $sql = "SELECT a.*, creator.fullname AS created_by_fullname, 
                            creator.profile_image AS created_by_profile_image,
                            assignee.fullname AS assigned_to_fullname, 
                            assignee.profile_image AS assigned_to_profile_image,
                            c.payee_name, 
                            c.payee_email
                            FROM task_info a
                            LEFT JOIN tbl_admin creator ON a.created_by = creator.user_id
                            LEFT JOIN tbl_admin assignee ON a.t_user_id = assignee.user_id
                            LEFT JOIN payee c ON a.payee_sms_id = c.payee_sms_id
                            WHERE a.status = 3
                            ORDER BY a.task_id DESC";
                        } else {
                            $sql = "SELECT a.*, creator.fullname AS created_by_fullname, 
                            creator.profile_image AS created_by_profile_image,
                            assignee.fullname AS assigned_to_fullname, 
                            assignee.profile_image AS assigned_to_profile_image,
                            c.payee_name, 
                            c.payee_email
                            FROM task_info a
                            LEFT JOIN tbl_admin creator ON a.created_by = creator.user_id
                            LEFT JOIN tbl_admin assignee ON a.t_user_id = assignee.user_id
                            LEFT JOIN payee c ON a.payee_sms_id = c.payee_sms_id
                            WHERE a.t_department_id = $department_id AND a.status = 3
                            ORDER BY a.task_id DESC";
                        }
                        $info = $obj_admin->manage_all_info($sql);
                        $serial  = 1;
                        $num_row = $info->rowCount();
                        
                        if ($num_row == 0) {
                            echo '<tr><td colspan="14" class="text-center">
                                    <img src="https://i.gifer.com/VAyR.gif" alt="Loading..." width="30"><br>
                                    <span style="color: #777;">No Data found</span>
                                </td></tr>';
                        }
                        
                        while ($row = $info->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        
                        <tr>
                            <td><?php echo $serial++; ?></td>
                            <td><?php echo $row['t_start_time']; ?></td>
                            <td><?php echo $row['dv_no']; ?></td>
                            <td class="text-center">
                                <div>
                                    <img 
                                        src="<?php echo !empty($row['created_by_fullname']) ? htmlspecialchars($row['created_by_profile_image']) : 'assets/img/avtar.jpg'; ?>" 
                                        class="img-circle elevation-2" 
                                        alt="User Image" 
                                        onerror="this.onerror=null;this.src='assets/img/avtar.jpg';"
                                        style="width:60px; height:60px; object-fit:cover;"
                                    >
                                </div>
                                <div class="mt-1">
                                    <?php echo htmlspecialchars($row['created_by_fullname']); ?>
                                </div>
                            </td>
                            <td><?php echo $row['jev_no']; ?></td>
                            <td><?php echo $row['payee_name']; ?></td>
                            <td class="description-column"><?php echo $row['t_description']; ?></td>
                            <td><?php echo number_format($row['net_amount'], 2); ?></td>
                            <td><?php echo $row['acic_batch_no']; ?></td>
                            <td><?php echo $row['transaction_ref_no']; ?></td>
                            <td class="text-center">
                                <div>
                                    <img 
                                        src="<?php echo !empty($row['assigned_to_profile_image']) ? htmlspecialchars($row['assigned_to_profile_image']) : 'assets/img/avtar.jpg'; ?>" 
                                        class="img-circle elevation-2" 
                                        alt="User Image" 
                                        onerror="this.onerror=null;this.src='assets/img/avtar.jpg';"
                                        style="width:60px; height:60px; object-fit:cover;"
                                    >
                                </div>
                                <div class="mt-1">
                                    <?php echo htmlspecialchars($row['assigned_to_fullname']); ?>
                                </div>
                            </td>
                            <td>
                                <?php  if($row['status'] == 1){
                                    echo "<span class='badge bg-danger'><i class='fas fa-times-circle'></i> For Compliance</span>";
                                }elseif($row['status'] == 2){
                                    echo "<span class='badge bg-success'><i class='fas fa-check-circle'></i> Paid</span>";
                                }elseif($row['status'] == 3){
                                    echo "<span class='badge bg-success'><i class='fas fa-check-circle'></i> Completed</span>";
                                }else{
                                    echo "<span class='badge bg-warning text-dark'><i class='fas fa-sync-alt'></i> In Progress</span>";
                                } ?>
                                
                            </td>
                            <td>
                            <?php  
                                // Compact department mapping: label (for background), short name, full name
                                $departments = [
                                    1 => ['label' => 'bg-primary',   'short' => 'ORD',     'name' => 'Office of the Regional Director'],
                                    2 => ['label' => 'bg-info',      'short' => 'ARD-MS',  'name' => 'ARD for Management Services'],
                                    3 => ['label' => 'bg-success',   'short' => 'ARD-TS',  'name' => 'ARD for Technical Services'],
                                    4 => ['label' => 'bg-warning',   'short' => 'PMD',     'name' => 'Planning and Management Division'],
                                    5 => ['label' => 'bg-secondary', 'short' => 'Finance', 'name' => 'Finance Division'],
                                    6 => ['label' => 'bg-danger',    'short' => 'Acctg',   'name' => 'Accounting Section'],
                                    7 => ['label' => 'bg-danger',    'short' => 'Budget',  'name' => 'Budget Section'],
                                    8 => ['label' => 'bg-danger',    'short' => 'Legal',   'name' => 'Legal Division'],
                                    9 => ['label' => 'bg-danger',    'short' => 'Admin',   'name' => 'Administrative Division'],
                                    10 => ['label' => 'bg-danger',   'short' => 'Proc',    'name' => 'Procurement Section'],
                                    11 => ['label' => 'bg-danger',   'short' => 'Cashier', 'name' => 'Cashier Section'],
                                    12 => ['label' => 'bg-success',  'short' => 'CDD',     'name' => 'Conservation and Development Division'],
                                    13 => ['label' => 'bg-success',  'short' => 'SMD',     'name' => 'Survey and Mapping Division'],
                                    14 => ['label' => 'bg-success',  'short' => 'LPDD',    'name' => 'Licenses, Patents and Deeds Division'],
                                    15 => ['label' => 'bg-default',  'short' => 'Enforce', 'name' => 'Enforcement Division'],
                                    16 => ['label' => 'bg-default',  'short' => 'COA',     'name' => 'Commission on Audit Division'],
                                    17 => ['label' => 'bg-default',  'short' => 'NGP',     'name' => 'NGP'],
                                    18 => ['label' => 'bg-dark',     'short' => 'None',    'name' => 'No Division']
                                ];

                                $department_id = $row['t_department_id'];
                                if (array_key_exists($department_id, $departments)) {
                                    $department = $departments[$department_id];
                                    echo "<span class='badge {$department['label']}' data-toggle='tooltip' title='{$department['name']}'>
                                            {$department['short']}
                                        </span>";
                                } else {
                                    echo "<span class='badge bg-secondary' data-toggle='tooltip' title='Unknown Department'>
                                            Unknown
                                        </span>";
                                }
                            ?>
                            </td>
            
                            <td>
                                <div class="action-buttons">
                                    <?php if ($user_role == 1) { ?>
                                        <!-- Admin -->
                                        <a title="Update Task" href="edit-task.php?task_id=<?php echo $row['task_id']; ?>" class="btn btn-block btn-outline-primary">
                                            <i class="fas fa-pencil-alt"></i> <!-- Better edit icon -->
                                        </a>
                                        <a title="View" href="task-details.php?task_id=<?php echo $row['task_id']; ?>" class="btn btn-block btn-outline-warning">
                                            <i class="fas fa-folder"></i>
                                        </a>
                                        <a class="btn btn-block btn-outline-danger" title="Delete" href="?delete_task=delete_task&task_id=<?php echo $row['task_id']; ?>" onclick="return check_delete();">
                                        <i class="fas fa-trash-alt"></i>
                                        </a>
                                    <?php } else { ?>
                                        <!-- Other users -->
                                        <a title="View" href="task-details.php?task_id=<?php echo $row['task_id']; ?>" class="btn btn-block btn-outline-warning">
                                            <i class="fas fa-folder"></i>
                                        </a>
                                    <?php } ?>
                                </div>
                            </td>
                            <?php } ?>
                            </tr>
                    </tbody>
                    </table>
                </div>
              </div>
              <!-- /.card-body -->
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script>
$('[data-toggle="tooltip"]').tooltip();
</script>