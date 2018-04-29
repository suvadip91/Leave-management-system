<?php

 $dbname='leave_management';
 $username='root';
 $dbpass='';
 $hostname='localhost';
 error_reporting(0);
 
 
 $dblink=mysql_connect($hostname,$username,$dbpass) or die('could not connect...');
 mysql_select_db($dbname,$dblink);
 

?>