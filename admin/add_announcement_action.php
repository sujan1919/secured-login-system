<?php
ob_start();
session_start();
include("db/config.php");
// Checking Admin is logged in or not
if(!isset($_SESSION['admin'])) {
	header("location: login.php"); 
	exit;
}
if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'AddAnnouncement') {
		if(!empty($_POST['announce_date']) && !empty($_POST['announceText']) ) {
			$announce_date = filter_var(date($_POST['announce_date']) , FILTER_SANITIZE_STRING);
			$announceText = filter_var($_POST['announceText'], FILTER_SANITIZE_STRING) ;
			$ins = $pdo->prepare("insert into admin_announcement (announcement_text, announcement_date) values (?,?)");
			$ins->execute(array($announceText,$announce_date));
			if($ins) {
				$update = $pdo->prepare("update user_announcement_read set read_announcement='0' where 1");
				$update->execute();
				echo 'Announcement Live Successfully .' ;		
			} else {
				echo 'Something went wrong. Try again after Refresh the page.';
			}
		} else {
			echo "All fields are mandatory" ; 
		}
	}
	if($_POST['btn_action'] == 'EditAnnouncement') {
		if(!empty($_POST['announce_date']) && !empty($_POST['announceText']) && !empty($_POST['announcement_id']) ) {
			$announceId = filter_var($_POST['announcement_id'], FILTER_SANITIZE_NUMBER_INT);
			$announce_date = filter_var(date($_POST['announce_date']) , FILTER_SANITIZE_STRING);
			$announceText = filter_var($_POST['announceText'], FILTER_SANITIZE_STRING) ;
			$upd = $pdo->prepare("update admin_announcement set announcement_text=? , announcement_date=? where announcement_id = ?");
			$upd->execute(array($announceText,$announce_date,$announceId));
			if($upd) {
				$update = $pdo->prepare("update user_announcement_read set read_announcement='0' where 1");
				$update->execute();
				echo 'Announcement Edited Successfully .' ;		
			} else {
				echo 'Something went wrong. Try again after Refresh the page.';
			}
		} else {
			echo "All fields are mandatory" ; 
		}
	}
}
?>