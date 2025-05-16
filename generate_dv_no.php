<?php
require_once 'authentication.php';

function generateDVNumber($db) {
    // Get the current year and month
    $year = date('y'); // Last two digits of the year
    $month = date('m'); // Two digits of the month

    // Prepare the SQL using PDO (assuming $db is PDO instance)
    $sql = "SELECT dv_no FROM task_info WHERE dv_no IS NOT NULL ORDER BY dv_no DESC LIMIT 1";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Extract and increment sequential number
    if ($row) {
        $lastDvNo = $row['dv_no'];
        $sequentialNumber = (int)substr($lastDvNo, 6) + 1;
    } else {
        $sequentialNumber = 1403;
    }

    // Format DV No. as YY-MM-XXXX
    $dvNo = $year . '-' . $month . '-' . str_pad($sequentialNumber, 4, '0', STR_PAD_LEFT);

    return $dvNo;
}
?>
