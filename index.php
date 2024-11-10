<?php
ob_start();
session_start();
require_once('admin/db/config.php');
require_once("admin/db/function_xss.php");
require_once("admin/db/CSRF_Protect.php");
$csrf = new CSRF_Protect();
unset($_SESSION['LastRequest']);
$admin = $pdo->prepare("SELECT * FROM ot_admin WHERE admin_status=?");
$admin->execute(array(filter_var("1", FILTER_SANITIZE_NUMBER_INT)));   
$admin_result = $admin->fetchAll(PDO::FETCH_ASSOC);
foreach($admin_result as $adm) {
//escape admin email
	$admin_email   = _e($adm['email']);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Email Login & Registration System</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<meta name="description" content="Email Login & Registration System">
	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/all.min.css">
	<link rel="stylesheet" href="css/custom.css" />
	<link rel="stylesheet" href="css/Latofont.css">
	<link rel="stylesheet" href="css/Niconnefont.css">
</head>

<body>
<div id="logreg-forms" class="shadow-lg">
			<?php 
					if(! empty($_SESSION['error_message'])){ ?>
						<div  class="alert alert-danger errorMessage">
						<button type="button" class="close float-right" aria-label="Close" >
						  <span aria-hidden="true" id="hide">&times;</span>						</button>
				<?php
						echo $_SESSION['error_message'] ;
						unset($_SESSION['error_message']);
				?>
						</div>
			<?php } ?>
			<div class="remove-messages"></div>
        	<form  id="login_form" class="form-signin" method="post">
				<h4 class="d-flex justify-content-center"> Sign In</h4>
				<input type="hidden" name="admin_email" value="<?php echo $admin_email ; ?>" />
				<input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" maxlength="50" required autofocus>
				<input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
				<button class="btn btn-success btn-block" type="submit" name="action_log" id="action_log"><i class="fas fa-sign-in"></i> Sign in</button>
				<a href="#" id="forgot_pswd">Forgot password?</a>
				<hr>
				<button class="btn btn-primary btn-block" type="button" id="btn-signup"><i class="fas fa-user-plus"></i> Sign up New Account</button>
            </form>
			<form class="form-reset forgot_form" method="post">
				<h4 class="d-flex justify-content-center"> Forgot Password ?</h4>
                <input type="email" name="email" id="resetEmail" class="form-control" placeholder="Email address" maxlength="50" required autofocus>
                <button class="btn btn-primary btn-block" type="submit">Reset Password</button>
                <a href="#" id="cancel_reset"><i class="fas fa-angle-left"></i> Back</a>
            </form>
            <form class="form-signup signup_form" method="post">
				<?php $csrf->echoInputField(); ?>
                <h4 class="d-flex justify-content-center"> Sign Up</h4>
				<input type="hidden" name="admin_email" value="<?php echo $admin_email ; ?>" />
                <input type="text" id="user-name" name="fullname" class="form-control" placeholder="Full name" required autofocus>
                <input type="email" id="user-email" name="email" class="form-control" placeholder="Email address" required autofocus>
				<small>Password must contain minimum 8 characters, 1 Uppercase character, 1 Lowercase character & 1 number.</small>
                <input type="password" id="user-pass" name="password" class="form-control" placeholder="Password" required autofocus>
                <input type="text" id="user-repeatpass" name="repassword" class="form-control" placeholder="Repeat Password" required autofocus>
				
				<button class="btn btn-primary btn-block" type="submit"><i class="fas fa-user-plus"></i> Sign Up</button>
                <a href="#" id="cancel_signup"><i class="fas fa-angle-left"></i> Back</a>
            </form>
            <br>
            
</div>
<div id="signupModal" class="modal fade " data-backdrop="static" data-keyboard="false">
    	<div class="modal-dialog">
    		<form method="post" id="signup_otpform">
    			<div class="modal-content">
    				<div class="modal-header">
						<h4 class="modal-title"><i class='fa fa-eye'></i> Verify Sign Up OTP</h4>
    				</div>
    				<div class="modal-body">
						<div class="row">
							<div class="col-lg-12 col-md-12">
								<div class="form-group">
									<label>Email*</label>
									<input type="text" name="email" id="signupemail" class="form-control" readonly="readonly" required />
								</div>
								<div class="form-group">
									<label>OTP*</label>
									<input type="password" name="otp" id="otp" class="form-control" required />
								</div>
							</div>
						</div>						
					</div>
					
					
    				<div class="modal-footer">
						<input type="hidden" name="password"  id="password" />
						<input type="hidden" name="fullname"  id="fullname" />
    					<input type="submit" name="action_sign" id="action_sign" class="btn btn-info" value="Verify OTP"  />
    					
    				</div>
    			</div>
    		</form>
    	</div>
    </div>
<div id="forgotModal" class="modal fade " data-backdrop="static" data-keyboard="false">
    	<div class="modal-dialog">
    		<form method="post" id="forgot_otpform">
    			<div class="modal-content">
    				<div class="modal-header">
						<h4 class="modal-title"><i class='fa fa-eye'></i> Verify Forgot Password OTP</h4>
    				</div>
    				<div class="modal-body">
						<div class="row">
							<div class="col-lg-12 col-md-12">
								<div class="form-group">
									<label>Email*</label>
									<input type="text" name="email" id="forgotemail" class="form-control" readonly="readonly" required />
								</div>
								<div class="form-group">
									<label>OTP*</label>
									<input type="password" name="otp" id="otp" class="form-control" required />
								</div>
							</div>
						</div>						
					</div>
					
					
    				<div class="modal-footer">
    					<input type="submit" name="action_fp" id="action_fp" class="btn btn-info" value="Verify OTP"  />
    					
    				</div>
    			</div>
    		</form>
    	</div>
    </div>
<div id="forgotpasswordModal" class="modal fade " data-backdrop="static" data-keyboard="false">
    	<div class="modal-dialog">
    		<form method="post" id="forgotpassword_otpform">
    			<div class="modal-content">
    				<div class="modal-header">
						<h4 class="modal-title"><i class='fa fa-key'></i> Change Password</h4>
    				</div>
    				<div class="modal-body">
						<div class="row">
							<div class="col-lg-12 col-md-12">
								<div class="form-group">
									<label>Email*</label>
									<input type="text" name="email" id="forgotpasswordemail" class="form-control" readonly="readonly" required />
								</div>
								<div class="form-group">
								 <small>Password must contain minimum 8 characters, 1 Uppercase character, 1 Lowercase character & 1 number.</small>
								 <br>
									<label for="newpassword" class="control-label">New Password*</label>
									<input type="password" class="form-control" name="newpassword" maxlength="50" required>
								</div>
								<div class="form-group">
									<label for="confirmnewpassword" class="control-label">Confirm New Password*</label>
									<input type="text" class="form-control" name="confirmnewpassword" maxlength="50" autocomplete="off" required>
								</div>
							</div>
						</div>						
					</div>
					
					
    				<div class="modal-footer">
    					<input type="submit" name="action_cp" id="action_cp" class="btn btn-info" value="Change Password"  />
    					
    				</div>
    			</div>
    		</form>
    	</div>
    </div>
<script type="text/javascript" src="js/jquery-3.5.0.min.js"></script>
<script type="text/javascript" src="js/popper.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/custom.js"></script>
</body>
</html>
