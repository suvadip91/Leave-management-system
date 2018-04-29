<?php 
session_start();
require 'conn.php';
require "function.php";

if( $_SESSION['staff_id'] == '' || !isset($_SESSION['staff_id']))
{
	header('location:login.php');
}


$menu_num = 1;
$page_name = "Dashboard";
include "header.php";


$sql="select * from staff where staff_id='".$_SESSION['staff_id']."'";
$result_query=mysql_query($sql,$dblink);
$row=mysql_fetch_assoc($result_query);

?>


	<?php if($row['staff_cat']!='PRINCIPAL'){?>
	<div class="row">
		<div class="col-md-3">
			<table class="table  table-bordered table-hover">
				<thead>
				<tr>
					<th>Leave Type</th>
					<th>Leave Balance</th>
				</tr>
				</thead>
		
			

			
				<tr>
					<td>
						CASUAL LEAVE 
					</td>
					<td>
						<?php echo $row['staff_cl_balance'];?>
					</td>
				</tr>
				<tr>
					<td>
						SICK LEAVE
					</td>
					<td>
						<?php echo $row['staff_sl_balance'];?>
					</td>
				</tr>
				<tr>
					<td>
						PRIVILEGED LEAVE
					</td>
					<td>
						<?php echo $row['staff_pl_balance'];?>
					</td>
				</tr>			
			
		
		
		
			
				<?php if($row['staff_gender']=='F'){?>	
				<tr>
					<td>
						MATERNITY LEAVE
					</td>
					<td>
						<?php echo $row['staff_ml_balance'];?>
					</td>
				</tr>
				<?php }?>
			</table>
		</div>
		</div>	

		<?php } ?> 
	



<?php include "footer.php";?>
