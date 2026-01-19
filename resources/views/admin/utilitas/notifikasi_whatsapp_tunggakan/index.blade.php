@extends('layouts.admin_new')
@section('style')
    <link rel="stylesheet" href="{{asset('main/vendor/libs/select2/select2.css')}}">
    <link rel="stylesheet" href="{{asset('main/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
    
    <link rel="stylesheet" href="{{asset('main/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
    <style>
        table.dataTable tr.selected {
            border-top: 2px solid var(--bs-primary);
            border-bottom: 2px solid var(--bs-primary);
            border-left: none;
            border-right: none;
        }
    </style>
@endsection
@section('content')
    <h3 class="page-heading d-flex text-gray-900 fw-bold flex-column justify-content-center my-0">
        {{($dataTitle??($mainTitle??($title??'')))}}
    </h3>
    <ul class="breadcrumb breadcrumb-style2">
        <li class="breadcrumb-item">
            <a href="#" class="text-hover-primary">Beranda</a>
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

    <div class="card">
        @csrf
        <form id="filterForm">
            <div class="card-header bg-card sticky-element">
                <div class="row mb-3">
                    <h5 class="mb-0 me-2">{{($dataTitle??$mainTitle)}}</h5>
                </div>
            </div>
            <div class="card-body">
                <div class="row px-5 mb-2">
                    <ul class="list-group list-group-timeline">
                        <li class="list-group-item list-group-timeline-danger">
                            <strong>Pastikan sudah melengkapi data nomor whatsapp siswa!!</strong>
                        </li>
                        <li class="list-group-item list-group-timeline-danger">
                            <strong>Siswa tanpa data nomor whatsapp, tidak akan menerima pesan ini!</strong>
                        </li>
                    </ul>
                </div>
                    <fieldset class="form-fieldset">
                        <div class="row">
                            <h5>Kirim Berdasarkan</h5>
                            <div class="col-lg-6">
                                <div class="mb-5">
                                    <label class="form-label" for="cari_siswa">
                                        Nis / Nama
                                    </label>
                                    <input class="form-control" id="cari_siswa" name="filter[cari_siswa]" placeholder="Nis / Nama">
                                </div>
                                <div class="mb-5">
                                        <label class="form-label" for="kelas">
                                            Kelas
                                        </label>
                                        <div class="row">
                                            <div class="col">
                                                <select class="form-select" id="unit" name="unit"
                                                        data-control="select2"
                                                        data-placeholder="Pilih Jenis Unit">
                                                    <option></option>
                                                    @isset($kelas)
                                                        @foreach ($kelas as $k)
                                                            <option value="{{$k->jenjang}}-{{$k->unit}}">{{$k->jenjang}} {{$k->unit}}</option>
                                                        @endforeach
                                                    @else
                                                        <option>Tidak Ada Data</option>
                                                    @endisset
                                                </select>
                                            </div>
                                            <div class="col">
                                                <select class="form-select" id="index-kelas" name="kelas" data-control="select2"
                                                        data-placeholder="Pilih Jenis Kelas" disabled>
                                                </select>
                                            </div>
                                        </div>

                                </div>

                            </div>
                            <div class="col-lg-6">
                                <div class="mb-5">
                                    <label class="form-label" for="tahun_akademik">
                                        Tahun Akademik
                                    </label>
                                    <select class="form-select" id="tahun_akademik"
                                            name="filter[tahun_akademik]"
                                            data-control="select2"
                                            data-placeholder="Pilih Tahun Akademik">
                                        <option value="all">Semua</option>
                                        @isset($thn_aka)
                                            @foreach($thn_aka as $item)
                                                <option
                                                    value="{{$item->thn_aka}}">{{$item->thn_aka}}</option>
                                            @endforeach
                                        @else
                                            <option>data kosong</option>
                                        @endisset
                                    </select>
                                </div>
                                <div class="mb-5">
                                    <label class="form-label" for="status_tagihan">
                                        Status
                                    </label>
                                    <select class="form-select" id="status_tagihan"
                                            name="status_tagihan"
                                            data-control="select2"
                                            data-placeholder="Pilih Status Tagihan">
                                            <option
                                            value="1">Semua Tagihan</option>
                                            <option
                                            value="2">Hanya Tagihan Dengan Urutan Terkecil</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="w-100">
                            <div class="row">
                                <div class="d-flex justify-content-center justify-content-md-end gap-4">
                                    <button type="reset" class="btn btn-outline-secondary">
                                        <span class="tf-icon ri-reset-left-line me-2"></span>
                                        Reset
                                    </button>
                                    <button type="submit" class="btn btn-outline-primary ">
                                        <span class="tf-icon ri-search-line me-2"></span>
                                        Cari
                                    </button>
                                </div>
                            </div>
                        </div>
                    </fieldset>
            </div>
            <div class="card-datatable table-responsive text-nowrap">
                <table class="table table-sm table-bordered table-hover"
                    id="main_table">
                    <thead class="table-light">

                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <div class="card-footer border-0 pt-0">
                <div class="d-flex justify-content-end gap-4">
                    <button type="btn" class="btn btn-success" onclick="sendWhatsapp()">
                        <span class="tf-icon ri-whatsapp-line me-2"></span>
                        Kirim
                    </button>
                </div>
            </div>
        </form>
    </div>

@endsection

@section('script')

<meta name="csrf-token" content="{{ csrf_token() }}" xmlns="http://www.w3.org/1999/html">

    <script src="{{asset('main/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
    <script src="{{asset('main/vendor/libs/select2/select2.js')}}"></script>
    <script src="{{asset('js/datatableCustom/Datatable0-3.js')}}"></script>

    <script type="text/javascript">
        let dataColumns = [];
        let dataTableInit;
        let dataUrl = '{{($datasUrl??null)}}';
        let columnUrl = '{{($columnsUrl??null)}}';
        let formId = 'filterForm';
        let tableId = 'main_table';
        const select2 = $(`[data-control='select2']`);
        const stickyEl = $('.sticky-element');
        let topSpacing;
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        let selectedRows = [];

        let dtOptions = {
            'tableId': tableId,
            'columnUrl': columnUrl,
            'dataUrl': dataUrl,
            'dataColumns': dataColumns,
            'formId': formId,
            'thead': true,
            'tfoot': false,
            'pagination': false,
            'search': true,
            'fixedHeader': true,
        };

        let handleSearchDatatable = function () {
            const filterSearch = document.querySelector('[data-kt-docs-table-filter="search"]');
            filterSearch.addEventListener('keyup', function (e) {
                dt.search(e.target.value).draw();
            });
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

        function sendWhatsapp() {
            loadingAlert('Mengirim pesan <br><span class="text-danger"> *</span>Jangan menutup atau memuat ulang halaman!');
            let mainForm = $(this);
            let url = '{{route('admin.notifikasi-whatsapp-tagihan.send-wa')}}';
            let tipe = 'POST';
            const formId = "filterForm";
            console.log(selectedRows);

            let ajaxOptions = {
                url: url,
                type: tipe,
                data: {
                    tagihan: selectedRows
                },
                datatype: 'json',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                },
            }
            clearErrorMessages(formId)
            $.ajax(ajaxOptions).done(function (responses) {
                document.getElementById(formId).reset();
                successAlert(responses.message)
            }).fail(function (xhr) {
                if (xhr.status === 422) {
                    const errMessage = xhr.responseJSON.message
                    errorAlert(errMessage)
                    const errors = JSON.parse(xhr.responseText).error
                    if (errors) {
                        processErros(errors)
                    }
                } else if (xhr.status === 419) {
                    errorAlert('Sesi anda telah habis, Silahkan Login Kembali');
                } else if (xhr.status === 500) {
                    errorAlert('Tidak dapat terhubung ke server, Silahkan periksa koneksi internet anda');
                } else if (xhr.status === 403) {
                    errorAlert('Anda tidak memiliki izin untuk mengakses halaman ini');
                } else if (xhr.status === 404) {
                    errorAlert('Halaman tidak ditemukan');
                } else {
                    errorAlert('Terjadi kesalahan, silahkan coba memuat ulang halaman');
                }
            })

        }

        document.addEventListener("DOMContentLoaded", function () {
            $('#unit').change(function() {
                const csrfToken = $('meta[name="csrf-token"]').attr('content');
                var selectedValue = $(this).val();
                if (selectedValue != "Semua") {
                    $('#index-kelas').prop('disabled', true);
                    var [jenjang, unit] = selectedValue.split('-');

                    $.ajax({
                        url: "{{route('admin.notifikasi-whatsapp-tagihan.get-kelas')}}",
                        type: 'POST',
                        data: {
                            jenjang: jenjang,
                            unit: unit
                        },
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        success: function(response) {
                            $('#index-kelas').empty().append('<option value="">Pilih Kelas</option>');
                            response.forEach(function(kelas) {
                                $('#index-kelas').append('<option value="' + kelas.kelas + '">' + kelas.kelas + '</option>');
                            });
                            $('#index-kelas').prop('disabled', false);
                        }
                    });
                } else {
                    $('#index-kelas').empty().append('<option value="">Pilih Kelas</option>').prop('disabled', true);
                }
            });

            let idTable = $(`#${tableId}`);

            if (select2.length) {
                select2.each(function () {
                    let $this = $(this);
                    $this.wrap('<div class="position-relative"></div>').select2({
                        placeholder: 'Select value',
                        dropdownParent: $this.parent()
                    });
                });
            }

            if (dataUrl && columnUrl) {
                getDT(tableId, columnUrl, dataUrl, dataColumns, formId, true, false ,true);
                if (formId) {
                    let filterForm = $(`#${formId}`);
                    filterForm.on('submit', function (e) {
                        e.preventDefault();
                        let kelas = $('#index-kelas').val();
                        if (kelas == '' || kelas == null) {
                            warningAlert("Silahkan isi filter kelas terlebih dahulu");
                            return;
                        }
                        idTable.DataTable().rows('.selected').deselect();
                        selectedRows = {};
                        dataReFilter(tableId);
                    });

                    filterForm.on('reset', function (e) {
                        setTimeout(function () {
                            idTable.DataTable().rows('.selected').deselect();
                            selectedRows = {};
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

            if (select2.length) {
                select2.each(function () {
                    let $this = $(this);
                    $this.wrap('<div class="position-relative"></div>').select2({
                        placeholder: 'Select value',
                        dropdownParent: $this.parent()
                    });
                });
            }

            idTable.on('select.dt', function(e, dt, type, indexes) {
                let selectedData = idTable.DataTable().table().rows(indexes).data().toArray();
                selectedData.forEach(row => {
                    if (!selectedRows[row.CUSTID]) {
                        selectedRows[row.CUSTID] = [];
                    }
                    if (!selectedRows[row.CUSTID].includes(row.id)) {
                        selectedRows[row.CUSTID].push(row.id);
                    }
                });
            });

            idTable.on('deselect.dt', function(e, dt, type, indexes) {
                let deselectedData = idTable.DataTable().table().rows(indexes).data().toArray();
                deselectedData.forEach(row => {
                    if (selectedRows[row.CUSTID]) {
                        selectedRows[row.CUSTID] = selectedRows[row.CUSTID].filter(id => id !== row.id);
                        if (selectedRows[row.CUSTID].length === 0) {
                            delete selectedRows[row.CUSTID];
                        }
                    }
                });
            });
        });

    </script>
    {{-- {!! ($modalLink??'') !!} --}}
@endsection
