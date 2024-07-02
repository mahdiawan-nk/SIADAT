<div class="modal fade" id="update-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
        <form class="modal-content form-vertical" id="form-update">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Kenegerian</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12" hidden>
                        <div class="form-group">
                            <label for="jenis">Jenis Data</label>
                            <input type="text" name="jenis" id="jenis" class="form-control"
                                value="{{ $jenis }}">
                        </div>
                    </div>
                    @if (in_array($jenis, ['seni_tari', 'seni_musik', 'kuliner_khas']))
                        <div class="col-12">
                            <div class="form-group">
                                <label for="nama">{{ $field }}</label>
                                <input type="text" id="nama" class="form-control" name="nama"
                                    placeholder="{{ $field }}" required>
                            </div>
                        </div>
                    @endif
                    @if ($jenis == 'peninggalan')
                        <div class="col-12">
                            <div class="form-group">
                                <label for="jenis_peninggalan">Jenis Peninggalan</label>
                                <input type="text" name="jenis_peninggalan" id="jenis_peninggalan"
                                    class="form-control" value="">
                            </div>
                        </div>
                    @endif

                    <div class="col-12">
                        <div class="form-group">
                            <label>Ringkasan</label>
                            <textarea name="ringkasan" id="e-ringkasan" class="form-control editor"></textarea>
                        </div>
                    </div>
                    @if ($jenis == 'peninggalan')
                        <div class="col-12">
                            <div class="form-group">
                                <label for="lokasi">Lokasi</label>
                                <textarea name="lokasi" id="lokasi" class="form-control" required></textarea>
                            </div>
                        </div>
                    @endif

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
