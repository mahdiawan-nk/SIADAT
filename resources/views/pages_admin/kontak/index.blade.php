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
                    <div class="card-body">
                        <form class="form form-horizontal" method="POST" action="{{ route('api.informasi-kontak.store') }}"
                            id="form-kontak">
                            @csrf
                            <input type="hidden" name="id" value="">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="surel">Surel</label>
                                    </div>
                                    <div class="col-md-9 form-group">
                                        <input type="text" id="surel" class="form-control" name="surel"
                                            placeholder="Surel" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="telephone">Telephone</label>
                                    </div>
                                    <div class="col-md-9 form-group">
                                        <textarea name="telephone" id="" cols="30" rows="4" class="form-control"></textarea>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="contact-info-horizontal">Alamat</label>
                                    </div>
                                    <div class="col-md-9 form-group">
                                        <textarea name="alamat" id="alamat" cols="30" rows="10" class="form-control" required></textarea>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="contact-info-horizontal">Catatan</label>
                                    </div>
                                    <div class="col-md-9 form-group">
                                        <textarea name="catatan" id="catatan" cols="30" rows="10" class="form-control" required></textarea>

                                    </div>
                                    <div class="col-sm-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1"
                                            id="btn-submit">Submit</button>
                                        <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script>
        var idData = 0
        var loadKontak = () => {
            let btnSubmit = $('#btn-submit')
            $.ajax({
                type: "GET",
                url: "{{ route('api.informasi-kontak.index') }}",
                dataType: "JSON",
                success: function(response) {
                    if (response.data != null) {
                        btnSubmit.text('Update')
                        $('[name="id"]').val(response.data.id)
                        $('[name="surel"]').val(response.data.surel)
                        $('[name="telephone"]').val(response.data.telephone)
                        $('[name="alamat"]').val(response.data.alamat)
                        $('[name="catatan"]').val(response.data.catatan)
                    } else {
                        btnSubmit.text('Submit')
                    }


                }
            });
        }

        loadKontak()

        $('#form-kontak').submit(function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "JSON",
                success: function(response) {
                    console.log(response)
                    Toast.fire({
                        icon: "success",
                        title: response.message
                    });
                    loadKontak()
                },
                error: function(xhr, status, error) {
                    handleErrorResponse(xhr.status, xhr.responseJSON)
                    console.error(xhr.responseText);
                }
            });
        });
    </script>
@endsection
