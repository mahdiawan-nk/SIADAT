<div class="modal fade text-left" id="persetujuan-modal" tabindex="-1" aria-labelledby="myModalLabel160" style="display: none;" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <form class="modal-content" id="form-berita-persetujuan">
            @csrf
            @method('PUT')
            <div class="modal-header bg-primary">
                <h5 class="modal-title white" id="myModalLabel160">Persetujuan Berita
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="judul" class="d-block">Persetujuan</label>
                    <input type="radio" class="btn-check" name="status" id="accept-outlined" autocomplete="off" value="1">
                    <label class="btn btn-outline-success" for="accept-outlined">Setujui</label>
                    <input type="radio" class="btn-check" name="status" id="rejected-outlined" autocomplete="off" value="2">
                    <label class="btn btn-outline-danger" for="rejected-outlined">Tolak</label>
                </div>
                <div class="form-group">
                    <label for="judul">Catatan</label>
                    <textarea name="catatan" id="catatan" class="form-control" rows="10" disabled></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Close</span>
                </button>
                <button type="submit" class="btn btn-primary ms-1" data-bs-dismiss="modal">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Submit</span>
                </button>
            </div>
        </form>
    </div>
</div>