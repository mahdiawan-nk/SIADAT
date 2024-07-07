<div class="modal fade" id="update-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
        <form class="modal-content form-vertical" id="form-update">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Update Datouk Ninik Mamak</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="nama">Nama Lengkap</label>
                            <input type="text" id="nama" class="form-control" name="nama"
                                placeholder="Nama Lengkap">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="first-name-vertical">Gelar</label>
                            <input type="text" class="form-control" name="gelar" id="gelar">
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
                            <textarea name="alamat" id="alamat" class="form-control"></textarea>
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
                                <input type="text" class="form-control" id="e-kenegerian" readonly>
                                <input type="hidden" name="id_kenegerian" class="form-control" id="id_kenegerian">
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="judul">Berkas Pendukung</label>
                        <div id="berkas-container" class="berkas-container">

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
