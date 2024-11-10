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
if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'changeAnnounceStatus')
	{
		$announceId = filter_var($_POST['announceId'], FILTER_SANITIZE_NUMBER_INT);
		$status = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
		if($announceId) { 
			$update = $pdo->prepare("UPDATE admin_announcement SET announcement_status=?   WHERE announcement_id=?");
			$result_new = $update->execute(array($status,$announceId));
			if($result_new) {
				echo 'Announcement status changed .' ;		
			}
		}
	}
	if($_POST['btn_action'] == 'fetch_announcement')
	{	
		if(!empty($_POST['announceId'])){
			$announceId = filter_var($_POST['announceId'], FILTER_SANITIZE_NUMBER_INT);
			$announce = $pdo->prepare("select * from admin_announcement where announcement_id = ?");
			$announce->execute(array($announceId));
			$result = $announce->fetchAll(PDO::FETCH_ASSOC);
			foreach($result as $row) {
				$output['announcementId'] = _e($row['announcement_id']);
				$output['announcementText'] = strip_tags($row['announcement_text']);
				$output['announcementDate'] = _e($row['announcement_date']);
			}
			echo json_encode($output) ;
		} else {
			echo "Error : Announcement Id is mandatory to View." ;
		}
	}
}
?>