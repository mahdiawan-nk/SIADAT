<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin</title>
    <link rel="shortcut icon" href="{{ asset('admin') }}/compiled/svg/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('admin') }}/compiled/css/app.css">
    <link rel="stylesheet" href="{{ asset('admin') }}/compiled/css/app-dark.css">
    <link href="https://cdn.datatables.net/v/bs5/dt-2.0.8/r-3.0.2/rg-1.5.0/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('admin/compiled/css/loading-bar.css') }}">


    @yield('style')
    <style>
        #img-view {
            position: relative;
        }

        .remove-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            background-color: rgba(255, 255, 255, 0.7);
            border-radius: 50%;
            padding: 5px;
        }

        .file-selected {
            background: green;
            padding: 4px;
        }

        .file-hover:hover {
            background: green;
            padding: 4px;
        }

        .checkbox-container {
            position: absolute;
            top: 0;
            right: 7px;
            z-index: 1;
            /* Mengatur z-index untuk memastikan checkbox ada di atas gambar */
            padding: 5px;
            /* Ruang di sekitar checkbox */
            /* background-color: rgba(255, 255, 255, 0.5); */
            /* Latar belakang semi-transparan */
        }

        .btn-mini,
        .btn-group-mini>.btn {
            --bs-btn-padding-y: 0.25rem;
            --bs-btn-padding-x: 0.5rem;
            --bs-btn-font-size: 0.699rem;
            --bs-btn-border-radius: .2rem;
        }
    </style>
</head>

<body>
    <div id="app">
        @include('layout.admin.sidebar')
        <div id="main" class='layout-navbar navbar-fixed'>
            @include('layout.admin.header')
            <div id="main-content" style="min-height:80vh" class="mt-1">

                @yield('pages_admin')
                {{-- @include('pages_admin.file-manager.index') --}}
            </div>
            @include('layout.admin.footer')
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('admin') }}/static/js/components/dark.js"></script>
    <script src="{{ asset('admin') }}/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="{{ asset('admin') }}/compiled/js/app.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-2.0.8/r-3.0.2/rg-1.5.0/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script>
        paceOptions = {
            ajax: true,
            document: true,
            eventLag: false,
            restartOnPushState: true,
            restartOnRequestAfter: true,
            target: "body",
            elements: {
                checkInterval: 100,
                selectors: ["#main-content"]
            },
            ajax: {
                trackMethods: ["POST", "PUT", "DELETE"]
            }
        };
    </script>
    <script src="{{ asset('admin/compiled/js/pace.min.js') }}"></script>
    <script src="https://unpkg.com/flmngr"></script>
    <script src="{{ asset('tinymce/js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>

    <script>
        const urlFileManager = "{{ url('/flmngr') }}"
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
        let timeLoadTiny;
        Flmngr.load({
            apiKey: "FLMNFLMN",
            urlFileManager: urlFileManager,
            urlFiles: '{{ asset('storage/file-manager') }}'
        }, {
            onFlmngrLoaded: () => {
                attachOnClickListenerToButton();
            }
        })
        const handleErrorResponse = (errorCode, message) => {
            var errorMessage = '';
            switch (errorCode) {
                case 400:
                    errorMessage = 'Bad Request (400)';
                    break;
                case 401:
                    errorMessage = 'Unauthorized (401)';
                    break;
                case 403:
                    errorMessage = 'Forbidden (403)';
                    break;
                case 404:
                    errorMessage = 'Not Found (404)';
                    break;
                case 500:
                    errorMessage = 'Internal Server Error (500)';
                    break;
                default:
                    errorMessage = 'Unexpected Error (' + errorCode + ')';
            }

            

            Swal.fire({
                target:'.modal',
                icon: "error",
                title: "Oops..." + message.status,
                text: message.message,
            });
        }

        function initTiny() {
            const startTime = performance.now();
            tinymce.init({
                license_key: 'gpl|njzovfhmb3vks8j71rythikqice89ysip4eh41v9fln6sjjw',
                selector: '.editor',
                plugins: 'anchor autolink charmap codesample emoticons image link file-manager lists media searchreplace table visualblocks wordcount',
                toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
                Flmngr: {
                    apiKey: "FLMNFLMN",
                    urlFileManager: urlFileManager, // demo server
                    urlFiles: '{{ asset('storage/file-manager') }}'
                },
                setup: function(editor) {
                    editor.on('init', function(e) {
                        const endTime = performance.now();
                        const loadTime = endTime - startTime;
                        timeLoadTiny = loadTime
                    });
                }
            });

        }

        initTiny()

        let ParseUrlToPath = (files) => {
            let filesUrl = files[0].url
            const parsedUrl = new URL(filesUrl);
            const filePath = decodeURIComponent(parsedUrl.pathname);
            const relativePath = filePath.startsWith('/') ? filePath.substring(1) : filePath;
            return relativePath;
        }

        function attachOnClickListenerToButton(elemnt) {
            $('.' + elemnt).on('click', function(e) {
                console.log(e.target)
                let targets = e.target.name
                selectFiles(targets);
            });

        }

        function selectFiles(target) {
            Flmngr.open({
                isMultiple: false,
                acceptExtensions: ["png", "jpeg", "jpg", "webp", "gif", "pdf"],
                onFinish: (files) => {
                    console.log(target)
                    let dataFile = ParseUrlToPath(files)
                    
                    $('[name="' + target + '"]').val(dataFile)
                }
            });
        }

        $('#log-out').click(function(e) {
            e.preventDefault();
            Swal.fire({
                title: "Are you sure?",
                text: "Anda Akan Logout dari sistem",
                icon: "question",
                allowOutsideClick: false,
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Log out!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('api.auth.logout') }}",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        dataType: "JSON",
                        success: function(response) {
                            window.location.href = "{{ route('panel-admin.login') }}"
                        }
                    });
                }
            });
        });
    </script>
    @yield('script')

</body>

</html>
