@extends('layout.admin.app')
@section('style')
@endsection
@section('pages_admin')
    <div class="page-heading">
        <h3>Visi Misi</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-md-12">
                <div class="card">
                    <form class="card-content" id="form-visi-misi" method="POST">
                        @csrf
                        <div class="card-body">
                            <input type="hidden" name="type_profil" value="1">
                            <input type="hidden" name="id" value="0">
                            <textarea name="isi" id="isi-visi-misi" class="form-control editor" cols="30" rows="10" disabled></textarea>
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
                        tinymce.get('isi-visi-misi').setContent(response.data.content);
                    }, 2500);



                }
            });
        }

        loadProfil()

        $('#form-visi-misi').submit(function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            const url = '{{ route('api.profil.store') }}'
            let visiMisi = {
                _token: '{{ csrf_token() }}',
                id: $('[name="id"]').val(),
                type_profil: $('[name="type_profil"]').val(),
                content: tinymce.get('isi-visi-misi').getContent(),
            }
            $.ajax({
                type: "POST",
                url: url,
                data: visiMisi,
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
                    handleErrorResponse(xhr.status, xhr.responseJSON)
                    console.error(xhr.responseText);
                }
            });
        });
    </script>
@endsection
