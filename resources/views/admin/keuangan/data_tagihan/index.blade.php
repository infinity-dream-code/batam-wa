@extends('layouts.admin_new')
@section('style')
    <link rel="stylesheet" href="{{asset('main/vendor/libs/select2/select2.css')}}">
    <link rel="stylesheet" href="{{asset('main/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('main/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
@endsection
@section('content')
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

    <div class="card">
        <div class="card-header bg-card sticky-element">
            <div class="row mb-3">
                <h5 class="mb-0 me-2">{{($dataTitle??$mainTitle)}}</h5>
            </div>
        </div>
        <div class="card-body">
            <form id="filterForm">
                <fieldset class="form-fieldset">
                    <div class="row">
                        <h5>Filter</h5>
                        <div class="col-lg-6">
                            <div class="mb-5">
                                <label class="form-label" for="status">
                                    Status Pembayaran
                                </label>
                                <select class="form-select" id="status" name="filter[status]"
                                        data-control="select2"
                                        data-placeholder="Pilih Status Tagihan" required>
                                    <option value="all">Semua</option>
                                    <option value="1">Dibayar</option>
                                    <option value="0">Belum Dibayar</option>
                                </select>
                            </div>
                            <div class="mb-5">
                                <label class="form-label" for="jenis">
                                    Jenis Pembayaran
                                </label>
                                <select class="form-select" id="jenis" name="filter[jenis]"
                                        data-control="select2"
                                        data-placeholder="Pilih Jenis Tagihan" required>
                                    <option value="all">Semua</option>
                                    <option value="0">Satuan</option>
                                    <option value="1">Cicilan</option>
                                </select>
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
                                <label class="form-label" for="kelas">
                                    Kelas
                                </label>
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
                    <div class="w-100">
                        <div class="row">
                            <div class="d-flex justify-content-center justify-content-md-end gap-4">
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
        <div class="card-datatable table-responsive text-nowrap">
            <table class="table table-sm table-bordered table-hover"
                   id="main_table">
                <thead class="table-light">

                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <meta name="csrf-token" content="{{ csrf_token() }}" xmlns="http://www.w3.org/1999/html">

    <script src="{{asset('main/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
    <script src="{{asset('main/vendor/libs/select2/select2.js')}}"></script>
    <script src="{{asset('js/datatableCustom/Datatable0-2.js')}}"></script>

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

        let dtOptions = {
            'tableId': tableId,
            'columnUrl': columnUrl,
            'dataUrl': dataUrl,
            'dataColumns': dataColumns,
            'formId': formId,
            'thead': true,
            'tfoot': false,
            'pagination': true,
            'search': true,
            'fixedHeader': true,
        };

        let handleSearchDatatable = function () {
            const filterSearch = document.querySelector('[data-kt-docs-table-filter="search"]');
            filterSearch.addEventListener('keyup', function (e) {
                dt.search(e.target.value).draw();
            });
        }

        document.addEventListener("DOMContentLoaded", function () {
            if (dataUrl && columnUrl) {
                getDT(tableId, columnUrl, dataUrl, dataColumns, formId, true);

                if (formId) {
                    let filterForm = $(`#${formId}`);
                    filterForm.on('submit', function (e) {
                        e.preventDefault();
                        dataReFilter(tableId, dataUrl, dataColumns, formId);
                    });

                    filterForm.on('reset', function (e) {
                        setTimeout(function () {
                            dataReFilter(tableId, dataUrl, dataColumns, formId);

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

            $(document).on('click', '.btn-print-tagihan', function (e) {
                loadingAlert();
                let data = $(this).data('val');
                if (data.item_id) {
                    const csrfToken = $('meta[name="csrf-token"]').attr('content')

                    let ajaxOptions = {
                        url: '{{route('admin.keuangan.tagihan-siswa.data-tagihan.cetak')}}',
                        type: 'get',
                        data: {
                            'id_tagihan': data.item_id
                        },
                        datatype: 'json',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        contentType: false,
                        processData: true,
                        cache: false,
                        xhrFields: {
                            responseType: 'blob'
                        },
                    }
                    $.ajax(ajaxOptions).done(function (response, status, xhr) {
                        try {
                            let blob = new Blob([response], {type: 'application/pdf'});

                            if (typeof window.navigator.msSaveBlob !== 'undefined') {
                                window.navigator.msSaveBlob(blob, filename);
                            } else {
                                let URL = window.URL || window.webkitURL;
                                let previewUrl = URL.createObjectURL(blob);
                                window.open(previewUrl, '_blank');
                            }

                        } catch (ex) {
                            console.log(ex);
                        }
                        successAlert('File tagihan terbuka pada tab baru');
                    }).fail(function (xhr) {
                        if (xhr.status === 422) {
                            const errMessage = xhr.responseJSON.message
                            errorAlert(errMessage)
                        } else if (xhr.status === 419) {
                            errorAlert('Sesi anda telah habis, Silahkan Login Kembali')
                        } else if (xhr.status === 403) {
                            errorAlert('Anda tidak memiliki izin untuk mengakses halaman ini')
                        } else if (xhr.status === 404) {
                            errorAlert('Halaman tidak ditemukan')
                        } else {
                            errorAlert('Terjadi kesalahan, silahkan coba memuat ulang halaman')
                        }
                    })
                }
            });

            if (select2.length) {
                select2.each(function () {
                    let $this = $(this);
                    $this.wrap('<div class="position-relative"></div>').select2({
                        placeholder: 'Select value',
                        dropdownParent: $this.parent()
                    });
                });
            }
        });

    </script>

    {!! ($modalLink??'') !!}
@endsection
