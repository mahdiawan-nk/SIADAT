@extends('layout.admin.app')
@section('style')
    <link rel="stylesheet" href="{{ asset('admin') }}/compiled/css/application-email.css">

    <link rel="stylesheet" href="{{ asset('admin') }}/extensions/choices.js/public/assets/styles/choices.css">
    <link rel="stylesheet" href="{{ asset('admin') }}/compiled/css/ui-widgets-chatbox.css">
    <style>
        .card-body {
            height: calc(60vh - 50px);
            /* Mengurangi tinggi card-footer */
            overflow-y: scroll;
        }

        .card-footer {
            background-color: #f8f9fa;
            padding: 10px;
        }

        .input-group.mb-3 button {
            min-width: 40px;
        }

        .input-group.mb-3 input {
            flex-grow: 1;
        }

        .message-form {
            width: 100%;
        }

        .chat-content {
            padding: 10px;
        }

        @media only screen and (max-width: 600px) {
            .email-application .content-area-wrapper .sidebar .compose-new-mail-sidebar {
                height: calc(100vh - 9rem);
                width: 100%;
                border-radius: 0 .267rem .267rem 0;
                background-color: #fff;
                position: absolute;
                -webkit-transform: translateX(130%);
                -ms-transform: translateX(130%);
                transform: translate(130%);
                -webkit-transition: all .3s ease;
                transition: all .3s ease;
                z-index: 8;
                right: 2.15rem;
                bottom: 1px;
            }
        }
    </style>
@endsection
@section('pages_admin')
    <div class="page-heading mb-1">
        <h3>Pesan</h3>
    </div>
    <div class="page-heading email-application overflow-hidden">
        <section class="section content-area-wrapper">
            <div class="sidebar-left">
                <div class="sidebar">
                    <div class="sidebar-content email-app-sidebar d-flex" style="height: 100vh">
                        <!-- sidebar close icon -->
                        <span class="sidebar-close-icon">
                            <i class="bi bi-x"></i>
                        </span>
                        <!-- sidebar close icon -->
                        <div class="email-app-menu">
                            <div class="form-group form-group-compose">
                                <!-- compose button  -->
                                <button type="button" class="btn btn-primary btn-block my-4 compose-btn">
                                    <i class="bi bi-plus"></i>
                                    Pesan Baru
                                </button>
                            </div>
                            <div class="sidebar-menu-list ps">

                                <div class="list-group list-group-labels">
                                    <a href="#"
                                        class="list-group-item d-flex flex-row align-items-center active list-menu"
                                        data-jenis="inbox">
                                        <i class="fa-solid fa-inbox me-2"></i>Pesan Masuk
                                        <span class="badge bg-light-danger badge-pill badge-round ms-2"
                                            id="badge-pesan-count">0</span>
                                    </a>
                                    <a href="#" class="list-group-item d-flex align-items-center list-menu"
                                        data-jenis="send">
                                        <i class="fa-solid fa-paper-plane me-2"></i>Pesan Terkirim
                                    </a>
                                    <a href="#" class="list-group-item d-flex align-items-center list-menu"
                                        data-jenis="trash">
                                        <i class="fas fa-regular fa-trash me-2"></i>Trash
                                    </a>
                                    <a href="#" class="list-group-item d-flex align-items-center list-menu"
                                        data-jenis="stars">
                                        <i class="fa-solid fa-star me-2"></i>Penting
                                    </a>
                                </div>
                                <!-- sidebar label end -->
                                <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                                    <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                                </div>
                                <div class="ps__rail-y" style="top: 0px; right: 0px;">
                                    <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- User new mail right area -->
                    <div class="compose-new-mail-sidebar ps shadow-lg">
                        <div class="card shadow-lg quill-wrapper p-0 overflow-auto">
                            <div class="card-header d-flex flex-row justify-content-between">
                                <h3 class="card-title" id="emailCompose">New Message</h3>
                                <button type="button" class="btn-close email-compose-new-close-btn" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <!-- form start -->
                            <form action="#" id="email-form-compose">
                                @csrf
                                <div class="card-content">
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="first-name-vertical">Dari</label>
                                                    <input type="text" id="first-name-vertical" class="form-control"
                                                        name="fname" placeholder="First Name"
                                                        value="{{ auth()->user()->email }}" disabled>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group basic-choices">
                                                    <label for="email-id-vertical">Kepada</label>
                                                    <select class="choices form-select" id="id_user_recieve"
                                                        name="id_user_recieve">

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="subject">Subject</label>
                                                    <input type="text" id="subject" class="form-control" name="subject"
                                                        placeholder="Subject">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group with-title mb-3">
                                                    <textarea class="form-control" id="exampleFormControlTextarea1" name="body" rows="10"></textarea>
                                                    <label>Pesan</label>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="formFile" class="form-label">Atachment</label>

                                                    <div class="input-group mb-3 upload-file" style="cursor: pointer">
                                                        <span class="input-group-text">Upload File</span>
                                                        <input type="text" name="attachment" class="form-control"
                                                            placeholder="Upload Files" aria-label="Upload Files"
                                                            aria-describedby="basic-addon2" readonly>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 d-flex justify-content-end">
                                                <button type="reset"
                                                    class="btn btn-light-secondary me-1 mb-1 email-compose-new-close-btn">Batal</button>
                                                <button type="submit" class="btn btn-primary me-1 mb-1"><i
                                                        class="bi bi-send me-3"></i>Kirim</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!-- form start end-->
                        </div>
                        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                        </div>
                        <div class="ps__rail-y" style="top: 0px; right: 0px;">
                            <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
                        </div>
                    </div>
                    <!--/ User Chat profile right area -->
                </div>
            </div>
            <div class="content-right" style="height: 100vh">
                <div class="content-overlay"></div>
                <div class="content-wrapper">
                    <div class="content-header row">
                    </div>
                    <div class="content-body">
                        <!-- email app overlay -->
                        <div class="app-content-overlay"></div>
                        <div class="email-app-area">
                            <!-- Email list Area -->
                            <div class="email-app-list-wrapper" style="height: 100vh">
                                <div class="email-app-list">
                                    <div class="email-action">
                                        <!-- action left start here -->
                                        <div class="action-left d-flex align-items-center">
                                            <!-- select All checkbox -->
                                            <div class="checkbox checkbox-shadow checkbox-sm selectAll me-3">
                                                <input type="checkbox" id="checkboxsmall" class="form-check-input">
                                                <label for="checkboxsmall"></label>
                                            </div>
                                            <!-- delete unread dropdown -->
                                            <ul class="list-inline m-0 d-flex">
                                                <li class="list-inline-item mail-delete">
                                                    <button type="button" class="btn btn-icon action-icon"
                                                        data-toggle="tooltip" id="delete-selected">
                                                        <span class="fonticon-wrap">
                                                            <i class="bi bi-trash3-fill"></i>
                                                        </span>
                                                    </button>
                                                </li>
                                                <li class="list-inline-item mail-unread" hidden>
                                                    <button type="button" class="btn btn-icon action-icon">
                                                        <span class="fonticon-wrap d-inline">
                                                            <i class="bi bi-bookmark-check-fill"></i>
                                                        </span>
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- action left end here -->

                                        <!-- action right start here -->
                                        <div
                                            class="action-right d-flex flex-grow-1 align-items-center justify-content-around">
                                            <div class="sidebar-toggle d-block d-lg-none">
                                                <button class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-list fs-5"></i>
                                                </button>
                                            </div>
                                            <!-- search bar  -->
                                            <div class="email-fixed-search flex-grow-1">

                                                <div class="form-group position-relative  mb-0 has-icon-left">
                                                    <input type="text" class="form-control"
                                                        placeholder="Search email..">
                                                    <div class="form-control-icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" fill="currentColor" class="bi bi-search"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- pagination and page count -->
                                            <span class="d-none d-sm-block" id="show-summary-pesan"></span>
                                            <button
                                                class="btn btn-icon email-pagination-prev action-button d-none d-sm-block"
                                                id="prev-page">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd"
                                                        d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0" />
                                                </svg>
                                            </button>
                                            <button
                                                class="btn btn-icon email-pagination-next action-button d-none d-sm-block border bodred-dark"
                                                id="next-page">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd"
                                                        d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- / action right -->

                                    <!-- email user list start -->
                                    <div class="email-user-list list-group ps" style="height: 100vh">
                                        <form action="" id="bulk-data">
                                            @csrf
                                            <ul class="users-list-wrapper media-list " id="list-media-pesan">

                                            </ul>
                                        </form>
                                        <!-- email user list end -->
                                    </div>
                                </div>
                            </div>
                            <!--/ Email list Area -->

                            <!-- Detailed Email View -->
                            <div class="email-app-details">
                                <div class="email-detail-header">
                                    <div class="email-header-left d-flex align-items-center mb-1"
                                        onclick="closeEmailDetails()">
                                        <span class="go-back me-3">
                                            <span class="fonticon-wrap d-inline">
                                                <i class="fas fa-chevron-left"></i>
                                            </span>
                                        </span>
                                        <h5 class="email-detail-title font-weight-normal mb-0" id="percakapan-subject">

                                        </h5>
                                    </div>

                                </div>
                                <div class="email-scroll-area ps ps--active-y" style="height: 100vh">
                                    <div class="row">
                                        <div class="col-md-12 p-2">
                                            <div class="card">
                                                <div class="card-header">
                                                    <div class="media d-flex align-items-center">
                                                        <div class="avatar me-3">
                                                            <img src="{{ asset('static-file/user.png') }}" alt=""
                                                                srcset="">
                                                            <span class="avatar-status bg-success"></span>
                                                        </div>
                                                        <div class="name flex-grow-1">
                                                            <h6 class="mb-0" id="username-sender"></h6>
                                                        </div>
                                                        <button class="btn btn-sm" onclick="closeEmailDetails()">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="feather feather-x">
                                                                <line x1="18" y1="6" x2="6"
                                                                    y2="18"></line>
                                                                <line x1="6" y1="6" x2="18"
                                                                    y2="18"></line>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card-body bg-grey">
                                                    <div class="chat-content">
                                                        <div class="chat chat-left" id="sender-pesan">

                                                        </div>
                                                    </div>
                                                    <div class="chat-content " id="percakapan-pesan-list">

                                                    </div>
                                                </div>
                                                <div class="card-footer">
                                                    <form action="" id="form-percakapan-pesan">
                                                        @csrf
                                                        <input type="hidden" name="id_user_recieve" id="user-recieve">
                                                        <input type="hidden" name="percakapan_id" id="id-percakapan">
                                                        <div class="d-flex flex-direction-column">
                                                            <div class="input-group mb-3">
                                                                <button class="btn btn-secondary" type="button"
                                                                    id="button-addon1" onclick="AttchselectFiles()"><i
                                                                        class="bi bi-file-earmark-arrow-up"></i></button>
                                                                <button class="btn btn-danger" type="button"
                                                                    id="button-addon1" onclick="removeAttch()"><i
                                                                        class="bi bi-x-square"></i></button>
                                                                <input type="text" class="form-control" aria-label=""
                                                                    name="attachment" id="attch-file" readonly>
                                                            </div>

                                                        </div>
                                                        <div
                                                            class="message-form d-flex flex-direction-column align-items-center">
                                                            <div class="d-flex flex-grow-1 ">
                                                                <textarea name="body" id="body-percakapan" class="form-control" rows="2"></textarea>
                                                            </div>
                                                            <button type="submit" class="btn btn-sm btn-primary ms-2"><i
                                                                    class="bi bi-send me-2"></i>Kirim</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                                        <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                                    </div>
                                    <div class="ps__rail-y" style="top: 0px; height: 736px; right: 0px;">
                                        <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 626px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('script')
    <script src="{{ asset('admin') }}/extensions/choices.js/public/assets/scripts/choices.js"></script>
    <script>
        function AttchselectFiles() {
            Flmngr.open({
                isMultiple: false,
                acceptExtensions: ["png", "jpeg", "jpg", "webp", "gif", "pdf"],
                onFinish: (files) => {
                    let dataFile = ParseUrlToPath(files)

                    $('#attch-file').val(dataFile)
                }
            });
        }

        function removeAttch() {
            $('#attch-file').val('')
        }
        var PercakapanPesan = (id) => {
            const url = '{{ route('api.pesan.show', ['pesan' => ':idData']) }}'.replace(
                ':idData',
                id);
            $.ajax({
                type: "GET",
                url: url,
                dataType: "JSON",
                success: function(response) {
                    let dataPesan = response.data.dataPesan;
                    let dataPercakapan = response.data.percakapan;
                    $('#percakapan-subject').text(dataPesan.subject)
                    let senderPesan = `<div class="chat-body">
                                            <div class="chat-message w-50">${ dataPesan.body}</div>
                                        </div>`
                    let listPercakapan = ''
                    dataPercakapan.forEach(item => {
                        listPercakapan += `<div class="chat ${item.id_user_sender == '{{ auth()->user()->id }}' ? '':'chat-left'}">
                                                            <div class="chat-body">
                                                                <div class="chat-message">
                                                                    ${item.body}
                                                                    <p class="text-secondary" ${item.attachment ? "":"hidden"}><a href="${item.file}" target="new"><i class="bi bi-file-earmark-richtext"></i> ${item.name_file}</a></p>
                                                                </div>
                                                            </div>
                                                        </div>`
                    });
                    $('#username-sender').text(dataPesan.user_sender.nama_lengkap)
                    $('#percakapan-pesan-list').html(listPercakapan)
                    $('#user-recieve').val(dataPesan.user_sender.id)
                    $('#id-percakapan').val(dataPesan.id)
                    $('#sender-pesan').html(senderPesan)

                }
            });
        }
        var updateReadPesan = (id) => {
            const url = '{{ route('api.pesan.update', ['pesan' => ':idData']) }}'.replace(
                ':idData',
                id);
            $.ajax({
                type: "PUT",
                url: url,
                data: {
                    _token: "{{ csrf_token() }}",
                    is_stars_click: false,
                    is_read_click:true
                },
                dataType: "JSON",
                success: function(response) {
                    Toast.fire({
                        icon: "success",
                        title: response.message
                    });
                    showListPesan(currentPage, jenis_pesan)
                }
            });
        }

        function showEmailDetails(ids) {

            const emailDetails = document.querySelector('.email-app-details');
            emailDetails.style.visibility = 'visible';
            emailDetails.style.opacity = '1';
            emailDetails.style.transform = 'translateX(0)';
            emailDetails.style.width = 'calc(100% - 300px)'

            setTimeout(() => {
                updateReadPesan(ids)
                PercakapanPesan(ids)
            }, 200);
        }

        function closeEmailDetails() {
            const emailDetails = document.querySelector('.email-app-details');
            emailDetails.style.visibility = 'hidden';
            emailDetails.style.opacity = '0';
            emailDetails.style.transform = 'translateX(100%)';
            emailDetails.style.width = 'calc(100% - 260px)'
        }
        document.querySelector('.sidebar-toggle').addEventListener('click', () => {
            document.querySelector('.email-app-sidebar').classList.toggle('show')
        })
        document.querySelector('.sidebar-close-icon').addEventListener('click', () => {
            document.querySelector('.email-app-sidebar').classList.remove('show')
        })
        document.querySelector('.compose-btn').addEventListener('click', () => {
            document.querySelector('.compose-new-mail-sidebar').classList.add('show')
        })
        document.querySelector('.email-compose-new-close-btn').addEventListener('click', () => {
            document.querySelector('.compose-new-mail-sidebar').classList.remove('show')
        })

        var choices = new Choices('#id_user_recieve', {
            shouldSort: false,
            placeholder: true,
            placeholderValue: 'Select an option',
        });

        var listPesanData = (data, jenis_pesan) => {
            $('#list-media-pesan').append(
                `<li class="media ${data.is_read ? 'mail-read':''}" style="cursor:default">
                                                <div class="user-action">
                                                    <div class="checkbox-con me-3">
                                                        <div class="checkbox checkbox-shadow checkbox-sm">
                                                            <input type="checkbox" id="checkboxsmall2"
                                                                class="form-check-input select-checkbox" name="data[]" value="${data.id}">
                                                            <label for="checkboxsmall2"></label>
                                                        </div>
                                                    </div>
                                                    <span class="favorite ${data.is_stars ? 'text-warning':''}" ${['trash','send'].includes(jenis_pesan) ? 'hidden':''} style="cursor:pointer" onclick="updateStars(${data.id})">
                                                        <i class="bi bi-star-fill"></i>
                                                    </span>
                                                </div>
                                                <div class="pr-50">
                                                    <div class="avatar">
                                                        <img class="rounded-circle" src="{{ asset('static-file/user.png') }}"
                                                            alt="Generic placeholder image">
                                                    </div>
                                                </div>
                                                <div class="media-body show-details-pesan" style="cursor:pointer" onclick="showEmailDetails(${data.id})">
                                                    <div class="user-details">
                                                        <div class="mail-items">
                                                            <span class="list-group-item-text text-truncate">${data.user_sender.nama_lengkap} - ${data.user_sender.email}</span>
                                                        </div>
                                                        <div class="mail-meta-item">
                                                            <span class="float-right">
                                                                <span class="mail-date">${data.last_time}</span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="mail-message">
                                                        <p class="list-group-item-text mb-0 truncate">
                                                            ${data.subject}
                                                        </p>
                                                        <div class="mail-meta-item">
                                                            <span class="float-right">
                                                                <span class="bullet bullet-danger bullet-sm"><i class="bi bi-paperclip me-3" ${data.attachment == null ? 'hidden':''}></i></span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>`
            )
        }

        let currentPage = 1;
        let lastPage = 1;
        let jenis_pesan = 'inbox'
        var showListPesan = (page, jenis_pesan) => {
            $.ajax({
                type: "GET",
                url: "{{ route('api.pesan.index') }}",
                data: {
                    page: page,
                    jenis_pesan: jenis_pesan
                },
                dataType: "JSON",
                success: function(response) {
                    let pesan = response.data.pesan
                    let pagination = response.data.pagination
                    currentPage = response.data.current_page;
                    lastPage = response.data.last_page;
                    const unreadCount = pesan.filter(pesan => pesan.is_read === 0).length;
                    $('#list-media-pesan').empty();
                    pesan.forEach(item => {

                        listPesanData(item, jenis_pesan)
                    });

                    let start = (currentPage - 1) * 10 + 1;
                    let end = start + pesan.length - 1;
                    let total = response.data.total;

                    $('#show-summary-pesan').text(`${start}-${end} of ${total}`)
                    const $badge = $('#badge-pesan-count');
                    $badge.text(unreadCount);

                    if (unreadCount === 0) {
                        $badge.hide();
                    } else {
                        $badge.show();
                    }
                    $('#prev-page').prop('disabled', currentPage === 1);
                    $('#next-page').prop('disabled', currentPage === lastPage);
                }
            });
        }

        var userList = () => {
            $.ajax({
                type: "GET",
                url: "{{ route('api.users.index') }}",
                data: {
                    users_id: '{{ auth()->user()->id }}'
                },
                dataType: "JSON",
                async: false,
                success: function(response) {
                    var items = response.data.map(function(item) {
                        return {
                            value: item.id,
                            label: item.nama_lengkap
                        };


                    });

                    // Set the choices with the fetched data
                    choices.setChoices(items, 'value', 'label', true);

                }
            });
        }

        userList()
        $("#checkboxsmall").on("change", function() {
            $(".select-checkbox").prop("checked", $(this).is(":checked"));
        });
        $('#prev-page').on('click', function() {
            if (currentPage > 1) {
                showListPesan(currentPage - 1, jenis_pesan)
            }
        });

        // Handle next page button click
        $('#next-page').on('click', function() {
            if (currentPage < lastPage) {
                console.log('klik next')
                showListPesan(currentPage + 1, jenis_pesan)

            }
        });

        $('.list-menu').click(function(e) {
            e.preventDefault();
            let jenis = $(this).data('jenis')
            jenis_pesan = jenis
            showListPesan(currentPage, jenis)
            $('.list-menu').removeClass('active');
            $(this).addClass('active');
        });



        showListPesan(currentPage, jenis_pesan)

        $('.mail-delete').click(function(e) {
            e.preventDefault();
            // let lengthChecked = $('#list-media-pesan ul li >div .select-checkbox:checked').length
            var checkedCount = $(".select-checkbox:checked").length;
            if (checkedCount == 0) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Tidak Ada Pesan Yang Dipilih",
                });
                return
            }

            Swal.fire({
                title: "Anda yakin?",
                text: "Data akan divalidasi!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Validasi!"
            }).then(result => {
                if (result.value) {
                    $.ajax({
                        url: '{{ route('api.pesan.delete.batch') }}',
                        type: 'POST',
                        dataType: 'json',
                        data: $('#bulk-data').serialize(),
                        success: function(response) {
                            console.log(response);
                            Toast.fire({
                                icon: "success",
                                title: response.message
                            });
                            showListPesan(currentPage, jenis_pesan)
                        },
                        error: function(xhr, status, error) {
                            handleErrorResponse(xhr.status, xhr.responseJSON)
                            console.error(xhr.responseJSON);
                        }
                    })
                }
            });
        });

        $('#email-form-compose').submit(function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            $.ajax({
                type: "POST",
                url: "{{ route('api.pesan.store') }}",
                data: $(this).serialize(),
                dataType: "JSON",
                success: function(response) {
                    Toast.fire({
                        icon: "success",
                        title: response.message
                    });

                    document.querySelector('.compose-new-mail-sidebar').classList.remove('show')
                    showListPesan(currentPage, jenis_pesan)
                },
                error: function(xhr, status, error) {
                    handleErrorResponse(xhr.status, xhr.responseJSON)
                    console.error(xhr.responseJSON);
                }
            });
        });

        $('#form-percakapan-pesan').submit(function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            $.ajax({
                type: "POST",
                url: "{{ route('api.pesan.store') }}",
                data: $(this).serialize(),
                dataType: "JSON",
                success: function(response) {
                    Toast.fire({
                        icon: "success",
                        title: response.message
                    });
                    $('#attch-file').val('')
                    $('#body-percakapan').val('')
                    PercakapanPesan(response.data.percakapan_id)
                },
                error: function(xhr, status, error) {
                    handleErrorResponse(xhr.status, xhr.responseJSON)
                    console.error(xhr.responseJSON);
                }
            });
        });

        function updateStars(data) {
            const url = '{{ route('api.pesan.update', ['pesan' => ':idData']) }}'.replace(
                ':idData',
                data);
            $.ajax({
                type: "PUT",
                url: url,
                data: {
                    _token: "{{ csrf_token() }}",
                    is_stars_click: true
                },
                dataType: "JSON",
                success: function(response) {
                    Toast.fire({
                        icon: "success",
                        title: response.message
                    });
                    showListPesan(currentPage, jenis_pesan)
                }
            });
        }
    </script>
@endsection
