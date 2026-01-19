@extends('layouts.admin_new')
@section('style')
    <link rel="stylesheet" href="{{asset('main/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('main/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('main/vendor/libs/select2/select2.css')}}">
@endsection
@section('content')
    <div class="row row-cols-1 row-cols-lg-2 pb-3">
        <div class="col">
            <h3 class="page-heading d-flex text-gray-900 fw-bold flex-column justify-content-center my-0">
                {{($dataTitle??($mainTitle??($title??'')))}}
            </h3>
            <ul class="breadcrumb breadcrumb-style2">
                <li class="breadcrumb-item">
                    <a href="{{route('admin.index')}}" class="text-hover-primary">Beranda</a>
                </li>
                @if(isset($title))
                    <li class="breadcrumb-item">
                        {{$title}}
                    </li>
                @endif
                @if(isset($mainTitle))
                    <li class="breadcrumb-item">
                        {{$mainTitle}}
                    </li>
                @endif
                @if(isset($dataTitle) && isset($mainTitle) && $mainTitle != $dataTitle)
                    <li class="breadcrumb-item active">
                        {{$dataTitle}}
                    </li>
                @endif
            </ul>
        </div>
        <div class="col-auto ms-auto d-print-none">
            <div class="d-flex justify-content-end">
                <a href="{{route('admin.keuangan.tagihan-siswa.buat-tagihan.index')}}" class="btn btn-outline-primary">
                    <span class="ri-arrow-left-s-line me-2"></span>
                    Kembali ke buat tagihan
                </a>
            </div>
        </div>
    </div>
    <meta name="csrf-token" content="{{ csrf_token() }}" xmlns="http://www.w3.org/1999/html">

    <div class="card">
        <div class="card-header header-elements">
            <h5 class="mb-0 me-2">{{($dataTitle??$mainTitle)}}</h5>
            <div class="card-header-elements ms-auto">
                <button type="button" class="btn btn-success" data-bs-toggle="modal"
                        data-bs-target="#modal-import" title="Buat Data">
                    <span class="ri-file-excel-2-line me-2"></span>
                    Import Tagihan Siswa
                </button>
            </div>
        </div>
        <div class="card-body">
            <form id="filterForm">
                <fieldset class="form-fieldset">
                    <div class="row row-cols-lg-2 row-cols-1">
                        <div class="col mb-5">
                            <div class="row d-flex align-items-center">
                                <div class="col-3">
                                    <label class="form-label" for="tahun_akademik">
                                        Tahun Akademik
                                    </label>
                                </div>
                                <div class="col">
                                    <select class="form-select" id="tahun_akademik"
                                            name="filter[tahun_akademik]"
                                            data-control="select2"
                                            data-placeholder="Pilih Tahun Akademik">
                                        <option value="all">Semua</option>
                                        @isset($thn_aka)
                                            @foreach($thn_aka as $item)
                                                <option
                                                    value="{{$item->id}}">{{$item->thn_aka}}</option>
                                            @endforeach
                                        @else
                                            <option>data kosong</option>
                                        @endisset
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-5">
                            <div class="row d-flex align-items-center">
                                <div class="col-3">
                                    <label class="form-label" for="kelas">
                                        Kelas
                                    </label>
                                </div>
                                <div class="col">
                                    <select class="form-select" id="kelas" name="filter[kelas]"
                                            data-control="select2" data-placeholder="Pilih Kelas">
                                        <option value="all">Semua</option>
                                        @isset($kelas)
                                            @foreach($kelas as $item)
                                                <option
                                                    value="{{$item->id}}">{{$item->unit}}  -  {{$item->kelas}} {{$item->kelompok}}</option>
                                            @endforeach
                                        @else
                                            <option>data kosong</option>
                                        @endisset
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="d-flex">
                            <div class="ms-auto">
                                <button type="reset" class="btn btn-outline-secondary">
                                    <span class="ri-reset-left-line me-2"></span>
                                    Reset
                                </button>
                                <button type="submit" class="btn btn-outline-primary ">
                                    <span class="ri-search-line me-2"></span>
                                    Cari
                                </button>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
        <div class="card-datatable table-responsive">
            <table class="table table-sm table-bordered table-hover"
                   id="main_table">
                <thead class="table-light">

                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <div class="w-100">
                <div class="row">
                    <div class="col-auto ms-auto d-print-none">
                        <div class="d-flex justify-content-end gap-3">
                            <button class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#modal-delete">
                                <span class="ri-delete-bin-2-line me-2"></span>
                                Hapus Data
                            </button>
                            <button class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#modal-validate">
                                <span class="ri-save-line me-2"></span>
                                Simpan Data
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <form id="deleteForm" class="mainForm">
        <div class="modal modal-blur fade" id="modal-delete" tabindex="-1" role="dialog" aria-hidden="true"
             data-bs-backdrop="static">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-status bg-danger"></div>
                    <div class="modal-header ">
                        <div class="modal-title">
                            Hapus Data
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body py-4">
                        <div class="row mb-3 text-center">
                            <span class="ri-delete-bin-2-line ri-48px"></span>
                            <h3>Hapus Seluruh data Import Tagihan Siswa?</h3>
                            <div class="">
                                Anda yakin ingin menghapus seluruh data tagihan siswa yang telah diimport?
                            </div>
                        </div>
                        <input type="hidden" id="delete_id" name="delete_id" value="12">
                    </div>
                    <div class="modal-footer ">
                        <div class="w-100">
                            <div class="row">
                                <div class="col">
                                    <input type="reset" class="btn btn-outline-secondary w-100" value="Batal"
                                           data-bs-dismiss="modal">
                                </div>
                                <div class="col">
                                    <input type="submit" value="Hapus Data" class="btn btn-danger w-100">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>


    <form id="formValidate" class="mainForm" method="POST">
        <div class="modal modal-blur fade" id="modal-validate" tabindex="-1" role="dialog" aria-hidden="true"
             data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-status bg-danger"></div>
                    <div class="modal-header ">
                        <div class="modal-title">
                            Simpan Data Siswa
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body py-4">
                        <div class="row mb-3 text-center">
                            <span class="ri-save-line ri-48px"></span>
                            <h3>Simpan Data tagihan?</h3>
                            <div class="">
                                Anda yakin ingin menyimpan data tagihan yang telah diimport?
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label class="form-label" for="metode">Metode Penyimpanan</label>
                                <select class="form-select" id="metode" name="metode" required>
                                    <option value="1" selected>Simpan data Tagihan</option>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" id="delete_id" name="delete_id" value="12">
                    </div>
                    <div class="modal-footer ">
                        <div class="w-100">
                            <div class="row">
                                <div class="col">
                                    <input type="reset" class="btn btn-outline-secondary w-100" value="Batal"
                                           data-bs-dismiss="modal">
                                </div>
                                <div class="col">
                                    <input type="submit" value="Simpan Data" class="btn btn-primary w-100">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form id="formImport" enctype="multipart/form-data" class="mainForm"
          method="POST">
        <div class="modal modal-blur fade" id="modal-import" tabindex="-1" role="dialog" aria-hidden="true"
             data-bs-backdrop="static">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Import Tagihan Siswa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                title="tutup"></button>
                    </div>
                    <div class="modal-body">
                        <ol class="mb-3">
                            <li>File harus berformat XLS/XLSX</li>
                            <li>Ukuran file tidak boleh lebih dari 2048KB/2MB</li>
                            <li>Kolom yang harus terisi: NIS, TAHUN AKADEMIK, NAMA TAGIHAN. NOMINAL, CICIL</li>
                            <li>Pastikan NIS sudah terdaftar pada Master Data Siswa</li>
                            <li>Pastikan Tahun Akademik sudah terdaftar pada Master Data Tahun Akademik</li>
                            <li>Pastikan Nama Tagihan sudah terdaftar pada Master Data Post</li>
                            <li>Contoh file yang dapat diproses untuk import:
                                @if(isset($templateImportExcel))
                                    <a href="{!! $templateImportExcel !!}">
                                        <i class="ti ti-file-spreadsheet"></i>&nbsp;Contoh File
                                    </a>
                                @endif
                            </li>
                        </ol>
                        <fieldset class="form-fieldset">

                            <div class="mb-3">
                                <label class="form-label required" for="file">File (.XLS, .XLSX)</label>
                                <input type="file" id="file" class="form-control"
                                       name="fileImport"
                                       placeholder="file" required>
                            </div>
                        </fieldset>
                    </div>
                    <div class="modal-footer">
                        <div class="w-100">
                            <div class="row">
                                <div class="col">
                                    <input type="reset" value="Batal" class="btn btn-outline-secondary w-100"
                                           data-bs-dismiss="modal">
                                </div>
                                <div class="col">
                                    <input type="submit" value="Import Data" class="btn btn-primary w-100">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script src="{{asset('main/vendor/libs/select2/select2.js')}}"></script>


    <link rel="stylesheet" href="{{asset('libs/filepond/dist/filepond.min.css')}}">
    <link rel="stylesheet" href="{{asset('libs/filepond/dist/custom.css')}}">
    <script
        src="{{asset('libs/filepond/plugin/filepond-plugin-file-validate-type/filepond-plugin-file-validate-type.min.js')}}"></script>
    <script
        src="{{asset('libs/filepond/plugin/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js')}}"></script>
    <script src="{{asset('libs/filepond/dist/filepond.min.js')}}"></script>
    <script src="{{asset('libs/filepond/dist/filepond.jquery.js')}}"></script>

    <script src="{{asset('main/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
    <script src="{{asset('js/datatableCustom/Datatable0-2.js')}}"></script>

    <script type="text/javascript">
        let dataColumns = [];
        let dataTableInit;
        let dataUrl = '{{($datasUrl??null)}}';
        let columnUrl = '{{($columnsUrl??null)}}';
        let formId = 'filterForm';
        let tableId = 'main_table';
        let id_action = '';
        let filePondElements = [];
        const select2 = $(`[data-control='select2']`);


        function initializeFilePond(id) {
            let inputElement = document.querySelector('input#' + id);
            filePondElements[id] = FilePond.create(inputElement, {
                credits: null,
                allowFileEncode: false,
                acceptedFileTypes: [
                    'application/vnd.ms-excel',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'application/wps-office.xlsx',
                    'application/wps-office.xls'
                ],
                // fileValidateTypeDetectType: (source, type) => new Promise((resolve, reject) => {
                //     console.log(source, type);
                //     resolve(type);
                // }),
                required: false,
                storeAsFile: true,
                labelIdle: 'Klik untuk membuka file manager, atau seret file ke dalam box ini.',
                allowFileTypeValidation: true,
                allowFileSizeValidation: true,
                labelMaxFileSizeExceeded: 'File terlalu besar',
                labelMaxFileSize: 'Ukuran maksimal file: {filesize}',
                labelFileTypeNotAllowed: 'Format file salah!',
                fileValidateTypeLabelExpectedTypes: 'file harus berformat .xls atau .xlsx',
                maxFileSize: 2048000,
            });
        }

        function resetFilePond(id) {
            filePondElements[id].removeFiles();
        }

        function clearErrorMessages(formId) {
            const form = document.querySelector(`#${formId}`);
            const errorElements = form.querySelectorAll('.invalid-feedback');
            const errorClass = form.querySelectorAll('.is-invalid');

            errorElements.forEach(element => element.textContent = '');
            errorClass.forEach(element => element.classList.remove('is-invalid'));
        }

        function processErros(errors) {
            for (const [key, value] of Object.entries(errors)) {
                const field = $(`[name=${key}]`);
                const errorMessage = value[0];

                function applyInvalidClasses(element, container) {
                    element.addClass('is-invalid');
                    container.addClass('is-invalid');
                    let errorFeedback = container.siblings('.invalid-feedback');

                    if (errorFeedback.length === 0) {
                        $('<div>', {
                            class: 'invalid-feedback',
                            role: 'alert',
                            text: errorMessage
                        }).insertAfter(container);
                    } else {
                        errorFeedback.html(errorMessage);
                    }
                }

                if (field.hasClass('select2-hidden-accessible')) {
                    let nextField = field.siblings('.select2-container');
                    applyInvalidClasses(field, nextField);
                } else {
                    if (field.parent().hasClass('input-group')) {
                        applyInvalidClasses(field, field.parent());
                    } else {
                        applyInvalidClasses(field, field);
                    }
                }

                if (key === 'password') {
                    const confirmField = $(`[name=${key}_confirmation]`);
                    applyInvalidClasses(confirmField, confirmField);
                }
            }
        }

        document.addEventListener("DOMContentLoaded", function () {
            if (dataUrl && columnUrl) {
                getDT(tableId, columnUrl, dataUrl, dataColumns, formId, true);

                if (formId) {
                    let filterForm = $(`#${formId}`);
                    filterForm.on('submit', function (e) {
                        e.preventDefault();
                        dataReFilter(tableId);
                    });

                    filterForm.on('reset', function (e) {
                        setTimeout(function () {
                            dataReFilter(tableId);

                            const select2InForm = select2.filter(`#${formId} [data-control='select2']`);

                            if (select2InForm.length) {
                                select2InForm.each(function () {
                                    let $this = $(this);
                                    $this.trigger('change');
                                });
                            }
                        }, 0)
                    });
                }

                $('[data-kt-docs-table-filter="search"]').on('keyup', function (e) {
                    $(`#${tableId}`).DataTable().search($(this).val()).draw();
                });
            }

            FilePond.registerPlugin(
                FilePondPluginFileValidateType,
                FilePondPluginFileValidateSize,
            )

            $('.mainForm').on('submit', function (e) {
                e.preventDefault()
                let url
                let tipe
                const formId = $(this).attr('id');
                let data = $(this).serialize();

                if (formId === "formImport") {
                    loadingAlert('Meng-Import data siswa');
                    url = '{{route('admin.keuangan.tagihan-siswa.buat-tagihan.import.store')}}'
                    tipe = 'POST';
                    data = new FormData(this);
                } else if (formId === 'formValidate') {
                    loadingAlert('Menyimpan data siswa');
                    url = '{{route('admin.keuangan.tagihan-siswa.buat-tagihan.import.validate-import')}}'
                    tipe = 'POST';
                } else if (formId === 'deleteForm') {
                    loadingAlert('Menghapus data siswa');
                    url = '{{route('admin.keuangan.tagihan-siswa.buat-tagihan.import.destroy-all')}}'
                    tipe = 'POST';
                }

                const csrfToken = $('meta[name="csrf-token"]').attr('content');
                let ajaxOptions = {
                    url: url,
                    type: tipe,
                    data: data,
                    datatype: 'json',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                    },
                }

                if (formId === "formImport") {
                    ajaxOptions.contentType = false;
                    ajaxOptions.processData = false;
                }

                // console.log(ajaxOptions)
                clearErrorMessages(formId)
                $.ajax(ajaxOptions).done(function (responses) {
                    document.getElementById(formId).reset();
                    successAlert(responses.message);
                    dataReload('main_table');
                    $("#" + $(e.target).attr('id')).find('[data-bs-dismiss="modal"]').trigger('click')
                }).fail(function (xhr) {
                    if (xhr.status === 422) {
                        const response = JSON.parse(xhr.responseText);
                        const error = response.error;
                        const errors = response.errors;
                        const errMessage = response.message || xhr.responseJSON.message;
                        errorAlert(errMessage);
                        if (error) {
                            processErros(error);
                        } else if (errors) {
                            processErros(errors);
                        }
                    } else if (xhr.status === 419) {
                        errorAlert('Sesi anda telah habis, Silahkan Login Kembali')
                    } else if (xhr.status === 500) {
                        errorAlert('Tidak dapat terhubung ke server, Silahkan periksa koneksi internet anda')
                    } else if (xhr.status === 403) {
                        errorAlert('Anda tidak memiliki izin untuk mengakses halaman ini')
                    } else if (xhr.status === 404) {
                        errorAlert('Halaman tidak ditemukan')
                    } else {
                        errorAlert('Terjadi kesalahan, silahkan coba memuat ulang halaman')
                    }
                })
            })

            $('#modal-import').on('hide.bs.modal', function (e) {
                resetFilePond('file')
            })

            if (select2.length) {
                select2.each(function () {
                    let $this = $(this);
                    // select2Focus($this);
                    $this.wrap('<div class="position-relative"></div>').select2({
                        placeholder: 'Select value',
                        dropdownParent: $this.parent()
                    });
                });
            }

            initializeFilePond('file');

        });

    </script>

    {!! ($modalLink??'') !!}
@endsection
