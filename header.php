<?php
ob_start();
session_start();
include("admin/db/config.php");
include('admin/db/api_otp_generate.php');
include("admin/db/CSRF_Protect.php");
include("admin/db/function_xss.php");
$csrf = new CSRF_Protect();
// Checking User is logged in or not
if(!isset($_SESSION['customer'])) {
	header('location: index.php');
	exit;
}
//session Id
$id = _e($_SESSION['customer']['user_id']);
// fetch customer all data
$customerStatement = $pdo->prepare("SELECT * FROM customer_active WHERE user_id=? and active_status=?");
$customerStatement->execute(array($id,_e(1)));
$total = $customerStatement->rowCount();
//if customer deactivated 
if($total == '0'){
	header('location: logout.php');
	exit;
}
$customer = $customerStatement->fetchAll(PDO::FETCH_ASSOC);
	foreach($customer as $cus)
	{
		$customer_name = _e($cus['user_fullname']);
		$customer_email = _e($cus['user_email']);
		$customer_address = _e($cus['user_address']);
		$customer_state = _e($cus['user_state']);
		$customer_city = _e($cus['user_city']);
		$customer_zipcode = _e($cus['user_zipcode']);
	}
$admin = $pdo->prepare("SELECT * FROM ot_admin WHERE admin_status=?");
$admin->execute(array(filter_var("1", FILTER_SANITIZE_NUMBER_INT)));   
$admin_result = $admin->fetchAll(PDO::FETCH_ASSOC);
foreach($admin_result as $adm) {
//escape admin email
	$admin_email   = _e($adm['email']);
}
$admin_announcement = $pdo->prepare("SELECT * FROM admin_announcement WHERE announcement_status=? order by announcement_id desc limit 4");
$admin_announcement->execute(array(filter_var("1", FILTER_SANITIZE_NUMBER_INT))); 
$announcement = $admin_announcement->fetchAll(PDO::FETCH_ASSOC);
$total_read = 1;
$total_announcement = $admin_announcement->rowCount();
if($total_announcement > 0) {
	$user_read = $pdo->prepare("select * from user_announcement_read where user_id = '".$id."' and read_announcement='1'");
	$user_read->execute();
	$total_read = $user_read->rowCount();
}
$admin = $pdo->prepare("SELECT * FROM ot_admin WHERE show_announcement=?");
$admin->execute(array(filter_var("1", FILTER_SANITIZE_NUMBER_INT)));   
$admin_result = $admin->rowCount();
function displayTextWithLinks($s) {
  return preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank">$1</a>', $s);
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Home</title>

	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/all.min.css">
	<link rel="stylesheet" href="css/Latofont.css">
	<link rel="stylesheet" href="css/Niconnefont.css">
	
</head>
<body class="app sidebar-mini">
    <!-- Navbar-->
    <header class="app-header"><a class="app-header__logo" href="dashboard.php"><img src="images/siteLogo.png" class="img-fluid" alt="Logo"></a>
      <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"><i class="fa fa-bars fa-2x"></i></a>
      <!-- Navbar Right Menu-->
      <ul class="app-nav">
        <!-- User Menu-->
        <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
          <ul class="dropdown-menu settings-menu dropdown-menu-right">
            <li><a class="dropdown-item" href="logout.php"><i class="fa fa-sign-out-alt fa-lg"></i> Logout</a></li>
          </ul>
        </li>
      </ul>
    </header>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user"><i class="fa fa-user fa-2x text-warning"></i>
        <div>
          <p class="app-sidebar__user-name"><small><?php echo $customer_name ; ?></small></p>
          <p class="app-sidebar__user-designation"><?php echo $customer_email ; ?></p>
        </div>
      </div>
      <ul class="app-menu">
        <li><a class="app-menu__item" href="dashboard.php"><i class="app-menu__icon fa fa-laptop"></i><span class="app-menu__label">Dashboard</span></a></li>
		<?php if($admin_result > 0){ ?>
		<li><a href="rannouncement.php" class="app-menu__item"><i class="app-menu__icon fa fa-bullhorn"></i><span class="app-menu__label"> Announcements <?php if($total_read == ''){ ?> <span class="badge badge-warning">!</span> <?php } ?></span></a></li>
		<?php } ?>
		<li><a href="email.php" class="app-menu__item"><i class="app-menu__icon fa fa-comment"></i><span class="app-menu__label"> Admin Email</span></a></li>
		<li><a href="update.php" class="app-menu__item"><i class="app-menu__icon fa fa-info"></i><span class="app-menu__label"> Manage Details</span></a></li>
		<li><a href="manage_email.php" class="app-menu__item"><i class="app-menu__icon fa fa-envelope"></i><span class="app-menu__label"> Manage Email</span></a></li>
		<li><a href="user_password.php" class="app-menu__item"><i class="app-menu__icon fa fa-key"></i><span class="app-menu__label"> Manage Password</span></a></li>
	  </ul>
    </aside>
    <main class="app-content">
 
