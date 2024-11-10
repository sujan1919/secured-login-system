<?php
ob_start();
session_start();
require_once('db/config.php');
require_once("db/function_xss.php");
$err = '0' ;
$headers = "";
	//check fullname, email, password should not be empty
	if( !empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['url']) ){
		$fullname = filter_var($_POST['username'], FILTER_SANITIZE_STRING) ;
		$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) ;
		$url = filter_var($_POST['url'], FILTER_SANITIZE_URL) ;
		$password = filter_var($_POST['password'], FILTER_SANITIZE_STRING) ;
		$uppercase = preg_match('@[A-Z]@', $password);
		$lowercase = preg_match('@[a-z]@', $password);
		$number    = preg_match('@[0-9]@', $password);
		//validate password
		if(!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
		  $err = 1 ;
		  echo $err ;
		} else {
				//checking database for already registered mobile
				$checkUser =  $pdo->prepare("SELECT * FROM customer_active WHERE user_email=?");
		 		$checkUser->execute(array($email));
		 		$user_ok = $checkUser->rowCount();
				if($user_ok > 0) {
					$err = 2 ;
		 		    echo $err ;
				} else {
					$to = $email ;
					$headers .= 'MIME-Version: 1.0' . "\r\n" ;
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n" ; 
					$headers .= $from . "\r\n" ; 
					$subject = "Congratulations! You are active User Now." ;
					$body = "Hello <b>".$fullname."</b>, You are active User Now. Login Details are <b>Email : ".$email.", Password : ".$password."</b> & <b>Login Link is ".$url."</b>";
					if (mail($to, $subject, $body, $headers))
					{
						$ins = $pdo->prepare("INSERT INTO customer_active (user_fullname, user_email, user_authpass,active_status) VALUES (?,?,?,?)");
						$ins->execute(array($fullname,$email,password_hash($password, PASSWORD_DEFAULT),'1'));
					
					}
					$output = array( 
								'error' => 0
							) ;
					echo json_encode($output);
					
				}
			
		}
	
	} 

?>
