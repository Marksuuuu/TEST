<div class="container-fluid">
    <div class="container-fluid">
        <div class="card">

            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Upload File</h5>
                <form class="form">
                    <div class="fv-row">
                        <div class="dropzone" id="uploadFile">
                            <div class="dz-message needsclick">
                                <i class="ki-duotone ki-file-up fs-3x text-primary"><span class="path1"></span><span class="path2"></span></i>
                                <div class="ms-4">
                                    <h3 class="fs-5 fw-bold text-gray-900 mb-1">Drop files here or click to upload.</h3>
                                    <span class="fs-7 fw-semibold text-gray-400">Upload up to 10 files <b>(5mb)</b></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <br>
                <div class="align-content-center">
                    <button class="justify-content-center w-100 btn mb-1 btn-rounded btn-outline-primary d-flex align-items-center" id="uploadSubmit"><i class="ti ti-upload fs-4 me-2"></i>Upload File</button>
                </div>


            </div>
        </div>
        <div class="card">
            <div class="card-body">


                <h5 class="card-title fw-semibold mb-4">Reference Docs</h5>

                <div class="d-md-flex align-items-center mt-3">
                    <div class="col-md-2">
                        <button id="deleteUploadBtn" class="btn mb-1 waves-effect waves-light btn-rounded btn-danger" disabled><i class="ti ti-trash fs-4 me-2"></i>Delete</button>
                    </div>
                    <div class="ms-auto mt-3 mt-md-0">
                        <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ti ti-filter fs-4"></i>
                        </button>
                        <ul class="dropdown-menu animated rubberBand" id="filterYear">


                        </ul>
                    </div>
                </div>


                <div class="table-responsive">
                    <table id="uploadListTbl" class="table border table-striped table-bordered text-nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th><input type="checkbox" class="form-check-input" id="allchecked"></th>
                                <th>No.</th>
                                <th>File Name</th>
                                <th>Added On</th>
                                <th>Added By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>