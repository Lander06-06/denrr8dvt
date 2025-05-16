<?php
require 'authentication.php';

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

$task_id = $_GET['task_id'];

// Process task update if the form is submitted
if (isset($_POST['update_task_info'])) {
    // Update task information
    $obj_admin->update_task_info($_POST, $task_id, $user_role);
    
    // After updating, get the new assigned user information
    $assign_to_id = $_POST['assign_to']; // Assuming you're sending the user ID through the form
    $dv_no = $_POST['dv_no'];  // Assuming you're sending the DV No through the form
    
    // Fetch the full name and email of the user based on the ID
    $stmt = $conn->prepare("SELECT fullname FROM tbl_admin WHERE user_id = ?");
    $stmt->bind_param("i", $assign_to_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    $assign_to = $user['full_name'] ?? 'Unknown';

    $notificationMessage = "A task with DV No. {$dv_no} has been forwarded to you.";
    $insertNotif = $conn->prepare("INSERT INTO notifications (user_id, message, is_read, created_at) VALUES (?, ?, 0, NOW())");
    $insertNotif->bind_param("is", $newUserId, $notificationMessage);
    $insertNotif->execute();


	exit();
}

$sql = "SELECT * FROM task_info WHERE task_id='$task_id' ";
$info = $obj_admin->manage_all_info($sql);
$row = $info->fetch(PDO::FETCH_ASSOC);

$page_name = "pending-dv";
include 'include/header.php';
include 'include/sidebar.php';
?>
  <title>DENR-R8 DVTS | EDIT DV</title>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Update DV</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Update DV</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit DV</h3>
                <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
                </div>
            </div>
               
                    <div class="card-body">
                    <form class="row" role="form" action="" method="post" autocomplete="off">
                        <div class="form-group col-md-6">
                            <label class="control-label">Payee</label>
                            
                            <?php 
                                // Fetch payee data from the database
                                $sql = "SELECT payee_sms_id, payee_name FROM payee ORDER BY payee_name ASC";
                                $info = $obj_admin->manage_all_info($sql);   
                            ?>
                            <select class="form-control selectpicker" name="payee_sms_id" id="payee_name" data-live-search="true">
                                <option value="">Select</option>

                                <?php while($rows = $info->fetch(PDO::FETCH_ASSOC)){ ?>
                                <option value="<?php echo $rows['payee_sms_id']; ?>" <?php
                                    // Check if the payee_sms_id from the database matches the selected one (in the current row)
                                    if($rows['payee_sms_id'] == $row['payee_sms_id']){
                                ?> selected <?php } ?>>
                                    <?php echo $rows['payee_name']; ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                    <div class="form-group col-md-6">
                        <label class="control-label">Transaction Type</label>
                        
                        <?php 
                            // Fetch payee data from the database
                            $sql = "SELECT transaction_id, transaction_type FROM transaction";
                            $info = $obj_admin->manage_all_info($sql);   
                        ?>
                        <select class="form-control selectpicker" name="transaction_id" id="transaction_type" data-live-search="true">
                            <option value="">Select Transaction Type...</option>

                            <?php while($rows = $info->fetch(PDO::FETCH_ASSOC)){ ?>
                            <option value="<?php echo $rows['transaction_id']; ?>" <?php
                                // Check if the payee_sms_id from the database matches the selected one (in the current row)
                                if($rows['transaction_id'] == $row['transaction_id']){
                            ?> selected <?php } ?>>
                                <?php echo $rows['transaction_type']; ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div id="procurementFields" class="col-12" style="display: none;">
                        <div class="form-group col-md-6">
                            <label for="pr_no">PR No.</label>
                            <input type="text" class="form-control" <?php echo ($user_id == 1 || $department_id == 10 || $department_id == 6) ? '' : 'readonly'; ?>  name="pr_no" id="pr_no" placeholder="To be filled out by procurement">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="po_no">PO No.</label>
                            <input type="text" class="form-control" <?php echo ($user_id == 1 || $department_id == 10 || $department_id == 6) ? '' : 'readonly'; ?>  name="po_no" id="po_no" placeholder="To be filled out by procurement">
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="control-label">Form 10 No.</label>
							<input type="text" placeholder="2025-03-000000-DIVISION" id="form_no" name="form_no" class="form-control" pattern="^[0-9]{4}-[0-9]{2}-[0-9]{6}-[A-Z]+$" value="<?php echo $row['form_no']; ?>">

						<label class="control-label">ORS No.</label>
							<input type="text" placeholder="Enter the ORS No." id="ors_no" <?php echo (($_SESSION['admin_id'] ?? 0) === 1 || ($_SESSION['department_id'] ?? 0) === 10 || ($_SESSION['department_id'] ?? 0) === 6 || ($_SESSION['department_id'] ?? 0) === 7) ? '' : 'readonly'; ?>  name="ors_no" class="form-control" value="<?php echo $row['ors_no']; ?>">

                        <label class="control-label">DV No.</label>
			                <input type="text" placeholder="DV No." id="dv_no" name="dv_no" list="expense" class="form-control" value="<?php echo $row['dv_no']; ?>" readonly>
					</div>
                    <div class="form-group col-md-6">
                        <label class="control-label">Payment Description</label>              
                        <textarea name="task_description" id="task_description" placeholder="Text Deskcription" class="form-control" rows="5" cols="5"><?php echo $row['t_description']; ?></textarea>  
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label">Gross Amount</label>
                            <input type="text" name="gross_amount" id="gross_amount" class="form-control" 
                                value="<?php echo number_format($row['gross_amount'], 2); ?>"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" 
                                maxlength="15">
                            <input type="hidden" id="gross_amount_raw" name="gross_amount" value="<?php echo $row['gross_amount']; ?>">

                        <label class="control-label">Net Amount</label>
                            <input type="text" name="net_amount" id="net_amount" <?php echo (($_SESSION['admin_id'] ?? 0) == 1 || ($_SESSION['department_id'] ?? 0) == 6) ? '' : 'readonly'; ?> class="form-control" 
                                value="<?php echo number_format($row['net_amount'], 2); ?>"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" 
                                maxlength="15">
                            <input type="hidden" id="net_amount_raw" name="net_amount" value="<?php echo $row['net_amount']; ?>">

                        <label class="control-label">e-NGAS JEV No.</label> 
                            <input type="text" placeholder="JEV No." id="jev_no" <?php echo (($_SESSION['admin_id'] ?? 0) == 1 || ($_SESSION['department_id'] ?? 0) == 6) ? '' : 'readonly'; ?> name="jev_no" list="expense" class="form-control" value="<?php echo $row['jev_no']; ?>" val pattern="^[0-9]{4}-[0-9]{2}-[0-9]+$">
							<!--<small class="form-text text-muted" style="color: red;">Please enter based on the example (eg., 2025-03-00128).</small>-->
			        </div>
                    <div class="form-group col-md-4">
                        <label class="control-label">ADA / Check No.</label>           
                        <input type="text" placeholder="To be filled out by Cashier or Accounting" id="ada_no" <?php echo (($_SESSION['admin_id'] ?? 0) == 1 || ($_SESSION['department_id'] ?? 0) == 6) ? '' : 'readonly'; ?> name="ada_no" class="form-control" value="<?php echo $row['ada_no']; ?>">               
                        <!-- <small class="form-text text-muted" style="color: red;">Please enter an 8-digit number (eg., 25.03.0641).</small> -->
                    </div>
                    <div class="form-group col-md-4">
                        <label class="control-label">Transaction Ref No.</label> 
                        <input type="text" placeholder="To be filled out by Cashier or Accounting" id="transaction_ref_no" <?php echo (($_SESSION['admin_id'] ?? 0) == 1 || ($_SESSION['department_id'] ?? 0) == 6) ? '' : 'readonly'; ?> name="transaction_ref_no" class="form-control" value="<?php echo $row['transaction_ref_no']; ?>">
                        <!-- <small class="form-text text-muted" style="color: red;">Please enter an 8-digit number (eg., 25.03.0641).</small> -->
                    </div>
                    <div class="form-group col-md-4">
                        <label class="control-label">ACIC Batch No.</label>    
                        <input type="text" placeholder="To be filled out by Cashier or Accounting" id="acic_batch_no" <?php echo (($_SESSION['admin_id'] ?? 0) == 1 || ($_SESSION['department_id'] ?? 0) == 6) ? '' : 'readonly'; ?> name="acic_batch_no" class="form-control" value="<?php echo $row['acic_batch_no']; ?>">
                    </div>
                    <div class="form-group col-md-10">
                            </div>
							<div class="form-group col-md-4">
			                    <label class="control-label">Note</label>
			                    
			                      <textarea name="comment" id="comment" placeholder="Put a note here" class="form-control" rows="5" cols="5"><?php echo $row['comment']; ?></textarea>

			                  </div>

                    <div class="form-group col-md-3">
                        <label class="control-label">Created By</label>
                            <?php
                            // Fetch the logged-in user's full name using session admin_id
                            $created_by_name = '';
                            $admin_id = $_SESSION['admin_id'];
                            $stmt = $obj_admin->manage_all_info("SELECT fullname FROM tbl_admin WHERE user_id = $admin_id");
                            if ($stmt && $user = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $created_by_name = htmlspecialchars($user['fullname']);
                            }
                            ?>
                        <input type="text" class="form-control" name="created_by" value="<?= $created_by_name ?>" readonly>
                        <label class="control-label">Assign To</label>
                            <select class="form-control selectpicker" name="assign_to" id="assign_to" data-live-search="true">
                                <option value="">Select</option>
                                <?php 
                                $sql = "SELECT a.user_id, a.fullname, d.department_name 
                                        FROM tbl_admin a
                                        LEFT JOIN department d ON a.department_id = d.department_id
                                        WHERE a.user_role = 2
                                        ORDER BY d.department_name ASC, a.fullname ASC";
                                $info = $obj_admin->manage_all_info($sql);

                                $current_department = '';
                                while ($rows = $info->fetch(PDO::FETCH_ASSOC)) {
                                    if ($rows['department_name'] != $current_department) {
                                        if ($current_department != '') {
                                            echo '</optgroup>';
                                        }
                                        $current_department = $rows['department_name'];
                                        echo '<optgroup label="' . htmlspecialchars($current_department) . '">';
                                    }
                                    ?>
                                    <option value="<?php echo $rows['user_id']; ?>" 
                                        <?php if ($rows['user_id'] == $row['t_user_id']) { echo 'selected'; } ?>>
                                        <?php echo htmlspecialchars($rows['fullname']); ?>
                                    </option>
                                    <?php
                                }
                                if ($current_department != '') {
                                    echo '</optgroup>';
                                }
                                ?>
                            </select>
                    </div>
                    <div class="form-group col-md-3">
                        <?php
                        // Only allow super‑admin (ID 1) or users in departments 6 or 11 to change status
                        $can_change_status = (
                            $_SESSION['admin_id'] == 1
                            || in_array($_SESSION['department_id'], [6, 11])
                        );
                        ?>
                        <label class="control-label">Status</label>
                        <select
                        class="form-control selectpicker"
                        name="status"
                        id="status"
                        data-live-search="true"
                        <?= $can_change_status ? '' : 'disabled' ?>
                        >
                        <option value="0" <?= $row['status'] == 0 ? 'selected' : '' ?>>In Progress</option>
                        <option value="1" <?= $row['status'] == 1 ? 'selected' : '' ?>>For Compliance</option>
                        <option value="2" <?= $row['status'] == 2 ? 'selected' : '' ?>>Paid</option>
                        <option value="3" <?= $row['status'] == 3 ? 'selected' : '' ?>>Completed</option>
                        <option value="4" <?= $row['status'] == 4 ? 'selected' : '' ?>>Complied</option>
                        <option value="5" <?= $row['status'] == 5 ? 'selected' : '' ?>>For Payment</option>
                        <option value="6" <?= $row['status'] == 6 ? 'selected' : '' ?>>For Certification</option>
                        <option value="7" <?= $row['status'] == 7 ? 'selected' : '' ?>>For Approval</option>
                        <option value="8" <?= $row['status'] == 8 ? 'selected' : '' ?>>For Fund Transfer</option>
                        <option value="9" <?= $row['status'] == 9 ? 'selected' : '' ?>>For Actual Credit</option>
                        </select>

                        <label for="filename">Upload File</label>
                        <div class="custom-file">
                        <input type="file" class="custom-file-input" id="filename" name="filename">
                        <label class="custom-file-label" for="filename">Choose file</label>
                        </div>
                        <small class="form-text text-muted">Supported: PDF, DOCX, XLSX, JPG, PNG, etc.</small>
                    </div>
                    <div class="form-group mt-5 ml-4 text-right">
                        <a href="#" class="btn btn-danger btn-fixed-spacing"onclick="history.back(); return false;">Cancel</a>
                        <input type="submit" name="update_task_info" data-task-id="<?= $task_id ?>" value="Update DV" class="btn btn-success btn-float-right btn-fixed-spacing">
                    </div>
                </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <script>
$(document).ready(function () { 
    $(".btn-success").click(function () {
        var taskId = $(this).data("task-id");

        if (!taskId) {
            alert("❌ Error: Task ID is missing.");
            return;
        }

        console.log("Fetching details for Task ID:", taskId);

        // Step 1: Fetch Task Info
        $.ajax({
            url: "fetch_task_info.php",
            type: "POST",
            dataType: "json",
            data: { task_id: taskId },
            success: function (taskData) {
                if (taskData.status === "error") {
                    alert("❌ " + taskData.message);
                    return;
                }

                console.log("Task Data:", taskData);

                // Step 2: Send Email with Task Info
                $.ajax({
                    url: "send_task_email.php",
                    type: "POST",
                    dataType: "json",
                    data: {
                        task_id: taskId,
                        task_dv_no: taskData.dv_no,
                        task_jev_no: taskData.jev_no,
                        task_payee_name: taskData.payee_name,
                        task_desc: taskData.t_description,
                        transaction_id: taskData.transaction_id,
                        transaction_type: taskData.transaction_type,
                        task_start_time: taskData.t_start_time,
                        task_end_time: taskData.t_end_time,
                        task_fullname: taskData.fullname,
                        payee_sms_id: taskData.payee_sms_id,
                        task_status: taskData.status,
                        task_t_department_id: taskData.t_department_id,
                        task_comment: taskData.comment
                    },
                    success: function (response) {
                        console.log("Response:", response);
                        if (response.status === "success") {
                          showCustomToast(`DV Track email sent successfully! DV No: ${response.dv_no}`, "success");
                          } else {
                              showCustomToast(`DV Track email not sent! DV No: ${response.dv_no}`, "error");
                          }
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                        showCustomToast("Failed to send email.", "error");
                    }
                });

            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", status, error);
                showCustomToast("Failed to fetch task details", "error");
            }
        });
    });
});
</script>
  <!-- /.content-wrapper -->
   <!-- AdminLTE App -->
  <script src="dist/js/adminlte.js"></script>
  <?php include 'include/footer.php'; ?>