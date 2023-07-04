<?php
$dboracle = new OracleApp();

$wip_entity_id = $_POST['wip_entity_id'];

$select=  "select DECODE(upper(a.DESCRIPTION), 'IGNITION TEST', 'FINAL TEST - POWER', upper(a.DESCRIPTION) )DESCRIPTION, b.FLEX_VALUE , b.TRANSACTION_QUANTITY
from 
wip_operations a,
tpc_rejects b 
where 
a.wip_entity_id = b.wip_entity_id 
and a.OPERATION_SEQ_NUM = b.OPERATION_SEQ_NUM 
and a.WIP_ENTITY_ID = $wip_entity_id ";

$result = $dboracle->query($select)->fetchAll();

$check_array = array();
if($result){
    $store_defect = array();
    $cnt = 0;
    foreach($result as $rs){
        if( !in_array($rs['DESCRIPTION'],$check_array)){
            $check_array[] = $rs['DESCRIPTION'];

            $store_defect[$rs['DESCRIPTION']]['FLEX'][] = $rs['FLEX_VALUE'];
            $store_defect[$rs['DESCRIPTION']]['QTY'][] = $rs['TRANSACTION_QUANTITY'];
            
            // if(strpos($rs['DESCRIPTION'], '2ND') !== false){

            // }else if(strpos($rs['DESCRIPTION'], '3RD') !== false){

            // }else if(strpos($rs['DESCRIPTION'], '4TH') !== false){

            // }else if(strpos($rs['DESCRIPTION'], 'FINAL') !== false){

            // }
        }else{
            $store_defect[$rs['DESCRIPTION']]['FLEX'][] = $rs['FLEX_VALUE'];
            $store_defect[$rs['DESCRIPTION']]['QTY'][] = $rs['TRANSACTION_QUANTITY'];
        }
    }
}

// echo '<pre>';       
// print_r($store_defect);
// exit;

$data = array(
    "result" => $store_defect,
    "operation" => $check_array
     
);

echo json_encode($data);