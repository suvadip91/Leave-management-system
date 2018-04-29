<?php 
session_start();
require 'conn.php';
require "function.php";




$err_str	= "";	
	     
if(isset($_POST['submit_btn'])){

		

	$staff_name		= $_POST['staff_name'];
	$staff_email		= $_POST['staff_email'];
	$staff_contact_no	= $_POST['staff_contact_no'];
	$staff_depertment	= $_POST['depertment_id'];
	$staff_password		= $_POST['staff_password'];
	$staff_cpassword	= $_POST['staff_cpassword'];
	$staff_cat			= $_POST['staff_cat'];
	$staff_gender  		= $_POST['staff_gender'];
	$reg_date			= time();
	
	$img_name			= $_FILES['imglink']['name'];
	$img_size			= $_FILES['imglink']['size'];
	$img_tmp			= $_FILES['imglink']['tmp_name'];
	
	$directory			= 'upload/';
	$target_file		= $directory.$img_name;
	
	if( $staff_name=='' || $staff_email=='' || $staff_contact_no=='' || $staff_depertment=='' || $staff_password=='' || $staff_cpassword=='' ||$staff_cat=='' || $staff_gender =='')
   {
	   $err_str=error_message(7);
   }
	else{
	if($staff_password==$staff_cpassword){
		$query			= "select * from staff where staff_email='$staff_email'";
		$res_query		= mysql_query($query,$dblink);
		
		if(mysql_num_rows($res_query)>0){
		   
			   $err_str=error_message(4);
			   
		}
	   else{
			   move_uploaded_file($img_tmp,$target_file);
				$query		= "insert into 		                   staff(staff_name,staff_email,staff_contact_no,depertment_id,staff_password,staff_cat,staff_gender,staff_imglink, reg_date)      values('$staff_name','$staff_email','$staff_contact_no','$staff_depertment','$staff_password','$staff_cat','$staff_gender','$target_file', 	'$reg_date')";
			
				$res_query	= mysql_query($query,$dblink);
			
				if($res_query){
				   $err_str=error_message(8); 
				}
				else{
				   $err_str=error_message(6);
			   }
		   }
		
		}
		else{
			
		   $err_str=error_message(5);
		   
		
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
	<link rel="stylesheet" href="assets/css/custom_style.css" />
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
<body class="no-skin">
	<div class="main-container">
		<div class="main-content">
			<div class="row"  style="margin-top:10px;">
				<div class="col-sm-10 col-sm-offset-1">
						<div class="row" style="background:#eee;padding:5px;border:2px solid #bbb">
							<h3 style="text-align:center;">Registration Form</h3>
						</div>
						<div class="alert alert-block alert-danger no-margin" >
										 
						</div>
						
						<div class="row"  style="margin-top:50px;">
						<div class="col-md-6" style="background: #eee;">
							<h2>Leave Management System</h2>
							<p>
								In the existing system, paper work related to leave management, 
								leaves are maintained using the register for faculty member. 
								The faculty member needs to submit their leaves manually to 
								their respective authorities. This increases the paperwork &
								maintaining the records becomes tedious. Maintaining notices
								in the records also increases the paperwork.
							</p>
							<ul class="reg_page_ul">
								<li class="reg_page_list"><img class="reg_page_img" src="assets/images/r1.jpg"></li>
								<li class="reg_page_list"><img class="reg_page_img" src="assets/images/r2.jpg"></li>
								<li class="reg_page_list"><img class="reg_page_img" src="assets/images/r3.png"></li>
							</ul>
						
						
						 
						</div>
						<div class="col-md-6">
							<form class="myform" action="registration.php"  method="post" enctype="multipart/form-data" autocomplete="off" onSubmit="return validation();">
							<div>
								<center>
										<img id="uploadPreview" src="assets/images/sign_up.png" width="148px" height="128px"/ >
										<div id="upload_img" style="width:300px;height:30px;margin-top:20px;">
											<div class="upload_img_btn">UPLOAD YOUR PROFILE PHOTO</div>	
											<input id="imglink" name="imglink" style="width:300px;height:30px;position:absolute;opacity:0;" type="file" accept=".jpg,.jpeg,.png" onChange="previewImage();">
										</div>
								</center>
							</div>

								
							
							<div class="form-group">
								<label for="login-username">Name: </label>
								<input type="text" class="form-control"  id="staff_name" name="staff_name" value="<?php echo $staff_name;?>">                                             
							</div>

							<div class="form-group">
								<label for="login-username">Gender:</label>
								<input type="radio" name="staff_gender" value="M">MALE <input type="radio" name="staff_gender" value="F">FEMALE                                             
							</div>

							<div class="form-group">
								<label for="login-username">Email Id:</label>
								<input type="text" id="email" class="form-control" name="staff_email" onBlur="emailvalidation(this.value);" value="<?php echo $staff_email?>" >  <span class="email_valid" style="color:red;"></span>                                             
							</div>
							<div class="form-group">
								<label for="login-username">Contact No:</label>
								<input type="text" class="form-control" name="staff_contact_no" value="<?php echo $staff_contact_no?>">                                             
							</div>
							<div class="form-group">
								<label for="login-username">Category:</label>
								<select id="s_cat" class="form-control" name="staff_cat" onChange="check_depertment();" value="<?php echo $staff_cat?>" >
									<option value="">--SELECT--</option>
									<option value="HOD">HOD</option>
									<option value="FAC">FACULTY</option>
									<option value="NFAC">NON-FACULTY</option>
				
								</select>                                             
							</div>
							<div class="form-group">
								<label for="login-username">Depertment:</label>
								<select  id="d_name" class="form-control" name="depertment_id" value="<?php echo $staff_depertment?>">
									<option value="">--SELECT--</option>
									<?php
										$sql = 'select * from depertment where is_active = \'Y\'';
										$retval=mysql_query($sql,$dblink);
										while($row=mysql_fetch_assoc($retval)){
									?>
											<option value="<?php echo $row['depertment_id']?>"><?php echo $row['depertment_name']?></option>
										<?php }?>
								
			
								</select>                                             
							</div>
							<div class="form-group">
								<label for="login-username">Password:</label>
								<input type="password"  class="form-control" id="pass" name="staff_password" onKeyUp="pass_validation()" >Strength: <span id="pass1" style="color:blue;">no strength..</span>                                            
							</div>
							<div class="form-group">
								<label for="login-username">Re-type Password:</label>
								<input type="password" class="form-control" name="staff_cpassword" >                                            
							</div>
							
							<div class="form-group">
								<button type="submit" id="btn_submit" name="submit_btn" class="btn btn-success btn-block">SIGN UP</button>
							</div>
							<div class="form-group">
								<a href="login.php"><input type="button" id="button2" class="btn btn-danger btn-block" value="BACK"></a>
							</div>
						</form>
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


		$('li img').slideUp(10);
		$('li img').slideDown(2000);				
	});

	function validation(){
	 
	
	 var email       = document.getElementById("email").value;
	 
	 var valid = 1;
	 
	 
	 
	  
	 
	 if( !emailvalidation(email))
		 {	
			 valid = 0;
		 }
	 
	  
	 if( valid == 1){
		 return true;
	 }else{
		 return false;
	 }
  }
 
  function emailvalidation(email){
			   
			   var atposition=email.indexOf("@");
			   var e_msg="*invalid email-id..."; 
				var dotposition=email.lastIndexOf(".");
				if(atposition<1 || dotposition-atposition<2 || dotposition+2>=email.length){
					$(".email_valid").html(e_msg);
					return false
					
				}else{
					
				   $(".email_valid").html(""); 
					return ture;
				}
	 }
 function check_depertment()
 {
	 var s_cat=document.getElementById("s_cat").value;
	 if(s_cat=="NFAC"){
		 //document.getElementById("d_name").style.display = "none";
		 
		 document.getElementById("d_name").value = 7;
		 document.getElementById("d_name").disabled = true;
	 }
	 
	 else{
		 document.getElementById("d_name").value = 1;
		 document.getElementById("d_name").disabled = false;
	 }
 }
 
 function pass_validation(){
	 var msg;
	 
	 var password=document.getElementById("pass").value;
	 
	 if(password.length>6){
		 msg="good.."; 
	 }
	 else{
		 msg="poor..";
	 }
	 
	 document.getElementById("pass1").innerText=msg;
 
 
 }
 function previewImage(){
	 var oFReader=new FileReader();
	 oFReader.readAsDataURL(document.getElementById("imglink").files[0]);
	 
	 oFReader.onload=function(oFREvent){
		 document.getElementById("uploadPreview").src=oFREvent.target.result;
	 };
 };
	
</script>
</html>