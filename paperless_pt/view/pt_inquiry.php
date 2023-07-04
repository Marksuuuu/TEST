<style>
    .up {
        width: 0px;
        height: 0px;
        border-style: inset;
        border-width: 0 60px 110px 60p;
        border-color: black transparent red transparent;
        float: left;
        transform: rotate(360deg);
        -ms-transform: rotate(360deg);
        -moz-transform: rotate(360deg);
        -webkit-transform: rotate(360deg);
        -o-transform: rotate(360deg);
    }

    .triangle p {
        text-align: center;
        top: 18px;
        left: -75px;
        position: relative;
        width: 150px;
        height: 50px;
        margin: 0px;
        font-size: 10px;
    }

    .triangle {
        width: 0px;
        height: 0px;
        position: relative;
        border-left: 50px solid transparent;
        border-right: 50px solid transparent;
        border-bottom: 65px solid #FA896B;
    }

    .triangle:before {
        content: "";
        width: 0px;
        height: 0px;
        position: absolute;
        border-left: 39px solid transparent;
        border-right: 39px solid transparent;
        border-bottom: 54px solid white;
        top: 7px;
        left: -39px;
    }

    .box {
        background-color: transparent;
        width: 70px;
        height: 70px;
        border: 5px solid #13DEB9;
        padding-top: 10px;
        font-size: 10px;
    }
</style>

<div class="container-fluid">

    <!-- <div class="row mb-2">
        <div class="col-md-12">
            <div class="form-group">
                <input type="text" id="mo_num" name="mo_num" class="form-control text-center"
                    placeholder="Enter MO #(Press Enter Key)" style="position: sticky; top: 50px; ">
            </div>
        </div>
    </div> -->
    <div class="d-flex justify-content-end">
        <a href="#" type="button" class="btn mb-1 waves-effect waves-light btn-light" target="_blank" id="btn-print">
            <span class="ti ti-printer"></span>Print
        </a>
    </div>

    <div class="card mo_print">
        <div class="card-body">
            <div class="d-md-flex align-items-center mb-9">
                <div>
                    <right>
                        <img src="public/theme/images//team.jpg" style="width:80px;height:80px">
                        <p style="margin:-70px 0px 0px 90px;font-size: 15pt ">TEAM PACIFIC CORPORATION<br>
                            <b>PROCESS TRAVELLER</b>
                        </p>
                    </right>

                </div>
                <div class="ms-auto mt-4 mt-md-0">
                    <img class="barcode"
                        src="http://api.labelary.com/v1/printers/12dpmm/labels/2.7x1.5/0/^XA\r\n^FX bar code.\r\n^BY5,2,270\r\n^FO100,80^BC^FDMO123456^FS^XZ^"
                        width="250px" height="75px"></img>
                </div>
            </div>
            <table class="table table-bordered mo-details">
                <tbody>
                    <tr>
                        <td width="15%">CUSTOMER</td>
                        <td width="25%" class="customer"></td>
                        <td width="10%">P.T.#</td>
                        <td width="20%" class="pt"></td>
                        <td width="15%">START DATE</td>
                        <td width="15%" class="start-date" align="center"></td>
                    </tr>
                    <tr>
                        <td>PKG TYPE</td>
                        <td class="pkg-type"></td>
                        <td>S.O.#</td>
                        <td class="so-no"></td>
                        <td>ASSY DATE</td>
                        <td class="assy-date" align="center"></td>
                    </tr>
                    <tr>
                        <td>DEVICE</td>
                        <td class="device"></td>
                        <td class="text-nowrap">BD NO. / REV.</td>
                        <td class="bd-no"></td>
                        <td>SHIP-OUT DATE</td>
                        <td class="ship-out-date" align="center"></td>
                    </tr>
                    <tr>
                        <td>LOT #</td>
                        <td class="lot-no"></td>
                        <td>P.O.#</td>
                        <td class="po-no"></td>
                        <td>START QTY</td>
                        <td class="start-qty" align="center"></td>
                    </tr>
                </tbody>
            </table>
            <input type="hidden" id="hidden-wip-entity-id">
            <input type="hidden" id="hidden-wip-entity-name">
            <input type="hidden" id="hidden-operation-seq-num">
            <table class="table table-bordered" style="height: 150px">
                <tbody>
                    <tr>
                        <td width="70%">SPECIAL INSTRUCTIONS:
                            <p class="ro-jo input"></p>
                            <p class="attribute2 input"></p>
                            <p class="attribute3 input"></p>
                            <p>Tray Number(s):</p>
                            <p class="tray-no"><input type="text" class="form-control input-tray-no"
                                    placeholder="Enter tray no." style="width: 150px"></p>
                        </td>
                        <td width="30%">
                            <p>SHIP TO:</p>
                            <p class="address input"></p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <a class="btn btn-light-info mb-2 font-medium text-info px-4 rounded-pill collapsed" data-bs-toggle="collapse"
        href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
        OPERATIONS
    </a>
    <a class="btn btn-light-info mb-2 font-medium text-info px-4 rounded-pill collapsed" data-bs-toggle="collapse"
        href="#materials" role="button" aria-expanded="false" aria-controls="materials">
        MATERIALS
    </a>
    <!-- <button class="btn btn-light-warning font-medium text-warning px-4 rounded-pill collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                        Button with data-bs-target
                      </button>
    <button class="btn btn-light-warning font-medium text-warning px-4 rounded-pill collapsed" type="button"
        data-bs-toggle="collapse" data-bs-target="#materials" aria-expanded="false"
        aria-controls="materials">
        Button with data-bs-target
    </button> -->
    <div class="collapse" id="collapseExample" style="">
        <div class="card card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered mb-0 align-middle" id="mo_inquiry_tbl"
                    style="overflow-y:scroll; height:400px !important;">
                    <thead class="text-dark fs-4">
                        <tr>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">OPERATIONS</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">SPEC. NO</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">CONDITION</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">MACH NO.</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">OPTR NO.</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">DATE START/TIME</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">DATE STOP/TIME</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">QTY IN</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">QTY OUT</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">YLD</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">QA</h6>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="collapse" id="materials" style="">
        <div class="card card-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered mb-0" id="material_tbl">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">STOCK NO.</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">DESCRIPTION</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">LOT NUMBER</h6>
                                    </th>
                                    <th class="border-bottom-0 text-right">
                                        <h6 class="fw-semibold mb-0">QUANTITY</h6>
                                    </th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="material_tb">
                                <tr>
                                    <td>
                                        <select id="slct_stock_no" class="form-control">
                                            <option value="">Select stock no.</option>
                                            <option>TPC.RN</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control stock-description"
                                            placeholder="Description" readonly>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control lot-number"
                                            placeholder="Enter lot number">
                                    </td>
                                    <td class="align-right">
                                        <input type="number" class="form-control align-right quantity"
                                            placeholder="Enter quantity">
                                    </td>
                                    <td>
                                        <button class="btn btn-info btn-sm add-materials"><span
                                                class="ti ti-plus"></span>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-4">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td align="center">TOP/SIDE MARK INSTRUCTION</td>
                            </tr>
                            <tr>
                                <td height="180px"></td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td align="center">BACK/BOTTOM MARK INSTRUCTION</td>
                            </tr>
                            <tr>
                                <td height="180px"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- <div class="row">
                <div class="col-md-4 mb-2">
                    <button class="btn btn-dark show-defect">Show Defect</button>
                </div>
            </div> -->

            <div class="row">
                <div class="col-md-3">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="defect2_tbl">
                            <thead>
                                <tr>
                                    <th class="text-nowrap defect text-center">2/0 DEFECTS</th>
                                    <th>QTY</th>
                                </tr>
                            </thead>
                            <tbody id="defect2_tb">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-nowrap text-center">3/0 DEFECTS</th>
                                    <th>QTY</th>
                                </tr>
                            </thead>
                            <tbody id="defect3_tb">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-nowrap text-center">PRE-SEAL DEFECT</th>
                                    <th>QTY</th>
                                </tr>
                            </thead>
                            <tbody id="pre_seal_tb">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-nowrap text-center">4/0 DEFECTS</th>
                                    <th>QTY</th>
                                </tr>
                            </thead>
                            <tbody id="defect4_tb">
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-nowrap text-center">ISOLATION</th>
                                    <th>QTY</th>
                                </tr>
                            </thead>
                            <tbody id="isolation_tb">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-nowrap text-center">OS</th>
                                    <th>QTY</th>
                                </tr>
                            </thead>
                            <tbody id="os_tb">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-nowrap text-center">FINAL TEST</th>
                                    <th>QTY</th>
                                </tr>
                            </thead>
                            <tbody id="final_tb">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for create new setup of sub section to area -->
<div class="modal fade" id="modal_create_tagging" tabindex="-1" aria-labelledby="bs-example-modal-lg" aria-modal="true"
    role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content waitme-tagging">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myLargeModalLabel">
                    Tagging
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body ">
                <div class="form-control">
                    <label></label>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-success font-medium waves-effect text-start btn-create-tagging">Save</button>
                <button type="button" class="btn btn-light-danger text-danger font-medium waves-effect text-start"
                    data-bs-dismiss="modal">
                    Close
                </button>
            </div>
            <!-- </form> -->
        </div>
    </div>
</div>


<div class="modal fade" id="modal_create_defect" tabindex="-1" aria-labelledby="bs-example-modal-lg" aria-modal="true"
    role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content waitme-defect">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myLargeModalLabel">
                    Defect
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body ">
                <div class="form-group">
                    <label>Type</label>
                    <select name="" id="slct-defect" class="form-control">
                        <option>2/0 Defect</option>
                        <option>3/0 Defect</option>
                        <option>Pre-Seal Defect</option>
                        <option>4/0 Defect</option>
                        <option>Isolation</option>
                        <option>OS</option>
                        <option>Final Test</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Quantity</label>
                    <input type="number" id="defect_quantity" class="form-control" placeholder="Enter quantity">
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-success font-medium waves-effect text-start btn-create-defect">Save</button>
                <button type="button" class="btn btn-light-danger text-danger font-medium waves-effect text-start"
                    data-bs-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>