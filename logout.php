<?php
    session_start();
    unset($_SESSION['admin_id']);
    unset($_SESSION['admin_name']);
    unset($_SESSION['security_key']);
    unset($_SESSION['user_role']);
    header('Location: index.php');
?>