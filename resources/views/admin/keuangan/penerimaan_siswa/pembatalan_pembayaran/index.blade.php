@extends('layouts.admin_new')
@section('style')
    <link rel="stylesheet" href="{{asset('main/vendor/libs/select2/select2.css')}}">

    <link rel="stylesheet" href="{{asset('main/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('main/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('main/vendor/libs/datatables-select-bs5/select.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('main/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css')}}">

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

    <form class="mainForm" id="bayar-form" action="#">
        <div class="card mb-6">
            <meta name="csrf-token" content="{{ csrf_token() }}" xmlns="http://www.w3.org/1999/html">

            <div class="card-header header-elements">
                <h5 class="mb-0 me-2">{{$dataTitle}}</h5>
            </div>
            <div class="card-body py-0">
                <div class="row">
                    <div class="col-12">
                        <div class="mb-5">
                            <label class="required form-label" for="siswa">
                                Siswa
                            </label>
                            <select class="form-select" id="siswa" name="siswa"
                                    data-control="select2-ajax-siswa" data-placeholder="Pilih Siswa">
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer border-0 pt-0">
                <div class="w-100">
                    <div class="row">
                        <div class="d-flex justify-content-center justify-content-md-end gap-3">
                            <button type="reset" class="btn btn-secondary">
                                <span class="ri-reset-left-line me-2"></span>
                                Reset
                            </button>
                            <button type="button" class="btn btn-primary cari-tagihan ">
                                <span class="ri-search-line me-2"></span>
                                Cari
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-datatable table-responsive text-nowrap">
                <table class="table table-sm table-hover table-bordered" id="main_table">
                    <thead class="table-light">
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="card-footer border-0">
                <div class="w-100">
                    <div class="row">
                        <div class="d-flex justify-content-center justify-content-md-end gap-3">

                            <button type="button" class="btn btn-warning button-open-confirm"
                                    title="Batalkan Pembayaran">
                                <span class="ri-cash-line me-2"></span>
                                Batalkan Pembayaran
                            </button>
                        </div>
                    </div>
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
                            Batalkan Pembayaran Tagihan
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-capitalize text-center py-4">

                        <i class="ri-refund-2-line ri-48px"></i>
                        <h4>Batalkan Pembayaran Tagihan?</h4>
                        <div class="">
                            anda yakin akan Batalkan Pembayaran Tagihan?
                        </div>
                    </div>
                    <div class="modal-footer ">
                        <div class="w-100">
                            <div class="row">
                                <div class="col">
                                    <button type="button" class="btn btn-outline-secondary w-100" value="Tutup"
                                            data-bs-dismiss="modal">Tutup</button>
                                </div>
                                <div class="col">
                                    <input type="submit" value="Batalkan" class="btn btn-warning w-100">
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

    <script type="text/javascript">
        let dataColumns = [];
        let dataTableInit;
        let dataUrl = '{{($datasUrl??null)}}';
        let columnUrl = '{{($columnsUrl??null)}}';
        let formId = '';
        let formClass = $('.mainForm');
        let tableId = 'main_table';
        const select2 = $(`[data-control='select2']`);
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        let maxBayar = 0;
        let select2Param = '';
        let tableTagihan;

        let currentDate = new Date();
        let day = currentDate.getDate().toString().padStart(2, '0');
        let month = (currentDate.getMonth() + 1).toString().padStart(2, '0');
        let year = currentDate.getFullYear();
        let formattedDate = day + '/' + month + '/' + year;

        function clearErrorMessages(formId) {
            const form = document.querySelector(`#${formId}`);
            const errorElements = form.querySelectorAll('.invalid-feedback');
            const errorClass = form.querySelectorAll('.is-invalid');

            errorElements.forEach(element => element.textContent = '');
            errorClass.forEach(element => element.classList.remove('is-invalid'));
        }


        function alertSubmit() {
            Swal.fire({
                text: 'Anda yakin akan membatalkan pembayaran?',
                icon: "success",
                buttonsStyling: false,
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tutup',
                customClass: {
                    confirmButton: 'swal2-confirm-btn',
                    cancelButton: 'swal2-cancel-btn',
                },
                reverseButtons: true
            }).then(function (result) {
                if (result.value) {
                    submitBatal();
                }
            });
        }

        function submitBatal() {

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

        function refreshDataTable(newData = []) {
            tableTagihan.rows().deselect();
            tableTagihan.clear();
            tableTagihan.rows.add(newData);
            tableTagihan.draw();
            // newData.length === 0 ? '' : $('.select-all').prop('checked', true);
        }


        function getTagihan(id) {
            let url = '{{route('admin.keuangan.penerimaan-siswa.batal-bayar.get-tagihan')}}';
            let ajaxOptions = {
                url: url,
                type: 'get',
                datatype: 'json',
                data: {
                    'siswa': id,
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                },
            }

            $.ajax(ajaxOptions).done(function (response) {
                refreshDataTable(response);
            }).fail(function (xhr) {
                if (xhr.status === 422) {
                    errorAlert('Gagal mendapat data siswa')
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
        }

        document.addEventListener("DOMContentLoaded", function () {
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

            tableTagihan = $('#main_table').DataTable({
                columns: [
                    {data: 'id'},
                    {data: 'nama_tagihan', title: 'Nama Tagihan'},
                    {data: 'amount_tagihan', title: 'Nominal'},
                    {data: 'tanggal_bayar', title: 'Tanggal Bayar'},
                ],
                columnDefs: [
                    {
                        targets: 0,
                        searchable: false,
                        orderable: false,
                        render: function (data) {
                            return `<input type="checkbox" id="tagihan-checkbox-${data}" class="dt-checkboxes form-check-input" name="tagihan[]" value="${data}">`;
                        },
                        checkboxes: {
                            selectRow: true,
                            selectAllRender: '<input id="tagihan-checkbox" name="tagihan-checkbox" type="checkbox" class="form-check-input select-all">'
                        },
                        className: 'text-center',
                    }, {
                        targets: 2,
                        render: function (data) {
                            if (data === null || data === 0) {return 'Rp. 0';}return $.fn.dataTable.render.number('.', ',', 0, 'Rp. ').display(data);
                        },
                    }
                ],
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/2.0.6/i18n/id.json',
                    emptyTable: "Siswa ini tidak memiliki tagihan yang sudah dibayar"
                },
                paging: true,
                serverSide: false,
                searching: false,
                lengthChange: false,
                pageLength: 10,
                order: [[1, 'desc']],
                select: {
                    style: 'multi'
                },
                scrollY: '300px',
                scrollX: true,
            });

            $(document).on('click', '.cari-tagihan', function (e) {
                let Siswa = $('#siswa').val();
                if (Siswa) {
                    getTagihan(Siswa);
                    $('#total_tagihan').val('');
                } else {
                    warningAlert('Silahkan Pilih Siswa!');
                }
            });

            $(document).on('click', '.button-open-confirm', function (e) {
                let count = $('input[name^="tagihan"]:checked').length;
                let Siswa = $('#siswa').val();
                if (!Siswa) {
                    warningAlert('Silahkan pilih siswa!');
                    return;
                }
                if (count < 1) {
                    warningAlert('Silahkan pilih tagihan yang akan dibatalkan pembayarannya!');
                    return;
                }
                $('#modal-confirm').modal('show');
            });

            $(document).on('keypress', '.formattedNumber', function (e) {
                const charCode = e.which ? e.which : e.keyCode;
                if (charCode < 48 || charCode > 57) {
                    e.preventDefault();
                }
            });

            $(document).on('input', '.formattedNumber', function (e) {
                const formattedValue = $(this).val();
                let parsedNumber = parseInt(formattedValue.replace(/\./g, ''));
                if (parsedNumber > maxBayar) {
                    parsedNumber = maxBayar;
                }
                if (!isNaN(parsedNumber)) {
                    const formattedString = parsedNumber.toLocaleString('id-ID');
                    $(this).val(formattedString);
                }
            });

            $('[data-control="select2-ajax-siswa"]').select2({
                placeholder: $(this).data('placeholder'),
                ajax: {
                    url: '{{ route('admin.master-data.data-siswa.get-siswa-select2') }}',
                    dataType: 'json',
                    delay: 300,
                    data: function (params) {
                        select2Param = params.term;
                        return {
                            term: params.term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                }, language: {
                    inputTooShort: function () {
                        return "Masukkan NIS atau Nama Siswa";
                    }, noResults: function () {
                        let w = $.isNumeric(select2Param) ? 'NIS' : 'Nama';
                        return "Siswa dengan " + w + ": <span class='bg-label-danger'><b>" + select2Param + "</b></span> tidak ditemukan!";
                    }, searching: function () {
                        return "Mencari Siswa ......"
                    }
                }, escapeMarkup: function (markup) {
                    return markup;
                }, minimumInputLength: 4,
            }).on('select2:selecting', function (e) {
                if (e.params.args.data.id === '') {
                    e.preventDefault();
                }
            });

            formClass.on('submit', function (e) {
                e.preventDefault()
                loadingAlert();
                let url = '{{route('admin.keuangan.penerimaan-siswa.batal-bayar.batal')}}';
                let tipe = 'POST';
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

                try {
                    let count = $('input[name^="tagihan"]:checked').length;
                    let Siswa = $('#siswa').val();
                    if (!Siswa) {
                        warningAlert('Silahkan pilih siswa!');
                        return;
                    }
                    if (count < 1) {
                        warningAlert('Silahkan pilih tagihan yang akan dibatalkan pembayarannya!');
                        return;
                    }
                    clearErrorMessages(formId)
                    $.ajax(ajaxOptions).done(function (responses) {
                        successAlert(responses.message)
                        $("#" + $(e.target).attr('id')).find('[data-bs-dismiss="modal"]').trigger('click')
                        document.getElementById(formId).reset();
                        select2.each(function () {
                            $(this).trigger('change');
                        })
                        $('#main_table tbody tr').remove();
                        refreshDataTable();
                    }).fail(function (xhr) {
                        $("#" + $(e.target).attr('id')).find('[data-bs-dismiss="modal"]').trigger('click')
                        if (xhr.status === 422) {
                            const { error, errors, message } = JSON.parse(xhr.responseText);
                            const errMessage = message || xhr.responseJSON?.message;
                            errorAlert(errMessage);
                            processErros(error || errors);
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
                } catch (e) {
                    errorAlert('terjadi error pada halaman, silahkan muat ulang');
                }
            })
        });
    </script>

    {!! ($modalLink??'') !!}
@endsection
