<?php
$dboracle = new OracleApp();
$dbpost = new Postgresql();

$result_details = array();
$mo = $_POST['mo'];

$get_details = "SELECT distinct a.wip_entity_id, a.wip_entity_name , b.lot_number, b.start_quantity, b.attribute11, b.attribute2, b.attribute3, c.segment1 device, c.description pkg_type,
 c.attribute1 || '  ' || b.attribute13 bd, b.attribute10,
 SHA.ORDER_NUMBER SO_NUM,
RAC.CUSTOMER_NUMBER CUSTOMER_ID,
RAC.CUSTOMER_NAME CUSTOMER,
RSU.LOCATION SHIP_TO_ADDRESS,
RA.ADDRESS1,
NVL(RA.ADDRESS2, ' ') ADDRESS2,
RA.CITY,
RA.COUNTY||' '||RA.POSTAL_CODE CTRY_CODE,
NVL(DECODE(RAC.CUSTOMER_NUMBER,1000,b.ATTRIBUTE11
   ,1026,b.ATTRIBUTE11
   ,1029,b.ATTRIBUTE11
   ,1227,b.ATTRIBUTE11
   ,1244,b.ATTRIBUTE11
   ,1275,b.ATTRIBUTE11
   ,1257,b.ATTRIBUTE11
   ,1295,b.ATTRIBUTE11
   ,1297,b.ATTRIBUTE11 || ' / ' || sla.attribute8
   ,1375,b.ATTRIBUTE11 || ' / ' || SLA.ATTRIBUTE8
   ,1312,SHA.PURCHASE_ORDER_NUM || ' / ' || b.ATTRIBUTE11 || ' / ' || SLA.ATTRIBUTE8
   ,1393,b.ATTRIBUTE11
   ,1397,b.ATTRIBUTE11
   ,1264,SHA.PURCHASE_ORDER_NUM || ' / ' || b.ATTRIBUTE11
   ,SHA.PURCHASE_ORDER_NUM)
   ,SLA.ATTRIBUTE8)RO_JO_PO,
   decode(sla.attribute8, null,SHA.PURCHASE_ORDER_NUM, sla.attribute8) PO,
NVL(RA.STATE, ' ')STATE,
nvl(RA.PROVINCE, ' ')PROVINCE,
RAC2.CUSTOMER_ID CUSTOMER_SHIP_TO_ID,
RAC2.CUSTOMER_NAME CUSTOMER_SHIP_TO_NAME
from
wip_entities a,
wip_discrete_jobs b,
mtl_system_items c,
APPS.AR_CUSTOMERS       RAC,
APPS.AR_CUSTOMERS       RAC2,---added by nat 27-JUN-2022
WIP.WIP_SO_ALLOCATIONS  WSA,
INV.MTL_SALES_ORDERS    MSO,
OE.SO_HEADERS_ALL       SHA,
OE.so_lines_all         SLA,
OE.SO_LINES_ALL         SLA2,
AR.RA_SITE_USES_ALL     RSU,
AR.RA_ADDRESSES_ALL     RA
where
a.wip_entity_id = b.wip_entity_id 
and b.PRIMARY_ITEM_ID = c.inventory_item_id and
a.WIP_ENTITY_ID               = WSA.WIP_ENTITY_ID     AND
WSA.DEMAND_SOURCE_HEADER_ID    = MSO.SALES_ORDER_ID    AND
MSO.SEGMENT1                   = SHA.ORDER_NUMBER      AND
SHA.CUSTOMER_ID                = RAC.CUSTOMER_ID       AND
SHA.SHIP_TO_SITE_USE_ID        = RSU.SITE_USE_ID       AND
RSU.ADDRESS_ID                 = RA.ADDRESS_ID         AND
RA.CUSTOMER_ID                 = RAC2.CUSTOMER_ID      AND---added by nat 27-JUN-2022
WSA.DEMAND_SOURCE_LINE         = SLA2.LINE_ID          AND
SLA2.SHIPMENT_SCHEDULE_LINE_ID = SLA.LINE_ID          
and c.organization_id = 102
and a.wip_entity_name = '$mo'";
$result_details = $dboracle->query($get_details)->fetchRow();

// BARCODE <<-----
$first = "^XA
^FX bar code.
^BY5,2,270
^FO100,80^BC^FD" . $mo . "^FS";

$path = 'http://api.labelary.com/v1/printers/12dpmm/labels/2.7x1.5/0/';

$label = $path . $first . '^XZ^';

$select_materials = "SELECT * from mo_inquiry_materials_tbl where wip_entity_name = '$mo' order by id desc";
$result_materials = $dbpost->fetchAll($select_materials);

if ($result_details) {

    $get_tray = "SELECT description from mo_inquiry_tray_tbl where wip_entity_id = " . $result_details['WIP_ENTITY_ID'] . " ";
    $result_tray = $dbpost->fetchRow($get_tray);

    if ($result_tray) {
        $result_details['TRAY'] = $result_tray['description'];
    }

    // $get_attr10 = ( $result_details['ATTRIBUTE10'] != null ? " AND B.ATTRIBUTE10 = '".$result_details['ATTRIBUTE10'] ."'  "  : '' );

    // $get_mo_range = "SELECT MIN(A.WIP_ENTITY_NAME) MIN_MO, MAX(A.WIP_ENTITY_NAME) MAX_MO--A.WIP_ENTITY_ID,A.WIP_ENTITY_NAME,C.SEGMENT1,B.*
    // FROM
    // WIP_ENTITIES A,
    // WIP_DISCRETE_JOBS B,
    // MTL_SYSTEM_ITEMS C
    // WHERE
    // A.WIP_ENTITY_ID = B.WIP_ENTITY_ID
    // AND B.PRIMARY_ITEM_ID = C.INVENTORY_ITEM_ID
    // AND C.ORGANIZATION_ID = 102
    // AND C.SEGMENT1 = '" . $result_details['DEVICE'] . "'  
    // AND B.ATTRIBUTE10 = '".$result_details['ATTRIBUTE10']."' ";
    // $result_range = $dboracle->query($get_mo_range)->fetchRow();
    // // echo $get_mo_range;exit;
    // if ($result_range) {
    //     if(empty($result_range['MAX_MO'])){
    //         $result_details['RANGE'] = '(' . $result_details['WIP_ENTITY_NAME'] . ' - ' . $result_details['WIP_ENTITY_NAME'] . ')';
    //     }else{
    //         $result_details['RANGE'] = '(' . $result_range['MIN_MO'] . ' - ' . $result_range['MAX_MO'] . ')';
    //     }

    // }


    // $get_range = "SELECT A.WIP_ENTITY_ID,A.WIP_ENTITY_NAME,C.SEGMENT1 --B.*, 
    // FROM
    // WIP_ENTITIES A,
    // WIP_DISCRETE_JOBS B,
    // MTL_SYSTEM_ITEMS C
    // WHERE
    // A.WIP_ENTITY_ID = B.WIP_ENTITY_ID
    // AND B.PRIMARY_ITEM_ID = C.INVENTORY_ITEM_ID
    // AND C.ORGANIZATION_ID = 102
    // AND C.SEGMENT1 = '" . $result_details['DEVICE'] . "'
    // --AND A.WIP_ENTITY_ID > ".$result_details['WIP_ENTITY_ID']."
    // AND 
    // ORDER BY A.WIP_ENTITY_ID";
    // $result_range = $dboracle->query($get_range)->fetchAll();

    // if($result_range){
    //     $cnt = 1;
    //     $max_mo = null;
    //     foreach($result_range as $range){
    //         if(($result_details['WIP_ENTITY_ID'] + $cnt) ==  $range['WIP_ENTITY_ID']){
    //             $max_mo = $range['WIP_ENTITY_NAME'];
    //             break;
    //         }
    //         $cnt++;
    //     }
    //     $result_details['RANGE'] = '(' . $result_details['WIP_ENTITY_NAME'] . ' - ' . $max_mo . ')';
    // }

    if ($result_details['CUSTOMER'] == 'IXYS, LLC') {
        $select_range = "SELECT MIN(WE.WIP_ENTITY_NAME) MIN_MO, MAX(WE.WIP_ENTITY_NAME) MAX_MO
        FROM
        WIP_ENTITIES WE,
        WIP_DISCRETE_JOBS WDJ,
        MTL_SYSTEM_ITEMS MSI,
        WIP.WIP_SO_ALLOCATIONS  WSA,
        INV.MTL_SALES_ORDERS    MSO,
        OE.SO_HEADERS_ALL       SHA,
        OE.so_lines_all         SLA,
        OE.SO_LINES_ALL         SLA2,
        AR.RA_SITE_USES_ALL     RSU,
        AR.RA_ADDRESSES_ALL     RA,
        APPS.AR_CUSTOMERS       RAC,
        APPS.AR_CUSTOMERS       RAC2
        where
        WE.WIP_ENTITY_ID               = WDJ.WIP_ENTITY_ID  AND
        WDJ.PRIMARY_ITEM_ID      	   = MSI.INVENTORY_ITEM_ID AND
        WE.WIP_ENTITY_ID               = WSA.WIP_ENTITY_ID     AND
        WSA.DEMAND_SOURCE_HEADER_ID    = MSO.SALES_ORDER_ID    AND
        MSO.SEGMENT1                   = SHA.ORDER_NUMBER AND
        SHA.CUSTOMER_ID                = RAC.CUSTOMER_ID       AND
        SHA.SHIP_TO_SITE_USE_ID        = RSU.SITE_USE_ID       AND
        RSU.ADDRESS_ID                 = RA.ADDRESS_ID         AND
        RA.CUSTOMER_ID                 = RAC2.CUSTOMER_ID      AND
        WSA.DEMAND_SOURCE_LINE         = SLA2.LINE_ID          AND
        SLA2.SHIPMENT_SCHEDULE_LINE_ID = SLA.LINE_ID           AND
        SHA.ORDER_NUMBER = " . $result_details['SO_NUM'] . " 
        and WDJ.LOT_NUMBER = '" . $result_details['LOT_NUMBER'] . "'";
        $result_range = $dboracle->query($select_range)->fetchRow();
        // echo $select_range;exit;
        if ($result_range) {
            $result_details['RANGE'] = '(' . $result_range['MIN_MO'] . ' - ' . $result_range['MAX_MO'] . ')';

            $result_details['MO_RANGE_MIN'] = $result_range['MIN_MO'];
            $result_details['MO_RANGE_MAX'] = $result_range['MAX_MO'];
        }

    }else{
        $select_range = "SELECT MIN(WE.WIP_ENTITY_NAME) MIN_MO, MAX(WE.WIP_ENTITY_NAME) MAX_MO
        FROM
        WIP_ENTITIES WE,
        WIP_DISCRETE_JOBS WDJ,
        MTL_SYSTEM_ITEMS MSI,
        WIP.WIP_SO_ALLOCATIONS  WSA,
        INV.MTL_SALES_ORDERS    MSO,
        OE.SO_HEADERS_ALL       SHA,
        OE.so_lines_all         SLA,
        OE.SO_LINES_ALL         SLA2
        where
        WE.WIP_ENTITY_ID               = WDJ.WIP_ENTITY_ID  AND
        WDJ.PRIMARY_ITEM_ID      	   = MSI.INVENTORY_ITEM_ID AND
        WE.WIP_ENTITY_ID               = WSA.WIP_ENTITY_ID     AND
        WSA.DEMAND_SOURCE_HEADER_ID    = MSO.SALES_ORDER_ID    AND
        MSO.SEGMENT1                   = SHA.ORDER_NUMBER AND
        WSA.DEMAND_SOURCE_LINE         = SLA2.LINE_ID          AND
        SLA2.SHIPMENT_SCHEDULE_LINE_ID = SLA.LINE_ID           AND
        SHA.ORDER_NUMBER = " . $result_details['SO_NUM'] . " ";
        $result_range = $dboracle->query($select_range)->fetchRow();

        if ($result_range) {
            $result_details['RANGE'] = '(' . $result_range['MIN_MO'] . ' - ' . $result_range['MAX_MO'] . ')';
            $result_details['MO_RANGE_MIN'] = $result_range['MIN_MO'];
            $result_details['MO_RANGE_MAX'] = $result_range['MAX_MO'];
        }
    }


}

if (empty($result_materials)) {
    $result_materials = array();
}



$data = array(
    "result" => $result_details,
    "barcode" => $label,
    "materials" => $result_materials
);


echo json_encode($data);