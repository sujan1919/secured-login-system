<?php
ob_start();
session_start();
require_once('admin/db/config.php');
$err = 0 ;
	if( !empty($_POST['email']) && !empty($_POST['otp']) ){
		$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) ;
		$otp = filter_var($_POST['otp'], FILTER_SANITIZE_NUMBER_INT) ;
		$otpAuthentication =  $pdo->prepare("SELECT * FROM customer_active WHERE user_email=? and user_otp=? and active_status=?");
		$otpAuthentication->execute(array($email,$otp,filter_var("1", FILTER_SANITIZE_NUMBER_INT)));
		$otp_ok = $otpAuthentication->rowCount();
		$userData = $otpAuthentication->fetchAll(PDO::FETCH_ASSOC);
		if($otp_ok > 0) {
			$err = $email ;
			echo $err ;
		}
		else {
			echo $err ;
		}
	
	} else {
		header("location: index.php");
	}

?>