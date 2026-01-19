@extends('layouts.admin')
@section('style')

@endsection
@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-gray-900 fw-bold flex-column justify-content-center my-0">
                        {{($dataTitle??($mainTitle??($title??'')))}}
                    </h1>
                    <ul class="breadcrumb breadcrumb-dot fw-semibold my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="/" class="text-muted text-hover-primary">Beranda</a>
                        </li>
                        @if(isset($title))
                            <li class="breadcrumb-item text-muted">
                                <span class="text-muted">{{$title}}</span>
                            </li>
                        @endif
                        @if(isset($mainTitle))
                            <li class="breadcrumb-item text-muted">
                                <span class="text-muted">{{$mainTitle}}</span>
                            </li>
                        @endif
                        @if(isset($dataTitle) && isset($mainTitle) && $mainTitle != $dataTitle)
                            <li class="breadcrumb-item text-muted">
                                <span class="text-muted">{{$dataTitle}}</span>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>

        </div>


        <div id="kt_app_content" class="app-content flex-column-fluid">

            <div id="kt_app_content_container" class="app-container container-fluid">
                <div class="card">
                    <div class="card-header border-0 pt-6">
                        <div class="card-title">
                            <div class="d-flex align-items-center position-relative my-1">
                                <i class="ki-solid ki-magnifier fs-3 position-absolute ms-5">
                                </i>
                                <input type="text" data-kt-docs-table-filter="search"
                                       class="form-control form-control-solid w-250px ps-12"
                                       placeholder="Cari"/>
                            </div>
                        </div>
                        <div class="card-toolbar">
                            <div class="d-flex justify-content-end gap-2 gap-lg-3"
                                 data-kt-customer-table-toolbar="base">
                                <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#modal-import">
                                    <i class="ki-solid ki-file-up"></i>
                                    Import Data
                                </button>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#modal-create">
                                    <i class="ki-solid ki-add-files"></i>
                                    Create Data
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <table
                            class="table align-middle table-row-dashed table-hover table-bordered table-striped fs-6 gy-5"
                            id="main_table">
                            <thead>

                            </thead>
                            <tbody class="fw-semibold text-gray-600">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{asset('js/datatableGatotTesting.js')}}"></script>

    <script type="text/javascript">
        let dataColumns = [];
        let dataTableInit;
        let dataUrl = '{{($datasUrl??null)}}';
        let columnUrl = '{{($columnsUrl??null)}}';
        let formId = '';
        let tableId = 'main_table';

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
        });

    </script>

    {!! ($modalLink??'') !!}
@endsection
