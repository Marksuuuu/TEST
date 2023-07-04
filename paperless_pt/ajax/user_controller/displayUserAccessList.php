<?php


$dbo = new OracleApp();
$db = new Postgresql();

$sql = "http://hris.teamglac.com/api/users";
$a = file_get_contents($sql);
$a = json_decode ($a,true);
$result = $a['result'];





$sql1 = "SELECT * FROM public.access_employee_page";
$query = $db->fetchAll($sql1);

foreach ($result as $key1 => $value1) {
   foreach ($query as $key => $value) {

        if(intval($value1['employee_id_no']) == intval($value["employee_id"])) {
            $result[$key1]["checked"] = $value["page_id"];
        }
   }
}



$data = array(
    "data" => $result
);

echo json_encode($data);



