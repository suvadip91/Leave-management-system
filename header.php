<!DOCTYPE html>
<html lang="en">
	<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta charset="utf-8" />
	<title><?php echo $page_name;?></title>

	<meta name="description" content="top menu &amp; navigation" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

	<!-- bootstrap & fontawesome -->
	<link rel="stylesheet" href="assets/ace/css/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/ace/font-awesome/4.5.0/css/font-awesome.min.css" />

	<!-- ace styles -->
	<link rel="stylesheet" href="assets/ace/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />

	<link rel="stylesheet" href="assets/ace/css/ace-skins.min.css" />
	<link rel="stylesheet" href="assets/ace/css/ace-rtl.min.css" />

	<!-- inline styles related to this page -->

	<!-- ace settings handler -->
	<script src="assets/ace/js/ace-extra.min.js"></script>

	
	
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script type="text/javascript" src="assets/ace/js/jquery-2.1.4.min.js"></script>

	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script type="text/javascript" src="assets/ace/js/bootstrap.min.js"></script>


	

	</head>

	<body class="no-skin">
		<div id="navbar" class="navbar navbar-default    navbar-collapse       h-navbar ace-save-state">
			<div class="navbar-container ace-save-state" id="navbar-container">
				<div class="navbar-header pull-left">
					<a href="index.html" class="navbar-brand">
						<small>
							Leave Management
						</small>
					</a>

					<button class="pull-right navbar-toggle navbar-toggle-img collapsed" type="button" data-toggle="collapse" data-target=".navbar-buttons,.navbar-menu">
						<span class="sr-only">Toggle user menu</span>

						<!--<img src="assets/images/avatars/user.jpg" alt="Jason's Photo" />-->
					</button>

					<button class="pull-right navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#sidebar">
						<span class="sr-only">Toggle sidebar</span>

						<span class="icon-bar"></span>

						<span class="icon-bar"></span>

						<span class="icon-bar"></span>
					</button>
				</div>

				<div class="navbar-buttons navbar-header pull-right  collapse navbar-collapse" role="navigation">
					<ul class="nav ace-nav">
						

						<li class="light-blue dropdown-modal admin_control">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle ">
								Welcome, <?php echo $_SESSION['staff_name'];?>
								
								
								<i class="ace-icon fa fa-caret-down"></i>
							</a>

							<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								<li>
									<a href="logout.php">
										<i class="ace-icon fa fa-power-off"></i>
										Logout
									</a>
								</li>
								<li>
									<a href="edit_profile.php">
										
										Edit Profile
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>

				<nav role="navigation" class="navbar-menu pull-left collapse navbar-collapse">
					
				</nav>
			</div><!-- /.navbar-container -->
		</div>

		<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>

			<?php 
            $top_menu_css = 'sidebar h-sidebar responsive ace-save-state';
            //$top_menu_css = 'sidebar responsive ace-save-state';
            ?>
			<div id="sidebar" class="<?php echo $top_menu_css;?>">
				<script type="text/javascript">
					try{ace.settings.loadState('sidebar')}catch(e){}
				</script>

				<!-- /.sidebar-shortcuts -->

				<?php include "menu.php";?><!-- /.nav-list -->
                
                <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
					<i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
				</div>
			</div>

			<div class="main-content">
				<div class="main-content-inner">
					<div class="page-content">
						
						
						<?php if($page_heading != ''){?>
						<div class="page-header">
							<h1>
								<?php echo $page_heading;?>
								<?php if($page_sub_heading != ''){?>
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									<?php echo $page_sub_heading;?>
								</small>
								<?php }?>
							</h1>
						</div><!-- /.page-header -->
						<?php }?>
						
						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<div class="left">
								<div id="alert_div" class="alert alert-block alert-danger no-margin" ></div>
									
