@extends('layouts.admin_new')
@section('style')
    <link rel="stylesheet" href="{{asset('main/vendor/libs/select2/select2.css')}}">
    <link rel="stylesheet" href="{{asset('main/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('main/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('main/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css')}}">

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
                                <div class="row d-flex align-items-center">
                                    <label class="form-label" for="nama">
                                        Pilih Tanggal
                                    </label>
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="Dari Tanggal" name="dari_tanggal" value="" id="dari-tanggal"/>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="Sampai Tanggal" name="sampai_tanggal" value="" id="sampai-tanggal"/>
                                    </div>
                                    <div class="invalid-feedback" role="alert"></div>
                                </div>
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
    <script src="{{asset('main/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js')}}"></script>

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

        function clearErrorMessages(formId) {
            const form = document.querySelector(`#${formId}`);
            const errorElements = form.querySelectorAll('.invalid-feedback');
            const errorClass = form.querySelectorAll('.is-invalid');

            errorElements.forEach(element => element.textContent = '');
            errorClass.forEach(element => element.classList.remove('is-invalid'));
        }

        function processErros(errors){
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
            $("#dari-tanggal").datepicker({
                format: "yyyy-mm-dd",
                autoclose: true,
                language: 'id'
            });
            $("#sampai-tanggal").datepicker({
                format: "yyyy-mm-dd",
                autoclose: true,
                language: 'id'
            });

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
                    $('#kelas-select').empty().append('<option value="">Pilih Kelas</option>').prop('disabled', true);
                }
            });

            if (dataUrl && columnUrl) {
                getDT(tableId, columnUrl, dataUrl, dataColumns, formId, true);
                if (formId) {
                    let filterForm = $(`#${formId}`);
                    filterForm.on('submit', function (e) {
                        e.preventDefault();

                        var dariTanggal = $('#dari-tanggal').val();
                        var sampaiTanggal = $('#sampai-tanggal').val();
                        
                        if (dariTanggal != '' && sampaiTanggal == '') {
                            warningAlert("isilah sampai tanggal")
                        }else if (dariTanggal == '' && sampaiTanggal != '') {
                            warningAlert("isilah dari tanggal")
                        }
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

    {{-- {!! ($modalLink??'') !!} --}}
@endsection
