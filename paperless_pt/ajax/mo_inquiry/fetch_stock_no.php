<?php
$dbwh = new OracleAppDw();

$search = $_GET['search'];
$select = "SELECT inventory_item_id, segment1, PRIMARY_UOM_CODE UOM, DESCRIPTION from 
INV.mtl_system_items
where 
 organization_id = 102
and inventory_Item_status_code = 'Active'
and upper(segment1) like upper('%$search%')";
$result = $dbwh->query($select)->fetchAll();


if (!empty($result)) {

	$data = array();
	$i = 0;
	foreach ($result as $rs) {
		$data[$i]['id'] = $rs['SEGMENT1'];
		$data[$i]['text'] = $rs['SEGMENT1'];
		$data[$i]['desc'] = $rs['DESCRIPTION'];
		$i++;
	}

}

echo json_encode($data);