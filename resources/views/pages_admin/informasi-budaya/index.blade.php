@extends('layout.admin.app')
@section('style')
@endsection
@section('pages_admin')
    <div class="page-heading">
        <h3>{{ $title }}</h3>
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
                                            <th>{{ $field }}</th>
                                            <th>Jenis Peninggalan</th>
                                            <th>Ringkasan</th>
                                            <th>Foto</th>
                                            <th>Tempat</th>
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
    @include('pages_admin.informasi-budaya.create')
    @include('pages_admin.informasi-budaya.update')
@endsection

@section('script')
    <script>
        $(function() {
            let jenisData = '{{ $jenis }}'
            let arrJenisData = ['seni_tari', 'seni_musik', 'kuliner_khas']
            var table = $('#table-data').DataTable({
                processing: true,
                serverSide: true,
                ordering: false,
                ajax: {
                    url: '{!! route('api.informasi-budaya.index') !!}',
                    type: "GET",
                    data: {
                        jenis: '{{ $jenis }}'
                    },
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
                        data: 'jenis_peninggalan',
                    },
                    {
                        data: 'contents',
                    },
                    {
                        data: 'thumbnails',
                    },
                    {
                        data: 'lokasi',
                    },
                    {
                        data: 'action',
                    },
                ]
            });
            table.columns([1]).visible(['peninggalan'].includes(jenisData) ? false : true);
            table.columns([2]).visible(arrJenisData.includes(jenisData) ? false : true);
            table.columns([5]).visible(arrJenisData.includes(jenisData) ? false : true);

            var deleteData = (id) => {
                const url = '{{ route('api.informasi-budaya.destroy', ['informasi_budaya' => ':idData']) }}'.replace(
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
                        handleErrorResponse(xhr.status,xhr.responseJSON)
                        console.error(xhr.responseText);
                    }
                });
            }

            attachOnClickListenerToButton('upload-file')

            $('.add').click(function(e) {
                e.preventDefault();
                $('form#form-add')[0].reset()
                $('#add-modal').modal('show')
            });

            table.on('click', '.edit', function() {
                let data = table.row($(this).parents('tr')).data()
                idData = data.id
                setTimeout(() => {
                    $('[name="nama"]').val(data.nama)
                    $('[name="jenis_peninggalan"]').val(data.jenis_peninggalan)
                    $('[name="lokasi"]').val(data.lokasi)
                    $('[name="foto"]').val(data.foto)
                    tinymce.get('e-ringkasan').setContent(data.contents);
                }, 1000);
                $('#update-modal').modal('show')

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
                    url: "{{ route('api.informasi-budaya.store') }}",
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
                        handleErrorResponse(xhr.status, xhr.responseJSON)
                        console.error(xhr.responseText);
                    }
                });
            });

            $('#form-update').submit(function(e) {
                e.preventDefault();
                e.stopImmediatePropagation();
                const url = '{{ route('api.informasi-budaya.update', ['informasi_budaya' => ':idData']) }}'
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
                        handleErrorResponse(xhr.status,xhr.responseJSON)
                        console.error(xhr.responseText);
                    }
                });
            });

        });
    </script>
@endsection
