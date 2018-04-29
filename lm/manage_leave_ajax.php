<?php 

    session_start();
    require 'conn.php';

    if($_SESSION['staff_id']==''  || !isset($_SESSION['staff_id'])){

        header('location:login.php');
    }

    if($_SESSION['staff_cat']=='HOD'){

         $selectedAction = $_GET['selectedAction'];
         $leave_apply_id = $_GET['leave_apply_id'];

        $sql="update leave_apply set leave_apply_status='$selectedAction' where leave_apply_id='$leave_apply_id'";
        $res_query=mysql_query($sql,$dblink);

        if($res_query){
             echo 1;
        }
    
    }
    else{
        
        $selectedAction         = $_GET['selectedAction'];
        $leave_apply_id         = $_GET['leave_apply_id'];
        $leave_id               = $_GET['leave_id'];
        $leave_apply_duration   = $_GET['leave_apply_duration'];
        $cl                     = $_GET['cl'];
        $sl                     = $_GET['sl'];
        $pl                     = $_GET['pl'];
        $ml                     = $_GET['ml'];
        $staff_id               = $_GET['staff_id'];

        
        $sql="update leave_apply set leave_apply_status='$selectedAction' where leave_apply_id='$leave_apply_id'";
        $res_query=mysql_query($sql,$dblink);


        if($selectedAction =='3'){
            if($leave_id=='1'){
                $cl= $cl - $leave_apply_duration;
                $sql="update staff set staff_cl_balance='$cl' where staff_id='$staff_id'";
                $res_query=mysql_query($sql,$dblink);
            }
            else if($leave_id=='2'){
                $sl=$sl-$leave_apply_duration;
                $sql="update staff set staff_sl_balance='$sl' where staff_id='$staff_id'";
                $res_query=mysql_query($sql,$dblink);
            }
            else if($leave_id=='3'){
                $pl=$pl-$leave_apply_duration;
                $sql="update staff set staff_pl_balance='$pl'  where staff_id='$staff_id'";
                $res_query=mysql_query($sql,$dblink);
            }
            else{
                $ml=$ml-$leave_apply_duration;
                $sql="update staff set staff_ml_balance='$ml'  where staff_id='$staff_id'";
                $res_query=mysql_query($sql,$dblink);
            }
            echo 1;
        }
        else if($selectedAction =='4'){
            echo 1;
        }
        else{
            echo 0;
        }


    }

?>