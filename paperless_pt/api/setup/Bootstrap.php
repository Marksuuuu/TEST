<?php 

date_default_timezone_set("Asia/Manila");
foreach (glob("../../Model/*.php") as $filename)
{
    include_once($filename);
}

$url = $_SERVER['REQUEST_URI'];
$url_folder = substr($url,1);
include_once("../../includes/functions.php");


$PROJECTNAME = "wop";