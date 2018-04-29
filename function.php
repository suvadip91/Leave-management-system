<?php

function error_message( $id, $param)
{
	$err_arr[1] = "Please enter ".$param[0].", it can't be blank";
	$err_arr[2] = "Invalid email-id or password...";
	$err_arr[3] = "Your account is deactivated by admin...";
	$err_arr[4] = "User already exists...";
	$err_arr[5]	= "Password and re-type password does not match...";
	$err_arr[6] = "Error...";
	$err_arr[7]	= "Please fill-up all the field...";
	$err_arr[8]	= "You have registered successfully...";
	$err_arr[9]	= "Data submitted successfully...";	
	$err_arr[10]= "You have updated successfully...";
	$err_arr[11]= "Year has been changed..";
	$err_arr[12]	= "Leave-application submitted successfully...";

	return $err_arr[$id];
}
?>