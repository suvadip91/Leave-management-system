<?php

session_start();
require 'conn.php';
require 'function.php';
$err_str='';
if(!isset($_SESSION['staff_id']) || $_SESSION['staff_id']==''){
    header('location:index.php');
}
include 'header.php';

if(isset($_POST['btn_submit'])){

	
	$staff_email		= $_POST['staff_email'];
	$staff_contact_no	= $_POST['staff_contact_no'];
	$staff_password		= $_POST['staff_password'];
	$staff_cpassword	= $_POST['staff_cpassword'];

	$img_name			= $_FILES['imglink1']['name'];
	$img_size			= $_FILES['imglink1']['size'];
	$img_tmp			= $_FILES['imglink1']['tmp_name'];
	
	$directory			= 'upload/';
	$target_file		= $directory.$img_name;

	
		$query			= "select * from staff where staff_email='$staff_email'";
		$res_query		= mysql_query($query,$dblink);
		
		if(mysql_num_rows($res_query)>1){
		   
			   $err_str=error_message(4);
			   
		}
	   	else{
			   if($target_file!='upload/'){
					$query_str=",staff_imglink='$target_file'";
			   }
			   else{
					$query_str="";
			   }

			   if($staff_password!=''){
				   $query_str.=",staff_password='$staff_password'";
			   }else{
				   $query_str.="";
			   }
			   if($staff_password==$staff_cpassword){
					move_uploaded_file($img_tmp,$target_file);
					$query		= "UPDATE staff SET staff_email='$staff_email',staff_contact_no='$staff_contact_no'".$query_str." WHERE staff_id='".$_SESSION['staff_id']."'";
				
					$res_query	= mysql_query($query,$dblink);
				
					if($res_query){
						
					$err_str=error_message(10); 
					}else{
						$err_str=error_message(6);
					}
			    }else{
					$err_str=error_message(5);
				}	
	
			}
	
	
}	

$query="select * from staff where staff_id='".$_SESSION['staff_id']."'";
$res_query  = mysql_query($query,$dblink);
$row	= mysql_fetch_array($res_query,MYSQL_ASSOC);

$query1="select * from depertment where depertment_id='".$_SESSION['depertment_id']."'";
$res_query1  = mysql_query($query1,$dblink);
$row1	= mysql_fetch_array($res_query1,MYSQL_ASSOC);


if($row['staff_imglink']=='upload/'){
	$row['staff_imglink']='assets/images/sign_up.png';
}
?>
<div class="col-md-3"></div>
<div class="col-md-6">
<h3 style="text-align:center;">Employee Details</h3>
<form class="myform" action="edit_profile.php" method="post" autocomplete="off" enctype="multipart/form-data" onSubmit="return validation();">
 
  
    <div>
        <center>
            <img id="uploadPreview1" src="<?php echo $row['staff_imglink'];?>" width="148px" height="128px" style="border-radius:50%;"/ >
    

        
            <div style="width:300px;height:30px;margin-top:20px;">
                <div style="width:300px;height:30px;position:absolute;background-color:#aaa;color:white;border-radius:30px;text-align:center;font-weight:bold;padding-top:5px;">CHANGE YOUR PROFILE PHOTO</div>	
    
                    <input id="imglink1" name="imglink1" style="width:300px;height:30px;position:absolute;opacity:0;" type="file" accept=".jpg,.jpeg,.png" onChange="previewImage();">
            </div>
		</center>
	</div>
   <br/><br/>
   <div class="form-group">
		<label for="login-username">Name: </label>
		<input type="text" class="form-control" disabled='true' value="<?php echo $row['staff_name'];?>">                                           
	</div>
	<div class="form-group">
		<label for="login-username">Email: </label>
		<input type="text" class="form-control" id="staff_email" name="staff_email" onBlur="emailvalidation(this.value);" value="<?php echo $row['staff_email'];?>"><span class="email_valid" style="color:red;"></span>                                              
	</div>
	<div class="form-group">
		<label for="login-username">Contact No:</label>
		<input type="text" class="form-control" id="staff_email" name="staff_contact_no" value="<?php echo $row['staff_contact_no'];?>">                                             
	</div>
	<?php if($row['staff_cat']<>'PRINCIPAL'){?>
	<div class="form-group">
		<label for="login-username">Depertment Name: </label>
		<input type="text" class="form-control" disabled='true' value="<?php echo $row1['depertment_name'];?>">                                           
	</div>
	<?php }?>
	<div class="form-group">
		<label for="login-username">Do you want to change your password? </label>
		<input type="button" class="btn-success" id="check" value="YES">                                           
	</div>
	<div class="form-group password_change" style="display:none;">
		<label for="login-username">Change Password:</label>
		<input type="password" class="form-control" id="staff_password" name="staff_password" onKeyUp="pass_validation()" >Strength: <span id="pass2" style="color:blue;"></span>                                             
	</div>
	<div class="form-group password_change" style="display:none;">
		<label for="login-username">Retype New Password:</label>
		<input type="password" class="form-control" id="staff_cpassword" name="staff_cpassword">                                             
	</div>
	<div class="form-group">
		<center>
		<input type="submit" class="btn btn-danger" id="btn_submit" name="btn_submit" value="UPDATE YOUR PROFILE"> 
		</center>                                       
	</div>


   
   

   
</div>

<script type="text/javascript">
$( document ).ready(function() {
		<?php if($err_str != ''){?>
			$(".alert").html("<?php echo $err_str;?>");
			$(".alert").show();
		<?php }else{?>
			$(".alert").hide();
		<?php }?>

	$('#check').click(function(){
		$(".password_change").show();
	});

});

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
function pass_validation(){
	var msg;
	
	var password=document.getElementById("staff_password").value;
	
	if(password.length>6){
		msg="good.."; 
	}
	else if(password.length<1){
		msg="no strength..";
	}
	else{
		msg="poor..";
	}
	
	document.getElementById("pass2").innerText=msg;


}
function validation(){
	 
	
     var email       = document.getElementById("staff_email").value;
     
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
function previewImage(){
	var oFReader=new FileReader();
	oFReader.readAsDataURL(document.getElementById("imglink1").files[0]);
	
	oFReader.onload=function(oFREvent){
		document.getElementById("uploadPreview1").src=oFREvent.target.result;
	};
};

</script>

<?php include 'footer.php'; ?>