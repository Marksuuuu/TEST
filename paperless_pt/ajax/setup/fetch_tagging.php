<?php
$dbpost_hybrid = new PostgresqlHybrid();

// get area
$query_area = "SELECT * from pl_setup_area where status = 'active'";
$result_area = $dbpost_hybrid->fetchAll($query_area);

$sql = "http://hris.teamglac.com/api/users/";
$a = file_get_contents($sql);
$a = json_decode($a);
$result = $a->result;

// var_dump($result);exit;
$check_sub_section = array();
$store_sub_section = array();
$cnt = 0;
foreach($result as $key => $value){
    if($value->employee_sub_section != null){
        if(!in_array($value->employee_sub_section_id, $check_sub_section)){
            $check_sub_section[] = $value->employee_sub_section_id;
            $store_sub_section[$cnt]['id'] = $value->employee_sub_section_id;
            $store_sub_section[$cnt]['name'] = $value->employee_sub_section;
            $cnt++;
        }
    }
}
// var_dump($store_sub_section);exit;


$data = array(
    "sub_section" => $store_sub_section,
    "area" => $result_area

);

echo json_encode($data);