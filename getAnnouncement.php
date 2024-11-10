<?php
ob_start();
session_start();
include("admin/db/config.php");
include("admin/db/CSRF_Protect.php");
include("admin/db/function_xss.php");
$csrf = new CSRF_Protect();
// Checking User is logged in or not
if(!isset($_SESSION['customer'])) {
	header('location: index.php');
	exit;
}
function displayTextWithLinks($s) {
  return preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank">$1</a>', $s);
}
if(!empty($_POST["id"])){
	$sql = "SELECT count(*) as number_rows FROM admin_announcement WHERE announcement_status='1' and announcement_id < ".$_POST['id']." order by announcement_id desc " ;
	$admin_announcement = $pdo->prepare($sql);
	$admin_announcement->execute(); 
	$announcement = $admin_announcement->fetchAll(PDO::FETCH_ASSOC);
	foreach($announcement as $row) {
		$totalRows = _e($row['number_rows']);
	}
	$limit = '4' ;
	$statement = $pdo->prepare("select * from admin_announcement WHERE announcement_status='1' and announcement_id < ".$_POST['id']." order by announcement_id desc Limit ".$limit."");
	$statement->execute();
	$total = $statement->rowCount();
	$announ = $statement->fetchAll(PDO::FETCH_ASSOC);
		foreach($announ as $notice) {
			$announceId = _e($notice['announcement_id']);
			$Note = nl2br($notice['announcement_text']);
			$Note = displayTextWithLinks($Note);
			$officialDate = _e($notice['announcement_date']);
			$officialDate =  date('d F, Y',strtotime($officialDate));
			?>
					<div class="card-deck mb-3 text-center  ">
					<div class="card mb-3 box-shadow basic-my-div shadow-lg ">
					  <div class="card-header bg-info">
						<h4 class="my-0 font-weight-normal text-light"><?php echo $officialDate ; ?></h4>
					  </div>
					  <div class="card-body bg-light ">
						<h5 class="myLi text-muted"><?php echo nl2br($Note) ; ?></h5>
					  </div>
					</div>
					</div>
				<?php
		}
		?>
					<?php if($totalRows > $limit){ ?>
						<div class="show_more_new_announcement" id="show_more_new_announcement<?php echo $announceId; ?>">
							
							<div class="col text-center p-2">
							<div id="loader-icon"><img src="images/loader.gif" /></div>
							<button id="<?php echo $announceId; ?>" class="show_more_announcement btn btn-light btn-sm" >Load More</button>
							</div>
							
						</div>
					<?php
					} else {
					?>
						<div class="col text-center p-2"><button  class="disabled btn btn-danger btn-sm " >No More Announcement</button></div>
					<?php
					}
}
?>