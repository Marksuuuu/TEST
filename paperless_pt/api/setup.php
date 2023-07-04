<?php
$dbpost = new Postgresql();


$sql = "SELECT a.optgrp_id,a.id,b.sbu_name,c.area_name,a.optgrp_name
        FROM 
        public.pl_maintenance_tag_setup a,
        pl_setup_sbu b,
        pl_setup_area c
        WHERE
        a.sbu_id = b.id
        AND
        a.area_id = c.id";
$query = $dbpost -> fetchAll($sql);

$data = array(
    "data" => $query
);


echo json_encode($data);