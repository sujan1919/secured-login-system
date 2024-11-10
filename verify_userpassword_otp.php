<?php 
include_once("admin/db/config.php");
include_once("admin/db/function_xss.php");
require_once('admin/db/api_otp_generate.php');
$err = 0 ;
$admin = $pdo->prepare("SELECT * FROM ot_admin WHERE admin_status=?");
$admin->execute(array(filter_var("1", FILTER_SANITIZE_NUMBER_INT)));   
$admin_result = $admin->fetchAll(PDO::FETCH_ASSOC);
foreach($admin_result as $adm) {
//escape admin email
	$admin_email   = _e($adm['email']);
}
	if( !empty($_POST['email']) ){
		$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) ;
		$checkUser = $pdo->prepare("SELECT * FROM customer_active WHERE user_email = ? and active_status = ?");
		$checkUser->execute(array($email,filter_var("1", FILTER_SANITIZE_NUMBER_INT)));
		$user_ok = $checkUser->rowCount();
		if($user_ok > 0) {
			$otp = filter_var(code(4), FILTER_SANITIZE_NUMBER_INT) ;
			$to = $email ;
			$from = $admin_email ;
			$from = "Verification Email From : ".$from ;
			$headers .= 'MIME-Version: 1.0' . "\r\n" ;
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n" ; 
			$headers .= $from . "\r\n" ; 
			$subject = "Password OTP" ;
			$body = "<br>Password OTP is <br><h3>".$otp."</h3><br>Please Do not share with anyone at any cost.";
			if (mail($to, $subject, $body, $headers)){
				$update_otp = $pdo->prepare("UPDATE customer_active SET user_otp = ? WHERE user_email=?");
				$update_otp->execute(array($otp,$email));
				$err = $email ;
				echo $err ;
			}
		} else {
			echo $err ;
		}
	} else {
		header("location: user_password.php");
	}

?>