<?php 
	session_start();
	require 'conn.php';
	require "function.php";

	if( $_SESSION['staff_id'] == '' || !isset($_SESSION['staff_id']) || $_SESSION['staff_cat']!='PRINCIPAL')
	{
		header('location:login.php');
	}
	
	
	$menu_num = 5;
	$page_name = "Manage-staff";
	include 'header.php';
	
	if(isset($_POST['btn_submit'])){


        $staff_name=$_POST['staff_name'];
        $staff_cat=$_POST['staff_cat'];
        $depertment_id=$_POST['depertment_id'];

        $where_str = "";
        if($staff_name != '')
        {
            $where_str .= " AND staff_name LIKE '%$staff_name%'";
        }


        if($staff_cat != '')
        {
            $where_str .= " AND t1.staff_cat='$staff_cat'";
        }

        if($depertment_id != '')
        {
            $where_str .= " AND t1.depertment_id='$depertment_id'";
        }

   
    }
?>
	<div class="row">
	<div class="col-md-2"></div>
	<div class="col-md-8" style="border:2px solid #bbb; margin-bottom: 20px; padding-top:10px; padding-bottom:10px; background:#ddd; ">

	<form action="manage_staff.php" method="post" >
	<div class="form-inline ">
		<label>Satff Name:</label>
		<input type="text" class="form-control"  name= "staff_name" value="<?php echo $staff_name;?>" />
		<label>Category</label>
		<select id="s_cat" name="staff_cat" onChange="check_depertment();"  class="form-control">
			<option value="">Select</option>
			<option value="HOD" <?php if($staff_cat == 'HOD'){?> selected <?php }?>>HOD</option>
			<option value="FAC">FACULTY</option>
			<option value="NFAC">NON-FACULTY</option>
		</select>

		<label>Depertment</label>
		<select  id="d_name" name="depertment_id"  class="form-control">
		<option value="">Select</option>
		<?php
		$sql = 'select * from depertment where is_active = \'Y\'';
		$retval=mysql_query($sql,$dblink);
		while($row=mysql_fetch_assoc($retval)){
			?>
			<option value="<?php echo $row['depertment_id']?>"  <?php if($depertment_id == $row['depertment_id']){?> selected <?php }?>><?php echo $row['depertment_name']?></option>
			<?php
		}
		?>
		
		</select>

		<button type="submit" id="btn_submit" name="btn_submit" class="btn btn-xs btn-success">Search</button>

	</div>
	</form>

    

	</div>
	</div>
	<div class="row">
	<div class="col-md-12">
	<table class="table  table-bordered table-hover">
	<thead>
	<tr>

    	<th>Name</th>
        <th>Email</th>
        <th>Category</th>
        <th>Depertment</th>
        <th>Regestration date</th>
        <th>Active</th>
		<th>Status</th>
		<th>Gender</th>
		<th style="text-align: center; background:#aaa; color:#fff">Leave Summary</th>
    </tr>
	</thead>	

    
<?php

    
	//
    $query="SELECT * FROM staff as t1 LEFT JOIN depertment as t2 on t1.depertment_id = t2.depertment_id WHERE staff_cat <> 'PRINCIPAL'".$where_str;
    $res_query  = mysql_query($query,$dblink);
	
	
	while($row	= mysql_fetch_array($res_query,MYSQL_ASSOC)){
	
	$bg_color = '#FFF';	
	if( $row['is_approved'] == 'P')
	{
		$bg_color = '#FDCBA6';
	}
    ?>
	
	<tr style="background:<?php echo $bg_color;?>;">
    	<td><?php echo $row['staff_name'];?></td>
        <td><?php echo $row['staff_email'];?></td>
        <td><?php echo $row['staff_cat'];?></td>
        <td><?php echo $row['depertment_name'];?></td>
        <td><?php echo date("d/M/Y",$row['reg_date']);?></td>
        <td><input type="checkbox" id="is_active_<?php echo $row['staff_id'];?>" name="is_active_<?php echo $row['staff_id'];?>" <?php if($row['is_active'] == 'Y'){?> checked="checked" <?php } ?> ></td>
        <td>
        	<select id="is_approved_<?php echo $row['staff_id'];?>" name="is_approved_<?php echo $row['staff_id']; ?>">
            	<option value="P" <?php if($row['is_approved'] == 'P'){?> selected="selected" <?php }?>>Pending</option>
                <option value="A" <?php if($row['is_approved'] == 'A'){?> selected="selected" <?php }?>>Approved</option>
                <option value="R" <?php if($row['is_approved'] == 'R'){?> selected="selected" <?php }?>>Rejected</option>
            </select>
        </td>
		<td><?php if($row['staff_gender']=='M')
					echo 'Male';
				  else
				  	echo 'Female';

		
			?>
		</td>
		
		<td style="background: #eee;">
        	<table>
            	<tr>
                	<td style="width:30px;">CL: </td>
                    <td style="width:60px;"><input type="text" class="form-control" id= "cl_<?php echo $row['staff_id'];?>" value="<?php echo $row['staff_cl_balance'];?>" /></td>
					<td style="padding-left:20px; width:50px;">SL:</td>
                    <td style="width:60px;"><input type="text" class="form-control"  id= "sl_<?php echo $row['staff_id'];?>" value="<?php echo $row['staff_sl_balance'];?>" /></td>
					<td style="padding-left:20px; width:50px;">PL:</td>
                    <td style="width:60px;"><input type="text" class="form-control" id= "pl_<?php echo $row['staff_id'];?>" value="<?php echo $row['staff_pl_balance'];?>" /></td>
					<?php if($row['staff_gender']=='F'){ ?>
						<td  style="padding-left:20px; width:50px;">ML: </td>
                    	<td style="width:60px;"><input type="text" class="form-control" id= "ml_<?php echo $row['staff_id'];?>" value="<?php echo $row['staff_ml_balance'];?>" /></td>
					<?php } ?>
					<td style="padding-left:20px; width:50px;">
						<button class="btn btn-xs btn-danger" name="btn_save_<?php echo $row['staff_id']; ?>" id= "btn_save_<?php echo $row['staff_id']; ?>" onclick= "save_staff(<?php echo $row['staff_id']; ?>);">SAVE</button>
					</td>
                </tr>
            </table>
        	
            
        </td>
        
    </tr>
  
    
	<?php	
    }
	
 ?>
</table>
</div>
</div>

<script type="text/javascript">

	
	

	function save_staff(staff_id){
		
		

		var is_approved		= $("#is_approved_" +staff_id).val();
		var cl				= $("#cl_" +staff_id).val();
		var sl				= $("#sl_" +staff_id).val();
		var pl				= $("#pl_" +staff_id).val();
		var ml				= $("#ml_" +staff_id).val();
		var is_active		= $("#is_active_" +staff_id).prop('checked');

		if(is_active==false){
			is_active='N';
		}
		else{
			is_active='Y';
		}

		
		var url='ajax_save_staff.php?staff_id='+staff_id+'&is_approved='+is_approved+'&cl='+cl+'&sl='+sl+ '&pl='+pl+'&ml='+ml+'&is_active='+is_active;

	
		$.ajax({

			
			cache: false,
			url: url,
			
			success: function(data){
					if(data==1){
						alert("data submitted successfully...");
						window.location = "manage_staff.php";
					}
			}		

		});
		

		
	
		
	}


</script>

<?php include "footer.php";?>
