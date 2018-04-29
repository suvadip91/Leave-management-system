<?php
	session_start();
	require 'conn.php';
	require "function.php";

	if( $_SESSION['staff_id'] == '' || !isset($_SESSION['staff_id']))
	{
		header('location:index.php');
	}

	$menu_num = 2;
	$page_name = "Leave-apply";
	$err_str= "";
	
	
/* */
	if(isset($_POST['submit'])){
		if($_POST['leave_id']=='4'){
			if($_POST['leave_apply_starting_date']==''){ 
				$err_str = error_message(7);	
			}
			else{
					
				$staff_id					= $_SESSION['staff_id'];
				$start						= explode("-", $_POST['leave_apply_starting_date']);
				
				
				
				

				$leave_id					= $_POST['leave_id'];
				$leave_apply_reason			= $_POST['leave_apply_reason'];
				$leave_apply_date			= time();
				$leave_apply_starting_date	= mktime(0,0,0,$start[1],$start[2],$start[0]);
				$leave_apply_joining_date	= (84600*180)+($leave_apply_starting_date);
				$leave_apply_duration		= 180;
				$leave_apply_year			= $start[0];
				
				$sql="INSERT INTO leave_apply(leave_id,staff_id,leave_apply_reason,leave_apply_starting_date,leave_apply_joining_date,leave_apply_date,leave_apply_duration,leave_apply_year) 			              VALUES('$leave_id','$staff_id','$leave_apply_reason','$leave_apply_starting_date','$leave_apply_joining_date','$leave_apply_date','$leave_apply_duration','$leave_apply_year')";
				$retval=mysql_query($sql,$dblink);
				
				
				
				if($retval){
					$err_str	= error_message(12);
				}
				else{
					$err_str	= error_message(6);

				}
			}

		}
		else{
			if($_POST['leave_apply_starting_date']=='' || $_POST['leave_apply_joining_date']=='' || $_POST['leave_apply_reason']==''){ 
				$err_str =error_message(7);	
			} 
			else{
			
				
				$staff_id					= $_SESSION['staff_id'];
				$start						= explode("-", $_POST['leave_apply_starting_date']);
				$end						= explode("-", $_POST['leave_apply_ending_date']);
				
				
				

				$leave_id					= $_POST['leave_id'];
				$leave_apply_reason			= $_POST['leave_apply_reason'];
				$leave_apply_date			= time();
				$leave_apply_starting_date	= mktime(0,0,0,$start[1],$start[2],$start[0]);
				$leave_apply_joining_date	= mktime(0,0,0,$end[1],$end[2],$end[0]);
				$leave_apply_duration		= ((($leave_apply_joining_date) - ($leave_apply_starting_date))/86400);
				$leave_apply_year			= $start[0];
				
				$sql="INSERT INTO leave_apply(leave_id,staff_id,leave_apply_reason,leave_apply_starting_date,leave_apply_joining_date,leave_apply_date,leave_apply_duration,leave_apply_year) 			              VALUES('$leave_id','$staff_id','$leave_apply_reason','$leave_apply_starting_date','$leave_apply_joining_date','$leave_apply_date','$leave_apply_duration','$leave_apply_year')";
				$retval=mysql_query($sql,$dblink);
				
				
				
				if($retval){
					$err_str	=  error_message(12);
				}
				else{
					$err_str	= error_message(6);

				}
			
			} 
		}
	}
	include 'header.php';
?>

<div class="row">

	<div  class="col-md-3"></div>
    <div class="col-md-6">
		<h3 style="text-align:center;">Leave Request Form</h3>	
    	<form class="form-horizontal" action="leave_request.php" method="post" autocomplete="off" ">
        	<table cellspacing="30px">
			<tr style="height:50px">
             	<td>LEAVE CATEGORY:</td>
             	<td><select id="leave_select" name="leave_id">
            				<option value="1">CASUAL LEAVE</option>
                            <option value="2">SICK LEAVE</option>
                            <option value="3">PRIVILEGED LEAVE</option>
							<?php if($_SESSION['staff_gender']=='F'){?>
                            <option value="4">MATERNITY LEAVE</option>
							<?php }?>
                                
              		 </select></td>
             </tr><br/>
        	 <tr style="height:50px">
             	<td>STARTING DATE OF LEAVE:</td> 
                <td><input type="date" id="leave_apply_starting_date" name="leave_apply_starting_date"></td>	
             </tr>
           	 <tr  style="height:50px">
             	<td>JOINING DATE:</td>
                <td><input type="date" id="leave_apply_joining_date" name="leave_apply_joining_date"></td>
             </tr>
             
                                    
            <tr id="leave_apply_reason">
             	<td >LEAVE REASON:</td>			
                <td><textarea  style="resize:none; "name="leave_apply_reason" rows="4" cols="50"></textarea></td>
				
				
            </tr>                        
			<tr>
             	<td></td>			
                <td><input id="btn_leave_apply" type="submit" name="submit" value="APPLY" class="btn btn-danger"></td>
            </tr>                        
            
		</table>
            
            
        </form>
    </div>
</div>   
<script type="text/javascript">

	$("#leave_select").change(function(){
		if($(this).val()=="4"){
			$("#leave_apply_joining_date").prop('disabled',true);
			$("#leave_apply_reason").hide();
		}
		else{
			$("#leave_apply_joining_date").prop('disabled',false);
			$("#leave_apply_reason").show();
		}
	});



			
</script>






<?php include 'footer.php'; ?>