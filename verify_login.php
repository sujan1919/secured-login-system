<?php
ob_start();
session_start();
require_once('admin/db/config.php');
require_once("admin/db/function_xss.php");
$err = 0;
if( !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['admin_email']) ){
		 $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) ;
		 $admin_email = filter_var($_POST['admin_email'], FILTER_SANITIZE_EMAIL) ;
		 $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
		 $checkUser =  $pdo->prepare("SELECT * FROM customer_active WHERE user_email=? and active_status=?");
		 $checkUser->execute(array($email,filter_var("1", FILTER_SANITIZE_NUMBER_INT)));
		 $user_ok = $checkUser->rowCount();
		 $user_data = $checkUser->fetchAll(PDO::FETCH_ASSOC);
		 //check mobile & password is correct and user is active
		 if($user_ok > 0){
			foreach($user_data as $row){
				$auth_pass = _e($row['user_authpass']);
			}
			if(password_verify($password, $auth_pass)) {
				$err = 1 ;
				echo $err ;
				$_SESSION['customer'] = $row;
			} else {
				echo $err ; 
			}
		}
}
?>