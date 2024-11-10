<?php
ob_start();
session_start();
require_once('db/config.php');
if(!isset($_SESSION['admin'])) {
	header('location: login.php');
	exit;
}
$err = 1 ;
if( isset($_POST['announcementShow'])){
	$announcementShow = filter_var($_POST['announcementShow'], FILTER_SANITIZE_NUMBER_INT) ;
	$update_setting = $pdo->prepare("UPDATE ot_admin SET show_announcement=? WHERE id='1'");
	$update_setting->execute(array($announcementShow));
	$err = 0 ;
	echo $err ;
} else {
	$err = 1 ;
	echo $err ;
}
?>