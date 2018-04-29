

<ul class="nav nav-list">
	<li class="<?php if($menu_num == 1){echo " active";}?> hover">
		<a href="dashboard.php">
			<i class="menu-icon fa fa-tachometer"></i>
			<span class="menu-text">
				Dashboard
			</span>
		</a>
	</li>

	<?php if($_SESSION['staff_cat']!='PRINCIPAL'){?>
	<li class="<?php if($menu_num == 2){echo " active";}?> hover">
		<a href="leave_request.php">
			<i class="menu-icon fa fa-tachometer"></i>
			<span class="menu-text">
				Request for Leave
			</span>
		</a>
	</li>

	<li class="<?php if($menu_num ==3){echo " active";}?> hover">
		<a href="leave_status.php">
			<i class="menu-icon fa fa-tachometer"></i>
			<span class="menu-text">
				Leave Status
			</span>
		</a>
	</li>

	<?php } ?>

	<?php if($_SESSION['staff_cat'] == 'PRINCIPAL'){?>
	<li class="<?php if($menu_num == 5){echo " active";}?> hover">
		<a href="manage_staff.php">
			<i class="menu-icon fa fa-tachometer"></i>
			<span class="menu-text">
				Manage Staff
			</span>
		</a>
	</li>
	<li class="<?php if($menu_num == 7){echo " active";}?> hover">
		<a href="change_year.php">
			<i class="menu-icon fa fa-tachometer"></i>
			<span class="menu-text">
				Change Year
			</span>
		</a>
	</li>
    <?php }?>
	

	<?php if( $_SESSION['staff_cat'] == 'HOD' || $_SESSION['staff_cat'] == 'PRINCIPAL'){?>
	<li class="<?php if($menu_num == 6){echo " active";}?> hover">
		<a href="manage_leave.php">
			<i class="menu-icon fa fa-tachometer"></i>
			<span class="menu-text">
				Leave Management
			</span>
		</a>
	</li>
    
    <?php }?>
    
	
</ul>