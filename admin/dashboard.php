<?php include("header.php") ; include("countFunctions.php") ; ?>
<div class="app-title">
        <div>
          <h1><i class="fa fa-laptop"></i> Admin Dashboard</h1>
		  <p class="text-success">Hassle Free Analysis for Users & Announcements.</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
        </ul>
 </div>
 <div class="row">
 		<div class="col-lg-12 col-md-12">
				<h5 class="border-bottom text-muted">Users Analysis</h5>
			</div>
        <div class="col-md-4 col-lg-4">
          <div class="widget-small primary coloured-icon"><i class="icon fa fa-users fa-3x"></i>
            <div class="info">
              <h5 class="font-italic text-muted">Total Users</h5>
              <p><b><?php echo count_total_users($pdo) ; ?></b></p>
            </div>
          </div>
        </div>
		<div class="col-md-4 col-lg-4">
          <div class="widget-small info coloured-icon"><i class="icon fa fa-check fa-3x"></i>
            <div class="info">
              <h5 class="font-italic text-muted">Active Users</h5>
              <p><b><?php echo  count_total_active_users($pdo) ; ?></b></p>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-lg-4">
          <div class="widget-small danger coloured-icon"><i class="icon fa fa-times fa-3x"></i>
            <div class="info">
              <h5 class="font-italic text-muted">Deactive Users</h5>
              <p><b><?php echo count_total_deactive_users($pdo) ; ?></b></p>
            </div>
          </div>
        </div>
</div>
 <div class="row">
 		<div class="col-lg-12 col-md-12">
				<h5 class="border-bottom text-muted">Announcement Analysis</h5>
			</div>
        <div class="col-md-4 col-lg-4">
          <div class="widget-small primary coloured-icon"><i class="icon fa fa-bullhorn fa-3x"></i>
            <div class="info">
              <h5 class="font-italic text-muted">Total Announcements</h5>
              <p><b><?php echo count_total_announcement($pdo) ; ?></b></p>
            </div>
          </div>
        </div>
		<div class="col-md-4 col-lg-4">
          <div class="widget-small info coloured-icon"><i class="icon fa fa-check fa-3x"></i>
            <div class="info">
              <h5 class="font-italic text-muted">Active Announcements</h5>
              <p><b><?php echo  count_total_active_announcement($pdo) ; ?></b></p>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-lg-4">
          <div class="widget-small danger coloured-icon"><i class="icon fa fa-times fa-3x"></i>
            <div class="info">
              <h5 class="font-italic text-muted">Deactive Announcements</h5>
              <p><b><?php echo count_total_deactive_announcement($pdo) ; ?></b></p>
            </div>
          </div>
        </div>
</div>
<div class="row">
 		<div class="col-lg-12 col-md-12">
				<h5 class="border-bottom text-muted">Send Email to User Analysis</h5>
			</div>
        <div class="col-md-4 col-lg-4">
          <div class="widget-small primary coloured-icon"><i class="icon fa fa-comments fa-3x"></i>
            <div class="info">
              <h5 class="font-italic text-muted">Total Email</h5>
              <p><b><?php echo count_total_sms($pdo) ; ?></b></p>
            </div>
          </div>
        </div>
		<div class="col-md-4 col-lg-4">
          <div class="widget-small info coloured-icon"><i class="icon fa fa-check fa-3x"></i>
            <div class="info">
              <h5 class="font-italic text-muted">This Month Email</h5>
              <p><b><?php echo  count_total_curmonth_sms($pdo) ; ?></b></p>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-lg-4">
          <div class="widget-small danger coloured-icon"><i class="icon fa fa-times fa-3x"></i>
            <div class="info">
              <h5 class="font-italic text-muted">Today Email</h5>
              <p><b><?php echo count_total_curday_sms($pdo) ; ?></b></p>
            </div>
          </div>
        </div>
</div>
<div class="row">
 		<div class="col-lg-12 col-md-12">
				<h5 class="border-bottom text-muted">Send Email to Non User Analysis</h5>
			</div>
        <div class="col-md-4 col-lg-4">
          <div class="widget-small primary coloured-icon"><i class="icon fa fa-list-ol fa-3x"></i>
            <div class="info">
              <h5 class="font-italic text-muted">Total Email</h5>
              <p><b><?php echo count_total_nonsms($pdo) ; ?></b></p>
            </div>
          </div>
        </div>
		<div class="col-md-4 col-lg-4">
          <div class="widget-small info coloured-icon"><i class="icon fa fa-check fa-3x"></i>
            <div class="info">
              <h5 class="font-italic text-muted">This Month Email</h5>
              <p><b><?php echo  count_total_curmonth_nonsms($pdo) ; ?></b></p>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-lg-4">
          <div class="widget-small danger coloured-icon"><i class="icon fa fa-times fa-3x"></i>
            <div class="info">
              <h5 class="font-italic text-muted">Today Email</h5>
              <p><b><?php echo count_total_curday_nonsms($pdo) ; ?></b></p>
            </div>
          </div>
        </div>
</div>
<?php include("footer.php") ; ?>
