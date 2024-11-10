<?php 
require_once('header.php');
$sub = '';
?>
<div class="app-title">
        <div>
          <h1><i class="fa fa-key"></i> Announcement Setting</h1>
		  <p class="text-success">Show / Hide Announcements to User it depends on Admin.</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
        </ul>
 </div>
  <div class="container mar-top">
	<div class="row">
		<div class="col-lg-12 col-md-12">
			<div class="row">
				<div class="col-lg-3 col-md-3"></div>
				<div class="col-lg-6 col-md-6">
					<div class="card">
                		<div class="card-header bg-secondary text-white text-center"><h4> Announcement Setting</h4></div>
                		<div class="card-body">
							<div class="remove-messages"></div>
							<form class="announcementOption" method="post" >
					  		<div class="form-group">
								<label>Do you want to Show Announcement Option & All Announcement to User*</label>
								<select class="form-control" name="announcementShow" id="announcementShow" required>
									<option value="1" <?php if($show_announcement == '1'){ echo $sub = 'selected = "selected" ' ; } else { echo $sub = '' ; } ?> >Yes</option>
									<option value="0" <?php if($show_announcement == '0'){ echo $sub = 'selected = "selected" ' ; } else { echo $sub = '' ; } ?> >No</option>
									</select>
					  		</div>
					  		<div class="form-group text-center">
					  			<input type="submit" class="btn btn-primary" name="submit" value="Save Setting">
					  		</div>
						</form>
						</div>
           			 </div>
				</div>
				<div class="col-lg-3 col-md-3"></div>
			</div>
		</div>
	</div>
</div>
<?php require_once('footer.php'); ?>