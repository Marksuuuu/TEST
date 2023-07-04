<?php

function getFileName(){
	$self =  $_SERVER['PHP_SELF'];
	$fileName = explode("/",$self);

	return end($fileName);
}

function printf_array($format, $arr) 
{ 
    return call_user_func_array('printf', array_merge((array)$format, $arr)); 
} 

function sysDate(){
	return date("n/d/Y G:i:s A");
}


function pre($str){
	echo "<pre>";
	var_dump($str);
	echo "</pre>";
}





?>