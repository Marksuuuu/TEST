<?php
session_start();
$dbpost = new Postgresql();

$mo =  $_POST['mo'];
$tray = $_POST['tray'];

$user_log = $_SESSION["hris"]['employee_id_no'];

$check_tray = "SELECT * from mo_inquiry_tray_tbl where wip_entity_id = $mo";
$result_check = $dbpost->fetchRow($check_tray);

if($result_check){
    $update_tray = "UPDATE mo_inquiry_tray_tbl set description = '$tray', changed_by = $user_log, changed_on = now() + interval '8 hours' where wip_entity_id = $mo  ";
    $result_update = $dbpost->query($update_tray);
    $flag = 2;
}else{
    $insert = "INSERT into mo_inquiry_tray_tbl(wip_entity_id,description,added_by)VALUES($mo,'$tray',$user_log)";
    $result = $dbpost->query($insert);
    $flag = 1;
}

$data = array(
    "flag" => $flag
);


echo json_encode($flag);