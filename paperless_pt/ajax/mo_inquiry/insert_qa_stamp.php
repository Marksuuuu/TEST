<?php
session_start();
$dbpost = new Postgresql();

$user_log = $_SESSION["hris"]['employee_id_no'];

$wip_entity_id = $_POST['wip_entity_id'];
$operation_seq_num = $_POST['operation_seq_num'];
$qa_stamp = $_POST['qa_stamp'];
$status = $_POST['status'];

$sql_in = "INSERT into mo_inquiry_qa_stamp_tbl(wip_entity_id,operation_seq_num,qa_stamp_no,status,added_by)VALUES($wip_entity_id,$operation_seq_num,'$qa_stamp','$status',$user_log)";
$dbpost->query($sql_in);

echo json_encode(1);