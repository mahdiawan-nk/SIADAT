<div class="modal fade" id="add-modal" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
        <form class="modal-content form-vertical" id="form-add">
            @csrf
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Kenegerian</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="nama_kenegerian">Nama Kenegerian</label>
                            <input type="text" id="nama_kenegerian" class="form-control" name="nama_kenegerian"
                                placeholder="Nama Kenegerian">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="first-name-vertical">Sejarah</label>
                            <textarea name="sejarah" id="sejarah" class="form-control editor"></textarea>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="first-name-vertical">Catatan</label>
                            <textarea name="catatan" id="catatan" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="first-name-vertical">Alamat</label>
                            <textarea name="alamat" id="alamat" class="form-control" maxlength="60"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="judul">Foto</label>
                        <div class="input-group mb-3 upload-file" style="cursor: pointer">
                            <span class="input-group-text">Upload File</span>
                            <input type="text" name="foto" class="form-control" placeholder="Upload Files"
                                aria-label="Upload Files" aria-describedby="basic-addon2" readonly>

                        </div>
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
