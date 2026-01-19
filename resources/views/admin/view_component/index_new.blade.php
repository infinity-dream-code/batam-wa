@extends('layouts.admin_new')
@section('style')
    <link rel="stylesheet" href="{{asset('main/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('main/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
@endsection
@section('content')
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

    <div class="card">
        <div class="card-header header-elements">
            <h5 class="mb-0 me-2">{{($dataTitle??$mainTitle)}}</h5>
            <div class="card-header-elements ms-auto">
                <div class="w-100">
                    <div class="row">
                        <div class="d-flex justify-content-center justify-content-md-end gap-4">
                            @if(isset($btnModalImport))
                                <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#modal-import" title="Import Data">
                                    <span class="ri-upload-2-line me-2"></span>Import Data
                                </button>
                            @endif
                            @if(isset($btnModalExport))
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#modal-download" title="Download Data">
                                    <span class="ri-download-2-line me-2"></span>Download Data
                                </button>
                            @endif
                            @if(isset($btnModalCreate))
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#modal-create" title="Buat Data">
                                    <span class="ri-add-line me-2"></span>
                                    Buat Data
                                </button>
                            @endif
                            @if(isset($btnLinkImport))
                                <button type="button" class="btn btn-success" href="{{$btnLinkImport}}"
                                        title="Import Data">
                                    <span class="ri-upload-2-line me-2"></span>Import Data
                                </button>
                            @endif
                            @if(isset($btnLinkExport))
                                <button type="button" class="btn btn-primary" href="{{$btnLinkExport}}"
                                        title="Download Data">
                                    <span class="ri-download-2-line me-2"></span>Download Data
                                </button>
                            @endif
                            @if(isset($btnLinkCreate))
                                <button type="button" class="btn btn-primary" href="{{$btnLinkCreate}}"
                                        title="Buat Data">
                                    <span class="ri-add-line me-2"></span>
                                    Buat Data
                                </button>
                            @endif
                        </div>
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
    <script src="{{asset('js/datatableCustom/Datatable0-1.js')}}"></script>

    <script type="text/javascript">
        let dataColumns = [];
        let dataTableInit;
        let dataUrl = '{{($datasUrl??null)}}';
        let columnUrl = '{{($columnsUrl??null)}}';
        let formId = '';
        let tableId = 'main_table';

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
        });

    </script>

    {!! ($modalLink??'') !!}
@endsection
