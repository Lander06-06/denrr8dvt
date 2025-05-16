<?php
// require 'authentication.php';
require 'db_conn.php';
// auth check
$user_id = $_SESSION['admin_id'];
$user_name = $_SESSION['name'];
$security_key = $_SESSION['security_key'];
if ($user_id == NULL || $security_key == NULL) {
    header('Location: index.php');
}

$user_role = $_SESSION['user_role'];

$task_id = $_GET['task_id'];



if(isset($_POST['update_task_info'])){
    $obj_admin->update_task_info($_POST,$task_id, $user_role);
}

$page_name="pending-dv";
include("include/header.php");
include("include/sidebar.php");

$sql = "SELECT a.*, b.fullname, c.payee_name, d.transaction_type 
FROM task_info a
LEFT JOIN tbl_admin b ON a.t_user_id = b.user_id
LEFT JOIN payee c ON a.payee_sms_id = c.payee_sms_id
LEFT JOIN transaction d ON a.transaction_id = d.transaction_id
WHERE a.task_id = '$task_id'";
$info = $obj_admin->manage_all_info($sql);
$row = $info->fetch(PDO::FETCH_ASSOC);

?>
  <title>DENR-R8 DVTS | DV INFO</title>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Disbursement Voucher Details</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">DV Details</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">Details</h5>
                </div>
                <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table  class="table table-codensed  display" id="example" style="width:100%">
                            <tbody>
                                <tr>
                                <td style="white-space: nowrap;">DV No.</td>
                                <td style="width: 1%; white-space: nowrap;">:</td>
                                <td><?php echo $row['dv_no']; ?></td>
                                </tr>
                                <tr>
                                <td>JEV No.</td>
                                <td>:</td>
                                <td><?php echo $row['jev_no']; ?></td>
                                </tr>
                                <tr>
                                <td>ADA/Check No.</td>
                                <td>:</td>
                                <td><?php echo $row['ada_no']; ?></td>
                                </tr>
                                <tr>
                                <td>ORS/BUR No.</td>
                                <td>:</td>
                                <td><?php echo $row['ors_no']; ?></td>
                                </tr>
                                <tr>
                                <td>Transaction Reference No.</td>
                                <td>:</td>
                                <td><?php echo $row['transaction_ref_no']; ?></td>
                                </tr>
                                <tr>
                                <td>ACIC Batch No.</td>
                                <td>:</td>
                                <td><?php echo $row['acic_batch_no']; ?></td>
                                </tr>
                                <tr>
                                <td>PR No.</td>
                                <td>:</td>
                                <td><?php echo $row['pr_no']; ?></td>
                                </tr>
                                <tr>
                                <td>PO No.</td>
                                <td>:</td>
                                <td><?php echo $row['po_no']; ?></td>
                                </tr>
                                <tr>
                                <td>Payee Name</td>
                                <td>:</td>
                                <td><?php echo $row['payee_name']; ?></td>
                                </tr>
                                <tr>
                                <td>Description</td>
                                <td>:</td>
                                <td><?php echo $row['t_description']; ?></td>
                                </tr>
                                <tr>
                                <td>Transaction Type</td>
                                <td>:</td>
                                <td><?php echo $row['transaction_type']; ?></td>
                                </tr>
                                <tr>
                                <td>Net Amount</td>
                                <td>:</td>
                                <td><?php echo number_format($row['net_amount'], 2); ?></td>
                                </tr>
                                <tr>
                                <td>Gross Amount</td>
                                <td>:</td>
                                <td><?php echo number_format($row['gross_amount'], 2); ?></td>
                                </tr>
                                <tr>
                                <td>Start Time</td>
                                <td>:</td>
                                <td><?php echo $row['t_start_time']; ?></td>
                                </tr>
                                <tr>
                                <td>End Time</td>
                                <td>:</td>
                                <td><?php echo $row['t_end_time']; ?></td>
                                </tr>
                                <tr>
                                <td>Assign To</td>
                                <td>:</td>
                                <td><?php echo $row['fullname']; ?></td>
                                </tr>
                                <tr>
                                <td>Status</td>
                                <td>:</td>
                                <td>
                                    <?php
                                    if ($row['status'] == 1) {
                                        echo "For Compliance";
                                    } elseif ($row['status'] == 2) {
                                        echo "Paid";
                                    } elseif ($row['status'] == 3) {
                                        echo "Completed";
                                    } else {
                                        echo "In Progress";
                                    }
                                    ?>
                                </td>
                                </tr>
                                <tr>
                                <td>Location</td>
                                <td>:</td>
                                <td>
                                    <?php  
                                    $departments = [
                                        1 => ['name' => 'Office of the Regional Director'],
                                        2 => ['name' => 'ARD for Management Services'],
                                        3 => ['name' => 'ARD for Technical Services'],
                                        4 => ['name' => 'Planning and Management Division'],
                                        5 => ['name' => 'Finance Division'],
                                        6 => ['name' => 'Accounting Section'],
                                        7 => ['name' => 'Budget Section'],
                                        8 => ['name' => 'Legal Division'],
                                        9 => ['name' => 'Administrative Division'],
                                        10 => ['name' => 'Procurement Section'],
                                        11 => ['name' => 'Cashier Section'],
                                        12 => ['name' => 'Conservation and Development Division'],
                                        13 => ['name' => 'Survey and Mapping Division'],
                                        14 => ['name' => 'Licenses, Patents and Deeds Division'],
                                        15 => ['name' => 'Enforcement Division'],
                                        16 => ['name' => 'Comission on Audit Division'],
                                        17 => ['name' => 'NGP'],
                                        18 => ['name' => 'No Division']
                                    ];

                                    $department_id = $row['t_department_id'];
                                    if (array_key_exists($department_id, $departments)) {
                                        echo "<span>{$departments[$department_id]['name']}</span>";
                                    } else {
                                        echo "<span>Unknown Department</span>";
                                    }
                                    ?>
                                </td>
                                </tr>
                                <tr>
                                <td>Comment</td>
                                <td>:</td>
                                <td><?php echo $row['comment']; ?></td>
                                </tr>
                            </tbody>
                            </table>
                        </div>

                        <div class="form-group">
                        <div class="col-sm-3">
                            <a href="javascript:history.back()" class="btn btn-primary">Return</a>
                        </div>
                    </div>
                    </form> 
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<?php include 'include/footer.php'; ?>