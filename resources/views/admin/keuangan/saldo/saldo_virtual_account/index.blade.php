@extends('layouts.admin_new')
@section('style')
    <link rel="stylesheet" href="{{asset('main/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('main/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('main/vendor/libs/datatables-fixedheader-bs5/fixedheader.bootstrap5.css')}}">
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
        <div class="card-header header-elements">
            <h5 class="mb-0 me-2">{{($dataTitle??$mainTitle)}}</h5>
            <div class="card-header-elements ms-auto">
                <div class="w-100">
                    <div class="row">
                        <div class="d-flex justify-content-center justify-content-md-end gap-4">
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#modal-tarik" title="Buat Data">
                                <span class="ri-add-line me-2"></span>
                                Tarik Manual
                            </button>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#modal-create" title="Buat Data">
                                <span class="ri-add-line me-2"></span>
                                Top Up Manual
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form id="filterForm">
                <fieldset class="form-fieldset">
                    <h5>Filter</h5>
                    <div class="row row-cols-lg-2 row-cols-1">
                        <div class="col mb-5">
                            <label class="form-label" for="tahun_akademik">
                                Tahun Akademik
                            </label>
                            <select class="form-select" id="tahun_akademik"
                                    name="filter[tahun_akademik]"
                                    data-control="select2"
                                    data-placeholder="Pilih Tahun Akademik">
                                <option value="all">Semua</option>
                                @isset($angkatan)
                                    @foreach($angkatan as $item)
                                        <option
                                            value="{{$item->id}}">{{$item->thn_aka}}</option>
                                    @endforeach
                                @else
                                    <option>data kosong</option>
                                @endisset
                            </select>
                        </div>
                        <div class="col mb-5">
                            <label class="form-label" for="kelas">
                                Kelas
                            </label>
                            <select class="form-select" id="kelas" name="filter[kelas]"
                                    data-control="select2" data-placeholder="Pilih Kelas">
                                <option value="all">Semua</option>
                                @isset($kelas)
                                    @foreach($kelas as $item)
                                        <option
                                            value="{{$item->id}}">{{$item->kelas}} {{$item->kelompok}}</option>
                                    @endforeach
                                @else
                                    <option>data kosong</option>
                                @endisset
                            </select>
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
    <script src="{{asset('main/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
    <script src="{{asset('js/datatableCustom/Datatable0-2.js')}}"></script>
    <script src="{{asset('main/vendor/libs/select2/select2.js')}}"></script>
    <script src="{{asset('main/vendor/libs/select2/id.min.js')}}"></script>

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
