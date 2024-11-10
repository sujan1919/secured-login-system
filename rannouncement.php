<?php 
ob_start();
session_start();
include("admin/db/config.php");
$admin = $pdo->prepare("SELECT * FROM ot_admin WHERE show_announcement=?");
$admin->execute(array(filter_var("1", FILTER_SANITIZE_NUMBER_INT)));   
$admin_result = $admin->rowCount();
if($admin_result == 0){ 
	header('location: dashboard.php');
}
//session Id
$id = filter_var($_SESSION['customer']['user_id'], FILTER_SANITIZE_NUMBER_INT);
$sel = $pdo->prepare("select * from user_announcement_read where user_id = '".$id."'");
$sel->execute();
$fe_total = $sel->rowCount();
if($fe_total > 0){
	$update = $pdo->prepare("update user_announcement_read set read_announcement='1' where user_id = ?");
	$update->execute(array($id));
} else {
	$ins = $pdo->prepare("insert into user_announcement_read (user_id, read_announcement) values (?,?)");
	$ins->execute(array($id,'1'));
}
header('location: announcement.php');
 ?>