
<?php
$dboracle = new OracleApp();
$dbpost = new Postgresql();

$min = $_GET['min'];
$max = $_GET['max'];
$select=" SELECT distinct a.wip_entity_id, a.wip_entity_name , b.lot_number, b.start_quantity, b.attribute11, b.attribute2, b.attribute3, c.segment1 device, c.description pkg_type,
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
and a.wip_entity_name between '$min'  and '$max'  ";
$result = $dboracle->query($select)->fetchAll();

include("view/" . getFileName());