<?php

$db = new Postgresql();
$id = $_POST["id"];
$status = $_POST["status"];




$sql = "UPDATE public.page_list SET status = '$status' WHERE id = '$id'";
$query = $db->query($sql);


if($query){
    $flag = "success";
}else{
    $flag = "error";
}

$data = array(
    "data" => $flag
);

echo json_encode($data);