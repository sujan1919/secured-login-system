<?php
ob_start();
session_start();
require_once('admin/db/config.php');
require_once("admin/db/function_xss.php");
require_once('admin/db/api_otp_generate.php');
$err = '0' ;
	//check fullname, mobile, password & confirm password should not be empty
	if( !empty($_POST['fullname']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['repassword']) && !empty($_POST['admin_email']) ){
		$fullname = filter_var($_POST['fullname'], FILTER_SANITIZE_STRING) ;
		$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) ;
		$admin_email = filter_var($_POST['admin_email'], FILTER_SANITIZE_EMAIL) ;
		$password = filter_var($_POST['password'], FILTER_SANITIZE_STRING) ;
		$repassword = filter_var($_POST['repassword'], FILTER_SANITIZE_STRING) ;
		$uppercase = preg_match('@[A-Z]@', $password);
		$lowercase = preg_match('@[a-z]@', $password);
		$number    = preg_match('@[0-9]@', $password);
		//validate password
		if(!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
		  $_SESSION['error_message'] = 'Password must contain 8 characters, an uppercase character, a lowercase character & atleast 1 number. Try Again';
		  $err = 1 ;
		  echo $err ;
		} else {
			//check password and confirm password are same
			if($password == $repassword) {
				//checking database for already registered mobile
				$checkUser =  $pdo->prepare("SELECT * FROM customer_active WHERE user_email=?");
		 		$checkUser->execute(array($email));
		 		$user_ok = $checkUser->rowCount();
				if($user_ok > 0) {
					$err = 3 ;
		 		    echo $err ;
				} else {
					$otp = filter_var(code(4), FILTER_SANITIZE_NUMBER_INT) ;
					$to = $email ;
					$from = $admin_email ;
					$from = "Verification OTP: ".$from ;
					$headers .= 'MIME-Version: 1.0' . "\r\n" ;
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n" ; 
					$headers .= $from . "\r\n" ; 
					$subject = "SignUp OTP" ;
					$body = "<br>Sign Up OTP is <br><h3>".$otp."</h3><br>Please Do not share with anyone at any cost.";
					if (mail($to, $subject, $body, $headers))
					{
						//first we insert/update user into temp table until they verify OTP
						$chkUserTmp = $pdo->prepare("SELECT * FROM customer_tmp WHERE user_email=?");
						$chkUserTmp->execute(array($email));
						$tmp_user = $chkUserTmp->rowCount();
						if($tmp_user > 0) {
							$update_tmp_user = $pdo->prepare("UPDATE customer_tmp SET user_fullname=? , user_authpass=? , user_otp=? WHERE user_email=?");
							$update_tmp_user->execute(array($fullname,password_hash($password, PASSWORD_DEFAULT),$otp,$email));
						} else {
							$ins_in_tmp = $pdo->prepare("INSERT INTO customer_tmp (user_fullname, user_email, user_authpass, user_otp) VALUES (?,?,?,?)");
							$ins_in_tmp->execute(array($fullname,$email,password_hash($password, PASSWORD_DEFAULT),$otp));
						}
						$output = array( 
									'fullname'    => $fullname,
									'password'    => $password,
									'email'      => $email,
									'error'       => 0
								) ;
						echo json_encode($output);
					}
				}
			} else {
				$err = 2 ;
				echo $err ;
			}
		}
	
	} else {
		header("location: index.php");
	}

?>