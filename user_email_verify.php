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
		$uid = filter_var($_POST['uid'], FILTER_SANITIZE_NUMBER_INT) ;
		//check this new email is already registered or not
		$checkUser =  $pdo->prepare("SELECT * FROM customer_active WHERE user_email=?");
		$checkUser->execute(array($email));
		$user_ok = $checkUser->rowCount();
		if($user_ok > 0) {
			echo $err ;
		} else {
			$err = $email ;
			$otp = filter_var(code(4), FILTER_SANITIZE_NUMBER_INT) ;
			$to = $email ;
			$from = $admin_email ;
			$from = "From: ".$from ;
			$headers .= 'MIME-Version: 1.0' . "\r\n" ;
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n" ; 
			$headers .= $from . "\r\n" ; 
			$subject = "Update Email OTP" ;
			$body = "<br>Update Email OTP is <br><h3>".$otp."</h3><br>Please Do not share with anyone at any cost.";
			if (mail($to, $subject, $body, $headers)){
				$update_tmp_mobile = $pdo->prepare("UPDATE customer_active SET user_otp = ? , user_tmp_email = ? WHERE user_id=?");
				$update_tmp_mobile->execute(array($otp,$email,$uid));
				echo $err ;
			} 
		}
	
	} else {
		header("location: manage_email.php");
	}
?>
