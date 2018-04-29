<?php 
session_start();
require 'conn.php';
require "function.php";

if( $_SESSION['staff_id'] != '' && isset($_SESSION['staff_id']))
{
	session_unset();
	session_destroy();
	header('location:login.php'); 
}
?>