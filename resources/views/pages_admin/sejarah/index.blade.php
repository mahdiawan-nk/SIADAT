@extends('layout.admin.app')
@section('style')
@endsection
@section('pages_admin')
    <div class="page-heading">
        <h3>Sejarah</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-md-12">
                <div class="card">
                    <form class="card-content" id="form-visi-misi" method="POST">
                        @csrf
                        <div class="card-body">
                            <input type="hidden" name="type_profil" value="2">
                            <input type="hidden" name="id" value="0">
                            <textarea name="content" class="form-control editor" id="isi-sejarah" cols="30" rows="10"></textarea>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script>
        var idData = 0
        var loadProfil = () => {
            $.ajax({
                type: "GET",
                url: "{{ route('api.profil.index') }}",
                data: {
                    type: $('[name="type_profil"]').val()
                },
                dataType: "JSON",
                success: function(response) {
                    idData = response.data.id == null ? 0 : response.data.id
                    $('[name="id"]').val(idData)
                    setTimeout(function() {
                        tinymce.get('isi-sejarah').setContent(response.data.content);
                    }, 2500);

                }
            });
        }

        loadProfil()

        $('#form-visi-misi').submit(function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            const url = '{{ route('api.profil.store') }}'
            let sejarah = {
                _token: '{{ csrf_token() }}',
                id: $('[name="id"]').val(),
                type_profil: $('[name="type_profil"]').val(),
                content: tinymce.get('isi-sejarah').getContent(),
            }
            $.ajax({
                type: "POST",
                url: url,
                data: sejarah,
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
                    loadProfil()
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    </script>
@endsection
