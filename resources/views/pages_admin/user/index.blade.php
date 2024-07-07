@extends('layout.admin.app')
@section('style')
    <link rel="stylesheet" href="{{ asset('admin') }}/extensions/choices.js/public/assets/styles/choices.css">
@endsection
@section('pages_admin')
    <div class="page-heading">
        <h3>Manajemen User</h3>
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
                                            <th>Nama Lengkap</th>
                                            <th>Username</th>
                                            <th>Kenegerian</th>
                                            <th>Role</th>
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
    @include('pages_admin.user.create')
    @include('pages_admin.user.update')
@endsection

@section('script')
    <script src="{{ asset('admin') }}/extensions/choices.js/public/assets/scripts/choices.js"></script>
    <script>
        $(function() {
            var table = $('#table-data').DataTable({
                processing: true,
                serverSide: true,
                ordering: false,
                ajax: {
                    url: '{!! route('api.users.index') !!}',
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
                        data: 'nama_lengkap',
                    },
                    {
                        data: 'username',
                    },
                    {
                        data: 'kenegerian.nama_kenegerian',
                    },
                    {
                        data: 'role',
                        render(h) {
                            return `<span class="badge bg-${h == 1 ? 'primary':'secondary'}">${h == 1 ? 'Administrator':'Operator Kenegerian'}</span>`
                        },
                    },
                    {
                        data: 'action',
                    },
                ]
            });
            var listKenegerian = () => {
                $.ajax({
                    type: "GET",
                    url: '{{ route('api.kenegerian.index') }}',
                    dataType: "JSON",
                    success: function(response) {
                        let list = ''
                        list += `<option value="">Pilih Kenegerian</option>`
                        response.data.map(function(item) {
                            list +=
                                `<option value="${item.id}">${item.nama_kenegerian}</option>`
                        });
                        $('[name="id_kenegerian"]').html(list)

                        // Set the choices with the fetched data
                        // choices.setChoices(items, 'value', 'label', true);
                    }
                });
            }

            var resetPassword = (id) => {
                const url = '{{ route('api.user.reset.password', ['user' => ':idData']) }}'.replace(
                    ':idData',
                    id);
                $.ajax({
                    type: "PUT",
                    url: url,
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    dataType: "JSON",
                    success: function(response) {
                        Swal.fire({
                            icon: "success",
                            title: "Reset Password",
                            text: response.message,
                        });
                        table.ajax.reload()
                    },
                    error: function(xhr, status, error) {
                        handleErrorResponse(xhr.status, xhr.responseJSON)
                        console.error(xhr.responseText);
                    }
                });
            }

            var deleteData = (id) => {
                const url = '{{ route('api.users.destroy', ['user' => ':idData']) }}'.replace(
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
                        console.error(xhr.responseJSON);
                    }
                });
            }
            $('.add').click(function(e) {
                e.preventDefault();
                $('form#form-add')[0].reset()
                $('#add-modal').modal('show')
                listKenegerian()
            });

            table.on('click', '.edit', function() {
                let data = table.row($(this).parents('tr')).data()
                idData = data.id
                listKenegerian()
                console.log(data.id_kenegerian)
                setTimeout(() => {
                    $('[name="nama_lengkap"]').val(data.nama_lengkap)
                    $('[name="username"]').val(data.username)
                    $('[name="email"]').val(data.email)
                    $('[name="id_kenegerian"]').val(data.id_kenegerian)
                }, 1000);

                $('#update-modal').modal('show')

            });

            table.on('click', '.reset', function() {
                let data = table.row($(this).parents('tr')).data()
                idData = data.id
                Swal.fire({
                    title: "Are you sure?",
                    text: "Password Akan Direset Ke Default 12345678 ",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, Reset Password!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        resetPassword(data.id)
                    }
                });

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
                var form = $(this);
                $.ajax({
                    type: "POST",
                    url: "{{ route('api.users.store') }}",
                    data: $(this).serialize(),
                    dataType: "JSON",
                    success: function(response) {
                        Toast.fire({
                            icon: "success",
                            title: response.message
                        });
                        console.log(response)
                        $('#add-modal').modal('hide')
                        table.ajax.reload()
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        console.log(xhr.responseJSON)
                        if (xhr.responseJSON) {
                            var errors = xhr.responseJSON.errors;
                            form.find('.form-control.is-invalid').removeClass('is-invalid');
                            form.find('.form-control.is-invalid').siblings('.invalid-tooltip')
                                .remove();
                            $.each(errors, function(key, value) {
                                var inputField = form.find('[name="' + key + '"]');
                                inputField.addClass('is-invalid');
                                inputField.parent().append(
                                    '<div class="invalid-tooltip">' +
                                    value + '</div>');
                            });

                        } else {

                        }
                    }
                });
            });

            $('#form-update').submit(function(e) {
                e.preventDefault();
                e.stopImmediatePropagation();
                const url = '{{ route('api.users.update', ['user' => ':idData']) }}'.replace(
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
    </script>
@endsection
