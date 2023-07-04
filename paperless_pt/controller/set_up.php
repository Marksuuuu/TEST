<?php
$dbpost = new Postgresql();

$sql = "SELECT * from tagging_sub_section_tbl order by id desc";
$result = $dbpost -> fetchAll($sql);


include("view/" . getFileName()); ?>