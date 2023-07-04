<?php 
$dboracle = new OracleApp();

// fetch 2nd opt defect 

$wip_entity_id = $_POST['wip_entity_id'];

$select_2nd = " select a.DESCRIPTION, b.FLEX_VALUE,  B.TRANSACTION_QUANTITY
from 
wip_operations a,
tpc_rejects b
where
a.wip_entity_id = b.wip_entity_id
and a.OPERATION_SEQ_NUM = b.OPERATION_SEQ_NUM
and a.WIP_ENTITY_ID = $wip_entity_id
and upper(description) like upper('%2nd%')";
$result_2nd = $dboracle->query($select_2nd)->fetchAll();

// fetch 3rd opt defect 

$select_3rd = " select a.DESCRIPTION, b.FLEX_VALUE,  B.TRANSACTION_QUANTITY
from 
wip_operations a,
tpc_rejects b
where
a.wip_entity_id = b.wip_entity_id
and a.OPERATION_SEQ_NUM = b.OPERATION_SEQ_NUM
and a.WIP_ENTITY_ID = $wip_entity_id
and upper(description) like upper('%3RD%')";
$result_3rd = $dboracle->query($select_3rd)->fetchAll();

// fetch 4th opt defect 

$select_4th = " select a.DESCRIPTION, b.FLEX_VALUE,  B.TRANSACTION_QUANTITY
from 
wip_operations a,
tpc_rejects b
where
a.wip_entity_id = b.wip_entity_id
and a.OPERATION_SEQ_NUM = b.OPERATION_SEQ_NUM
and a.WIP_ENTITY_ID = $wip_entity_id
and upper(description) like upper('%4th%')";
$result_4th = $dboracle->query($select_4th)->fetchAll();

// FETCH FINAL TEST 

$select_final = " select a.DESCRIPTION, b.FLEX_VALUE, B.TRANSACTION_QUANTITY
from
wip_operations a,
tpc_rejects b
where
a.wip_entity_id = b.wip_entity_id
and a.OPERATION_SEQ_NUM = b.OPERATION_SEQ_NUM
and a.WIP_ENTITY_ID = $wip_entity_id
and upper(description) like upper('%FINAL TEST%')";
$result_final = $dboracle->query($select_final)->fetchAll();


$data = array(
    "second" => $result_2nd,
    "third" => $result_3rd,
    "fourth" => $result_4th,
    "final_test" => $result_final
);

echo json_encode($data);