@extends('layout.admin.app')
@section('style')
    <link rel="stylesheet" href="{{ asset('admin') }}/compiled/css/iconly.css">
@endsection
@section('pages_admin')
    <div class="page-heading">
        <h3>Dashboard</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-md-12 col-sm-12">
                <div class="card mb-0">
                    <div class="card-content">
                        <img class="card-img-top img-fluid" src="{{ asset('static-file/header-bg.jpg') }}"
                            alt="Card image cap" style="height: 20rem">
                        <div class="card-body card-img-overlay d-flex justify-content-center align-items-center">
                            <h4 class="card-title text-center">SELAMAT DATANG DI SISTEM INFORMASI ADAT KAMPAR</h4>
                        </div>
                    </div>
                </div>
                <div class="card mt-0">
                    <div class="card-content">
                        <div class="card-body">
                            <h4 class="card-title">SIADAT Sistem Informasi Adat Kampar</h4>
                            <p class="card-text">
                                SIADAT adalah sistem terintegrasi yang menyediakan informasi lengkap mengenai adat istiadat
                                dan budaya masyarakat Kampar. Dengan fitur pencarian dan penyimpanan data yang canggih,
                                SIADAT menjadi sumber informasi yang handal.
                            </p>
                            <p class="card-text">
                                Cupcake fruitcake macaroon donut pastry gummies tiramisu chocolate bar muffin.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="row">
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Recent Messages</h4>
                    </div>
                    <div class="card-content pb-4">
                        @php
                            $listPesan = App\Helpers\widgetRecentMessage();
                        @endphp
                        @foreach ($listPesan as $item)
                            <div class="recent-message d-flex px-4 py-3">
                                <div class="avatar avatar-lg">
                                    <img src="{{ asset('static-file/user.png') }}">
                                </div>
                                <div class="name ms-4">
                                    <h5 class="mb-1">{{ $item->userSender->username }}</h5>
                                    <h6 class="text-muted mb-0">{{ $item->userSender->email }}</h6>
                                    <p class="text-muted mb-0 mt-1">Pesan : {{ $item->subject }}</p>
                                </div>
                            </div>
                        @endforeach

                        <div class="px-4">
                            <a href="{{ route('panel-admin.pesan') }}"
                                class="btn btn-block btn-xl btn-outline-primary font-bold mt-3">Start
                                Conversation</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Informasi Profil</h4>
                    </div>
                    <div class="card-content pb-4">
                        <div class="recent-message d-flex px-4 py-3">
                            <div class="avatar avatar-lg">
                                <img src="{{ asset('static-file/user.png') }}">
                            </div>
                            <div class="name ms-4">
                                <h5 class="mb-1">{{ auth()->user()->username }}</h5>
                                <h6 class="text-muted mb-0">{{ auth()->user()->email }}</h6>
                            </div>
                        </div>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span> Nama Lengkap</span>
                                <span
                                    class="badge bg-secondary badge-pill badge-round ms-1">{{ auth()->user()->nama_lengkap }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span> Username</span>
                                <span
                                    class="badge bg-secondary badge-pill badge-round ms-1">{{ auth()->user()->username }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span> Kenegerian</span>
                                <span
                                    class="badge bg-danger badge-pill badge-round ms-1">{{ App\Helpers\userKenegerian(auth()->user()->id_kenegerian) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Role User</span>
                                <span
                                    class="badge bg-secondary badge-pill badge-round ms-1">{{ auth()->user()->role == 1 ? 'Administartor' : 'Operator Kenegerian' }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
