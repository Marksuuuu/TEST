<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-sidebartype="full" data-sidebar-position="fixed"
    data-header-position="fixed">
    <div class="position-relative overflow-hidden  d-flex align-items-center justify-content-center">
        <div class="d-flex align-items-center justify-content-center w-100">
            <div class="row justify-content-center w-100">
                <!-- <div class="col-lg-4">
                    <div class="text-center">
                        <img src="../../dist/images/backgrounds/errorimg.svg" alt="" class="img-fluid">
                        <h1 class="fw-semibold mb-7 fs-9">Opps!!!</h1>
                        <h4 class="fw-semibold mb-7">This page you are looking for could not be found.</h4>
                        <a class="btn btn-primary" href="./index.html" role="button">Go Back to Home</a>
                    </div>
                </div> -->
                <!-- <div class="card mo_print">
                    <div class="card-body"> -->
                <?php
                $page_break = [4,8,12,16,20,24,24,32];
                $cnt = 1;
                foreach ($result as $rs) {
                    $first = "^XA
                    ^FX bar code.
                    ^BY5,2,270
                    ^FO100,80^BC^FD" . $rs['WIP_ENTITY_NAME'] . "^FS";

                    $path = 'http://api.labelary.com/v1/printers/12dpmm/labels/2.7x1.5/0/';

                    $label = $path . $first . '^XZ^';
                    $tray = '';
                    $range = '';
                    $get_tray = "SELECT description from mo_inquiry_tray_tbl where wip_entity_id = " . $rs['WIP_ENTITY_ID'] . " ";
                    $result_tray = $dbpost->fetchRow($get_tray);

                    if ($result_tray) {
                        $tray = $result_tray['description'];
                    }
                    if ($rs['CUSTOMER'] == 'IXYS, LLC') {
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
                        SHA.ORDER_NUMBER = " . $rs['SO_NUM'] . " 
                        and WDJ.LOT_NUMBER = '" . $rs['LOT_NUMBER'] . "'";
                        $result_range = $dboracle->query($select_range)->fetchRow();
                        // echo $select_range;exit;
                        if ($result_range) {
                            $range = '(' . $result_range['MIN_MO'] . ' - ' . $result_range['MAX_MO'] . ')';
                        }

                    } else {
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
                        SHA.ORDER_NUMBER = " . $rs['SO_NUM'] . " ";
                        $result_range = $dboracle->query($select_range)->fetchRow();

                        if ($result_range) {
                            $range = '(' . $result_range['MIN_MO'] . ' - ' . $result_range['MAX_MO'] . ')';
                        }
                    }
                    $check_page = (in_array($cnt, $page_break) ? 'break-after:page': '');
                    ?>
                    
                    <div class="mb-2" style="border-bottom:dashed;<?= $check_page; ?>">

                        <!-- </div> -->
                        <div class="d-md-flex align-items-center mb-9">
                            <div>
                                <right>
                                    <img src="public/theme/images/team.jpg" style="width:80px;height:80px">
                                    <p style="margin:-70px 0px 0px 90px;font-size: 15pt ">TEAM PACIFIC CORPORATION<br>
                                        <b>PROCESS TRAVELLER</b>
                                    </p>
                                </right>

                            </div>
                            <div class="ms-auto mt-4 mt-md-0">
                                <img class="barcode" src="<?= $label ?>" width="250px" height="75px"></img>
                            </div>
                        </div>
                        <table class="table table-bordered mo-details" style="border: 1px solid !important">

                            <tbody>
                                <tr>
                                    <td width="15%">CUSTOMER</td>
                                    <td width="25%" class="customer">
                                        <?= $rs['CUSTOMER']; ?>
                                    </td>
                                    <td width="10%">P.T.#</td>
                                    <td width="20%" class="pt">
                                        <?= $rs['WIP_ENTITY_NAME'] . ' ' . $range; ?>
                                    </td>
                                    <td width="15%">START DATE</td>
                                    <td width="15%" class="start-date" align="center"></td>
                                </tr>
                                <tr>
                                    <td>PKG TYPE</td>
                                    <td class="pkg-type">
                                        <?= $rs['PKG_TYPE']; ?>
                                    </td>
                                    <td>S.O.#</td>
                                    <td class="so-no">
                                        <?= $rs['SO_NUM']; ?>
                                    </td>
                                    <td>ASSY DATE</td>
                                    <td class="assy-date" align="center"></td>
                                </tr>
                                <tr>
                                    <td>DEVICE</td>
                                    <td class="device">
                                        <?= $rs['DEVICE']; ?>
                                    </td>
                                    <td>BD NO. / REV.</td>
                                    <td class="bd-no">
                                        <?= $rs['BD']; ?>
                                    </td>
                                    <td>SHIP-OUT DATE</td>
                                    <td class="ship-out-date" align="center"></td>
                                </tr>
                                <tr>
                                    <td>LOT #</td>
                                    <td class="lot-no">
                                        <?= $rs['LOT_NUMBER']; ?>
                                    </td>
                                    <td>P.O.#</td>
                                    <td class="po-no">
                                        <?= $rs['PO']; ?>
                                    </td>
                                    <td>START QTY</td>
                                    <td class="start-qty" align="center">
                                        <?= $rs['START_QUANTITY']; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table table-bordered" style="height: 150px; border: 1px solid !important;">
                            <tbody>
                                <tr>
                                    <td width="70%">SPECIAL INSTRUCTIONS:
                                        <p class="ro-jo">
                                            <?= $rs['ATTRIBUTE11']; ?>
                                        </p>
                                        <p class="attribute2">
                                            <?= $rs['ATTRIBUTE2']; ?>
                                        </p>
                                        <p class="attribute3">
                                            <?= $rs['ATTRIBUTE3']; ?>
                                        </p>
                                        <p>Tray Number(s):</p>
                                        <p class="tray-no">
                                            <?= $tray; ?>
                                        </p>
                                    </td>
                                    <td width="30%">
                                        <p>SHIP TO:</p>
                                        <p class="address">
                                            <?= $rs['CUSTOMER'] . '<br>' . $rs['ADDRESS1'] . '<br>' . $rs['ADDRESS2'] . '<br>' . $rs['CITY'] . ', ' . $rs['STATE'] . ', ' . $rs['PROVINCE'] . ' ' . $rs['CTRY_CODE']; ?>
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- <br> -->
                    <!-- <br clear="all" style="page-break-before:always" /> -->
                    <?php
                    $cnt++;
                    // 
                    // echo '<br style="'.$check_page.'" >';
                }

                ?>
            </div>
        </div>
    </div>
</div>