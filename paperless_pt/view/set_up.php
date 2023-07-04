<style>
    table {
        width: 140px;
        border: 1px solid #bbb
    }

    .tdbreak {
        word-break: break-all
    }
</style>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="d-md-flex align-items-center mb-9">
                <div>
                    <h5 class="card-title fw-semibold mb-4">Sub Section to Area</h5>
                    <p class="card-subtitle">Tagging of sub section to area.</p>
                </div>
                <div class="ms-auto mt-4 mt-md-0">
                    <button class="btn btn-info btn-show-tagging">
                        <span class="ti ti-plus"></span>
                        <span class="icon-name">Create</span>
                    </button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table text-nowrap mb-0 align-middle" id="setup_tbl">
                    <thead class="text-dark fs-4">
                        <tr>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Sub Section</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Area</h6>
                            </th>
                            <th class="border-bottom-0 text-center">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $html = '';
                        if ($result) {
                            foreach ($result as $rs) {
                                $html .= '<tr>
                                            <td>' . $rs['sub_section_name'] . '</td>
                                            <td>' . $rs['area_name'] . '</td>
                                            <td align="center">
                                            <button type="button" class="d-inline-flex align-items-center justify-content-center btn btn-danger btn-circle btn-lg" data-id="'.$rs['id'].'" data-bs-toggle="tooltip" title="Remove">
                                                <i class="fs-5 ti ti-trash"></i>
                                            </button>
                                            </td>
                                            </tr>';
                            }
                            echo $html;
                        }

                        ?>
                    </tbody>
                </table>
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
                <!-- <form action="ajax/setup/insert_tagging.php" id="frm_tagging" method="POST"> -->
                <div class="mb-3 form-group">
                    <label>Sub Section<span class="text-danger">*</span></label>
                    <div class="controls">
                        <select name="select_sub_section" id="select_sub_section" required="" class="form-control"
                            aria-invalid="false">
                            <option value="">Select option</option>
                        </select>
                        <div class="help-block"></div>
                    </div>
                </div>
                <div class="mb-3 form-group">
                    <label>Area Name<span class="text-danger">*</span></label>
                    <div class="controls">
                        <select name="select_area" id="select_area" required="" class="form-control"
                            aria-invalid="false">
                            <option value="">Select option</option>
                        </select>
                        <div class="help-block"></div>
                    </div>
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