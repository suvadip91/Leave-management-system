<?php
	session_start();
	require 'conn.php';
	
	if($_SESSION['staff_id']=='' || !isset($_SESSION['staff_id'])){
		
		header('location:login.php');
		
	}
	$menu_num = 3;
	$page_name = "Leave-status";
	include 'header.php';
	$where_str="";

	if(isset($_POST['btn_submit'])){
		$year=$_POST['year'];
		$where_str="AND leave_apply_year='$year'";
		

	}else{
		$query="SELECT * FROM leave_year WHERE is_active='Y'";
		$res_query=mysql_query($query,$dblink);
		$row=mysql_fetch_assoc($res_query);
		$year=$row['leave_year_name'];
		$where_str="AND leave_apply_year='$year'";
	}
?>

<div class="row">
	<div class="col-md-4"></div>
	<div class="col-md-4" style="background:#ddd;border:2px solid #bbb;padding-top:10px;padding-bottom:10px;">
		<center>
			<form action="leave_status.php" method="post">
				<div class="form-inline">
					<label>Select the year:</label>
					<select class="form-control" name="year">
						<option value="">--SELECT--</option>
						<option value="2018">2018</option>
						<option value="2019">2019</option>
						<option value="2020">2020</option>
						<option value="2021">2021</option>
						<option value="2022">2022</option>
						<option value="2023">2023</option>
						<option value="2024">2024</option>
						<option value="2025">2025</option>
						<option value="2026">2026</option>
						<option value="2027">2027</option>
						<option value="2028">2028</option>
						<option value="2029">2029</option>
						<option value="2030">2030</option>
					</select>
					<input type="submit" name="btn_submit" class="btn btn-xs btn-success" value="SEARCH">
				</div>
			</form>	
		</center>
	</div>
</div><br/>


<div class="row">
<div class="col-md-12">
<table class="table  table-bordered table-hover" style="table-layout:fixed;">
	<thead>
	<tr>
    	<td>Leave category</td>
        <td ><div style="max-width:100px; word-wrap:break-word;">Leave reason</div></td>
        <td>Apply date</td>
        <td>Leave starting date</td>
        <td>Joining date</td>
        <td>HOD comment</td>
        <td>Principal comment</td>
    </tr>
	</thead>
<?php
	
	$query="select * from leave_apply  WHERE staff_id='".$_SESSION['staff_id']."'".$where_str. "order by leave_apply_id desc";
	$res_query=mysql_query($query,$dblink);
	
	while($row = mysql_fetch_array($res_query,MYSQL_ASSOC)){
		$query1="select * from leave_emp where leave_id ='".$row['leave_id']."'";
		$res_query1=mysql_query($query1,$dblink);
		$row1=mysql_fetch_assoc($res_query1);	
	 
	
?>  

	
    	<tr>
        	
        	<td><?php echo $row1['leave_category'];?></td>
        	<td><div style="max-width:100px; word-wrap:break-word;"><?php echo $row['leave_apply_reason'];?></div></td>
        	<td><?php echo date("d-m-y",$row['leave_apply_date']);?></td>
        	<td><?php echo date("d-m-y",$row['leave_apply_starting_date']);?></td>
        	<td><?php echo date("d-m-y",$row['leave_apply_joining_date']);?></td>
        	<?php if($row['leave_apply_status']=='1'){ $hcomment='pending'; $pcomment='pending';}
				  elseif($row['leave_apply_status']=='2'){ $hcomment='approved';$pcomment='pending';}
				  elseif($row['leave_apply_status']=='0') {$hcomment='rejected'; $pcomment='';}
				  elseif($row['leave_apply_status']=='4') {$hcomment='approved'; $pcomment='rejected';}
				  else {$hcomment='approved'; $pcomment='approved';}
			?>
            <td><?php echo $hcomment;?></td>
        	<td><?php echo $pcomment;?></td>
    
    	</tr>
<?php }?>
</table>
</div>
</div>
<?php include 'footer.php';?>