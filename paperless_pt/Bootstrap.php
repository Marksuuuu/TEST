<?php 
session_start();
date_default_timezone_set("Asia/Manila");
include_once("includes/functions.php");
foreach (glob("Model/*.php") as $filename)
{
	include_once($filename);
}foreach (glob("Model/issuance/*.php") as $filename)
{
	include_once($filename);
}
$url = $_SERVER['REQUEST_URI'];
$url_folder = substr($url,1);

$PROJECTNAME = "";