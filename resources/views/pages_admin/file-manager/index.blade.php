{{-- <div class="modal fade" id="file-manager" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">File Manager</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="form-uploads-tabs" data-bs-toggle="tab" href="#home" role="tab"
                            aria-controls="home" aria-selected="true">Upload Files</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="browser-file-tabs" data-bs-toggle="tab" href="#list" role="tab"
                            aria-controls="profile" aria-selected="false">Browse File</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent" style="min-height:65vh">
                    <div class="tab-pane fade show active p-3" id="home" role="tabpanel"
                        aria-labelledby="home-tab">
                        <div class="d-flex justify-content-center align-items-center" style="height: 65vh">
                            <div class="d-flex flex-column justify-content-center align-items-center text-center border border-dark"
                                style="height: 100%; width: 100%;cursor: pointer;" id="new-file">
                                <span><i class="fa-solid fa-file-circle-plus fa-2xl"></i></span>
                                <span class="mt-3">Upload Files</span>
                            </div>
                            <div class="d-none align-items-center text-center" id="img-view">
                                <img src="" alt="" id="previewImage" class="img-thumbnail">
                                <span class="remove-icon"><i class="fas fa-regular fa-xmark fa-lg"
                                        style="color: #101413;"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade p-3" id="list" role="tabpanel" aria-labelledby="profile-tab" style="height: 65vh">
                        <div class="row row-cols-1 row-cols-md-6 g-3" id="views-files">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">pilih</button>
            </div>
        </div>
    </div>
</div> --}}

<div class="modal fade" id="file-manager" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">File Manager</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="min-height: 50vh">
                <div class="row">
                    <div class="col-sm-2 mb-1">
                        <button class="btn btn-primary btn-block" id="new-file"><i class="fa-solid fa-file-import me-2"></i> New
                            File</button>
                    </div>
                    <div class="col-sm-10 mb-1">
                        <input type="search" class="form-control form-check-lg" placeholder="Cari File">
                    </div>
                </div>
                <hr>

                <div class="row row-cols-1 row-cols-md-6 g-3" id="views-files">
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
