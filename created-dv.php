<?php
require_once 'authentication.php';
require_once 'db_conn.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

// auth check   
  $user_id = $_SESSION['admin_id'];
  $user_name = $_SESSION['name'];
  $department_id = $_SESSION['department_id'];
  $security_key = $_SESSION['security_key'];
if ($user_id == NULL || $security_key == NULL) {
    header('Location: index.php');
}
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
    $sent_po = "pending-dv.php";
    $obj_admin->delete_data_by_this_method($sql, $action_id, $sent_po);
    exit();
}

if (isset($_POST['add_task_post'])) {
    // Add new task
    $obj_admin->add_new_task($_POST);

    // Fetch the full name of the user based on the ID
    $stmt = $conn->prepare("SELECT fullname FROM tbl_admin WHERE user_id = ?");
    $stmt->bind_param("i", $assign_to_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    // Check if a full name was found
    $user_id = $user['fullname'] ?? 'Unknown';  // Default to 'Unknown' if not found

    $stmt_payee = $conn->prepare("SELECT payee_email FROM payee WHERE payee_id = ?");
    $stmt_payee->bind_param("i", $payee_id);
    $stmt_payee->execute();
    $result_payee = $stmt_payee->get_result();
    $payee = $result_payee->fetch_assoc();
    
    // Get the payee email
    $payee_email = $payee['payee_email'] ?? ''; // Default to empty if not found
      
    exit();
}

if (isset($_GET['action']) && isset($_GET['task_id'])) {
    $task_id = $_GET['task_id'];  // Get the task ID
    $action = $_GET['action'];    // Get the action (approve or disapprove)

    // Check if task_id and action are valid
    if (empty($task_id) || !in_array($action, ['approve', 'disapprove'])) {
        // Invalid request or missing parameters
        die('Invalid task ID or action.');
    }

    // Get current date
    date_default_timezone_set('Asia/Manila');
    $current_date = date('Y-m-d H:i:s');

    // STEP 1: Get the task's assigned user (t_user_id)
    $stmt = $conn->prepare("SELECT t_user_id FROM task_info WHERE task_id = ?");
    $stmt->bind_param("i", $task_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $task = $result->fetch_assoc();

    if (!$task) {
        die('Task not found.');
    }

    $task_user_id = $task['t_user_id'];

    // Fetch user full name from the database
    $user_id = $_SESSION['admin_id']; // Get the current logged-in user's ID from session or wherever you store it
    $stmt = $conn->prepare("SELECT fullname FROM tbl_admin WHERE user_id = ?");
    $stmt->bind_param("i", $task_user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    // Check if full name exists, otherwise set a default value
    $full_name = $user['fullname'] ?? 'Unknown User'; // Default to 'Unknown User' if no name is found

    // Define the department ID and comment based on action
    if ($action == 'approve') {
        $t_user_id = 59;
        $t_department_id = 6;  // Set to accounting section (department id = 6)
        $comment = "APPROVED by " . $full_name . " on " . $current_date;
    } elseif ($action == 'disapprove') {
        $t_user_id = 59;
        $t_department_id = 6;
        $comment = "DISAPPROVED by " . $full_name . " on " . $current_date;
    }

    // Update the task with the new department and comment
    $sql = "UPDATE task_info SET t_user_id = ?, t_department_id = ?, comment = ? WHERE task_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$t_user_id, $t_department_id, $comment, $task_id]);

    $insert_sql = "INSERT INTO transmittal_report (task_id, updated_by, update_time) VALUES (?, ?, NOW())";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("ii", $task_id, $user_id);  // using $user_id as the admin who approved/disapproved
    $insert_stmt->execute();


    // Redirect to the task list or other page as needed
    header('Location: pending-dv.php');
    exit(); // Exit after the redirection
}
$page_name = "pending-dv";
include 'include/header.php';
include 'include/sidebar.php';
?>
<head>
  <title>DENR-R8 DVTS | Created DV</title>

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
  
</head>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Created DV Table</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Created DV Table</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="container-fluid">
        <div class="row mb-2">
        <div class="col-12 text-left">
            <!-- Button to open modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addTaskModal">
            Add DV
            </button>
        </div>
        </div>
        <div class="row">
        <div class="col-12">
            <div class="card">
            <div class="card-header">
                <h3 class="card-title">Disbursement Vouchers</h3>
            </div>
                <!-- Add Task Modal -->
                <div class="modal fade" id="addTaskModal" tabindex="-1" role="dialog" aria-labelledby="addTaskModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                    <form role="form" action="" method="post" enctype="multipart/form-data" autocomplete="off" id="add-task-form">
                        <div class="modal-header">
                        <h5 class="modal-title" id="addTaskModalLabel">Add New DV</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="control-label ">Payee Name</label>
                            
                                    <?php 
                                    $sql = "SELECT payee_sms_id, payee_name FROM payee ORDER BY payee_name ASC";
                                    $info = $obj_admin->manage_all_info($sql);   
                                    ?>
                                    <select class="form-control select2" name="payee_sms_id" id="payee_sms_id" data-live-search="true" required>
                                        <option value="">Select Payee...</option>
                                        <?php while($row = $info->fetch(PDO::FETCH_ASSOC)) { ?>
                                            <option value="<?php echo $row['payee_sms_id']; ?>"><?php echo $row['payee_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label ">Transaction Type</label>
                            
                                    <?php 
                                    $sql = "SELECT transaction_id, transaction_type FROM transaction ORDER BY transaction_type ASC";
                                    $info = $obj_admin->manage_all_info($sql);   
                                    ?>
                                    <select class="form-control select2" name="transaction_id" id="transaction_id" data-live-search="true" required>
                                        <option value="">Select Transaction Type...</option>
                                        <?php while($row = $info->fetch(PDO::FETCH_ASSOC)) { ?>
                                            <option value="<?php echo $row['transaction_id']; ?>"><?php echo $row['transaction_type']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div id="procurementFields" class="col-12" style="display: none;">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="pr_no">PR No.</label>
                                            <input type="text" class="form-control" <?php echo ($user_id == 1 || $department_id == 10 || $department_id == 6) ? '' : 'readonly'; ?>  name="pr_no" id="pr_no" placeholder="To be filled out by procurement">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="po_no">PO No.</label>
                                            <input type="text" class="form-control" <?php echo ($user_id == 1 || $department_id == 10 || $department_id == 6) ? '' : 'readonly'; ?>  name="po_no" id="po_no" placeholder="To be filled out by procurement">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Form 10 No.</label>
                                    <input type="text" placeholder="2025-03-000000-DIVISION" id="form_no" name="form_no" class="form-control" pattern="^[0-9]{4}-[0-9]{2}-[0-9]{6}-[A-Z]+$">
                                    <small class="form-text text-muted" style="color: red;">Please enter based on the example (eg., 2025-03-XXXXXX-FD).</small>
                                    <label class="control-label">ORS No.</label>
                                    <input type="text" placeholder="2025-03-000000" id="ors_no" name="ors_no" <?php echo ($user_id == 1 || $department_id == 10 || $department_id == 6 || $department_id == 7) ? '' : 'readonly'; ?> class="form-control" pattern="^[0-9]{4}-[0-9]{2}-[0-9]{6}$" >
                                    <small class="form-text text-muted" style="color: red;">Please enter based on the example (eg., 2025-03-XXXXXX).</small>
                                </div>
                                <div class="form-group col-md-5">
                                    <label class="control-label">Payment Description</label>
                                    <textarea name="task_description" id="task_description" placeholder="Description" class="form-control" rows="5" cols="5"></textarea>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label">Gross Amount</label>
                                    <input type="text" name="gross_amount" id="gross_amount" placeholder="Enter Gross Amount" class="form-control" 
                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" 
                                            maxlength="15">
                                            <input type="hidden" id="gross_amount_raw" name="gross_amount">
                                    <label class="control-label">Net Amount</label>
                                    <input type="text" name="net_amount" id="net_amount" placeholder="Enter Net Amount" class="form-control" <?php echo ($user_id == 1 || $department_id == 6 ||$department_id == 7 ) ? '' : 'readonly'; ?>
                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" 
                                            maxlength="15">
                                            <input type="hidden" id="net_amount_raw" name="net_amount">
                                </div>
                                <div class="form-group">
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label">e-NGAS JEV No.</label>
                                    <input type="text" placeholder="2025-03-000000" id="jev_no" name="jev_no" class="form-control"<?php echo ($user_id == 1 || $department_id == 6) ? '' : 'readonly'; ?> pattern="^[0-9]{4}-[0-9]{2}-[0-9]{6}$" >
                                    <small class="form-text text-muted" style="color: red;">Please enter based on the example (eg., 2025-03-XXXXXX).</small>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label">ADA / Check No.</label>
                                    <input type="text" placeholder="To be filled out by Cashier or Accounting" id="ada_no" name="ada_no" class="form-control" <?php echo ($user_id == 1 || $department_id == 6) ? '' : 'readonly'; ?>>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label">Transaction Ref No.</label>
                                    <input type="text" placeholder="To be filled out by Cashier or Accounting" id="transaction_ref_no" name="transaction_ref_no" class="form-control" <?php echo ($user_id == 1 || $department_id == 6) ? '' : 'readonly'; ?>>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label">ACIC Batch No.</label>
                                    <input type="text" placeholder="To be filled out by Cashier or Accounting" id="acic_batch_no" name="acic_batch_no" class="form-control" <?php echo ($user_id == 1 || $department_id == 6) ? '' : 'readonly'; ?>>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label ">Assign To</label>
                                    <?php 
                                    $sql = "SELECT user_id, fullname, department_id FROM tbl_admin WHERE user_role = 2 ORDER BY fullname ASC";
                                    $info = $obj_admin->manage_all_info($sql);   
                                    ?>
                                    <select class="form-control selectpicker" name="assign_to" id="aassign_to" data-live-search="true" required>
                                    <option value="">Select Employee...</option>

                                    <?php while($row = $info->fetch(PDO::FETCH_ASSOC)){ ?>
                                    <option value="<?php echo $row['user_id']; ?>"><?php echo $row['fullname']; ?></option>
                                    <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Note/Remarks</label>
                                    <textarea name="comment" id="comment" placeholder="Put a note if any" class="form-control" rows="5" cols="5"></textarea>
                                </div>
                                <div class="form-group col-md-4">
                                <label for="filename">Upload File</label>
                                    <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="filename" name="filename">
                                    <input type="hidden" name="1xi00E0l3K5m31Ry6A1PKWGmj8tAQwlu4" value="1xi00E0l3K5m31Ry6A1PKWGmj8tAQwlu4">
                                    <label class="custom-file-label" for="filename">Choose file</label>
                                    </div>
                                    <small class="form-text text-muted">Supported: PDF, DOCX, XLSX, JPG, PNG, etc.</small>
                                    <div class="modal-include/footer justify-content-between">
                                        <button type="button" class="btn btn-default btn-sm" style="width: 100px;" data-dismiss="modal">Close</button>
                                        <button type="submit" name="add_task_post"class="btn btn-primary btn-sm" style="width: 100px;">Assign Task</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
                </div>
                <!-- ./row -->
                <div class="row">
                <div class="col-12 col-sm-12">
                    <div class="card card-primary card-tabs">
                    <div class="card-header p-0 pt-1">
                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                        <li class="nav-item">
                        <a class="nav-link" href="pending-dv.php">Pending DV's</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link active" href="#">Created DV's</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="complied-dv.php">Complied DV's</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="for-ada-dv.php">For ADA</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="for-fund-transfer-dv.php">For Fund Transfer DV's</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="for-actual-credit-dv.php">For Actual Credit DV's</a>
                        </li>
                    </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-one-tabContent">
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
                                    WHERE a.created_by = {$_SESSION['admin_id']}
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
                                    WHERE a.created_by = {$_SESSION['admin_id']}
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
                                                <a title="Update Task" href="edit-task.php?task_id=<?php echo $row['task_id']; ?>" class="btn btn-block btn-outline-primary">
                                                    <i class="fas fa-pencil-alt"></i> <!-- Better edit icon -->
                                                </a>
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
                        </div>
                    </div>
                    <!-- /.card -->
                    </div>
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
<!-- AdminLTE App -->
<script>
$('[data-toggle="tooltip"]').tooltip();
</script>
