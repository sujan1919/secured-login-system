<?php 
require_once('header.php');
?>
<div class="app-title">
        <div>
          <h1><i class="fa fa-users"></i> Send Email to Non User</h1>
		  <p class="text-success">Send Email to Any Email Address in the World.</p>
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
								<div class="page-heading"> 
								<button class="btn btn-info  m-1 bg-success border-success" id="add_nonuser_email"><i class="fa fa-user"></i> Send Email to Any Email Address</button>
								</div>
							</div> <!-- /panel-heading -->
							<div class="panel-body">
								<div class="remove-messages"></div>
								<div class="row">
									<div class="col-md-12">
									  <div class="tile">
										<div class="tile-body">
											<div class="table-responsive">
												<table class="table table-bordered table-striped" id="manageNonCustomerTable">
													<thead>
														<tr>
															<th>S.No.</th>
															<th>Date</th>
															<th>Email</th>							
															<th>Subject</th>
															<th>Email Text</th>
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
</main>	<!-- page-content" -->
<!-- Add User Modal -->
	<div id="nonuserModal" class="modal fade">
    	<div class="modal-dialog">
    		<form method="post" id="nonuser_form">
    			<div class="modal-content">
    				<div class="modal-header">
						<h4 class="modal-title"><i class="fa fa-plus"></i> Send Email</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
    				</div>
    				<div class="modal-body">
						
						<div class="form-group">
							<label>Email*</label>
							<input type="email" class="form-control" id="email" name="email" placeholder="User Email*" autocomplete="off" required maxlength="50">
						</div>
						<div class="form-group">
							<label>Email Subject* </label>
							<input type="text" name="subject" id="subject" class="form-control" required autofocus  maxlength="50"> 
						</div>
						<div class="form-group">
							<label>Email Text* </label>
							<textarea name="emailtext" class="form-control" rows="4" ></textarea>
						</div>
    				</div> 
    				<div class="modal-footer"> 
						
						<input type="hidden" name="btn_action_nonuser" id="btn_action_nonuser" />
    					<input type="submit" name="action_nonuser" id="action_user" class="btn btn-info" value="Send Email" />
    					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    				</div>
    			</div>
    		</form>
    	</div>
    </div>

<?php require_once('footer.php'); ?>

