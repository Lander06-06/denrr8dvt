<?php 
ob_start();
session_start();
require_once 'classes/admin_class.php';
$obj_admin = new Admin_Class();

if(isset($_GET['logout'])){
	$obj_admin->admin_logout();
}