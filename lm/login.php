<?php 
session_start();
require 'conn.php';
require "function.php";




$err_str	= "";	
	     
if(isset($_POST['btn_submit'])){
	
	$email		= addslashes(trim($_POST['staff_email']));
	$password	= addslashes($_POST['staff_password']);
	$valid		= 1;
	if( $email == '')
	{
		 $err_str 	= error_message(1, array('Email'));
		 $valid		= 0;
	}
	
	if( $password == '')
	{
		 $err_str 	.= "<br />".error_message(1, array('Password'));
		 $valid		= 0;
	}
	
	if( $valid == 1){
	
	$query="select * from staff WHERE staff_email='$email' AND staff_password='$password'";
	$res_query=mysql_query($query,$dblink);
	
	// Blank Check...
		
	if(mysql_num_rows($res_query)>0){
		
		$row=mysql_fetch_assoc($res_query);
			
		if( $row['is_active'] == 'Y' and $row['is_approved'] == 'A')
		{
		
			$_SESSION['staff_id']		= $row['staff_id'];
			$_SESSION['staff_email']	= $row['staff_email'];
			$_SESSION['staff_name']		= $row['staff_name'];
			$_SESSION['staff_cat']		= $row['staff_cat'];
			$_SESSION['depertment_id']	= $row['depertment_id'];
			$_SESSION['staff_imglink']	= $row['staff_imglink'];
			$_SESSION['staff_gender']   = $row['staff_gender'];
			
			$query="select * from leave_year WHERE is_active='Y'";
			$res_query=mysql_query($query,$dblink);
			$row=mysql_fetch_assoc($res_query);
			
			$_SESSION['leave_year_id']		= $row['leave_year_id'];
			
			header('location:dashboard.php');
		}else{
			 $err_str 	= error_message(3);
		}
		
		/*if($row['staff_cat']=="HOD"){			
			header('location:homepage_hod.php');	
		}
		elseif($row['staff_cat']=="PRINCIPAL"){
			header('location:homepage_admin.php');	
		}
		else{
			header('location:homepage_faculty.php');
		}*/
		
	}
	
	else{
		 $err_str = error_message(2);
			
	}
	}
		
		
 }
	
  

?>

<!DOCTYPE html>
<html>
<head>
    <title>Leave Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <meta name="description" content="top menu &amp; navigation" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
	<link rel="stylesheet" href="assets/ace/css/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/ace/font-awesome/4.5.0/css/font-awesome.min.css" />

	<!-- ace styles -->
	<link rel="stylesheet" href="assets/ace/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />

	<link rel="stylesheet" href="assets/ace/css/ace-skins.min.css" />
	<link rel="stylesheet" href="assets/ace/css/ace-rtl.min.css" />

	<!-- ace settings handler -->
	<script src="assets/ace/js/ace-extra.min.js"></script>

	
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script type="text/javascript" src="assets/ace/js/jquery-2.1.4.min.js"></script>

	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script type="text/javascript" src="assets/ace/js/bootstrap.min.js"></script>


    
</head>
<body class="login-layout">
	<div class="main-container">
		<div class="main-content">
			<div class="row">
				<div class="col-sm-10 col-sm-offset-1">
					<div class="login-container login-top-area">
						<div class="center">
							<div id="login-container">
								<div id="logo">
									<sup><i class="icon-cloud"></i></sup>
								</div>
								<div id="login">
                                	<div class="pull-left" style="width:100px;">
                                    	<div style="padding-top:10px;">
                                    		<i class="fa fa-cloud" aria-hidden="true" style="font-size:60px;"></i>
                                        </div>
                                     </div>
                                    <div class="pull-left" style="text-align:center">
                                    	<h4 style="font-weight:bold">Welcome to <span>Leave Management</span>.</h4>
                                        <h5>Please sign in to get access.</h5>
                                    </div>
                                    <div class="clearfix"></div>
									
									
									
									<div class="alert alert-block alert-danger no-margin" >
										 
									</div>
									<div style="height:15px;"></div>
										<form class="myform" action="login.php"  method="post" autocomplete="off">
									
										<div class="form-group">
                                        	<div class="col-md-3" style="text-align:left; padding-right:0px;">
                                            	<div style="padding-top:7px;">
                                            		<i class="fa fa-user" aria-hidden="true" style="padding-right:7px;"></i> <label for="login-username">Username</label>
                                             	</div>
                                             </div>
                                            <div class="col-md-9" style="padding-left:0px;">
                                            	<input type="text" class="form-control" placeholder="User Name" id="staff_email" name="staff_email">
                                             </div>
                                        	<div class="clearfix"></div>
										</div>
										<div class="form-group">
                                            <div class="col-md-3" style="text-align:left; padding-right:0px;">
                                            	<div style="padding-top:7px;">
                                            		<i class="fa fa-key" aria-hidden="true" style="padding-right:7px;"></i> <label for="login-password">Password</label>
                                            	</div>
                                            </div>
                                            <div class="col-md-9" style="padding-left:0px;">
                                             	<input type="password" class="form-control" placeholder="Password" id="staff_password" name="staff_password">
                                             </div>
                                            <div class="clearfix"></div>
										</div>
										<div class="form-group">
											<button type="submit" id="btn_submit" name="btn_submit" class="btn btn-success btn-block">Signin</button>
										</div>
										</form>
										Dont have an account?<a href="registration.php">Sign up</a>
									
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
	



<script>
	$( document ).ready(function() {
		<?php if($err_str != ''){?>
			$(".alert").html("<?php echo $err_str;?>");
			$(".alert").show();
		<?php }else{?>
			$(".alert").hide();
		<?php }?>				
	});
	
</script>
</html>