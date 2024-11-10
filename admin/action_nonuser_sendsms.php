<?php
ob_start();
session_start();
include("db/config.php");
include("db/function_xss.php") ;
// Checking Admin is logged in or not
if(!isset($_SESSION['admin'])) {
	header("location: login.php");
	exit;
}
$headers = "";
if(isset($_POST['btn_action_nonuser']))
{
	if($_POST['btn_action_nonuser'] == 'SendEmail')
	{
		if(!empty($_POST['subject']) && !empty($_POST['email'])  && !empty($_POST['emailtext']) ){
		
			$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) ;
			$subject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING) ;
			$body = filter_var($_POST['emailtext'], FILTER_SANITIZE_STRING) ;
			$date = filter_var(date("Y-m-d"), FILTER_SANITIZE_STRING) ;
			$statement = $pdo->prepare("insert into send_nonuser_email (nonuser_subject, nonuser_email, nonuser_email_text, nonuser_email_date) values(?,?,?,?)") ;
			$statement->execute(array($subject,$email,$body,$date));
			if($statement){
				$to = $email ;
				$headers .= 'MIME-Version: 1.0' . "\r\n" ;
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n" ; 
				$headers .= $from . "\r\n" ; 
				if (mail($to, $subject, $body, $headers)) {
					echo "Email sent successfully.";
				} else {
					echo "Error in Sending Email. Try Again.";
				}
			}
		
		} else {
			echo "Error: All fields are mandatory to send Email.";
		}
	}
}
?>