<?php
$db = new Postgresql();
$checkedValues = $_POST["checkedValues"];
$removeBy = "(".$_POST["emp"].") ".$_POST["fname"];
$date = date("Y-m-d h:i:s a");
if($checkedValues){
    foreach($checkedValues as $values){
        $sql = "UPDATE reference_docs SET STATUS = 'deactive',remove_by = '$removeBy',remove_on ='$date' WHERE id = '$values'";
        $db -> query($sql);


        $data = "Data (id#".$values.") has been removed by ".$removeBy." On ".$date. PHP_EOL; 
        $file = "../../logs/RemoveAddLogs.txt";

        file_put_contents($file, $data, FILE_APPEND);
    }
}   






$data = array(
    "data" => true
);


echo json_encode($data);
