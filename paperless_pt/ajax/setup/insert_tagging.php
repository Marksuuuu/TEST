<?php
session_start();
$dbpost = new Postgresql();
$dbpost_hybrid = new PostgresqlHybrid();

$user_log = $_SESSION["hris"]['employee_id_no'];

// echo $user_log;exit;

$select_sub_section = $_POST['select_sub_section'];
$select_area = $_POST['select_area'];

$select_sub_section_text = $_POST['select_sub_section_text'];
$select_area_text = $_POST['select_area_text'];

$sql_in = "INSERT into tagging_sub_section_tbl(sub_section_id,area_id,added_by,sub_section_name,area_name)VALUES($select_sub_section,$select_area,$user_log,'$select_sub_section_text','$select_area_text') returning id";
$result = $dbpost->fetchRow($sql_in);

$max_id =  $result['id'];

// echo $select_sub_section;




echo json_encode($max_id);