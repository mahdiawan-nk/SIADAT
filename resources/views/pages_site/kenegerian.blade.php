@extends('layout.site.app')

@section('pages')
    <!-- Page Header Start -->
    <div class="container-fluid page-header">
        <h1 class="display-3 text-uppercase text-white mb-3">informasi</h1>
        <div class="d-inline-flex text-white">
            <h3 class="text-uppercase m-0"><a href="">{{ $title }}</a></h3>
        </div>
    </div>
    <!-- Page Header Start -->
    <div class="container-fluid py-6 px-5" style="min-height:80vh">

        <div class="row g-5 portfolio-container">
            @foreach ($data as $item)
                <div class="col-xl-4 col-lg-6 col-md-6 portfolio-item first">
                    <div class="position-relative portfolio-box">
                        <div class="image-container" style="width: 100%; height: 450px;">
                            <img class="img-fluid mx-auto" src="{{ asset($item->foto) }}" alt=""
                                style="object-fit: cover; width: 100%; height: 100%;">
                        </div>
                        <a class="portfolio-title shadow-sm show-keterangan" href="#shwo-keterangan"
                            style="min-height:120px;height: auto" data-id="{{ $item->id }}">
                            <p class="h4 text-uppercase">{{ $item->nama_kenegerian }}</p>
                            <span class="text-body"><i
                                    class="fa fa-map-marker-alt text-primary me-2"></i>{{ $item->alamat }}</span>
                        </a>
                        <a class="portfolio-btn" href="{{ asset($item->foto) }}" data-lightbox="portfolio">
                            <i class="bi bi-plus text-white"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center mt-5">
            {{ $data->links() }}
        </div>
    </div>
    <div class="modal fade" id="show-ringkasan" tabindex="-1" aria-labelledby="title-modal" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="title-modal"> </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="text-value-show">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(function() {
            $('.show-keterangan').on('click', function(event) {
                event.preventDefault();
                let dataId = $(this).data('id')
                const url = '{{ route('api.kenegerian.show', ['kenegerian' => ':idData']) }}'.replace(
                    ':idData',
                    dataId);
                $.ajax({
                    type: "GET",
                    url: url,
                    dataType: "JSON",
                    success: function(response) {
                        console.log(response)
                        $('#title-modal').text(`Informasi Sejarah Kenegerian ${response.data.nama_kenegerian}`)
                        $('#text-value-show').text(response.data.sejarah)
                        $('#show-ringkasan').modal('show')
                    }
                });

            });
        });
    </script>
@endsection
