<div class="modal fade" id="add-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
        <form class="modal-content form-vertical" id="form-add">
            @csrf
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Adat Istiadat</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="id_kenegerian">Kenegerian</label>
                            <select name="id_kenegerian" id="id_kenegerian" class="form-select form-control" required>
                                <option value="" selected>Pilih Kenegerian</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="nama_adat">Nama Adat</label>
                            <input type="text" id="nama_adat" class="form-control" name="nama_adat"
                                placeholder="Nama Kenegerian" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label >Ringkasan</label>
                            <textarea name="ringkasan" id="ringkasan" class="form-control editor"></textarea>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="lokasi">Lokasi</label>
                            <textarea name="lokasi" id="lokasi" class="form-control" required></textarea>
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
