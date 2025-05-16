<?php
require_once 'db_conn.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_id     = $_POST['task_id']     ?? null;
    $comment     = trim($_POST['comment'] ?? '');
    date_default_timezone_set('Asia/Manila');
    $timestamp   = date('Y-m-d H:i:s');
    $current_user = $_SESSION['admin_id'];

    if ($task_id && $current_user) {
        // 1) Fetch current approver's fullname
        $appr_stmt = $conn->prepare("SELECT fullname FROM tbl_admin WHERE user_id = ?");
        $appr_stmt->bind_param("i", $current_user);
        $appr_stmt->execute();
        $appr = $appr_stmt->get_result()->fetch_assoc();
        $user_name = $appr['fullname'] ?? 'Unknown Approver';

        // 2) Set new assignee
        $new_user_id = 59;
        $new_dept_id = 6;

        // 3) Update task_info: assign to user_id 59, department 6, status 7
        $update_sql = "
            UPDATE task_info
            SET 
              t_user_id = ?,
              t_department_id = ?,
              status = 5
            WHERE task_id = ?
        ";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("iii", $new_user_id, $new_dept_id, $task_id);
        $update_stmt->execute();

        // 4) Fetch the full name of the new assignee
        $assignee_stmt = $conn->prepare("SELECT fullname FROM tbl_admin WHERE user_id = ?");
        $assignee_stmt->bind_param("i", $new_user_id);
        $assignee_stmt->execute();
        $assignee = $assignee_stmt->get_result()->fetch_assoc();
        $assignee_name = $assignee['fullname'] ?? 'User 59';

        // 5) Build approval note with newline
        $approve_note = "\nApproved by {$user_name} on {$timestamp}, Assigned to {$assignee_name}";
        if ($comment !== '') {
            $approve_note .= ", Reason: {$comment}";
        }
        $approve_note .= ".";

        // 6) Append the note to the comment field
        $comment_sql = "
            UPDATE task_info
            SET comment = CONCAT(IFNULL(comment, ''), ?)
            WHERE task_id = ?
        ";
        $comment_stmt = $conn->prepare($comment_sql);
        $comment_stmt->bind_param("si", $approve_note, $task_id);
        $comment_stmt->execute();

        // 7) Log the action in transmittal_report
        $insert_sql = "
            INSERT INTO transmittal_report (task_id, updated_by, update_time)
            VALUES (?, ?, NOW())
        ";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("ii", $task_id, $current_user);
        $insert_stmt->execute();
    }

    header("Location: pending-dv.php");
    exit;
}
?>
