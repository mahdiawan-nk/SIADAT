<div class="modal fade" id="add-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
        <form class="modal-content form-vertical" id="form-add">
            @csrf
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Datouk Ninik Mamak</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="nama">Nama Lengkap</label>
                            <input type="text" id="nama" class="form-control" name="nama"
                                placeholder="Nama Lengkap" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="first-name-vertical">Gelar</label>
                            <input type="text" class="form-control" name="gelar" id="gelar" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="first-name-vertical">Suku</label>
                            <input type="text" class="form-control" name="suku" id="suku">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="first-name-vertical">Alamat</label>
                            <textarea name="alamat" id="alamat" class="form-control" required maxlength="60"></textarea>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="first-name-vertical">Kenegerian</label>
                            @if (auth()->user()->role == 1)
                                <select name="id_kenegerian" id="id_kenegerian" class="form-select form-control"
                                    required>
                                    <option value="" selected>Pilih Kenegerian</option>
                                </select>
                            @else
                                <input type="text" class="form-control" id="kenegerian" readonly>
                                <input type="hidden" name="id_kenegerian" class="form-control" id="id_kenegerian">
                            @endif

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="judul">Berkas Pendukung</label>
                        <div id="berkas-container-add" class="berkas-container">
                            <div class="input-group mb-3" style="cursor: pointer">
                                <span class="input-group-text">Nama Berkas</span>
                                <input type="text" name="nama_berkas[]" class="form-control" placeholder="Nama Files"
                                    aria-label="Upload Files" aria-describedby="basic-addon2" required>
                                <span class="input-group-text">Upload File</span>
                                <input type="text" name="file[]" class="form-control upload-file" id="file-0"
                                    placeholder="Upload Files" aria-label="Upload Files" aria-describedby="basic-addon2"
                                    required style="cursor: pointer">

                                <button type="button" class="btn btn-primary add-file-btn"><i
                                        class="fa fa-plus"></i></button>
                            </div>
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
