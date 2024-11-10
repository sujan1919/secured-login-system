<?php
ob_start();
session_start();
include("db/config.php");
include("db/function_xss.php");
// Checking Admin is logged in or not
if(!isset($_SESSION['admin'])) {
	header("location: login.php"); 
	exit;
}
$Statement = $pdo->prepare("SELECT * FROM admin_announcement WHERE 1 order by announcement_id desc ");
$Statement->execute(); 
$total = $Statement->rowCount();    
$result = $Statement->fetchAll(PDO::FETCH_ASSOC); 
$output = array('data' => array());
if($total > 0) {
	$active = "";
	foreach($result as $row) {
		$announceId = _e($row['announcement_id']) ;
		$announceText = strip_tags($row['announcement_text']);
		$announceDate = _e($row['announcement_date']);
		$announceDate =  date('d F, Y',strtotime($announceDate));
		$status = _e($row['announcement_status']);
		if($status== 1) {
			// deactivate announcement
			$active ="<b>Active</b>";
			$banAnnounce = '<button type="button" name="changeAnnounceStatus" id="'.$announceId.'" class="btn btn-danger btn-sm changeAnnounceStatus" data-status="0"><i class="fa fa-ban"></i></button>';
		} else {
			// activate announcement
			$active ="<b class='text-danger'>Not Active</b>";
			$banAnnounce = '<button type="button" name="changeAnnounceStatus" id="'.$announceId.'" class="btn btn-success btn-sm changeAnnounceStatus" data-status="1"><i class="fa fa-check"></i></button>';
		} 
		$editAnnounce = '<button type="button" name="editAnnounceStatus" id="'.$announceId.'" class="btn btn-light btn-sm editAnnounceStatus" ><i class="fa fa-pencil-alt"></i></button>'; 
		$output['data'][] = array( 		
		$announceId,
		$announceDate,
		$announceText,
		$active,
		$editAnnounce,
		$banAnnounce
		); 	
	}
}
echo json_encode($output);
?>