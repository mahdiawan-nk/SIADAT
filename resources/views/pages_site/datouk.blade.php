@extends('layout.site.app')
@section('css')
    <link href="https://cdn.datatables.net/v/bs5/dt-2.0.8/r-3.0.2/rg-1.5.0/datatables.min.css" rel="stylesheet">
@endsection
@section('pages')
    <!-- Page Header Start -->
    <div class="container-fluid page-header">
        <h1 class="display-3 text-uppercase text-white mb-3">Informasi</h1>
        <div class="d-inline-flex text-white">
            <h3 class="text-uppercase m-0"><a href="">{{ $title }}</a></h3>
        </div>
    </div>
    <!-- Page Header Start -->
    <div class="container-fluid py-6 px-5" style="min-height:80vh">
        <div class="row g-5">
            <div class="col-lg-12  ">
                <div class="card shadow p-3 mb-5 bg-body rounded">
                    <div class="card-body">
                        <table class="table" id="table-data">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Gelar</th>
                                    <th scope="col">Alamat</th>
                                    <th scope="col">Suku</th>
                                    <th scope="col">Kenegerian</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $index => $item)
                                    <tr>
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->gelar }}</td>
                                        <td>{{ $item->alamat }}</td>
                                        <td>{{ $item->suku }}</td>
                                        <td>{{ $item->kenegerian->nama_kenegerian }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://cdn.datatables.net/v/bs5/dt-2.0.8/r-3.0.2/rg-1.5.0/datatables.min.js"></script>
    <script>
        $('#table-data').DataTable()
    </script>
@endsection
