<?php
ob_start();
session_start();
include("admin/db/config.php");
include("admin/db/function_xss.php");
// Checking Admin is logged in or not
if(!isset($_SESSION['customer'])) {
	header("location: index.php");
	exit;
}
$Statement = $pdo->prepare("SELECT * FROM send_user_email WHERE user_id = '".$_SESSION['customer']['user_id']."' order by id desc");
$Statement->execute(); 
$total = $Statement->rowCount();    
$result = $Statement->fetchAll(PDO::FETCH_ASSOC); 
$output = array('data' => array());
$sum = 0;
if($total > 0) {
	$statuss = "";
	foreach($result as $row) {
		$sum = $sum + 1 ;
		$subject = _e($row['subject']);
		$email = _e($row['user_email']);
		$smsText = nl2br($row['email_text']);
		$smsDate = _e($row['email_date']);
		$smsDate =  date('d F, Y',strtotime($smsDate));
		$output['data'][] = array( 		
		$sum,
		$smsDate,
		$email, 
		$subject,
		$smsText
		); 	
	}
}
echo json_encode($output);
?>