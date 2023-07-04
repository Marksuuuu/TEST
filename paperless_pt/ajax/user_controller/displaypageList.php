<?php

$db = new Postgresql();

$sql = "SELECT id,page_name,page_link,page_icon,to_char(added_on, 'MONTH DD, YYYY on HH12:MI AM') as added_on,added_by,status
        FROM 
        public.page_list
        ORDER BY status";
$query = $db -> fetchAll($sql);



if($query){
    $data = array(
        "data" => $query
    );
}
else{
    $data = array(
        "data" => 0
    );
}

echo json_encode($data);