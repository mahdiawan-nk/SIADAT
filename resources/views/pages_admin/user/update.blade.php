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
                    <div class="form-group position-relative ">
                        <label for="nama_lengkap">Nama Lengkap</label>
                        <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap"
                            placeholder="Nama Lengkap" required>
                    </div>
                    <div class="form-group position-relative ">
                        <label for="username">Username</label>
                        <input type="text" class="form-control " name="username" id="username" placeholder="Username"
                            required>
                    </div>
                    <div class="form-group position-relative ">
                        <label for="email">email</label>
                        <input type="email" class="form-control " name="email" id="email" placeholder="Email"
                            required>
                    </div>
                    <div class="form-group position-relative">
                        <label for="id_kenegerian">Kenegerian</label>
                        <select name="id_kenegerian" id="id_kenegerian" class="choices form-select form-control"
                            aria-placeholder="Kenegerian" required>
                            <option value="">Kenegerian</option>
                        </select>
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
