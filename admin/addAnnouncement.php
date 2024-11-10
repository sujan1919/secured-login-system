<?php 
require_once('header.php');

?>

<div class="app-title">
        <div>
          <h1><i class="fa fa-key"></i> Manage Announcement</h1>
		  <p class="text-success">You can Easily Manage your Announcement via Edit / Activate or Deactivate Announcement.</p>
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
		   			<div class="col-md-12 col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								
								<button class="btn btn-info  m-1 bg-success border-success" id="add_announce"><i class="fa fa-bullhorn"></i> Add Announcement</button>
							</div> <!-- /panel-heading -->
							<div class="panel-body">
								<div class="remove-messages"></div>
								<div class="row">
									<div class="col-md-12">
									  <div class="tile">
										<div class="tile-body">
											<div class="table-responsive">
												<table class="table table-bordered table-hover" id="manageAnnouncementTable">
													<thead>
														<tr>
															<th>Announcement ID</th>	
															<th>Date</th>					
															<th>Text</th>
															<th>Status</th>
															<th><i class="fa fa-pencil-alt"></i></th>
															<th><i class="fa fa-ban"></i></th>
														</tr>
													</thead>
												</table><!-- /table -->
											</div>
										</div>
									</div>
								</div>
							</div>
							</div> <!-- /panel-body -->
					</div> <!-- /panel -->	
					</div>
				</div>
			</div>
		</div>
	</div>
</main><!-- page-content" -->
	<!-- Add Announcement Modal -->
	<div id="announcementModal" class="modal fade">
    	<div class="modal-dialog">
    		<form method="post" id="announcement_form">
    			<div class="modal-content">
    				<div class="modal-header">
						<h4 class="modal-title"><i class="fa fa-plus"></i> Add Announcement</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
    				</div>
    				<div class="modal-body">
						<div class="form-group col-md-6 my-1">
							<label>Announcement Date*</label>
							<input type="text" class="form-control announce_date" id="announce_date" name="announce_date" placeholder="Announcement Date*" autocomplete="off" required>
						</div>
						<div class="form-group col-md-12">
							<label>Announcement Text*</label>
							<textarea placeholder="Announcement Text*" rows="6" class="form-control" id="announceText" name="announceText" required ></textarea>
						</div> 
    				</div> 
    				<div class="modal-footer"> 
						<input type="hidden" name="announcement_id" id="announcement_id"/>
						<input type="hidden" name="btn_action" id="btn_action" />
    					<input type="submit" name="action" id="action" class="btn btn-info" value="Add Announcement" />
    					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    				</div>
    			</div>
    		</form>
    	</div>
    </div>
<?php require_once('footer.php'); ?>

