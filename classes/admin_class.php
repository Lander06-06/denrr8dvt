<?php

class Admin_Class
{	

/* -------------------------set_database_connection_using_PDO---------------------- */
	public $db; // ✅ Declare the property here 
	public function __construct()
	{ 
		// 1) Make sure PHP itself is using Manila time
		date_default_timezone_set('Asia/Manila');
        $host_name='localhost';
		$user_name='root';
		$password='';
		$db_name='taskmatic';

		try{
			$connection=new PDO("mysql:host={$host_name}; dbname={$db_name}", $user_name,  $password);
            // $connection->exec("SET time_zone = '{Asia/Manila}'");
			$this->db = $connection; // connection established

		} catch (PDOException $message ) {
			echo $message->getMessage();
		}
	}

/* ---------------------- test_form_input_data ----------------------------------- */
	
	public function test_form_input_data($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
	return $data;
	}

 
/* ---------------------- Admin Login Check ----------------------------------- */

public function admin_login_check($data) {
    // only start if no session is active
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Sanitize input
    $username = $this->test_form_input_data($data['username']);
    $inputPassword = $this->test_form_input_data($data['admin_password']);
    $hashedPassword = md5($inputPassword); // You should replace MD5 with password_hash() in the future.

    try {
        // Fetch user by username only
        $stmt = $this->db->prepare("SELECT * FROM tbl_admin WHERE username = :uname LIMIT 1");
        $stmt->execute([':uname' => $username]);
        $userRow = $stmt->fetch(PDO::FETCH_ASSOC);

        // If user found, validate credentials
        if ($userRow) {
            $dbPassword = $userRow['password'];
            $tempPassword = $userRow['temp_password'];

            // Check either main hashed password or plain temp password
            if ($hashedPassword === $dbPassword || (!empty($tempPassword) && $inputPassword === $tempPassword)) {
                
                // Set session variables
                $_SESSION['admin_id'] = $userRow['user_id'];
                $_SESSION['name'] = $userRow['fullname'];
                $_SESSION['department_id'] = $userRow['department_id'];
                $_SESSION['security_key'] = 'rewsgf@%^&*nmghjjkh';
                $_SESSION['user_role'] = $userRow['user_role'];
                $_SESSION['temp_password'] = $userRow['temp_password'];

                // Redirect to appropriate page
                if (!empty($tempPassword) && $inputPassword === $tempPassword) {
                    header('Location: changePasswordForEmployee.php');
                } else {
                    header('Location: dashboard.php');
                }
                exit();
            }
        }

        // Generic error (whether username or password is wrong)
        return 'Invalid username or password';

    } catch (PDOException $e) {
        // Optionally log the error, don't expose to users
        error_log($e->getMessage());
        return 'Something went wrong. Please try again.';
    }
}





    public function change_password_for_employee($data){
    	$password  = $this->test_form_input_data($data['password']);
		$re_password = $this->test_form_input_data($data['re_password']);

		$user_id = $this->test_form_input_data($data['user_id']);
		$final_password = md5($password);
		$temp_password = '';

		if($password == $re_password){
			try{
				$update_user = $this->db->prepare("UPDATE tbl_admin SET password = :x, temp_password = :y WHERE user_id = :id ");

				$update_user->bindparam(':x', $final_password);
				$update_user->bindparam(':y', $temp_password);
				$update_user->bindparam(':id', $user_id);
				$update_user->execute();



				$stmt = $this->db->prepare("SELECT * FROM tbl_admin WHERE user_id=:id LIMIT 1");
		          $stmt->execute(array(':id'=>$user_id));
		          $userRow=$stmt->fetch(PDO::FETCH_ASSOC);

		          if($stmt->rowCount() > 0){
			          		session_start();
				            $_SESSION['admin_id'] = $userRow['user_id'];
				            $_SESSION['name'] = $userRow['fullname'];
				            $_SESSION['security_key'] = 'rewsgf@%^&*nmghjjkh';
				            $_SESSION['user_role'] = $userRow['user_role'];
				            $_SESSION['temp_password'] = $userRow['temp_password'];

				            header('Location: dashboard.php');
			          }

			}catch (PDOException $e) {
				echo $e->getMessage();
			}

		}else{
			$message = 'Sorry !! Password Can not match';
            return $message;
		}

		
    }


/* -------------------- Admin Logout ----------------------------------- */

    public function admin_logout() {
        
        session_start();
        unset($_SESSION['admin_id']);
        unset($_SESSION['admin_name']);
        unset($_SESSION['security_key']);
        unset($_SESSION['user_role']);
        header('Location: index.php');
    }

/*----------- add_new_user--------------*/

	public function add_new_user($data){
		$user_fullname  = $this->test_form_input_data($data['em_fullname']);
		$user_username = $this->test_form_input_data($data['em_username']);
		$user_email = $this->test_form_input_data($data['em_email']);
		$user_department_id = $this->test_form_input_data($data['department_id']);
        $profile_image = isset($data['profile_image']) ? $data['profile_image'] : null;

		$temp_password = rand(000000001,10000000);
		$user_password = $this->test_form_input_data(md5($temp_password));
		$user_role = 2;
		try{
			$sqlEmail = "SELECT email FROM tbl_admin WHERE email = '$user_email' ";
			$query_result_for_email = $this->manage_all_info($sqlEmail);
			$total_email = $query_result_for_email->rowCount();

			$sqlUsername = "SELECT username FROM tbl_admin WHERE username = '$user_username' ";
			$query_result_for_username = $this->manage_all_info($sqlUsername);
			$total_username = $query_result_for_username->rowCount();

			$sqlDepartment = "SELECT department_id FROM tbl_admin WHERE department_id = '$user_department_id' ";
			$query_result_for_department_id = $this->manage_all_info($sqlDepartment);
			$total_department_id = $query_result_for_department_id->rowCount();

			if($total_email != 0 && $total_username != 0){
				$message = "Email and Password both are already taken";
            	return $message;

			}elseif($total_username != 0){
				$message = "Username Already Taken";
            	return $message;

			}elseif($total_email != 0){
				$message = "Email Already Taken";
            	return $message;

			}else{
				$add_user = $this->db->prepare("INSERT INTO tbl_admin (fullname, username, email, department_id, password, temp_password, user_role, profile_image) VALUES (:x, :y, :z, :d, :a, :b, :c, :img) ");

				$add_user->bindparam(':x', $user_fullname);
				$add_user->bindparam(':y', $user_username);
				$add_user->bindparam(':z', $user_email);
				$add_user->bindparam(':d', $user_department_id);
				$add_user->bindparam(':a', $user_password);
				$add_user->bindparam(':b', $temp_password);
				$add_user->bindparam(':c', $user_role);
                $add_user->bindparam(':img', $profile_image);
				$add_user->execute();
                // Return the needed info
                return [
                    'username' => $user_username,
                    'temp_password' => $temp_password,
                    'email' => $user_email
                ];
			}


		}catch (PDOException $e) {
			echo $e->getMessage();
		}
	}


/* ---------update_user_data----------*/

	public function update_user_data($data, $id){
		$user_fullname  = $this->test_form_input_data($data['em_fullname']);
		$user_username = $this->test_form_input_data($data['em_username']);
		$user_email = $this->test_form_input_data($data['em_email']);
		$user_department_id = $this->test_form_input_data($data['department_id']);
		try{
			$update_user = $this->db->prepare("UPDATE tbl_admin SET fullname = :x, username = :y, email = :z, department_id = :d WHERE user_id = :id ");

			$update_user->bindparam(':x', $user_fullname);
			$update_user->bindparam(':y', $user_username);
			$update_user->bindparam(':z', $user_email);
			$update_user->bindparam(':d', $user_department_id);
			$update_user->bindparam(':id', $id);
			
			$update_user->execute();

			$_SESSION['update_user'] = 'update_user';

			header('Location: admin-manage-user.php');
		}catch (PDOException $e) {
			echo $e->getMessage();
		}
	}


/* ------------update_admin_data-------------------- */

	public function update_admin_data($data, $id){
		$user_fullname  = $this->test_form_input_data($data['em_fullname']);
		$user_username = $this->test_form_input_data($data['em_username']);
		$user_email = $this->test_form_input_data($data['em_email']);

		try{
			$update_user = $this->db->prepare("UPDATE tbl_admin SET fullname = :x, username = :y, email = :z WHERE user_id = :id ");

			$update_user->bindparam(':x', $user_fullname);
			$update_user->bindparam(':y', $user_username);
			$update_user->bindparam(':z', $user_email);
			$update_user->bindparam(':id', $id);
			
			$update_user->execute();

			header('Location: manage-admin.php');
		}catch (PDOException $e) {
			echo $e->getMessage();
		}
	}


/* ------update_user_password------------------*/
	
	public function update_user_password($data, $id){
		$employee_password  = $this->test_form_input_data(md5($data['employee_password']));
		
		try{
			$update_user_password = $this->db->prepare("UPDATE tbl_admin SET password = :x WHERE user_id = :id ");

			$update_user_password->bindparam(':x', $employee_password);
			$update_user_password->bindparam(':id', $id);
			
			$update_user_password->execute();

			$_SESSION['update_user_pass'] = 'update_user_pass';

			header('Location: admin-manage-user.php');
		}catch (PDOException $e) {
			echo $e->getMessage();
		}
	}




/* -------------admin_password_change------------*/

	public function admin_password_change($data, $id){
		$admin_old_password  = $this->test_form_input_data(md5($data['admin_old_password']));
		$admin_new_password  = $this->test_form_input_data(md5($data['admin_new_password']));
		$admin_cnew_password  = $this->test_form_input_data(md5($data['admin_cnew_password']));
		$admin_raw_password = $this->test_form_input_data($data['admin_new_password']);
		
		try{

			// old password matching check 

			$sql = "SELECT * FROM tbl_admin WHERE user_id = '$id' AND password = '$admin_old_password' ";

			$query_result = $this->manage_all_info($sql);

			$total_row = $query_result->rowCount();
			$all_error = '';
			if($total_row == 0){
				$all_error = "Invalid old password";
			}
			

			if($admin_new_password != $admin_cnew_password ){
				$all_error .= '<br>'."New and Confirm New password do not match";
			}

			$password_length = strlen($admin_raw_password);

			if($password_length < 6){
				$all_error .= '<br>'."Password length must be more then 6 character";
			}

			if(empty($all_error)){
				$update_admin_password = $this->db->prepare("UPDATE tbl_admin SET password = :x WHERE user_id = :id ");

				$update_admin_password->bindparam(':x', $admin_new_password);
				$update_admin_password->bindparam(':id', $id);
				
				$update_admin_password->execute();

				$_SESSION['update_user_pass'] = 'update_user_pass';

				header('Location: admin-manage-user.php');

			}else{
				return $all_error;
			}

			
		}catch (PDOException $e) {
			echo $e->getMessage();
		}
	}




	/* =================Task Related===================== */
    
	public function add_new_task($data) {
		// Sanitize input data
        require_once 'generate_dv_no.php'; // adjust path
		$dv_no = generateDVNumber($this->db);
		$jev_no = $this->test_form_input_data($data['jev_no']);
		$ada_no = $this->test_form_input_data($data['ada_no']); // ADA/Check No.
		$ors_no = $this->test_form_input_data($data['ors_no']);
		$transaction_ref_no = $this->test_form_input_data($data['transaction_ref_no']);
		$acic_batch_no = $this->test_form_input_data($data['acic_batch_no']);
        $pr_no = $this->test_form_input_data($data['pr_no']);
        $po_no = $this->test_form_input_data($data['po_no']);
        $form_no = $this->test_form_input_data($data['form_no']);

		$payee_sms_id = $this->test_form_input_data($data['payee_sms_id']);
		$transaction_id = $this->test_form_input_data($data['transaction_id']);
		$task_description = $this->test_form_input_data($data['task_description']);
        $gross_amount = $this->test_form_input_data($data['gross_amount']);
		$net_amount = $this->test_form_input_data($data['net_amount']);
		$assign_to = $this->test_form_input_data($data['assign_to']);
		$comment = $this->test_form_input_data($data['comment']);
		
		try {
			// Fetch the department_id of the assigned employee
			$stmt = $this->db->prepare("
            SELECT a.department_id, a.fullname, d.department_name 
            FROM tbl_admin a
            JOIN department d ON a.department_id = d.department_id
            WHERE a.user_id = :assign_to
        ");

			$stmt->bindParam(':assign_to', $assign_to);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
            $t_department_id = $result ? $result['department_id'] : null;
            $assigned_fullname = $result ? $result['fullname'] : 'Unknown';
            $assigned_department = $result ? $result['department_name'] : 'Unknown';

	
			// Ensure department_id is retrieved
			$t_department_id = $result ? $result['department_id'] : null;
	
			// Prepare the query to insert the task
			$add_task = $this->db->prepare("INSERT INTO task_info 
				(dv_no, jev_no, ada_no, ors_no, transaction_ref_no, acic_batch_no, pr_no, po_no, form_no, payee_sms_id, transaction_id, t_description, t_department_id, gross_amount, net_amount, t_user_id, comment, created_by) 
				VALUES 
				(:n, :j, :ada, :ors, :ref, :acic, :pr, :po, :a, :p, :r, :y, :e, :g, :t, :b, :d, :created_by)");
	
			// Bind all parameters
			$add_task->bindParam(':n', $dv_no);
			$add_task->bindParam(':j', $jev_no);
			$add_task->bindParam(':ada', $ada_no);
			$add_task->bindParam(':ors', $ors_no);    
			$add_task->bindParam(':ref', $transaction_ref_no);
			$add_task->bindParam(':acic', $acic_batch_no);
            $add_task->bindParam(':pr', $pr_no);
            $add_task->bindParam(':po', $po_no);
            $add_task->bindParam(':a', $form_no);
			$add_task->bindParam(':p', $payee_sms_id);
			$add_task->bindParam(':r', $transaction_id);
			$add_task->bindParam(':y', $task_description);
			$add_task->bindParam(':e', $t_department_id);
            $add_task->bindParam(':g', $gross_amount);
			$add_task->bindParam(':t', $net_amount);
			$add_task->bindParam(':b', $assign_to);
			$add_task->bindParam(':d', $comment);
	
			// Add the created_by field with the current user's session ID
			$add_task->bindParam(':created_by', $_SESSION['admin_id']);
	
			// Execute the query
			$add_task->execute();

            // ✅ Get the ID of the newly inserted task
            $task_id = $this->db->lastInsertId();

            // Make sure $task_id is already a plain value, not an array
            $task_id = is_array($task_id) ? $task_id['task_id'] : $task_id;

            // Get current user (assumed admin)
            $updated_by = $_SESSION['admin_id']; // assuming this is stored in session

            // Log the update in transmittal_report
            $insert_update_log = $this->db->prepare("
                INSERT INTO transmittal_report (task_id, updated_by, update_time) 
                VALUES (:task_id, :updated_by, NOW())
            ");
            $insert_update_log->bindParam(':task_id', $task_id, PDO::PARAM_INT);
            $insert_update_log->bindParam(':updated_by', $updated_by, PDO::PARAM_INT);
            $insert_update_log->execute();
			// — NEW: set t_start_time to NOW() for this task —
			$updateStart = $this->db->prepare("
				UPDATE task_info
				SET t_start_time = NOW()
				WHERE task_id = :task_id
			");
			$updateStart->bindParam(':task_id', $task_id, PDO::PARAM_INT);
			$updateStart->execute();


			// redirect back to wherever they came from
			if (!empty($_SERVER['HTTP_REFERER'])) {
				header('Location: ' . $_SERVER['HTTP_REFERER']);
			} else {
				header('Location: pending-dv.php');
			}
			exit;
                
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
	

	public function update_task_info($data, $task_id, $user_role) {
		// Sanitize input data
		$dv_no = $this->test_form_input_data($data['dv_no']);
		$jev_no = $this->test_form_input_data($data['jev_no']);
		$ada_no = $this->test_form_input_data($data['ada_no']);
		$ors_no = $this->test_form_input_data($data['ors_no']);
		$transaction_ref_no = $this->test_form_input_data($data['transaction_ref_no']);
		$acic_batch_no = $this->test_form_input_data($data['acic_batch_no']);
        $po_no = $this->test_form_input_data($data['po_no']);
        $pr_no = $this->test_form_input_data($data['pr_no']);
        $form_no = $this->test_form_input_data($data['form_no']);

		$payee_sms_id = $this->test_form_input_data($data['payee_sms_id']);
		$transaction_id = $this->test_form_input_data($data['transaction_id']);
		$task_description = $this->test_form_input_data($data['task_description']);
        $gross_amount = $this->test_form_input_data($data['gross_amount']);
        $net_amount = $this->test_form_input_data($data['net_amount']);
		$status = $this->test_form_input_data($data['status']);
		$location = $this->test_form_input_data($data['location']);
		$comment = $this->test_form_input_data($data['comment']);

        if ($status == 2) {
            date_default_timezone_set('Asia/Manila'); // Set timezone to Asia/Manila
            $t_end_time = date('Y-m-d H:i:s'); // Get the current time in Manila timezone
        }
	
		if ($user_role == 1) {
			$assign_to = $this->test_form_input_data($data['assign_to']);
		} else {
			// Fetch existing task info
			$sql = "SELECT * FROM task_info WHERE task_id = :task_id";
			$info = $this->db->prepare($sql);
			$info->bindParam(':task_id', $task_id);
			$info->execute();
			$row = $info->fetch(PDO::FETCH_ASSOC);
			$assign_to = $row['t_user_id']; // Keep existing assigned employee
		}
	
		try {
			$assign_to = $this->test_form_input_data($data['assign_to']);
			// Fetch the department_id of the assigned employee
			$stmt = $this->db->prepare("SELECT department_id FROM tbl_admin WHERE user_id = :assign_to");
			$stmt->bindParam(':assign_to', $assign_to);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
	
			// Ensure department_id is retrieved
			$t_department_id = $result ? $result['department_id'] : null;
	
			// Prepare the query to update the task
			$update_task = $this->db->prepare("UPDATE task_info SET 
				dv_no = :n, jev_no = :j, ada_no = :ada, ors_no = :ors, transaction_ref_no = :ref, acic_batch_no = :acic, po_no = :po, pr_no = :pr, form_no = :fn,
				payee_sms_id = :p, transaction_id = :r, t_description = :y, t_department_id = :e, gross_amount = :g,
				net_amount = :t, t_end_time = :a, t_user_id = :b, 
				status = :c, location = :l, comment = :d 
				WHERE task_id = :id");

			// Bind all parameters
			$update_task->bindParam(':n', $dv_no);
			$update_task->bindParam(':j', $jev_no);
			$update_task->bindParam(':ada', $ada_no);
			$update_task->bindParam(':ors', $ors_no);
			$update_task->bindParam(':ref', $transaction_ref_no);
			$update_task->bindParam(':acic', $acic_batch_no);
            $update_task->bindParam(':po', $po_no);
            $update_task->bindParam(':pr', $pr_no);
            $update_task->bindParam(':fn', $form_no);
			$update_task->bindParam(':p', $payee_sms_id);
			$update_task->bindParam(':r', $transaction_id);
			$update_task->bindParam(':y', $task_description);
			$update_task->bindParam(':e', $t_department_id);
            $update_task->bindParam(':g', $gross_amount);
			$update_task->bindParam(':t', $net_amount);
			$update_task->bindParam(':a', $t_end_time);
			$update_task->bindParam(':b', $assign_to);
			$update_task->bindParam(':c', $status);
			$update_task->bindParam(':l', $location);
			$update_task->bindParam(':d', $comment);
			$update_task->bindParam(':id', $task_id);
	
			// Execute the query
			$update_task->execute();

            // Compose notification message
            $notif_msg = "Task #$task_id has been updated.";
            $sender_id = $_SESSION['admin_id']; // assuming this is stored in session
            $receiver_id = $assign_to; // the assigned employee
            date_default_timezone_set('Asia/Manila'); // Set timezone to Asia/Manila
            $notif_date = date("Y-m-d H:i:s");
            $is_read = 0;

            // Insert into notif table
            $insert_notif = $this->db->prepare("INSERT INTO notif (task_id, notif_msg, sender_id, receiver_id, notif_date, is_read) 
                VALUES (:task_id, :notif_msg, :sender_id, :receiver_id, :notif_date, :is_read)");
            $insert_notif->bindParam(':task_id', $task_id);
            $insert_notif->bindParam(':notif_msg', $notif_msg);
            $insert_notif->bindParam(':sender_id', $sender_id);
            $insert_notif->bindParam(':receiver_id', $receiver_id);
            $insert_notif->bindParam(':notif_date', $notif_date);
            $insert_notif->bindParam(':is_read', $is_read);
            $insert_notif->execute();

            // Make sure $task_id is already a plain value, not an array
            $task_id = is_array($task_id) ? $task_id['task_id'] : $task_id;

            // Get current user (assumed admin)
            $updated_by = $_SESSION['admin_id']; // assuming this is stored in session

            // Log the update in transmittal_report
            $insert_update_log = $this->db->prepare("
                INSERT INTO transmittal_report (task_id, updated_by, update_time) 
                VALUES (:task_id, :updated_by, NOW())
            ");
            $insert_update_log->bindParam(':task_id', $task_id, PDO::PARAM_INT);
            $insert_update_log->bindParam(':updated_by', $updated_by, PDO::PARAM_INT);
            $insert_update_log->execute();

			// Set success message and redirect
			$_SESSION['Task_msg'] = 'Task Updated Successfully';
			header('Location: pending-dv.php');
		} catch (PDOException $e) {
			echo "Error: " . $e->getMessage();
		}
	}
	


	/* =================Attendance Related===================== */
	public function add_punch_in($data){
		// data insert 
		$date = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
 		
		$user_id  = $this->test_form_input_data($data['user_id']);
		$punch_in_time = $date->format('d-m-Y H:i:s');

		try{
			$add_attendance = $this->db->prepare("INSERT INTO attendance_info (atn_user_id, in_time) VALUES ('$user_id', '$punch_in_time') ");
			$add_attendance->execute();

			header('Location: attendance-info.php');

		}catch (PDOException $e) {
			echo $e->getMessage();
		}
	}


	public function add_punch_out($data){
		$date = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
		$punch_out_time = $date->format('d-m-Y H:i:s');
		$punch_in_time  = $this->test_form_input_data($data['punch_in_time']);

		$dteStart = new DateTime($punch_in_time);
        $dteEnd   = new DateTime($punch_out_time);
        $dteDiff  = $dteStart->diff($dteEnd);
        $total_duration = $dteDiff->format("%H:%I:%S");

		$attendance_id  = $this->test_form_input_data($data['aten_id']);

		try{
			$update_user = $this->db->prepare("UPDATE attendance_info SET out_time = :x, total_duration = :y WHERE aten_id = :id ");

			$update_user->bindparam(':x', $punch_out_time);
			$update_user->bindparam(':y', $total_duration);
			$update_user->bindparam(':id', $attendance_id);
			
			$update_user->execute();

			header('Location: attendance-info.php');
		}catch (PDOException $e) {
			echo $e->getMessage();
		}

	}



	/* --------------------delete_data_by_this_method--------------*/

	public function delete_data_by_this_method($sql,$action_id,$sent_po){
		try{
			$delete_data = $this->db->prepare($sql);

			$delete_data->bindparam(':id', $action_id);

			$delete_data->execute();

			header('Location: '.$sent_po);
		}catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

/* ----------------------manage_all_info--------------------- */

	public function manage_all_info($sql) {
		try{
			$info = $this->db->prepare($sql);
			$info->execute();
			return $info;
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}





}
?>