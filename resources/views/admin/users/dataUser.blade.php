@extends('layouts.admin')
@section('style')
    {{--    <link rel="stylesheet" href="{{asset('libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}">--}}
    {{--    <link rel="stylesheet" href="{{asset('css/table-datatable-jquery.css')}}">--}}
@endsection
@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-gray-900 fw-bold flex-column justify-content-center my-0">
                        Manajemen User
                    </h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="#" class="text-muted text-hover-primary">Manajemen User</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Manajemen User</li>
                    </ul>
                </div>

                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <div class="m-0">
                        <a href="#" class="btn btn-flex btn-secondary fw-bold" data-kt-menu-trigger="click"
                           data-kt-menu-placement="bottom-end">
                            <i class="ki-duotone ki-filter fs-6 text-muted me-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            Filter
                        </a>
                        <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true"
                             id="kt_menu_64b7761ae92af">
                            <div class="px-7 py-5">
                                <div class="fs-5 text-dark fw-bold">Filter Options</div>
                            </div>
                            <div class="separator border-gray-200"></div>
                            <div class="px-7 py-5">
                                <div class="mb-10">
                                    <label class="form-label fw-semibold">Status:</label>
                                    <div>
                                        <select class="form-select form-select-solid" multiple="multiple"
                                                data-kt-select2="true" data-close-on-select="false"
                                                data-placeholder="Select option"
                                                data-dropdown-parent="#kt_menu_64b7761ae92af"
                                                data-allow-clear="true">
                                            <option></option>
                                            <option value="1">Approved</option>
                                            <option value="2">Pending</option>
                                            <option value="2">In Process</option>
                                            <option value="2">Rejected</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-10">
                                    <label class="form-label fw-semibold">Member Type:</label>
                                    <div class="d-flex">
                                        <label
                                            class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                            <input class="form-check-input" type="checkbox" value="1"/>
                                            <span class="form-check-label">Author</span>
                                        </label>
                                        <label class="form-check form-check-sm form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" value="2"
                                                   checked="checked"/>
                                            <span class="form-check-label">Customer</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-10">
                                    <label class="form-label fw-semibold">Notifications:</label>
                                    <div
                                        class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value=""
                                               name="notifications" checked="checked"/>
                                        <label class="form-check-label">
                                            Enabled
                                        </label>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="reset" class="btn btn-sm btn-light btn-active-light-primary me-2"
                                            data-kt-menu-dismiss="true">
                                        Reset
                                    </button>
                                    <button type="submit" class="btn btn-sm btn-primary"
                                            data-kt-menu-dismiss="true">
                                        Apply
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="#" class="btn fw-bold btn-primary" data-bs-toggle="modal"
                       data-bs-target="#kt_modal_create_app">
                        Create
                    </a>
                </div>

            </div>

        </div>


        <div id="kt_app_content" class="app-content flex-column-fluid">

            <div id="kt_app_content_container" class="app-container container-fluid">
                <div class="card">
                    <div class="card-header border-0 pt-6">
                        <div class="card-title">
                            <div class="d-flex align-items-center position-relative my-1">
                                <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <input type="text" data-kt-docs-table-filter="search"
                                       class="form-control form-control-solid w-250px ps-12"
                                       placeholder="Cari"/>
                            </div>
                        </div>
                        <div class="card-toolbar">
                            <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_add_customer">Add Customer
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <table class="table table-striped table-row-bordered gy-5 gs-7" id="kt_customers_table">
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

    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">

                    <div class="page-pretitle">
                        Manajemen Pengguna {{Auth::id()}}
                    </div>
                    <h2 class="page-title">
                        Manajemen Data Pengguna
                    </h2>
                </div>


                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <div class="btn-list">
                            <a href="#" class="btn btn-green d-none d-sm-inline-block" data-bs-toggle="modal"
                               data-bs-target="#modal-import">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="icon icon-tabler icon-tabler-file-spreadsheet" width="24" height="24"
                                     viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                                    <path
                                        d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                                    <path d="M8 11h8v7h-8z"></path>
                                    <path d="M8 15h8"></path>
                                    <path d="M11 11v7"></path>
                                </svg>
                                Upload Excel
                            </a>
                            <a href="#" class="btn btn-green d-sm-none btn-icon" data-bs-toggle="modal"
                               data-bs-target="#modal-import" aria-label="Create new report">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="icon icon-tabler icon-tabler-file-spreadsheet" width="24" height="24"
                                     viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                                    <path
                                        d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                                    <path d="M8 11h8v7h-8z"></path>
                                    <path d="M8 15h8"></path>
                                    <path d="M11 11v7"></path>
                                </svg>
                            </a>
                            <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal"
                               data-bs-target="#modal-create">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                     viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M12 5l0 14"/>
                                    <path d="M5 12l14 0"/>
                                </svg>
                                Tambah Admin Baru
                            </a>
                            <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal"
                               data-bs-target="#modal-create" aria-label="Create new report">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                     viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M12 5l0 14"/>
                                    <path d="M5 12l14 0"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.users.modal.modalUser')

@endsection

@section('script')
    {{--    <script src="{{asset('libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>--}}
    {{--    <script src="{{asset('libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js')}}"></script>--}}
    <script src="{{asset('js/datatableGatotTesting.js')}}"></script>

    <script type="text/javascript">
        let dataColumns = [];
        let dataTableInit;
        let dataUrl = '{{($datasUrl??null)}}';
        let columnUrl = '{{($columnsUrl??null)}}';
        let formId = '';
        let tableId = 'kt_customers_table';

        function triggerCancelBtn(id) {
            $('#input-name-' + id).addClass('d-none');
            $('#view-name-' + id).removeClass('d-none');

            $('#input-username-' + id).addClass('d-none');
            $('#view-username-' + id).removeClass('d-none');

            $('#btn-save-' + id).addClass('d-none');

            $('#btn-cancel-' + id).addClass('d-none');
        }

        function triggerEditBtn(id) {

            $('#view-name-' + id).addClass('d-none');
            $('#input-name-' + id).removeClass('d-none');

            $('#view-username-' + id).addClass('d-none');
            $('#input-username-' + id).removeClass('d-none');

            $('#btn-save-' + id).removeClass('d-none');

            $('#btn-cancel-' + id).removeClass('d-none');

        }

        function triggerSave(id) {
            let serializedData = $('.form-control[data-id="' + id + '"]').serializeArray();
            loadingAlert();
            var uri = "{{ route('admin.users.update', ':id') }}";
            uri = uri.replace(':id', id);
            $.ajax({
                url: uri,
                type: "PUT",
                cache: false,
                data: serializedData,
                datatype: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('input[name=_token]').val()
                }
            }).done(function (responses) {
                successAlert(responses.message);
                dataReload();
            }).fail(function (xhr) {
                if (xhr.status === 422) {
                    const errors = JSON.parse(xhr.responseText).error
                    const errMessage = xhr.responseJSON.message
                    const idData = JSON.parse(xhr.responseText).id
                    // const idMessage = xhr.responseJSON.id
                    errorAlert(errMessage)
                    for (const [key, value] of Object.entries(errors)) {
                        // console.log(key + ': ', value[0]);
                        const field = $(`[data-id="${idData}"][name="${key}"]`);
                        field.addClass('is-invalid');
                        field.next('.invalid-feedback').html(value[0]);

                        if (key === 'password') {
                            const confirm = $(`[name="${key + '_confirmation'}"]`);
                            confirm.addClass('is-invalid');
                        }
                    }
                } else {
                    errorAlert('terjadi masalah saat menghubungkan ke server, Silahkan coba memuat ulang halaman')
                }
            })

        }

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

                const filterSearch = document.querySelector('[data-kt-docs-table-filter="search"]');

                $('[data-kt-docs-table-filter="search"]').on('keyup', function (e) {
                    $(`#${tableId}`).DataTable().search($(this).val()).draw();
                });
            }

            $(document).on('click', '.editBtn', function () {
                let idButton = $(this).attr('data-id');
                triggerEditBtn(idButton);
            });
            $(document).on('click', '.cancelBtn', function () {
                let idButton = $(this).attr('data-id');
                triggerCancelBtn(idButton);
            });


        });


    </script>
@endsection
