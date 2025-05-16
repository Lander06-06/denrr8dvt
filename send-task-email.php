
<?php
require 'db_conn.php';
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$task_id = $_POST['task_id'] ?? null;
if (!$task_id) {
    echo json_encode(["status" => "error", "message" => "Task ID is missing"]);
    exit;
}

// Fetch Task Info
$query = $conn->prepare("SELECT dv_no, jev_no, ada_no, transaction_ref_no, acic_batch_no, t_description, gross_amount, net_amount, t_start_time, t_end_time, t_user_id, payee_sms_id, transaction_id, t_department_id, status, location, comment FROM task_info WHERE task_id = ?");
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

$statusNames =[
    0 => "Processing",
    1 => "For Compliance",
    2 => "Paid",
    3 => "Completed",
    4 => "Complied",
    5 => "For Payment",
    6 => "For Certification",
    7 => "For Approval"

];
$statusName = $statusNames[$taskData['status']] ?? "Uknown Status";

// Fetch the payee's email and payee name from the payee table
$payeeQuery = $conn->prepare("SELECT payee_email, payee_name FROM payee WHERE payee_sms_id = ?");
$payeeQuery->bind_param("i", $taskData['payee_sms_id']);
$payeeQuery->execute();
$payeeResult = $payeeQuery->get_result();
$payeeData = $payeeResult->fetch_assoc(); // fetch payee data

if (!$payeeData) {
    echo json_encode(["status" => "error", "message" => "Payee not found"]);
    exit;
}

$payeeEmail = $payeeData['payee_email'] ?? null;
$payeeName = $payeeData['payee_name'] ?? null;

// Now merge payee details into taskData if necessary
$taskData['payee_email'] = $payeeEmail;
$taskData['payee_name'] = $payeeName;

// Check if payee email exists
if (!$payeeEmail) {
    echo json_encode(["status" => "error", "message" => "Payee email not found"]);
    exit;
}

// Fetch the user's fullname based on t_user_id from tbl_admin
$userQuery = $conn->prepare("SELECT fullname FROM tbl_admin WHERE user_id = ?");
$userQuery->bind_param("i", $taskData['t_user_id']);
$userQuery->execute();
$userResult = $userQuery->get_result();
$userData = $userResult->fetch_assoc(); // Fetch user data

if (!$userData) {
    echo json_encode(["status" => "error", "message" => "User not found"]);
    exit;
}

$taskData['fullname'] = $userData['fullname'] ?? "Unknown User";

// Fetch the transaction type based on the transaction_id from the transaction table
$transactionQuery = $conn->prepare("SELECT transaction_type FROM transaction WHERE transaction_id = ?");
$transactionQuery->bind_param("i", $taskData['transaction_id']);
$transactionQuery->execute();
$transactionResult = $transactionQuery->get_result();
$transactionData = $transactionResult->fetch_assoc(); // Fetch transaction data

// Debugging: Show the transaction_id for troubleshooting
if (!$transactionData) {
    echo json_encode(["status" => "error", "message" => "Transaction not found for transaction_id: " . $taskData['transaction_id']]);
    exit;
}

$taskData['transaction_type'] = $transactionData['transaction_type'] ?? "Unknown Transaction Type";

// Skip email if status is Completed
if ($taskData['status'] == 3) {
    echo json_encode(["status" => "skipped", "message" => "This DV is completed. No more updates to the claimant thankyou"]);
    exit;
}

$mail = new PHPMailer(true);
try {
    // SMTP Configuration
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'denr8paidvouchers@gmail.com';
    $mail->Password = 'iaxh iesw jlyr aycx'; 
    $mail->AddEmbeddedImage('assets/img/logoemail.png', 'logoemail');
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Email Setup

    $mail->setFrom('denr8paidvouchers@gmail.com', 'DENR RVIII DISBURSEMENT VOUCHER TRACKING SYSTEM');
    $mail->addReplyTo('no-reply@DisbursementVoucherTrackingSystem.com', 'No-Reply');

    $mail->addAddress($payeeEmail); // Send to actual payee email
    $mail->Subject = "Disbursement Voucher Updates";


    // Email Body with proper location


    // Determine text color based on status
$statusTextColor = "#28a745"; // Default to green (Completed)
if ($statusName === "For Compliance") {
    $statusTextColor = "#dc3545"; // Red for Incomplete
} elseif ($statusName === "Processing") {
    $statusTextColor = "#ffc107"; // Yellow for Processing
} elseif ($statusName === "For Certification") {
    $statusTextColor = "#ffc107"; // Yellow for Processing
} elseif ($statusName === "For Approval") {
    $statusTextColor = "#ffc107"; // Yellow for Processing
}
$status = $taskData['status'];
$departmentId = $taskData['t_department_id'];
$assignTo = $taskData['t_department_id']; // Replace with department name if needed

// Determine message based on status and department
if ($status == 1 && $departmentId == 6) {
    $statusMsg = "Please be informed that your <strong>CLAIMS</strong> has been submitted to <strong>{$assignTo}</strong> for processing. Below are the details of the transaction. Please wait while we process your request.";
} elseif ($status == 1) {
    $statusMsg = "Please be informed that your <strong>CLAIMS</strong> has been submitted to <strong>{$assignTo}</strong> <strong>FOR COMPLIANCE</strong>.";
} elseif ($status == 2) {
    $statusMsg = "We are pleased to inform you that your <strong>CLAIMS</strong> has been <strong>PAID</strong>. Thank you for your patience.";
} elseif ($status == 5) {
    $statusMsg = "Please be informed that your <strong>CLAIMS</strong> has been submitted to <strong>{$assignTo}</strong> <strong>FOR PAYMENT</strong>.";
} elseif ($status == 6) {
    $statusMsg = "Please be informed that your <strong>CLAIMS</strong> has been submitted to <strong>{$assignTo}</strong> <strong>FOR CERTIFICATION</strong>.";
} elseif ($status == 7) {
    $statusMsg = "Please be informed that your <strong>CLAIMS</strong> has been submitted to <strong>{$assignTo}</strong> <strong>FOR APPROVAL</strong>.";
} else {
    $statusMsg = "Please be informed that your <strong>CLAIMS</strong> has been submitted to <strong>{$assignTo}</strong> for <strong>PROCESSING</strong>.";
}

$emailBody = "
<div style='font-family: Arial, sans-serif; color: #000; padding: 20px;'>

    <!-- Logo -->
    <div style='text-align: left; margin-bottom: 20px;'>
        <img src='cid:logoemail' alt='Logo' style='height: 120px;'>
    </div>

    <!-- Greeting -->
    <p style='font-size: 16px; color: #000;'><strong>Dear {$taskData['payee_name']},</strong></p>
    <p style='font-size: 16px; color: #000;'>Greetings from the DENR RVIII - Finance Disbursement Voucher Tracking System!</p>

    <!-- Status -->
    <p style='font-size: 16px; margin-bottom: 20px; color: #000;'>{$statusMsg}</p>

    <!-- Section Title 
    <h3 style='font-size: 18px; margin-bottom: 15px; color: #008DDA;'>Disbursement Details</h3>-->

    <!-- Disbursement Voucher Details (Table) -->
    <table style='width: 100%; font-size: 14px; line-height: 1.4; color: #000; border-spacing: 0;'>
        <tr>
            <td style='padding: 4px 0; font-weight: bold; white-space: nowrap; width: 200px;'>Disbursement Voucher No<span style='float:right;'>:</span></td>
            <td style='padding: 4px 8px;'>{$taskData['dv_no']}</td>
        </tr>
        <tr>
            <td style='padding: 4px 0; font-weight: bold;'>e-NGAS JEV No<span style='float:right;'>:</span></td>
            <td style='padding: 4px 8px;'>{$taskData['jev_no']}</td>
        </tr>
        <tr>
            <td style='padding: 4px 0; font-weight: bold;'>ADA/Check No<span style='float:right;'>:</span></td>
            <td style='padding: 4px 8px;'>{$taskData['ada_no']}</td>
        </tr>
        <tr>
            <td style='padding: 4px 0; font-weight: bold;'>Transaction Ref No<span style='float:right;'>:</span></td>
            <td style='padding: 4px 8px;'>{$taskData['transaction_ref_no']}</td>
        </tr>
        <tr>
            <td style='padding: 4px 0; font-weight: bold;'>Payee Name<span style='float:right;'>:</span></td>
            <td style='padding: 4px 8px;'>{$taskData['payee_name']}</td>
        </tr>
        <tr>
            <td style='padding: 4px 0; font-weight: bold;'>Transaction Type<span style='float:right;'>:</span></td>
            <td style='padding: 4px 8px;'>{$taskData['transaction_type']}</td>
        </tr>
        <tr>
            <td style='padding: 4px 0; font-weight: bold;'>Description<span style='float:right;'>:</span></td>
            <td style='padding: 4px 8px;'>{$taskData['t_description']}</td>
        </tr>
        <tr>
            <td style='padding: 4px 0; font-weight: bold;'>Gross Amount<span style='float:right;'>:</span></td>
            <td style='padding: 4px 8px;'>{$taskData['gross_amount']}</td>
        </tr>
        <tr>
            <td style='padding: 4px 0; font-weight: bold;'>Net Amount<span style='float:right;'>:</span></td>
            <td style='padding: 4px 8px;'>{$taskData['net_amount']}</td>
        </tr>
        <tr>
            <td style='padding: 4px 0; font-weight: bold;'>Current Track Location<span style='float:right;'>:</span></td>
            <td style='padding: 4px 8px;'>{$taskData['t_department_id']}</td>
        </tr>
        <tr>
            <td style='padding: 4px 0; font-weight: bold;'>Status<span style='float:right;'>:</span></td>
            <td style='padding: 4px 8px; font-weight: bold; color: {$statusTextColor};'>{$statusName}</td>
        </tr>
    </table>

    <!-- Disclaimer -->
    <div style='margin-top: 30px; font-size: 14px; color: #555;'>
        <p>
            Should you have concerns or clarifications, you may contact the Accounting Section through any of the following:
            <br>Telephone Number: (053) 832-0822
            <br>Email Address: <a href='mailto:denr8paidvouchers@gmail.com'>denr8paidvouchers@gmail.com</a>
        </p>

        <p>Please note: Do not share this information with anyone not authorized to receive it. Misuse or unauthorized disclosure of financial data is strictly prohibited and may result in administrative or legal action.</p>
        <p>This is an automated message. Please do not reply directly to this email.</p>
        <p>If you received this message in error, please notify us at <a href='mailto:denr8paidvouchers@gmail.com'>denr8paidvouchers@gmail.com</a> and delete it from your system immediately.</p>
    </div>

</div>
";



    $mail->isHTML(true);
    $mail->Body = $emailBody;

    if ($mail->send()) {
        echo json_encode(["status" => "success", "message" => "Email sent successfully", "email" => $payeeEmail]);
    } else {
        echo json_encode(["status" => "error", "message" => "Email sending failed"]);
    }
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => "Mailer Error: " . $mail->ErrorInfo]);
}

$conn->close();
exit;
