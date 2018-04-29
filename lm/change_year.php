<?php 
	session_start();
	require 'conn.php';
	require "function.php";

	if( $_SESSION['staff_id'] == '' || !isset($_SESSION['staff_id']) || $_SESSION['staff_cat']!='PRINCIPAL')
	{
		header('location:login.php');
	}
	
	
	$menu_num = 7;
	$page_name = "Change-year";
    include 'header.php';
    $err_str="";
    if(isset($_POST['btn_submit'])){
        $query="SELECT * FROM leave_year WHERE is_active='Y'";
        $res_query=mysql_query($query,$dblink);
        $row=mysql_fetch_assoc($res_query);
        $year=$row['leave_year_name'];

        $next_year=$year+1;
        $query="UPDATE leave_year set is_active='N' WHERE leave_year_name='$year'";
        $res_query=mysql_query($query,$dblink);

        $query="UPDATE leave_year set is_active='Y' WHERE leave_year_name='$next_year'";
        $res_query=mysql_query($query,$dblink);

        $query="SELECT * FROM staff";
	    $res_query=mysql_query($query,$dblink);
	    while($row=mysql_fetch_assoc($res_query)){
            $old_sl_balance=$row['staff_sl_balance'];
            $staff_id=$row['staff_id'];
            $staff_sl_balance=$old_sl_balance+10;
            $query="UPDATE staff set staff_cl_balance='10',staff_pl_balance='15',staff_sl_balance='$staff_sl_balance' WHERE staff_cat<>'PRINCIPAL' AND staff_id='$staff_id'";
            mysql_query($query,$dblink);
        }
        $err_str=error_message(11); 
    }
    $query="SELECT * FROM leave_year WHERE is_active='Y'";
	$res_query=mysql_query($query,$dblink);
	$row=mysql_fetch_assoc($res_query);
	$year=$row['leave_year_name'];
?>
<div class="row">
	<div class="col-md-4"></div>
	<div class="col-md-4" >
        <div style="border:2px solid red;">
            <h3 style="text-align:center;color:red;">WARNING !!! </h3>
            <p>Make sure that one year ends and another year starts, otherwise it will cause severe damage.</p>
        </div><br/>
        <div style="background:#ddd;border:2px solid #bbb;padding-top:10px;padding-bottom:10px;">
            <center>
                <form action="change_year.php" method="post">
                    <div>
                        <label>Running Year:</label>
                        <label><?php echo $year;?></label>
                        <div class="form-group">
                            <input type="submit" name="btn_submit" class="btn btn-xs btn-danger" value="CHANGE THE YEAR">
                        </div>
                    </div>
                </form>	
            </center>
        </div>
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
	});

</script>

<?php include "footer.php";?>