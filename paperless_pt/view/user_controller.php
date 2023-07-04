<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Page List</h5>
            <div class="d-md-flex align-items-center mt-3">
                <div class="col-md-2">
                    <!-- <button id="deactPage_btn" class="btn mb-1 waves-effect waves-light btn-rounded btn-danger" disabled><i class="ti ti-pin fs-4 me-2"></i>Deactive</button> -->
                </div>
                <div class="ms-auto mt-3 mt-md-0">
                    <button id="createPage_btn" class="btn mb-1 waves-effect waves-light btn-rounded btn-info" data-bs-target="#createPage_modal">
                        <div class="d-flex align-items-center">
                            <i class="ti ti-plus me-2 fs-4"></i>
                            Create
                        </div>
                    </button>
                </div>
            </div>
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="pageList_tbl" class="table border table-striped table-bordered text-nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th>Page Name</th>
                                <th>Link</th>
                                <th>Icon</th>
                                <th>Added By</th>
                                <th>Added On</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- MODAL FOR CREATE PAGE -->
<div class="modal fade" id="createPage_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title">
                    Create Page
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-4">
                    <label for="inputName" class="form-label fw-semibold">Page Name</label>
                    <div class="input-group border rounded-1">
                        <span class="input-group-text bg-transparent px-6 border-0"><i class="ti ti-pin fs-6"></i></span>
                        <input type="text" class="form-control border-0 ps-2" placeholder="User Page" id="inputName">
                    </div>
                </div>
                <div class="mb-4">
                    <label for="inputLink" class="form-label fw-semibold">Page Link</label>
                    <div class="input-group border rounded-1">
                        <span class="input-group-text bg-transparent px-6 border-0"><i class="ti ti-link fs-6"></i></span>
                        <input type="text" class="form-control border-0 ps-2" placeholder="index" id="inputLink">
                    </div>
                </div>
                <div class="mb-4">
                    <label for="inputIcon" class="form-label fw-semibold">Page Icon</label>
                    <div class="input-group border rounded-1">
                        <span class="input-group-text bg-transparent px-6 border-0"><i class="ti ti-mail fs-6"></i></span>
                        <input type="text" class="form-control border-0 ps-2" placeholder="Ex. ti ti-mail" id="inputIcon">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger font-medium waves-effect text-start" data-bs-dismiss="modal">
                    Close
                </button>
                <button type="button" class="btn btn-primary font-medium waves-effect text-start" id="createPage_save">
                    Saved
                </button>
            </div>
        </div>
    </div>
</div>
<!--END MODAL FOR CREATE PAGE -->

<!-- MODAL FOR USER ACCESS PAGE -->
<div class="modal fade" id="userAccess_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title">
                    User Access
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="userAccess_tbl" class="table border table-striped table-bordered text-nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th><input type="checkbox" class="form-check-input pointer" id="allchecked"></th>
                                <th>FullName</th>
                                <th>Position</th>
                                <th>Department</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger font-medium waves-effect text-start" data-bs-dismiss="modal">
                    Close
                </button>
                <button type="button" class="btn btn-primary font-medium waves-effect text-start" id="userAccess_btn">
                    Saved
                </button>
            </div>
        </div>
    </div>
</div>
<!--END MODAL FOR USER ACCESS PAGE -->