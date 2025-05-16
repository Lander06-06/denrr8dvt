<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'db_connection.php';

$task_id = $_POST['task_id'] ?? null;
if (!$task_id) {
    echo json_encode(["status" => "error", "message" => "Task ID is missing"]);
    exit;
}

// Fetch Task Info
$query = $conn->prepare("
    SELECT 
        t.dv_no, 
        t.jev_no,
        t.t_description, 
        t.t_start_time, 
        t.t_end_time, 
        t.t_user_id, 
        t.payee_sms_id, 
        t.transaction_id,
        t.status, 
        t.location, 
        t.t_department_id,
        t.comment, 
        p.payee_name, 
        u.fullname,
        r.transaction_type,
        d.department_name
    FROM task_info t
    LEFT JOIN payee p ON t.payee_sms_id = p.payee_sms_id
    LEFT JOIN tbl_admin u ON t.t_user_id = u.user_id
    LEFT JOIN transaction r ON t.transaction_id = r.transaction_id
    LEFT JOIN department d ON t.t_department_id = d.department_id
    WHERE t.task_id = ?
");
$query->bind_param("i", $task_id);
$query->execute();
$result = $query->get_result();
$taskData = $result->fetch_assoc();


if (!$taskData) {
    echo json_encode(["status" => "error", "message" => "Task not found"]);
    exit;
}



// Convert location number to division name
$locationNames = [
    1 => "Office of the Regional Director",
    2 => "ARD for Management Services",
    3 => "ARD for Technical Services",
    4 => "Planning and Management Division",
    5 => "Finance Division",
    6 => "Accounting Section",
    7 => "Budget Section",
    8 => "Legal Division",
    9 => "Administrative Division",
    10 => "Procurement Section",
    11 => "Cashier Section",
    12 => "Conservation and Development Division",
    13 => "Survey and Mapping Division",
    14 => "Licenses, Patents and Deeds Division",
    15 => "Enforcement Division"
];

$taskData['t_department_id'] = $locationNames[$taskData['t_department_id']] ?? "Unknown Division";

echo json_encode($taskData);
$conn->close();
exit;
