<?php 
session_start();
$dbpost = new Postgresql();

$user_log = $_SESSION["hris"]['employee_id_no'];

$wip_entity_name = $_POST['wip_entity_name'];

$defect = $_POST['defect'];
$qty = $_POST['qty'];

$insert = "INSERT into mo_inquiry_defetc_tbl(wip_entity_name,type,quantity)VALUES('$wip_entity_name','$defect', $qty)";
$result = $dbpost->query($insert);

echo json_encode(1);