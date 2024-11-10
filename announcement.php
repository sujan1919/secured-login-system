<?php 
include("header.php") ;
if($admin_result == 0){ 
	header('location: dashboard.php');
}
?>
<div class="app-title">
        <div>
          <h1><i class="fa fa-bullhorn"></i> Admin Announcements</h1>
		  <p class="text-success">All Admin Announcements is really Important to Every Users.</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
        </ul>
 </div>
<main class="page-content">
    <div class="container-fluid">
      <div class="row">
	  	<div class="col-lg-12 col-md-12">
			<div class="row">
				<div class="col-md-3 col-lg-3"></div>
				<div class="col-md-6 col-lg-6">
				<div class="announce-res">
				<?php
				foreach($announcement as $notice) {
					$announceId = _e($notice['announcement_id']);
					$Note = (nl2br($notice['announcement_text']));
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
				<div class="show_more_new_announcement" id="show_more_new_announcement<?php if(!empty($announceId)) {echo $announceId; } ?>">
							
							<div class="col text-center p-2">
							<div id="loader-icon"><img src="images/loader.gif" class="img-fluid img-loader" /></div>
							<?php if(!empty($announceId)) { ?><button id="<?php echo $announceId; ?>" class="show_more_announcement btn btn-sm btn-light " >Load More</button><?php } ?>
							</div>
							
						</div>
				</div>
				</div>
				<div class="col-md-3 col-lg-3"></div>
			  </div>
		   </div>
	  </div>
   </div>
</main> <!-- page-content" -->

<?php include("footer.php") ; ?>