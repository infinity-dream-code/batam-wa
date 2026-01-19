@extends('layouts.admin_new')
@section('style')
    <link rel="stylesheet" href="{{asset('main/vendor/libs/select2/select2.css')}}">
    <link rel="stylesheet" href="{{asset('main/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('main/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('main/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css')}}">
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
        <div class="card-header">
            <div class="row mb-3">
                <h5 class="mb-0 me-2">{{($dataTitle??$mainTitle)}}</h5>
            </div>
            <form id="rekapForm">
                <div class="row">
                    <div class="mb-5">
                        <div class="row d-flex align-items-center">
                            <div class="col-3">
                                <label for="dari-tanggal">Tanggal Transaksi</label>
                            </div>
                            <div class="col">
                                <input type="text" id="tanggal-transaksi" name="filter[tanggal-transaksi]"
                                       placeholder="tanggal/bulan/tahun"
                                       class="form-control "/>
                            </div>
                        </div>
                    </div>
                    <div class="mb-5">
                        <div class="row d-flex align-items-center">
                            <div class="col-3">
                                <label class="form-label" for="status">
                                    Status
                                </label>
                            </div>
                            <div class="col">
                                <select class="form-select" id="status" name="status"
                                        data-control="select2"
                                        data-placeholder="Pilih Status Tagihan" required>
                                    <option value="all">Semua</option>
                                    <option value="paid">Dibayar</option>
                                    <option value="non_paid">Belum Dibayar</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-5">
                        <div class="row d-flex align-items-center">
                            <div class="col-3">
                                <label class="form-label" for="jenis">
                                    Jenis
                                </label>
                            </div>
                            <div class="col">
                                <select class="form-select" id="jenis" name="jenis"
                                        data-control="select2"
                                        data-placeholder="Pilih Jenis Tagihan" required>
                                    <option value="all">Semua</option>
                                    <option value="satuan">Satuan</option>
                                    <option value="cicilan">Cicilan</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-5">
                        <div class="row d-flex align-items-center">
                            <div class="col-3">
                                <label class="form-label" for="tahun_akademik">
                                    Tahun Akademik
                                </label>
                            </div>
                            <div class="col">
                                <select class="form-select" id="tahun_akademik"
                                        name="tahun_akademik"
                                        data-control="select2"
                                        data-placeholder="Pilih Tahun Akademik">
                                    <option></option>
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
                </div>
            </form>
        </div>
        <div class="card-footer border-0 pt-0">
            <div class="d-flex justify-content-end gap-4">
                <button type="button" class="btn btn-primary cari-tagihan">
                    <span class="ri-search-line me-2"></span>
                    Cari
                </button>
                <button type="button" class="btn btn-danger cetak-tagihan">
                    <span class="ri-money-cny-box-line me-2"></span>
                    Bayar
                </button>
            </div>
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
    <script src="{{asset('main/vendor/libs/select2/select2.js')}}"></script>
    <script src="{{asset('main/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
    <script src="{{asset('js/datatableCustom/Datatable0-2.js')}}"></script>
    <script src="{{asset('main/vendor/libs/moment/moment.js')}}"></script>
    <script src="{{asset('main/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js')}}"></script>

    <script type="text/javascript">
        let dataColumns = [];
        let dataTableInit;
        let dataUrl = '{{($datasUrl??null)}}';
        let columnUrl = '{{($columnsUrl??null)}}';
        let formId = '';
        let tableId = 'main_table';
        const select2 = $(`[data-control='select2']`);

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
                    $(`#${formId}`).on('input', 'input, select, textarea', function () {
                        dataReFilter(tableId, dataUrl, dataColumns, formId);
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
                        url: '{{route('admin.keuangan.penerimaan-siswa.data-penerimaan.cetak-tagihan-dibayar')}}',
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
                        let filename = "";
                        let disposition = xhr.getResponseHeader('Content-Disposition');

                        if (disposition) {
                            let filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                            let matches = filenameRegex.exec(disposition);
                            if (matches !== null && matches[1]) filename = matches[1].replace(/['"]/g, '');
                        }
                        let linkelem = document.createElement('a');
                        try {
                            let blob = new Blob([response], {type: 'application/octet-stream'});

                            if (typeof window.navigator.msSaveBlob !== 'undefined') {
                                //   IE workaround for "HTML7007: One or more blob URLs were revoked by closing the blob for which they were created. These URLs will no longer resolve as the data backing the URL has been freed."
                                window.navigator.msSaveBlob(blob, filename);
                            } else {
                                let URL = window.URL || window.webkitURL;
                                let downloadUrl = URL.createObjectURL(blob);

                                if (filename) {
                                    // use HTML5 a[download] attribute to specify filename
                                    let a = document.createElement("a");

                                    // safari doesn't support this yet
                                    if (typeof a.download === 'undefined') {
                                        window.location = downloadUrl;
                                    } else {
                                        a.href = downloadUrl;
                                        a.download = filename;
                                        document.body.appendChild(a);
                                        a.target = "_blank";
                                        a.click();
                                    }
                                } else {
                                    window.location = downloadUrl;
                                }
                            }

                        } catch (ex) {
                            console.log(ex);
                        }
                        Swal.close();
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
                    // select2Focus($this);
                    $this.wrap('<div class="position-relative"></div>').select2({
                        placeholder: 'Select value',
                        dropdownParent: $this.parent()
                    });
                });
            }
            let date = $('#tanggal-transaksi');
            date.daterangepicker({
                todayHighlight: true,
                autoclose: true,
                locale: {
                    format: 'DD-MM-YYYY',
                    separator: " - ",
                    applyLabel: "Terapkan",
                    cancelLabel: "Batal",
                    fromLabel: "Dari",
                    toLabel: "Ke",
                    customRangeLabel: "Kustom",
                    daysOfWeek: ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"],
                    monthNames: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
                    firstDay: 0
                },
                maxDate: moment()
            });
        });

    </script>

    {!! ($modalLink??'') !!}
@endsection
