<?php

// header('Content-type: application/vnd.ms-excel');
$file = date('Ymd');
header("content-type:application/vnd.ms-excel;charset=UTF-8");
header("Content-Disposition: attachment; filename=$file.xls");
header("Pragma: no-cache");

$buffer = $_POST['csvBuffer'];
$buffer = str_replace("<br/>", "\r\n", $buffer);
try{
    echo $buffer;
} catch ( Exception $e ) {

}

?>