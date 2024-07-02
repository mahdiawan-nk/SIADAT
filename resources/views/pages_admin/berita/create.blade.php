<div class="modal fade" id="add-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
        <form class="modal-content" method="POST" id="form-berita-add">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Form Tambah Berita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="judul">Judul Berita</label>
                    <input type="text" class="form-control" id="judul" name="judul"
                        placeholder="Enter judul berita">
                </div>
                <div class="form-group">
                    <label for="judul">isi Berita</label>
                    <textarea name="isi" id="isi" class="form-control editor" cols="30" rows="10"></textarea>
                </div>
                <div class="form-group">
                    <label for="judul">Thumbnail</label>
                    <div class="input-group mb-3 upload-file" style="cursor: pointer">
                        <span class="input-group-text">Upload File</span>
                        <input type="text" name="thumbnail" class="form-control" placeholder="Upload Files" aria-label="Upload Files"
                            aria-describedby="basic-addon2" readonly>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
