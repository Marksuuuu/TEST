<?php
session_start();

$hrisUsername = $_POST["hrisusername"];

$hrispass = $_POST["hrispass"];

$storeCredentials = array();

$sql = "http://hris.teamglac.com/api/users/login?u=" . urlencode($hrisUsername) . "&p=" . urlencode($hrispass);
$a = file_get_contents($sql);
$a = json_decode($a);
$result = $a->result;

if($result){
    $flag = 1;

    foreach($result as $key => $value){
        $_SESSION["hris"][$key] = $value;

      $storeCredentials[$key] = $value;
   }






    $hash = sha1($result->employee_id_no);
}else{
    $flag = 0;
    $hash = 0;
}


$data = array(
    "status" => $flag,
    "encrypt" =>  $hash,
    "storeCredentials" => $storeCredentials

);

echo json_encode($data);

