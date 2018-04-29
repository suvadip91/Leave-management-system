<?php
	session_start();
	require 'conn.php';
	
	if($_SESSION['staff_id']=='' || !isset($_SESSION['staff_id']) || $_SESSION['staff_cat']=='FAC' || $_SESSION['staff_cat']=='NFAC'){
		
		header('location:login.php');

	}

	$menu_num = 6;
	$page_name = "Manage_leave";
	include 'header.php';
	
	if($_SESSION['staff_cat']=='HOD'){

?>
	<div class="row">
	<div class="col-md-12">
	<table class="table  table-bordered table-hover" style="table-layout:fixed;">
		<thead>
		<tr>
			<td>NAME</td>
			<td>LEAVE APPLY DATE</td>
			<td>LEAVE STARTING DATE</td>
			<td>JOINING DATE</td>	
			<td style="max-width:200px; word-wrap:break-word;">LEAVE REASON</td>
			<td>LEAVE CATEGORY</td>
			<td>RELATED LEAVE BALANCE</td>
			<td>LEAVE DURATION</td>
			<td>HOD COMMENT</td>
			<td>ACTION</td> 
			
		</tr>
		</thead>

<?php 
	$query="select * from leave_apply INNER JOIN staff on leave_apply.staff_id=staff.staff_id where staff_cat <> 'HOD' and depertment_id='".$_SESSION['depertment_id']."' and leave_apply_status='1' order by leave_apply_id desc";
	$res_query=mysql_query($query,$dblink);
	while($row=mysql_fetch_assoc($res_query)){
		
		$query1="select * from staff where staff_id ='".$row['staff_id']."'";
		$res_query1=mysql_query($query1,$dblink);
		$row1=mysql_fetch_assoc($res_query1);

		if($row['leave_id']=='1'){
			$leave_bal=$row1['staff_cl_balance'];
			$leave_cat='CASUAL LEAVE';
		}
		else if($row['leave_id']=='2'){
			$leave_bal=$row1['staff_sl_balance'];
			$leave_cat='SICK LEAVE';
		}
		else if($row['leave_id']=='3'){
			$leave_bal=$row1['staff_pl_balance'];
			$leave_cat='PRIVILEGED LEAVE';
		}
		else{
			$leave_bal=$row1['staff_ml_balance'];
			$leave_cat='MATERNITY LEAVE';
		}
 ?>

	<tr>
		<td><?php echo $row['staff_name'];?></td>
		<td><?php echo date("d/M/Y",$row['leave_apply_date']);?></td>
		<td><?php echo date("d/M/Y",$row['leave_apply_starting_date']);?></td>
		<td><?php echo date("d/M/Y",$row['leave_apply_joining_date']);?></td>	
		<td style="max-width:200px; word-wrap:break-word;"><?php echo $row['leave_apply_reason'];?></td>
		<td><?php echo $leave_cat;?></td>
		<td><?php echo $leave_bal;?></td>
		<td><?php echo $row['leave_apply_duration']; ?></td>
		<td>
			<select name="hod_comment" id="select_<?php echo $row['leave_apply_id'];?>">
				<option value="">--SELECT--</option>
		    	<option value="0">REJECT</option>
				<option value="2">APPROVE</option>
		     </select>
		</td>
		<td><button class="btn btn-danger" id="<?php echo $row['leave_apply_id'];?>" onclick="manage_leave_hod(<?php echo $row['leave_apply_id'];?>)">SAVE</button></td>

	</tr>
	
<?php 	}?> 
</table>
</div>
</div>
	<?php }else{?>
	<div class="row">
	<div class="col-md-12">
	<table class="table  table-bordered table-hover">
		<thead>
		<tr>
			<td>NAME</td>
			<td>LEAVE APPLY DATE</td>
			<td>LEAVE STARTING DATE</td>
			<td>JOINING DATE</td>	
			<td style="max-width:200px; word-wrap:break-word;">LEAVE REASON</td>
			<td>DEPERTMENT</td>
			<td>STAFF CATEGORY</td>
			<td>PRINCIPAL COMMENT</td>
			<td>ACTION</td>
		</tr>
		</thead>

<?php 
	$query="select * from leave_apply INNER JOIN staff on leave_apply.staff_id=staff.staff_id  where leave_apply_status='2' or (leave_apply_status='1' and (staff_cat='HOD' or staff_cat='NFAC')) order by leave_apply_id desc";
	$res_query=mysql_query($query,$dblink);
	while($row=mysql_fetch_assoc($res_query)){
 ?>
	<?php  $query1="select * from depertment where depertment_id ='".$row['depertment_id']."'";
	 $res_query1=mysql_query($query1,$dblink);
	 $row1=mysql_fetch_assoc($res_query1);
	 ?>
	<tr style="background-color:white;">
		<td><?php echo $row['staff_name'];?></td>
		<td><?php echo date("d/M/Y",$row['leave_apply_date']);?></td>
		<td><?php echo date("d/M/Y",$row['leave_apply_starting_date']);?></td>
		<td><?php echo date("d/M/Y",$row['leave_apply_joining_date']);?></td>	
		<td style="max-width:200px; word-wrap:break-word;"><?php echo $row['leave_apply_reason'];?></td>
		<td><?php echo $row1['depertment_name'];?></td>
		<td><?php echo $row['staff_cat'];?></td>
		<td><select name="principal_comment" id="select2_<?php echo $row['leave_apply_id'];?>">
				<option value="">--SELECT--</option>
		    	<option value="4">REJECT</option>
				<option value="3">APPROVE</option>
		     </select></td>
		<td><button class="bt btn-danger" id="<?php echo $row['staff_id'];?>" onclick="manage_leave_principal(<?php echo $row['leave_apply_id'];?>,<?php echo $row['leave_id'];?>,<?php echo $row['leave_apply_duration'];?>,<?php echo $row['staff_cl_balance'];?>,<?php echo $row['staff_sl_balance'];?>,<?php echo $row['staff_pl_balance'];?>,<?php echo $row['staff_ml_balance'];?>,<?php echo $row['staff_id'];?>)">SAVE</button></td>

	</tr>
	
<?php 	} 
	}?>

	</table>
	</div>
	</div>

<script type="text/javascript">

	function manage_leave_hod(leave_apply_id){

		

		var selectedAction = $("#select_" + leave_apply_id).val();

		var url = "manage_leave_ajax.php?selectedAction="+selectedAction+"&leave_apply_id="+leave_apply_id;

		$.ajax({

			cache : false,

			url : url,

			success:function(data){

				if(data==1){
					alert("data submitted successfully....");
					window.location="manage_leave.php";
				}
				else{
					alert("Error...");
				}
			}

		});


	}
	function manage_leave_principal(leave_apply_id,leave_id,leave_apply_duration,cl,sl,pl,ml,staff_id){

		
		
		var selectedAction = $("#select2_"+leave_apply_id).val();

		var url = "manage_leave_ajax.php?selectedAction="+selectedAction+"&leave_apply_id="+leave_apply_id+"&leave_id="+leave_id+"&leave_apply_duration="+leave_apply_duration+"&cl="+cl+"&sl="+sl+"&pl="+pl+"&ml="+ml+"&staff_id="+staff_id;

		

		$.ajax({

			

			cache : false,

			url : url,

			success:function(data){

				if(data==1){
					alert("data submitted successfully....");
					window.location="manage_leave.php";
				}
				else{
					alert("Error...");
				}
			}

		});


}




</script>

<?php include "footer.php"; ?>