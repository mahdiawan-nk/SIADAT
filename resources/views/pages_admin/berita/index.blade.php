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
                                            <th>Catatan</th>
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
                        data: 'catatan',
                    },
                    {
                        data: 'status',
                        render(h) {
                            return `${h == 0 ? '<span class="badge bg-info text-dark">Proses</span>' : (h == 1 ? '<span class="badge bg-success text-dark">Setujui - Publish</span>':(h == 2 ? '<span class="badge bg-danger text-dark">Rejected</span>':'<span class="badge bg-danger text-dark">Un-Publish</span>'))} `
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

            attachOnClickListenerToButton('upload-file')

            $('.berita-add').click(function(e) {
                e.preventDefault();
                // initTiny()
                $('form#form-berita-add')[0].reset()
                $('#add-modal').modal('show')
            });

            $('input[name="status"]').on('click', function() {
                if ($(this).val() == '2') {
                    $('#catatan').removeAttr('disabled');
                } else if ($(this).val() == '1') {
                    $('#catatan').attr('disabled', 'disabled');
                }
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
                            $('#catatan').removeAttr('disabled');
                        }
                        $('#catatan').val(data.catatan)
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
                        console.error(xhr);
                    }
                });
            });

            $('#form-berita-persetujuan').submit(function(e) {
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
                        $('#persetujuan-modal').modal('hide')
                        table.ajax.reload()
                        forThis = null
                        idData = null
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr);
                    }
                });
            });

        });
    </script>
@endsection
