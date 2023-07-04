<?php
$db = new Postgresql();
$lessYear = $_REQUEST["lessYear"];

$sql = "SELECT id,filename,to_char(added_on, 'MONTH DD, YYYY on HH12:MI AM') as added_on,added_by 
        FROM 
        reference_docs 
        WHERE 
        STATUS = 'active' 
        AND 
        to_char(added_on, 'YYYY') = '$lessYear'";
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