<?php
ob_start();
session_start();
require_once('admin/db/config.php');
if(!isset($_SESSION['customer'])) {
	header('location: index.php');
	exit;
}
$err = 0 ;
if( !empty($_POST['email']) && !empty($_POST['id']) && !empty($_POST['otp']) ){
	$id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT) ;
	$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) ;
	$otp = filter_var($_POST['otp'], FILTER_SANITIZE_NUMBER_INT);
	$otpAuthentication = $pdo->prepare("SELECT * FROM customer_active WHERE user_id=? and user_otp=? and active_status=?");
	$otpAuthentication->execute(array($id,$otp,filter_var("1", FILTER_SANITIZE_NUMBER_INT)));
	$otp_ok = $otpAuthentication->rowCount();
	if($otp_ok > 0) {
		$err = $email ;
		echo $err ;
	}
	else {
		echo $err ;
	}

} else {
	header("location: user_password.php");
}

?>