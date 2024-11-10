<?php
ob_start();
session_start();
include("db/config.php");
include("db/function_xss.php");
// Checking Admin is logged in or not
if(!isset($_SESSION['admin'])) {
	header("location: ".ADMIN_URL."/login.php");
	exit;
}
$Statement = $pdo->prepare("SELECT * FROM send_nonuser_email WHERE 1 order by id desc");
$Statement->execute(); 
$total = $Statement->rowCount();    
$result = $Statement->fetchAll(PDO::FETCH_ASSOC); 
$output = array('data' => array());
$sum = 0;
if($total > 0) {
	foreach($result as $row) {
		$sum = $sum + 1 ;
		$subject = _e($row['nonuser_subject']);
		$email = _e($row['nonuser_email']);
		$smsText = (nl2br($row['nonuser_email_text']));
		$smsDate = _e($row['nonuser_email_date']);
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