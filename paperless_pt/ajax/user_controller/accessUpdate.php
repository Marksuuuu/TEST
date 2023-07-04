<?php

$db =new Postgresql();

$id = $_POST["id"];
$emp = $_POST["checkedValues"];


$delete = "DELETE FROM public.access_employee_page WHERE page_id = $id";
$db -> query($delete);


if($emp){
    foreach($emp as $value){


        $sql = "INSERT INTO public.access_employee_page(page_id,employee_id)VALUES('$id','$value')";
        $db -> query($sql);
    }
    
}




$data = array(
    "data" => true,
);


echo json_encode($data);