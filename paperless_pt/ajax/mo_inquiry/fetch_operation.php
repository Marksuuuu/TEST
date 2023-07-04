<?php
$dboracle = new OracleApp();

$dbpost = new Postgresql();
$mo = $_POST['mo'];




$select = "select a.description, a.attribute2, a.OPERATION_SEQ_NUM , a.wip_entity_id,to_char( min(start_date), 'DD MON YY HH:MI AM')min_start, to_char (max(end_date), 'DD MON YY HH:MI AM')max_end, max(c.QUANTITY_COMPLETED) qty_in, a.QUANTITY_REJECTED
from 
wip_operations  a,
wip_entities b,
TRANS_WIPQTY_HIST c
where 
a.wip_entity_id = b.wip_entity_id
and a.wip_entity_id = c.wip_entity_id(+)
and a.operation_seq_num = c.operation_seq_num(+)
and b.wip_entity_name = '$mo'
group by a.description, a.attribute2, a.OPERATION_SEQ_NUM , a.wip_entity_id, a.QUANTITY_REJECTED
order by OPERATION_SEQ_NUM";
$result = $dboracle->query($select)->fetchAll();

if ($result) {

    $cnt = 0;
    $check_operator = array();
    $check_machine = array();

    $get_previous_qty_in = 0;
    $get_reject = 0;
    $get_previous_out = 0;
    foreach ($result as $rs) {

        
        // $reject = $rs['QUANTITY_REJECTED'];

        if ($cnt > 1) {
            $qty_in = $get_previous_out;
            $qty_out = $get_previous_out - $get_reject;
        }else{
            $qty_in = $rs['QTY_IN'];
            $qty_out = $rs['QTY_IN'];
        }

        $result[$cnt]['IN'] = $qty_in;
        $result[$cnt]['OUT'] = $qty_out;

        $yield = @round(($qty_out / $qty_in) * 100, 2);

        $result[$cnt]['YIELD'] = $yield . '%';

        if ($rs['DESCRIPTION'] == 'QA Final Test Buy-off') {
            $result[$cnt]['IN'] = @$rs['QTY_IN'];
            $result[$cnt]['OUT'] = $rs['QTY_IN'];

            $result[$cnt]['YIELD'] = @round(($rs['QTY_IN'] / $rs['QTY_IN']) * 100, 2);
            $result[$cnt]['YIELD'] = $result[$cnt]['YIELD'] . '%';
        }

        if (empty($rs['MIN_START'])) {
            $result[$cnt]['IN'] = 0;
            $result[$cnt]['OUT'] = 0;
            $result[$cnt]['YIELD'] = 0 . '%';
        }

        // get operator
        $get_operator = "SELECT b.empnum
    FROM
    TRANS_WIPQTY_HIST a,
    tks_control_lmu b
    WHERE
    a.assid = b.assid
    and a.WIP_ENTITY_ID = " . $rs['WIP_ENTITY_ID'] . "
    AND a.OPERATION_SEQ_NUM = " . $rs['OPERATION_SEQ_NUM'] . "  ";
        $result_operator = $dboracle->query($get_operator)->fetchAll();

        if ($result_operator) {
            foreach ($result_operator as $opr) {
                if (!in_array($opr['EMPNUM'], $check_operator)) {
                    $check_operator[] = $opr['EMPNUM'];

                    $result[$cnt]['OPERATOR'][] = $opr['EMPNUM'];
                }
            }
        }
        // end of operator

        //get machine 
        $get_machine = "SELECT b.*
    FROM
    TRANS_WIPQTY_HIST a,
    TRANS_WIPQTY_MACHINES b
    WHERE
    a.WIPQTY_TRANSID = b.WIPQTY_TRANSID
    and a.WIP_ENTITY_ID = " . $rs['WIP_ENTITY_ID'] . "
    AND a.OPERATION_SEQ_NUM = " . $rs['OPERATION_SEQ_NUM'] . " ";
        $result_machine = $dboracle->query($get_machine)->fetchAll();

        if ($result_machine) {
            foreach ($result_machine as $mach) {
                if (!in_array($mach['MACHINE_NAME'], $check_machine)) {
                    $check_machine[] = $mach['MACHINE_NAME'];

                    $result[$cnt]['MACHINE'][] = $mach['MACHINE_NAME'];
                }
            }
        }

        if (!empty($rs['MIN_START']) && $rs['DESCRIPTION'] != 'QA Final Test Buy-off') {
            $get_previous_qty_in = $qty_in;
            $get_previous_out = $qty_out;

            $get_reject = $rs['QUANTITY_REJECTED'];
        }


        // get condition

        $select_condition = "SELECT * from mo_inquiry_condition_tbl where wip_entity_id = ".$rs['WIP_ENTITY_ID']." and operation_seq_num = " . $rs['OPERATION_SEQ_NUM'] . " ";
        $result_condition = $dbpost->fetchRow($select_condition);

        if($result_condition){
            $result[$cnt]['CONDITION'] = $result_condition['description'];
        }else{
            $result[$cnt]['CONDITION'] = null;
        }

        // get qa stamp

        $select_qa_stamp = "SELECT * from mo_inquiry_qa_stamp_tbl where wip_entity_id = ".$rs['WIP_ENTITY_ID']." and operation_seq_num = " . $rs['OPERATION_SEQ_NUM'] . " ";
        $result_qa_stamp = $dbpost->fetchRow($select_qa_stamp);

        if($result_qa_stamp){

            if($result_qa_stamp['status']== 'ACCEPT'){
                $result[$cnt]['QA'] = 'accept';
                $result[$cnt]['QA_STAMP'] = $result_qa_stamp['qa_stamp_no'];
            }else{
                $result[$cnt]['QA'] = 'reject';
                $result[$cnt]['QA_STAMP'] = $result_qa_stamp['qa_stamp_no'];
            }
        }else{
            $result[$cnt]['QA'] = null;
        }


        $cnt++;
    }
}
else{
    $result = array();
}

$data = array(
    "data" => $result
);

echo json_encode($data);