<?php 
require_once('header.php');
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
         $url = "https://";   
   } else  {
         $url = "http://";  
	} 
    // Append the host(domain name, ip) to the URL.   
    $url.= $_SERVER['HTTP_HOST'];   
    
    // Append the requested resource location to the URL   
    $url.= $_SERVER['REQUEST_URI'];
	$replace = "";
	$url = str_replace('/admin/edit_user.php', '' . $replace . '/', $url); 
	$serverUrl = $url ; 
?>
<div class="app-title">
        <div>
          <h1><i class="fa fa-file"></i> User Details</h1>
		  <p class="text-success">Activate or Deactivate User. Deactivated User automatically Logout when they click any option.</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
        </ul>
 </div>
	<div class="container">
		
      	<div class="row">
			<div class="col-lg-12 col-md-12">
				<div class="row">
		   			<div class="col-md-12 col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="page-heading"><button class="btn btn-info  m-1 bg-success border-success" id="add_user"><i class="fa fa-user"></i> Add User & Send Email</button></div>
							</div> <!-- /panel-heading -->
							<div class="panel-body">
								<div class="remove-messages"></div>
								<div class="row">
									<div class="col-md-12">
									  <div class="tile">
										<div class="tile-body">
								<div class="table-responsive">
									<table class="table table-bordered table-hover" id="manageCustomerTable">
										<thead>
											<tr>
												<th>ID</th>						
												<th>Fullname</th>							
												<th>Email</th>
												<th>Status</th>
												<th>Activate / Deactivate</th>
												<th>SendEmail</th>
											</tr>
										</thead>
									</table><!-- /table -->
								</div>
							</div> 
									</div>
								</div>
							</div><!-- /panel-body -->
					</div> <!-- /panel -->	
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- Add User Modal -->
	<div id="userModal" class="modal fade">
    	<div class="modal-dialog">
    		<form method="post" id="user_form">
    			<div class="modal-content">
    				<div class="modal-header">
						<h4 class="modal-title"><i class="fa fa-plus"></i> Add User & Send Email</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
    				</div>
    				<div class="modal-body">
						<div class="form-group">
							<label>User Fullname*</label>
							<input type="text" class="form-control" id="username" name="username" placeholder="User Fullname*" autocomplete="off" required maxlength="25">
						</div>
						<div class="form-group">
							<label>User Email*</label>
							<input type="email" class="form-control" id="email" name="email" placeholder="User Email*" autocomplete="off" required maxlength="50">
						</div>
						<div class="form-group">
							<label>User Password* <br><small>Password must contain minimum 8 characters, 1 Uppercase character, 1 Lowercase character & 1 number.</small></label>
							<input type="text" class="form-control" id="password" name="password" placeholder="User Password*" autocomplete="off" required maxlength="50">
						</div>
						
						<div class="removeuser-messages"></div>
    				</div> 
    				<div class="modal-footer"> 
						<input type="hidden" name="url" value="<?php echo $serverUrl ; ?>" >
						<input type="hidden" name="btn_action" id="btn_action" />
    					<input type="submit" name="action" id="action" class="btn btn-info" value="Add User & Send Credential Email" />
    					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    				</div>
    			</div>
    		</form>
    	</div>
    </div>
<!-- Send User Email Modal -->
	<div id="emailModal" class="modal fade">
    	<div class="modal-dialog">
    		<form method="post" id="email_form">
    			<div class="modal-content">
    				<div class="modal-header">
						<h4 class="modal-title"><i class="fa fa-envelope"></i> Send Email</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
    				</div>
    				<div class="modal-body">
						<div class="form-group">
							<input type="text" class="form-control" id="user_name" name="username" autocomplete="off" required readonly="readonly">
						</div>
						<div class="form-group">
							<input type="email" name="useremail" id="useremail" class="form-control" required autofocus readonly="readonly"> 
						</div>
						<div class="form-group">
							<label>Email Subject* </label>
							<input type="text" name="subject" id="subject" class="form-control" required autofocus  maxlength="50"> 
						</div>
						<div class="form-group">
							<label>Email Body* </label>
							<textarea name="emailtext" class="form-control" rows="4"></textarea>
						</div>
						
    				</div> 
    				<div class="modal-footer"> 
						<input type="hidden" name="userId" id="userId">
						<input type="hidden" name="btn_action_sms" id="btn_action_sms" />
    					<input type="submit" name="action_sms" id="action_sms" class="btn btn-info" value="Send Email" />
    					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    				</div>
    			</div>
    		</form>
    	</div>
    </div>
<?php require_once('footer.php'); ?>

