@extends('layout.site.app')

@section('pages')
    <!-- Page Header Start -->
    <div class="container-fluid page-header">
        <h1 class="display-3 text-uppercase text-white mb-3">kebudayaan</h1>
        <div class="d-inline-flex text-white">
            <h3 class="text-uppercase m-0"><a href="">{{ $title }}</a></h3>
        </div>
    </div>
    <!-- Page Header Start -->
    <div class="container-fluid py-6 px-5" style="min-height:80vh">

        <div class="row g-5 portfolio-container">
            @foreach ($data as $item)
                <div class="col-xl-4 col-lg-6 col-md-6 portfolio-item first">
                    <div class="position-relative portfolio-box shadow">
                        <img class="img-fluid w-100" src="{{ asset($item->foto) }}" alt="">
                        <a class="portfolio-title shadow-sm show-keterangan" href="#shwo-keterangan"
                            data-id="{{ $item->id }}">
                            <p class="h4 text-uppercase">
                                {{ $item->jenis != 'peninggalan' ? $item->nama : $item->jenis_peninggalan }}</p>
                            <div class="text-body" {{ $item->jenis == 'peninggalan' ? '' : 'hidden' }}>
                                <span class="d-flex flex-row justify-content-start">
                                    <i class="fa fa-map-marker-alt text-primary me-2 align-self-center"></i><span class="text-break">{{ $item->lokasi }}</span>
                                </span>
                            </div>
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
                <div class="modal-body text-break" id="text-value-show">

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
                const url = '{{ route('api.informasi-budaya.show', ['informasi_budaya' => ':idData']) }}'.replace(
                    ':idData',
                    dataId);
                $.ajax({
                    type: "GET",
                    url: url,
                    dataType: "JSON",
                    success: function(response) {
                        console.log(response.data)
                        let data = response.data
                        $('#title-modal').text(`Informasi ${data.jenis == 'peninggalan' ? data.jenis_peninggalan:data.nama}`)
                        $('#text-value-show').html(response.data.ringkasan)
                        $('#show-ringkasan').modal('show')
                    }
                });
            });
        });
    </script>
@endsection
