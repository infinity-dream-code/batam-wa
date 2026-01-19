@extends('layouts.admin_new')
@section('style')
    <link rel="stylesheet" href="{{asset('main/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('main/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('main/vendor/libs/datatables-fixedheader-bs5/fixedheader.bootstrap5.css')}}">
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
                    <a href="{{ route('admin.index') }}" class="text-hover-primary">Beranda</a>
                </li>

                @isset($title)
                    <li class="breadcrumb-item">{{ $title }}</li>
                @endisset

                @isset($mainTitle)
                    <li class="breadcrumb-item">{{ $mainTitle }}</li>
                @endisset

                @if(isset($dataTitle) && isset($mainTitle) && $mainTitle !== $dataTitle)
                    <li class="breadcrumb-item {{$showTitle??'active'}}">
                        @if(isset($indexUrl))
                            <a href="{{ $indexUrl }}" class="text-hover-primary">{{ $dataTitle }}</a>
                        @else
                            {{ $dataTitle }}
                        @endif
                    </li>

                    @isset($showTitle)
                        <li class="breadcrumb-item active">{{ $showTitle }}</li>
                    @endisset
                @endif
            </ul>
        </div>
        <div class="col">
            <div class="col-auto ms-auto d-print-none">
                <div class="d-flex justify-content-end">
                    <a href="{{route('admin.keuangan.saldo.saldo-virtual-account.index')}}"
                       class="btn btn-outline-primary">
                        <span class="ri-arrow-left-s-line me-2"></span>
                        Kembali ke Saldo VA
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header header-elements">
            <h5 class="mb-0 me-2">{{($dataTitle??$mainTitle)}}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="info-container">
                        <ul class="list-unstyled mb-3">
                            <li class="mb-2">
                                <span class="fw-medium text-heading me-2">Nis:</span>
                                <span>{{$siswa->nis??''}}</span>
                            </li>
                            <li class="mb-2">
                                <span class="fw-medium text-heading me-2">Nama:</span>
                                <span>{{$siswa->nama??''}}</span>
                            </li>
                            <li class="mb-2">
                                <span class="fw-medium text-heading me-2">Kelas:</span>
                                <span>{{$siswa->kelas??''}} {{$siswa->kelompok??''}}</span>
                            </li>
                            <li class="mb-2">
                                <span class="fw-medium text-heading me-2">Angkatan:</span>
                                <span>{{$siswa->thn_aka??''}}</span>
                            </li>
                            <li class="mb-2">
                                <span class="fw-medium text-heading me-2">Nomor Virtual Account:</span>
                                <span>{{$siswa->nova??''}}</span>
                            </li>

                        </ul>
                    </div>
                </div>
                <div class="col">
                    <div class="row px-3 fw-medium text-heading me-2">
                        Total Saldo:
                    </div>
                    <div class="row px-3 ">
                        @rupiah($siswa->saldo??0)
                    </div>
                </div>
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
    <script src="{{asset('main/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
    <script src="{{asset('js/datatableCustom/Datatable0-2.js')}}"></script>

    <script type="text/javascript">
        let dataColumns = [];
        let dataTableInit;
        let dataUrl = '{{($datasUrl??null)}}';
        let columnUrl = '{{($columnsUrl??null)}}';
        let formId = 'filterForm';
        let tableId = 'main_table';

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
        });

    </script>

    {!! ($modalLink??'') !!}
@endsection
