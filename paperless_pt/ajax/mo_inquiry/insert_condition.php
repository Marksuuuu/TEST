<?php
session_start();
$dbpost = new Postgresql();

$user_log = $_SESSION["hris"]['employee_id_no'];

$wip_entity_id = $_POST['wip_entity_id'];
$operation_seq_num = $_POST['operation_seq_num'];
$condition = $_POST['condition'];

$check_condition = "SELECT * from mo_inquiry_condition_tbl where wip_entity_id = $wip_entity_id and operation_seq_num = $operation_seq_num ";
$result_check = $dbpost->fetchRow($check_condition);

if ($result_check) {
    $update = "UPDATE mo_inquiry_condition_tbl set description = '$condition', changed_by = $user_log, changed_on = now() + interval '8 hours' where wip_entity_id = $wip_entity_id and operation_seq_num = $operation_seq_num  ";
    $result_up = $dbpost->query($update);
    $flag = 2;
} else {
    $sql_in = "INSERT into mo_inquiry_condition_tbl(wip_entity_id,operation_seq_num,description,added_by)VALUES($wip_entity_id,$operation_seq_num,'$condition', $user_log)";
    $dbpost->query($sql_in);
    $flag = 1;
}
$data = array(
    "flag" => $flag
);

echo json_encode($flag);