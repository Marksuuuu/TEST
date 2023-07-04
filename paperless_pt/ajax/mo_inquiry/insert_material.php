<?php
session_start();
$dbpost = new Postgresql();

$user_log = $_SESSION["hris"]['employee_id_no'];

$wip_entity_name = $_POST['wip_entity_name'];

$stock_no = $_POST['stock_no'];
$desc = $_POST['desc'];
$lot_no = $_POST['lot_no'];
$qty = $_POST['qty'];

$insert = "INSERT into mo_inquiry_materials_tbl(wip_entity_name,stock_no,description,lot_no,quantity,added_by)VALUES('$wip_entity_name', '$stock_no', '$desc', '$lot_no', $qty, $user_log) returning id";
$result = $dbpost->fetchRow($insert);

$max_id = $result['id'];
echo json_encode($max_id);