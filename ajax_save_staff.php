<?php

session_start();
require 'conn.php';
require "function.php";
error_reporting(0);

if( $_SESSION['staff_id'] == '' || !isset($_SESSION['staff_id']))
{
    header('location:index.php');
}





$staff_id   = $_GET['staff_id'];
$cl         = $_GET['cl'];
$pl         = $_GET['pl'];
$sl         = $_GET['sl'];
$ml         = $_GET['ml'];
$is_approved=$_GET['is_approved'];
$is_active  =$_GET['is_active'];


if($is_approved=='R'){
    $sql="DELETE FROM staff WHERE staff_id='$staff_id'";
    $res_query=mysql_query($sql,$dblink);
      
}
else{
    $sql="update staff set staff_cl_balance='$cl',staff_pl_balance='$pl',staff_sl_balance='$sl',staff_ml_balance='$ml',is_approved='$is_approved',is_active='$is_active' where staff_id='$staff_id'";
    $res_query=mysql_query($sql,$dblink);
}
echo 1;

?>


