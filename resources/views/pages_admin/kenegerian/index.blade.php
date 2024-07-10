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
        <h3>Kenegerian</h3>
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
                                            <th>Sejarah</th>
                                            <th>Foto</th>
                                            <th>Catatan</th>
                                            <th>Alamat</th>
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
    @include('pages_admin.kenegerian.create')
    @include('pages_admin.kenegerian.update')
@endsection

@section('script')
    <script>
        $(function() {
            var table = $('#table-data').DataTable({
                processing: true,
                serverSide: true,
                ordering: false,
                ajax: {
                    url: '{!! route('api.kenegerian.index') !!}',
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
                        data: 'nama_kenegerian',
                    },
                    {
                        data: 'contents',
                        render(h) {
                            return `<p class="text-wrap" style="width:10rem">${batasiPanjangKalimat(h,30)}</p>`
                        },
                    },
                    {
                        data: 'thumbnail',
                    },
                    {
                        data: 'catatan',
                    },
                    {
                        data: 'alamat',
                    },
                    {
                        data: 'action',
                    },
                ]
            });
            attachOnClickListenerToButton('upload-file')
            var deleteData = (id) => {
                const url = '{{ route('api.kenegerian.destroy', ['kenegerian' => ':idData']) }}'.replace(
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
            $('.add').click(function(e) {
                e.preventDefault();
                $('form#form-add')[0].reset()
                $('#add-modal').modal('show')
            });

            table.on('click', '.edit', function() {
                let data = table.row($(this).parents('tr')).data()
                idData = data.id
                setTimeout(() => {
                    $('[name="nama_kenegerian"]').val(data.nama_kenegerian)
                    $('[name="catatan"]').val(data.catatan)
                    $('[name="alamat"]').val(data.alamat)
                    $('[name="foto"]').val(data.foto)
                    tinymce.get('e-sejarah').setContent(data.contents);
                }, 100);

                $('#update-modal').modal('show')

            });

            table.on('click', '.hapus', function() {
                let data = table.row($(this).parents('tr')).data()
                idData = data.id
                Swal.fire({
                    title: "Are You sure?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: "Delete",
                }).then((result) => {
                    deleteData(data.id)
                });
            });

            $('#form-add').submit(function(e) {
                e.preventDefault();
                e.stopImmediatePropagation();
                $.ajax({
                    type: "POST",
                    url: "{{ route('api.kenegerian.store') }}",
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
                const url = '{{ route('api.kenegerian.update', ['kenegerian' => ':idData']) }}'.replace(
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
                        handleErrorResponse(xhr.status, xhr.responseJSON)
                        console.error(xhr.responseText);
                    }
                });
            });
        });

        function batasiPanjangKalimat(kalimat, batasKarakter) {
            if (kalimat.length > batasKarakter) {
                return kalimat.substring(0, batasKarakter) + '...';
            } else {
                return kalimat;
            }
        }
    </script>
@endsection
