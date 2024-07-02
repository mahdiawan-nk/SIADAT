@extends('layout.admin.app')
@section('style')
@endsection
@section('pages_admin')
    <div class="page-heading">
        <h3>Adat Istiadat</h3>
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
                                            <th>Nama Adat</th>
                                            <th>Dari Kenegerian</th>
                                            <th>Foto</th>
                                            <th>Lokasi</th>
                                            <th>Status</th>
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
    @include('pages_admin.adat-istiadat.create')
    @include('pages_admin.adat-istiadat.update')
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
            let userRole = '{{ auth()->user()->role }}'
            var table = $('#table-data').DataTable({
                processing: true,
                serverSide: true,
                ordering: false,
                ajax: {
                    url: '{!! route('api.adat-istiadat.index') !!}',
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
                        data: 'nama_adat',
                    },
                    {
                        data: 'kenegerian',
                        render(h) {
                            return `${h.nama_kenegerian}`
                        },
                    },
                    {
                        data: 'thumbnails',
                    },
                    {
                        data: 'lokasi',
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
            var dataKenegerian = () => {
                $.ajax({
                    type: "GET",
                    url: "{{ route('api.kenegerian.index') }}",
                    dataType: "JSON",
                    success: function(response) {
                        let list = ''
                        list += '<option value="">Pilih Kenegerian</option>'
                        response.data.forEach(item => {
                            list +=
                                `<option value="${item.id}">${item.nama_kenegerian}</option>`
                        });

                        $('[name="id_kenegerian"]').html(list)
                    }
                });
            }
            var updatePersetujuan = (uid, status, message = null) => {
                const url = '{{ route('api.adat-istiadat.persetujuan', ['adat_istiadat' => ':idData']) }}'
                    .replace(
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
                        console.log(response)
                        Toast.fire({
                            icon: "success",
                            title: response.message
                        });
                        table.ajax.reload()
                        idData = null
                    },
                    error: function(xhr, status, error) {
                        handleErrorResponse(xhr.status)
                        console.error(xhr.responseText);
                    }
                });
            }
            var persetujuanModal = (uid) => {
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
                        updatePersetujuan(uid, 1, 'Pengajuan Di Setujui')
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
                                updatePersetujuan(uid, 2, text)
                            }
                        });

                    }
                });
            }
            var deleteData = (id) => {
                const url = '{{ route('api.adat-istiadat.destroy', ['adat_istiadat' => ':idData']) }}'.replace(
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
            attachOnClickListenerToButton('upload-file')
            $('.add').click(function(e) {
                e.preventDefault();
                dataKenegerian()
                $('form#form-add')[0].reset()
                $('#add-modal').modal('show')
            });
            table.on('click', '.edit', function() {
                let data = table.row($(this).parents('tr')).data()
                idData = data.id
                Swal.fire({
                    title: "Do you want to save the changes?",
                    icon: "question",
                    denyButtonColor: '#33CCFF',
                    showDenyButton: userRole == 1 ? true : false,
                    showCancelButton: true,
                    confirmButtonText: "Edit Data",
                    denyButtonText: `Persetujuan`
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        dataKenegerian()
                        setTimeout(() => {
                            $('[name="id_kenegerian"]').val(data.kenegerian.id)
                            $('[name="nama_adat"]').val(data.nama_adat)
                            $('[name="lokasi"]').val(data.lokasi)
                            $('[name="foto"]').val(data.foto)
                            tinymce.get('e-ringkasan').setContent(data.contents);
                        }, 1000);
                        $('#update-modal').modal('show')
                    } else if (result.isDenied) {
                        persetujuanModal(idData)
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
                    allowEscapeKey: false,
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
                    url: "{{ route('api.adat-istiadat.store') }}",
                    data: $(this).serialize(),
                    dataType: "JSON",
                    success: function(response) {
                        Toast.fire({
                            icon: "success",
                            title: response.message
                        });
                        $('#add-modal').modal('hide')
                        table.ajax.reload()
                    },
                    error: function(xhr, status, error) {
                        handleErrorResponse(xhr.status)
                        console.error(xhr.responseText);
                    }
                });
            });

            $('#form-update').submit(function(e) {
                e.preventDefault();
                e.stopImmediatePropagation();
                const url = '{{ route('api.adat-istiadat.update', ['adat_istiadat' => ':idData']) }}'
                    .replace(
                        ':idData',
                        idData);
                $.ajax({
                    type: "POST",
                    url: url,
                    data: $(this).serialize(),
                    dataType: "JSON",
                    success: function(response) {
                        Toast.fire({
                            icon: "success",
                            title: response.message
                        });
                        $('#update-modal').modal('hide')
                        table.ajax.reload()
                        idData = null
                    },
                    error: function(xhr, status, error) {
                        handleErrorResponse(xhr.status)
                        console.error(xhr.responseText);
                    }
                });
            });

        });
    </script>
@endsection
