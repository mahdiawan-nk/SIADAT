@extends('layout.admin.app')
@section('style')
    <style>
        tbody tr td {
            font-size: 12px;
        }
    </style>
@endsection
@section('pages_admin')
    <div class="page-heading">
        <h3>Data Datouk ninik mamak</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-content">
                        <button class="btn btn-sm btn-primary ms-3 mt-2 add">Tambah</button>
                        <hr>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-lg" id="table-data">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Gelar</th>
                                            <th>Alamat</th>
                                            <th>Suku</th>
                                            <th>Kenegerian</th>
                                            <th>Status</th>
                                            <th>Berkas Pendukung</th>
                                            <th>Created By</th>
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
    @include('pages_admin.ninik-mamak.create')
    @include('pages_admin.ninik-mamak.update')
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
            let fileIndex = 1;
            var table = $('#table-data').DataTable({
                processing: true,
                serverSide: true,
                ordering: false,
                ajax: {
                    url: '{!! route('api.ninik-mamak.index') !!}',
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
                        data: 'nama',
                    },
                    {
                        data: 'gelar',
                    },
                    {
                        data: 'alamat',
                        render(h) {
                            return `<div class="text-wrap" style="width: 8rem;">
                                        ${h}
                                    </div>`
                        },
                    },
                    {
                        data: 'suku',
                    },
                    {
                        data: 'kenegerian',
                        render(h) {
                            return `${h.nama_kenegerian}`
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
                        data: 'berkas_pendukung',
                        render(h) {
                            let files = ''
                            h.forEach(element => {
                                files +=
                                    `<a href="{{ asset('') }}${element.file}" target="new" data-bs-toggle="tooltip" data-bs-placement="top" title="${element.file}" style="cursor:pointer"><i class="fa-solid fa-file pe-1"></i></a>`
                            });
                            return files
                        },
                    },
                    {
                        data: 'user',
                        render(h) {
                            return h.username
                        },
                    },
                    {
                        data: 'action',
                    },
                ]
            });
            var deleteData = (id) => {
                const url = '{{ route('api.ninik-mamak.destroy', ['ninik_mamak' => ':idData']) }}'.replace(
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
                        Toast.fire({
                            icon: "success",
                            title: response.message
                        });
                        table.ajax.reload()
                        idData = null
                    },
                    error: function(xhr, status, error) {
                        handleErrorResponse(xhr.status, xhr.responseJSON)
                        console.error(xhr.responseText);
                    }
                });
            }

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
            var dataKenegerian = () => {
                let url =
                    '{{ auth()->user()->id_kenegerian ? route('api.kenegerian.show', ['kenegerian' => auth()->user()->id_kenegerian]) : route('api.kenegerian.index') }}'

                $.ajax({
                    type: "GET",
                    url: url,
                    dataType: "JSON",
                    success: function(response) {
                        if (response.data.length > 1) {
                            let list = ''
                            list += '<option value="">Pilih Kenegerian</option>'
                            response.data.forEach(item => {
                                list +=
                                    `<option value="${item.id}">${item.nama_kenegerian}</option>`
                            });

                            $('[name="id_kenegerian"]').html(list)
                        } else {
                            $('#kenegerian').val(response.data.nama_kenegerian)
                            $('[name="id_kenegerian"]').val(response.data.id)
                        }

                    }
                });
            }
            var updatePersetujuan = (uid, status, message = null) => {
                const url = '{{ route('api.ninik-mamak.persetujuan', ['ninik_mamak' => ':idData']) }}'.replace(
                    ':idData',
                    uid);
                $.ajax({
                    type: "PUT",
                    url: url,
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: status,
                        message: message
                    },
                    dataType: "JSON",
                    success: function(response) {
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: `Pengajuan di ${status ===1 ? 'Setujui':'Tolak'}`,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        table.ajax.reload()
                        idData = null
                    },
                    error: function(xhr, status, error) {
                        handleErrorResponse(xhr.status, xhr.responseJSON)
                        console.error(xhr.responseText);
                    }
                });
            }
            $(document).on('click', '.add-file-btn', function() {
                var $this = $(this);
                if ($this.find('i').hasClass('fa-plus')) {
                    var $clone = $this.closest('.input-group').clone();
                    $clone.find('input[name="id_berkas[]"]').val('');
                    $clone.find('input.upload-file').attr('id', 'file-' + fileIndex).val('');
                    $clone.find('input[name="nama_berkas[]"]').val('');

                    $clone.find('.add-file-btn').html('<i class="fa fa-minus"></i>').removeClass(
                        'add-file-btn').addClass('remove-file-btn');

                    fileIndex++;
                    // $clone.insertAfter($this.closest('.input-group'));
                    $('.berkas-container .input-group:last').after($clone);
                }
            });
            $(document).on('click', '.remove-file-btn', function() {
                $(this).closest('.input-group').remove();
            });
            $(document).on('click', '.upload-file', function() {
                Flmngr.selectFiles({
                    acceptExtensions: ["pdf,'png', 'jpeg', 'jpg", "webp", "gif", "docx", "doc"],
                    isMultiple: true,
                    onFinish: (files) => {
                        Flmngr.upload({
                            filesOrLinks: files,
                            dirUploads: "/",
                            onFinish: (uploadedFiles) => {
                                $(this).val(ParseUrlToPath(uploadedFiles))
                            }
                        });

                    }
                });
            });
            $('.add').click(function(e) {
                e.preventDefault();
                dataKenegerian()
                $('form#form-add')[0].reset()
                $('#add-modal').modal('show')
            });
            table.on('click', '.edit', function() {

                let data = table.row($(this).parents('tr')).data()
                idData = data.id
                dataKenegerian()
                setTimeout(() => {
                    $('[name="id_kenegerian"]').val(data.kenegerian.id)
                    $('#e-kenegerian').val(data.kenegerian.nama_kenegerian)
                    $('[name="nama"]').val(data.nama)
                    $('[name="gelar"]').val(data.gelar)
                    $('[name="suku"]').val(data.suku)
                    $('[name="alamat"]').val(data.alamat)
                    let inputGroup = ''
                    data.berkas_pendukung.forEach((element, index) => {
                        inputGroup += `
                    <div class="input-group mb-3" style="cursor: pointer">
                        <span class="input-group-text">Nama Berkas</span>
                        <input type="text" name="nama_berkas[]" class="form-control" value="${element.nama_berkas}" placeholder="Nama Files" aria-label="Upload Files" aria-describedby="basic-addon2">
                        <span class="input-group-text">Upload File</span>
                        <input type="hidden" name="id_berkas[]" value="${element.id}" class="form-control">
                        <input type="text" name="file[]" class="form-control upload-file" value="${element.file}" id="file-${index}" placeholder="Upload Files" aria-label="Upload Files" aria-describedby="basic-addon2" readonly>
                        <button type="button" class="btn btn-primary ${index === 0 ? 'add-file-btn' : 'remove-file-btn'}"><i class="fa ${index === 0 ? 'fa-plus' : 'fa-minus'}"></i></button>
                    </div>`;

                    });
                    $('#berkas-container').html(inputGroup);
                }, 1500);

                $('#update-modal').modal('show')

            });
            table.on('click', '.persetujuan', function() {
                let data = table.row($(this).parents('tr')).data()
                idData = data.id
                Swal.fire({
                    title: "Do you want to save the changes?",
                    icon: "question",
                    allowOutsideClick: false,
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: "Setujui",
                    denyButtonText: `Tolak`
                }).then((result) => {
                    if (result.isConfirmed) {
                        updatePersetujuan(data.id, 1, 'Pengajuan Di Setujui')
                    } else if (result.isDenied) {
                        Swal.fire({
                            allowOutsideClick: false,
                            input: "textarea",
                            inputLabel: "Message Penolakan",
                            inputPlaceholder: "Type your message here...",
                            inputAttributes: {
                                "aria-label": "Type your message here"
                            },
                            showCancelButton: true,
                            showLoaderOnConfirm: true,
                            preConfirm: () => {
                                const text = Swal.getInput().value;
                                if (!text) {
                                    Swal.showValidationMessage('Message is required');
                                }
                                return text;
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                const text = result.value;
                                updatePersetujuan(data.id, 2, text)
                            }
                        });

                    }
                });
            });
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
            table.on('click', '.hapus', function() {
                let data = table.row($(this).parents('tr')).data()
                idData = data.id
                Swal.fire({
                    allowOutsideClick: false,
                    title: "Are You sure?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: "Delete",
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteData(data.id)
                    }
                });
            });

            $('#form-add').submit(function(e) {
                e.preventDefault();
                e.stopImmediatePropagation();
                $.ajax({
                    type: "POST",
                    url: "{{ route('api.ninik-mamak.store') }}",
                    data: $(this).serialize(),
                    dataType: "JSON",
                    success: function(response) {
                        console.log(response)
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

            $('#form-update').submit(function(e) {
                e.preventDefault();
                e.stopImmediatePropagation();
                const url = '{{ route('api.ninik-mamak.update', ['ninik_mamak' => ':idData']) }}'.replace(
                    ':idData',
                    idData);
                $.ajax({
                    type: "POST",
                    url: url,
                    data: $(this).serialize(),
                    dataType: "JSON",
                    success: function(response) {
                        console.log(response)
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Your work has been Update",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('#update-modal').modal('hide')
                        table.ajax.reload()
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
