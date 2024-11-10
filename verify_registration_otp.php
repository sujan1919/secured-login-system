<?php
ob_start();
session_start();
require_once('admin/db/config.php');
$err = 0 ;
if( !empty($_POST['email']) && !empty($_POST['otp']) && !empty($_POST['fullname']) && !empty($_POST['password']) ){
	$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) ;
	$otp = filter_var($_POST['otp'], FILTER_SANITIZE_NUMBER_INT) ;
	$fullname = filter_var($_POST['fullname'], FILTER_SANITIZE_STRING) ;
	$password = filter_var($_POST['password'], FILTER_SANITIZE_STRING) ;
	$otpAuthentication =  $pdo->prepare("SELECT * FROM customer_tmp WHERE user_email=? and user_otp=?");
	$otpAuthentication->execute(array($email,$otp));
	$otp_ok = $otpAuthentication->rowCount();
	if($otp_ok > 0) {
		//delete customer from temp
		$del_tmp=$pdo->prepare("DELETE FROM customer_tmp WHERE user_email=?");
		$del_tmp->execute(array($email));
		//insert customer into Active table
		$ins_in_active = $pdo->prepare("INSERT INTO customer_active (user_fullname, user_email, user_authpass, user_address, user_country, user_state, user_city, user_zipcode, active_status) VALUES (?,?,?,?,?,?,?,?,?)");
		$ins_in_active->execute(array($fullname,$email,password_hash($password, PASSWORD_DEFAULT),'','','','','',filter_var("1", FILTER_SANITIZE_NUMBER_INT)));
		//create user session
		if($ins_in_active) {
			$statement_active = $pdo->prepare("SELECT * FROM customer_active WHERE user_email=? AND active_status=?");
			$statement_active->execute(array($email,filter_var("1", FILTER_SANITIZE_NUMBER_INT)));   
			$result_active = $statement_active->fetchAll(PDO::FETCH_ASSOC);
			foreach($result_active as $row)
				{
					$_SESSION['customer'] = $row;
				}
		}
		$err = 1 ;
		echo $err ;
	}
	else {
		echo $err ; 
	}

} else {
	header("location: index.php");
}
?>