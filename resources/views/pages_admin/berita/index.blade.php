@extends('layout.admin.app')
@section('style')
@endsection
@section('pages_admin')
    <div class="page-heading">
        <h3>Dashboard</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Data Berita</h4>
                    </div>
                    <div class="card-content">
                        <button class="btn btn-sm btn-primary ms-3 berita-add">Tambah Berita</button>
                        <hr>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-lg" id="table-data">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Thumbnail</th>
                                            <th>Judul</th>
                                            <th>Status</th>
                                            <th>Created By</th>
                                            <th>Created At</th>
                                            <th>Update At</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @include('pages_admin.berita.create')
    @include('pages_admin.berita.update')
    @include('pages_admin.berita.persetujuan')
    <div class="modal fade text-left" id="notes-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="myModalLabel130" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title white" id="myModalLabel130">Catatan
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-x">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <div class="list-group" id="list-notes">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(function() {
            var idData = null
            var table = $('#table-data').DataTable({
                processing: true,
                serverSide: true,
                ordering: false,
                ajax: {
                    url: '{!! route('api.berita.index') !!}',
                    type: "GET",
                    dataSrc: "data",
                },
                columns: [{
                        data: 'DT_RowIndex',
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'thumbnails',
                    },
                    {
                        data: 'judul',
                        render(h) {
                            return `<p class="text-wrap" style="width:10rem">${h}</p>`
                        },
                    },
                    {
                        data: {
                            status: 'status',
                            catatans: 'catatans',
                        },
                        render(h) {
                            return getStatusLabel(h)
                        },
                    },
                    {
                        data: 'user',
                        render(h) {
                            return h.username
                        },
                    },
                    {
                        data: 'created_at',
                    },
                    {
                        data: 'updated_at',
                    },
                    {
                        data: 'action',
                    },
                ]
            });

            function getStatusLabel(status) {
                let objStatus = [];
                switch (status.status) {
                    case 1:
                        objStatus = {
                            classes: 'btn-success',
                            text: 'Accepted'
                        }
                        break;
                    case 2:
                        objStatus = {
                            classes: 'btn-danger',
                            text: 'Rejected'
                        }
                        break;
                    default:
                        objStatus = {
                            classes: 'btn-info',
                            text: 'Prosses'
                        }
                        break;
                }

                const jumlahNotes = status.catatans ? status.catatans.length : 0

                return `<button type="button" class="btn btn-mini position-relative ${objStatus.classes} show-notes">
                            ${objStatus.text}
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                ${jumlahNotes}
                                <span class="visually-hidden">unread messages</span>
                            </span>
                            </button>`
            }
            var unPublisBerita = (id) => {
                const url = '{{ route('api.berita.update', ['beritum' => ':idData']) }}'.replace(
                    ':idData',
                    id);
                $.ajax({
                    type: "PUT",
                    url: url,
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: 3
                    },
                    dataType: "JSON",
                    success: function(response) {
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Berita has been Un-Publish",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('#persetujuan-modal').modal('hide')
                        table.ajax.reload()
                        forThis = null
                        idData = null
                    }
                });
            }

            var deleteBerita = (id) => {
                const url = '{{ route('api.berita.destroy', ['beritum' => ':idData']) }}'.replace(
                    ':idData',
                    id);
                $.ajax({
                    type: "DELETE",
                    url: url,
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    dataType: "JSON",
                    success: function(response) {
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Berita has been Delete Permanently",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        table.ajax.reload()
                        forThis = null
                        idData = null
                    }
                });
            }
            table.on('click', '.show-notes', function() {
                let data = table.row($(this).parents('tr')).data()
                let listNotes = ''
                data.catatans.forEach(item => {
                    listNotes += `<li href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">User : ${item.user}</h5>
                                <small>${item.last_time}</small>
                            </div>
                            <p class="mb-1">
                            Pesan : ${item.pesan ?? ''}
                            </p>
                            <small>Status : ${item.status}</small>
                        </li>`
                });
                $('#list-notes').html(listNotes)
                $('#notes-modal').modal('show')

            });

            $(document).on('click', '.upload-file', function(e) {
                let targets = e.target.name
                Flmngr.selectFiles({
                    acceptExtensions: ["jpg", "jpeg", "png"],
                    isMultiple: true,
                    onFinish: (files) => {
                        let isValid = true;
                        files.forEach(file => {
                            let ext = file.name.split('.').pop().toLowerCase();
                            if (!["jpg", "jpeg", "png"].includes(ext)) {
                                isValid = false;
                                return false; // Exit forEach loop early
                            }
                        });

                        if (!isValid) {
                            $('.modal').css('z-index', '999')
                            Swal.fire({
                                icon: 'error',
                                title: 'File Extension Error',
                                text: 'Only JPG, JPEG, and PNG files are allowed.',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $('.modal').css('z-index', '99999')
                                }
                            });
                            return;
                        }
                        Flmngr.upload({
                            filesOrLinks: files,
                            dirUploads: "/",
                            onFinish: (uploadedFiles) => {
                                $('[name="' + targets + '"]').val(ParseUrlToPath(
                                    uploadedFiles))
                            },
                            onFail: (error) => {
                                console.log(error)
                            }
                        });

                    }
                });
            });

            $('.berita-add').click(function(e) {
                e.preventDefault();
                // initTiny()
                $('form#form-berita-add')[0].reset()
                $('#add-modal').modal('show')
            });


            table.on('click', '.edit', function() {
                // initTiny()
                let data = table.row($(this).parents('tr')).data()
                idData = data.id
                Swal.fire({
                    title: "Do you want to save the changes?",
                    icon: "question",
                    denyButtonColor: '#33CCFF',
                    showConfirmButton: "{{ auth()->user()->role }}" == 1 ? true : false,
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: "Persetujuan",
                    denyButtonText: `Edit Data`
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        if (data.status == 1) {
                            $('#accept-outlined').prop('checked', true)
                        } else if (data.status == 2) {
                            $('#rejected-outlined').prop('checked', true)
                        }
                        $('#persetujuan-modal').modal('show')
                    } else if (result.isDenied) {

                        $('[name="judul"]').val(data.judul)
                        $('[name="thumbnail"]').val(data.thumbnail)
                        tinymce.get('e-isi').setContent(data.contents);
                        $('#update-modal').modal('show')

                    }
                });

            });

            table.on('click', '.hapus', function() {
                let data = table.row($(this).parents('tr')).data()
                idData = data.id
                Swal.fire({
                    title: "Do you want to save the changes?",
                    icon: "question",
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: "Un Publish",
                    denyButtonText: `Delete`
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        unPublisBerita(data.id)
                    } else if (result.isDenied) {
                        deleteBerita(data.id)
                    }
                });
            });

            $('#form-berita-add').submit(function(e) {
                e.preventDefault();
                e.stopImmediatePropagation();

                $.ajax({
                    type: "POST",
                    url: "{{ route('api.berita.store') }}",
                    data: $(this).serialize(),
                    dataType: "JSON",
                    success: function(response) {
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Your work has been saved",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('#add-modal').modal('hide')
                        table.ajax.reload()
                    },
                    error: function(xhr, status, error) {
                        handleErrorResponse(xhr.status, xhr.responseJSON)
                        console.error(xhr.responseText);
                    }
                });
            });

            $('#form-berita-update').submit(function(e) {
                e.preventDefault();
                e.stopImmediatePropagation();
                const url = '{{ route('api.berita.update', ['beritum' => ':idData']) }}'.replace(
                    ':idData',
                    idData);
                $.ajax({
                    type: "POST",
                    url: url,
                    data: $(this).serialize(),
                    dataType: "JSON",
                    success: function(response) {
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Your work has been Update",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('#update-modal').modal('hide')
                        table.ajax.reload()
                        forThis = null
                        idData = null
                    },
                    error: function(xhr, status, error) {
                        handleErrorResponse(xhr.status, xhr.responseJSON)
                        console.error(xhr.responseText);
                    }
                });
            });

            $('#form-berita-persetujuan').submit(function(e) {
                e.preventDefault();
                e.stopImmediatePropagation();
                const url = '{{ route('api.berita.persetujuan', ['beritum' => ':idData']) }}'.replace(
                    ':idData',
                    idData);
                $.ajax({
                    type: "POST",
                    url: url,
                    data: $(this).serialize(),
                    dataType: "JSON",
                    success: function(response) {
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Your work has been Update",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('#catatan').val('')
                        $('#persetujuan-modal').modal('hide')
                        table.ajax.reload()
                        forThis = null
                        idData = null
                    },
                    error: function(xhr, status, error) {
                        handleErrorResponse(xhr.status, xhr.responseJSON)
                        console.error(xhr.responseText);
                    }
                });
            });

        });
    </script>
@endsection
