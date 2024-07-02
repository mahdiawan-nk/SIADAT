class FileManager {
    constructor(options) {
        this.settings = Object.assign(
            {
                listFilesUrl: options.listFilesUrl || "",
                endPointUploadFile: options.endPointUploadFile || "",
                fileInputAccept: options.fileInputAccept || ".jpeg,.png,.jpg",
                summernoteSelector: options.summernoteSelector || ".isi-berita",
                modalSelector: options.modalSelector || "#file-manager",
                newFileSelector: options.newFileSelector || "#new-file",
                previewImageUpload: options.previewImageUpload || true,
                _tokenCsrf: options._tokenCsrf || "",
                multipleSelect: options.multipleSelect || false,
            },
            options
        );

        this.clickSummernote = false;
        this.dataFiles = null;
        this.statePreview = true;
        this.selectedFiles = [];
        this.selectedFilesUrl = [];
        this.init();
    }
    init() {
        this.generateModalHTML();
        this.initFileInputChange();
    }

    listFiles(type = null) {
        $.ajax({
            type: "GET",
            url: this.settings.listFilesUrl,
            data: {
                type: type,
            },
            dataType: "JSON",
            success: (response) => {
                const views = document.querySelectorAll("#views-files");
                views.forEach((view) => (view.innerHTML = ""));
                if (response.data.length === 0) {
                    let alert = `<div class="w-100"><div class="alert alert-danger text-center d-block mx-auto my-auto" role="alert">
                                    <label>Data Tidak Ada</label>
                                </div></div>`;
                    views.forEach((view) => (view.innerHTML = alert));
                    return;
                }
                response.data.forEach((item) => {
                    const list = `
                                    <div class="col mt-2 mb-4" style="cursor: pointer;position:relative">
                                        <img class="img-thumbnail" style="width:100%;height:100%;object-fit:contain;" src="${item.url_thumbnail}">
                                        <small>${item.file}</small>
                                        <div class="checkbox-container">
                                            <input type="checkbox" class="form-check-input checked-file" style="width:1.5em;height:1.5em" value="${item.file}" data-url="${item.url}">
                                        </div>
                                    </div>`;
                    views.forEach((view) =>
                        view.insertAdjacentHTML("beforeend", list)
                    );
                });
            },
        });
    }

    uploadFile(file) {
        var formData = new FormData();
        formData.append("file", file);
        formData.append("_token", this.settings._tokenCsrf);

        $.ajax({
            url: this.settings.endPointUploadFile,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: (response) => {
                this.listFiles();
                $("#preview-image").modal("hide");
            },
            error: (xhr, status, error) => {
                console.error(xhr.responseText);
            },
        });
    }

    initFileInputChange() {
        document.body.addEventListener("change", (event) => {
            if (event.target.id === "input-file-upload") {
                const file = event.target.files[0];
                if (file) {
                    if (this.settings.previewImageUpload) {
                        var reader = new FileReader();
                        reader.onload = (e) => {
                            var img = new Image();
                            img.src = e.target.result;
                            img.onload = () => {
                                var canvas = document.createElement("canvas");
                                var ctx = canvas.getContext("2d");

                                var maxWidth = 500;
                                var maxHeight = 500;
                                var width = img.width;
                                var height = img.height;

                                if (width > height) {
                                    if (width > maxWidth) {
                                        height *= maxWidth / width;
                                        width = maxWidth;
                                    }
                                } else {
                                    if (height > maxHeight) {
                                        width *= maxHeight / height;
                                        height = maxHeight;
                                    }
                                }

                                canvas.width = width;
                                canvas.height = height;
                                ctx.drawImage(img, 0, 0, width, height);

                                var resizedDataUrl =
                                    canvas.toDataURL("image/jpeg");
                                this.dataFiles = file;
                                $("#img-file").attr("src", resizedDataUrl);
                                $("#preview-image").modal("show");
                            };
                        };
                        reader.readAsDataURL(file);
                    } else {
                        this.uploadFile(file);
                    }
                }
            }
        });
    }

    initNewFile() {
        document.body.addEventListener("click", function (event) {
            if (event.target.id === "new-file") {
                document.querySelector("#input-file-upload").click();
            }
        });
    }
    generateModalHTML() {
        document.addEventListener("DOMContentLoaded", (event) => {
            const div = document.createElement("div");
            div.className = "modal fade";
            div.id = "file-manager";
            div.setAttribute("data-bs-backdrop", "static");
            div.setAttribute("data-bs-keyboard", "false");
            div.setAttribute("tabindex", "-1");
            div.setAttribute("aria-labelledby", "staticBackdropLabel");
            div.setAttribute("aria-hidden", "true");

            div.innerHTML = `
                        <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">File Manager</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body" style="min-height: 50vh">
                                    <div class="row">
                                        <div class="col-sm-2 mb-1">
                                            <input type="file" id="input-file-upload" style="display:none" accept="${this.settings.fileInputAccept}">
                                            <button class="btn btn-primary btn-block" id="new-file"><i class="fa-solid fa-file-import me-2"></i> New
                                                File</button>
                                        </div>
                                        <div class="col-sm-9 mb-1">
                                            <input type="search" class="form-control form-check-lg" placeholder="Cari File">
                                        </div>
                                        <div class="col-sm-1 ">
                                            <div class="btn-group w-100" role="group">
                                                <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa-solid fa-filter me-2"></i>Filter
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1" id="filter-files">
                                                    <li><a class="dropdown-item filters" data-filter="" href="#" id="all-files"><i class="fa-solid fa-filter-circle-xmark me-1"></i>All Files</a></li>
                                                    <li><a class="dropdown-item filters" data-filter="image" href="#" id="image"><i class="fa-solid fa-image me-1"></i> Image</a></li>
                                                    <li><a class="dropdown-item filters" data-filter="document" href="#" id="document"><i class="fa-solid fa-file me-1"></i>Document</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>

                                    <div class="row row-cols-1 row-cols-md-6 g-3" id="views-files">
                                        
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" id="submit-filemanager">Selesai</button>
                                </div>
                            </div>
                        </div>
                        `;

            // Menambahkan elemen ke dalam body
            document.body.appendChild(div);

            const divPreview = document.createElement("div");
            divPreview.className = "modal fade";
            divPreview.id = "preview-image";
            divPreview.setAttribute("data-bs-backdrop", "static");
            divPreview.setAttribute("data-bs-keyboard", "false");
            divPreview.setAttribute("tabindex", "-1");
            divPreview.setAttribute("aria-labelledby", "staticBackdropLabel");
            divPreview.setAttribute("aria-hidden", "true");

            divPreview.innerHTML = `
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Preview Image</h5>
                                </div>
                                <div class="modal-body" style="min-height: 50vh">
                                    <div class="d-flex justify-content-center">
                                        <img src="" id="img-file" class="w-100 mx-auto"/>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="button" class="btn btn-primary" id="goto-upload" data-files="">Upload</button>
                                </div>
                            </div>
                        </div>
                        `;
            document.body.appendChild(divPreview);
            this.setupEventListeners();
        });
    }

    setupEventListeners() {
        let openFileManagerButton = document.querySelector(".open-filemanager");

        if (openFileManagerButton) {
            openFileManagerButton.addEventListener(
                "click",
                function () {
                    $(this.settings.modalSelector).modal("show");
                    this.listFiles();
                }.bind(this)
            );
        }
        document.body.addEventListener("click", (event) => {
            if (event.target.id === "new-file") {
                document.querySelector("#input-file-upload").click();
            }
            if (event.target.id == "goto-upload") {
                this.uploadFile(this.dataFiles);
            }
            if (event.target.id == "submit-filemanager") {
                if (this.clickSummernote) {
                    this.selectedFilesUrl.forEach(item => {
                        $(this.settings.summernoteSelector).summernote('insertImage', item);
                    });
                } else {
                    
                    
                    // console.log(this.selectedFiles);
                }
                this.clickSummernote = false
                $('.checked-file').prop('checked',false)
                $(this.settings.modalSelector).modal("hide");
            }
            if (
                event.target.classList.contains("dropdown-item") &&
                event.target.classList.contains("filters")
            ) {
                let filters = event.target.getAttribute("data-filter");
                this.listFiles(filters);
            }
        });

        document.body.addEventListener("change", (event) => {
            if (
                event.target.classList.contains("form-check-input") &&
                event.target.classList.contains("checked-file")
            ) {
                let fileName = event.target.value;
                let fileUrl = event.target.dataset.url;
                if (this.settings.multipleSelect) {
                    if (event.target.checked) {
                        if (!this.selectedFiles.includes(fileName)) {
                            
                            if (this.clickSummernote) {
                                this.selectedFilesUrl.push(fileUrl);
                            }else{
                                this.selectedFiles.push(fileName);
                            }
                        }
                    } else {
                        let index = this.selectedFiles.indexOf(fileName);
                        if (index !== -1) {
                            if (this.clickSummernote) {
                                let urlIndex =
                                    this.selectedFilesUrl.indexOf(fileUrl);
                                if (urlIndex !== -1) {
                                    this.selectedFilesUrl.splice(urlIndex, 1);
                                }
                            }else{
                                this.selectedFiles.splice(index, 1);
                            }
                        }
                    }
                } else {
                    if (event.target.checked) {
                        if(this.clickSummernote){
                            this.selectedFilesUrl = this.clickSummernote? [fileUrl]: [];
                        }else{
                            this.selectedFiles = [fileName];
                        }
                        
                        
                        document
                            .querySelectorAll(".form-check-input.checked-file")
                            .forEach((checkbox) => {
                                if (checkbox.value !== fileName) {
                                    checkbox.checked = false;
                                    let index = this.selectedFiles.indexOf(
                                        checkbox.value
                                    );
                                    if (index !== -1) {
                                        this.selectedFiles.splice(index, 1);
                                    }
                                    if (this.clickSummernote) {
                                        let urlIndex =
                                            this.selectedFilesUrl.indexOf(
                                                checkbox.dataset.url
                                            );
                                        if (urlIndex !== -1) {
                                            this.selectedFilesUrl.splice(
                                                urlIndex,
                                                1
                                            );
                                        }
                                    }
                                }
                            });
                    } else {
                        let index = this.selectedFiles.indexOf(fileName);
                        if (index !== -1) {
                            this.selectedFiles.splice(index, 1);
                        }
                        if (this.clickSummernote) {
                            let urlIndex =
                                this.selectedFilesUrl.indexOf(fileUrl);
                            if (urlIndex !== -1) {
                                this.selectedFilesUrl.splice(urlIndex, 1);
                            }
                        }
                    }
                }

                // console.log(this.selectedFiles); // Tampilkan array yang berisi nilai file yang dipilih
                // console.log(this.selectedFilesUrl);
            }
        });


    }

    setMultipleSelect(value) {
        console.log(this.settings.multipleSelect);
        this.settings.multipleSelect = value;
    }

    openBysummernote() {
        $(this.settings.modalSelector).modal("show");
        this.listFiles();
    }
    setClickSummernote(value) {
        this.clickSummernote = value;
    }

    getFilesUpload(){
        return this.selectedFiles
    }
}
