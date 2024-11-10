<?php
ob_start();
session_start();
require_once('admin/db/config.php');
if(!isset($_SESSION['customer'])) {
	header('location: index.php');
	exit;
}
$err = 0 ;
if( !empty($_POST['newemail']) && !empty($_POST['id']) && !empty($_POST['otp']) ){
	$id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT) ;
	$newemail = filter_var($_POST['newemail'], FILTER_SANITIZE_EMAIL) ;
	$otp = filter_var($_POST['otp'], FILTER_SANITIZE_NUMBER_INT);
	$otpAuthentication =  $pdo->prepare("SELECT * FROM customer_active WHERE user_id=? and user_otp=? and active_status=?");
	$otpAuthentication->execute(array($id,$otp,filter_var("1", FILTER_SANITIZE_NUMBER_INT)));
	$otp_ok = $otpAuthentication->rowCount();
	$userData = $otpAuthentication->fetchAll(PDO::FETCH_ASSOC);
	if($otp_ok > 0) {
		$update_mobile = $pdo->prepare("UPDATE customer_active SET user_email = ? , user_tmp_email = ? WHERE user_id=?");
		$update_mobile->execute(array($newemail,NULL,$id));
		$err = 1;
		echo $err ;
	}
	else {
		echo $err ;
	}

} else {
	header("location: manage_email.php");
}
?>
