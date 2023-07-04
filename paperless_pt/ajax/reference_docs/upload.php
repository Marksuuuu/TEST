<?php

$db = new Postgresql();

$filename = $_FILES['file']['name'];
$addedBy = "(".$_POST["emp"].") ".$_POST["fname"];
$targetDir = '../../pdf/'; 
$targetFile = $targetDir . $filename;

$date = date("Y-m-d h:i:s a");


$sql = "INSERT INTO public.reference_docs(filename,added_on,added_by)VALUES('$filename','$date','$addedBy')";
$query = $db -> query($sql);


if($query){
    move_uploaded_file($_FILES['file']['tmp_name'], $targetFile);


    $data = "Data (".$filename.") has been added by ".$addedBy." On ".$date. PHP_EOL; 
    $file = "../../logs/RemoveAddLogs.txt";

    file_put_contents($file, $data, FILE_APPEND);
}



$data = array(
    'success' => true
);
echo json_encode($data);
?>