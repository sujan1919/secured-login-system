<?php 
require_once('header.php');
if(isset($_POST['submit'])){
	$fullname = filter_var($_POST['fullname'], FILTER_SANITIZE_STRING) ;
	$address = filter_var($_POST['address'], FILTER_SANITIZE_STRING) ;
	$state = filter_var($_POST['state'], FILTER_SANITIZE_STRING) ;
	$city = filter_var($_POST['city'], FILTER_SANITIZE_STRING) ;
	$zipcode = filter_var($_POST['zipcode'], FILTER_SANITIZE_NUMBER_INT) ;
	
	if( (empty($fullname)) || (empty($address)) || (empty($state)) || (empty($city)) || (empty($zipcode)) ) {
		$_SESSION['address_message'] = 'All fields are required.';		
	} else {
		$upd = $pdo->prepare("UPDATE customer_active SET user_fullname=? , user_address=? , user_state=? , user_city=? , user_zipcode=? WHERE user_id=?");
		$upd->execute(array($fullname,$address,$state,$city,$zipcode,$id));
		$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		header("location:".$actual_link."");
	}
}
?>
<div class="app-title">
        <div>
          <h1><i class="fa fa-info"></i> Manage Details</h1>
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
                		<div class="card-header bg-secondary text-white text-center"><h4> Change Details</h4></div>
                		<div class="card-body">
						<?php 
					if(! empty($_SESSION['address_message'])){ ?>
						<div  class="alert alert-danger errorMessage">
						<button type="button" class="close float-right" aria-label="Close" >
						  <span aria-hidden="true" id="hide">&times;</span>
						</button>
				<?php
						echo $_SESSION['address_message'] ;
						unset($_SESSION['address_message']);
				?>
						</div>
			<?php } ?>
						<form action="" method="post" >
							<?php $csrf->echoInputField(); ?>
					  		<div class="form-group">
								<label>Full Name*</label>
								<input type="text" class="form-control"   placeholder="Full Name" name="fullname" value="<?php echo $customer_name ; ?>" required>
					  		</div>
					  		<div class="form-group">
								<label>Address*</label>
								<input type="text" class="form-control"  placeholder="Address" name="address" value="<?php echo $customer_address ; ?>" required>
					  		</div>
					  		<div class="form-group">
								<label>State*</label>
								<input type="text" class="form-control"  placeholder="State" name="state" value="<?php echo $customer_state ; ?>" required>
					  		</div>
					  		<div class="form-group">
								<label>City*</label>
								<input type="text" class="form-control"  placeholder="City" name="city"  value="<?php echo $customer_city ; ?>" required>
					  		</div>
					  		<div class="form-group">
								<label>Zipcode*</label>
								<input type="text" class="form-control"  placeholder="Zipcode" name="zipcode"  value="<?php echo $customer_zipcode ; ?>" required>
					  		</div>
					  		<div class="form-group" align="center">
					  			<input type="submit" class="btn btn-primary" name="submit" value="Save">
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

