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

    <form class="mainForm" id="form-setting">
        @csrf
        <div class="card">
            <div class="card-header">
                <div class="row mb-3">
                    <h5 class="mb-0 me-2">{{($dataTitle??$mainTitle)}}</h5>
                </div>
            </div>
            <div class="card-body">
                <fieldset class="form-fieldset">
                    <div class="row">
                        <div class="col-md mb-md-0 mb-5">
                            <div class="form-check custom-option custom-option-icon h-100 {{$setting == 0?'checked':''}}">
                                <label class="form-check-label custom-option-content" for="customRadioTemp1">
                                    <span class="custom-option-body">
                                      <i class="ri-close-line"></i>
                                      <span class="custom-option-title mb-2">Tidak Aktif</span>
                                      <small>Tidak akan secara otomatis memotong saldo.</small>
                                    </span>
                                    <input name="setting" class="form-check-input" type="radio" value="0"
                                           id="customRadioTemp1" {{$setting == 0?'checked':''}}>
                                </label>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-check custom-option custom-option-icon h-100 {{$setting == 1?'checked':''}}">
                                <label class="form-check-label custom-option-content" for="customRadioTemp2">
                                    <span class="custom-option-body">
                                      <i class="ri-check-line"></i>
                                      <span class="custom-option-title mb-2">Aktif</span>
                                      <small>Secara Otomatis memotong saldo siswa jika mencukupi untuk membayarkan tagihan yang ada.</small>
                                    </span>
                                    <input name="setting" class="form-check-input" type="radio" value="1"
                                           id="customRadioTemp2" {{$setting == 1?'checked':''}}>
                                </label>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="card-footer border-0 pt-0">
                <div class="d-flex justify-content-end gap-4">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#modal-confirm" class="btn btn-primary cari-tagihan">
                        <span class="ri-save-line me-2"></span>
                        Simpan
                    </button>
                </div>
            </div>
        </div>
        <div class="modal modal-blur fade" id="modal-confirm" tabindex="-1" role="dialog" aria-hidden="true"
             data-bs-backdrop="static">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-status bg-danger"></div>
                    <div class="modal-header ">
                        <div class="modal-title">
                            Setting Auto Bayar VA
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body py-4">
                        <div class="row mb-3 text-center">
                            <span class="ri-settings-line ri-48px"></span>
                            <div class="pt-3">
                                Anda yakin ingin mengganti pengaturan auto bayar VA?
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer ">
                        <div class="w-100">
                            <div class="row">
                                <div class="col">
                                    <input type="button" class="btn btn-outline-secondary w-100" value="Batal"
                                           data-bs-dismiss="modal">
                                </div>
                                <div class="col">
                                    <input type="submit" value="Ganti" class="btn btn-warning w-100">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
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
        let formAction = $('#form-setting');
        let tableId = 'main_table';
        const select2 = $(`[data-control='select2']`);
        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        function submitForm(){
            let values = formAction.serialize();
            console.log(values);
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
            formAction.on('submit',function (e){
                e.preventDefault();
                let url =  '{{route('admin.setting-auto-bayar.store')}}';
                let tipe = 'POST'
                const formId = $(this).attr('id');
                let data = $(this).serialize();

                let ajaxOptions = {
                    url: url,
                    type: tipe,
                    data: data,
                    datatype: 'json',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                    },
                }

                // console.log(ajaxOptions)
                clearErrorMessages(formId)
                $.ajax(ajaxOptions).done(function (responses) {
                    successAlert(responses.message);
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
        });

    </script>

    {!! ($modalLink??'') !!}
@endsection
