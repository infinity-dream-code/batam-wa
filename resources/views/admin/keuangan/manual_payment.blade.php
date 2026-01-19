@extends('layouts.admin_new')
@section('style')
    <link rel="stylesheet" href="{{asset('main/vendor/libs/select2/select2.css')}}">
    <link rel="stylesheet" href="{{asset('main/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css')}}">

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
                <h5 class="mb-0 me-2">{{$mainTitle}}</h5>
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
                    <div class="col-12">
                        <div class="mb-5">
                            <label class="required form-label" for="saldo">
                                Saldo
                            </label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text">Rp. </span>
                                <input readonly type="text" id="saldo" name="saldo"
                                       placeholder="Saldo"
                                       class="form-control"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-5">
                            <label class="form-label" for="tanggal">Tanggal Bayar</label>
                            <input type="text" id="tanggal" name="tanggal" placeholder="tanggal/bulan/tahun"
                                   class="form-control"/>
                        </div>
                        <div class="mb-5">
                            <label class="form-label" for="bank">Bank</label>
                            <select type="text" id="bank" name="bank" class="form-select"
                                    data-control="select2" data-placeholder="Bank">
                                <option value="1140000">Manual Cash</option>
                                <option value="1140001">Manual BMI</option>
                                <option value="1140002">Manual Saldo</option>
                                <option value="1140003">Transfer Bank Lain</option>
                                <option value="1140004">INFAQ</option>
                                <option value="1200001">Loket Manual - Beasiswa</option>
                                <option value="1200002">Loket Manual - Potongan</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-5">
                            <label class="form-label" for="total_tagihan">Total Tagihan</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text">Rp. </span>
                                <input readonly type="text" id="total_tagihan" name="total_tagihan"
                                       placeholder="Total Tagihan"
                                       class="form-control formattedNumber"/>
                            </div>
                        </div>
                        <div class="mb-5">
                            <label class="form-label" for="total_bayar">Nominal Bayar</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text">Rp. </span>
                                <input type="text" id="total_bayar" inputmode="number" name="total_bayar"
                                       placeholder="Nominal Bayar"
                                       class="form-control formattedNumber rounded-end"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer border-0 pt-0">
                <div class="d-flex">
                    <div class="ms-auto gap-6">
                        <button type="button" class="btn btn-primary cari-tagihan ">
                            <span class="ri-search-line me-2"></span>
                            Cari
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-datatable table-responsive text-nowrap">
                <table class="table table-sm table-striped table-bordered table-hover"
                       id="main_table">
                    <thead class="table-light">
                    <tr>
                        <th></th>
                        <th>NIS</th>
                        <th>NO. DAFTAR</th>
                        <th>Kelas</th>
                        <th>NO. VA</th>
                        <th>NAMA</th>
                        <th>Nama Post</th>
                        <th>Nama Tagihan</th>
                        <th>Urutan</th>
                        <th>Cicil</th>
                        <th>Nominal</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="text-center" colspan="12">Silahkan Pilih Siswa</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer border-0">
                <div class="w-100">
                    <div class="row">
                        <div class="d-flex justify-content-center justify-content-md-end gap-4">
                            <button type="button" class="btn btn-danger cetak-tagihan">
                                <span class="ri-file-pdf-2-line me-2"></span>
                                Pratinjau
                            </button>
                            <button type="submit" class="btn btn-success">
                                <span class="ri-cash-line me-2"></span>
                                Bayar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('script')
    <script src="{{asset('main/vendor/libs/select2/select2.js')}}"></script>
    <script src="{{asset('main/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js')}}"></script>


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

        function fieldTagihan(data) {
            let tagihan = data.total_tagihan ?? 0;
            tagihan = tagihan.toLocaleString('id-ID');
            let post = `
                <td>
                    <input class="form-check-input row-checkbox" type="checkbox" value="${data.id}" data-tagihan="${data.total_tagihan}" name="tagihan[${data.id}][post]"/>
                </td>
            `;

            let nis = `<td>${data.nis}</td>`;
            let no_daftar = `<td>${data.no_daftar ?? '-'}</td>`;
            let kelas = `<td>${data.kelas ?? '-'}</td>`;
            let nova = `<td>${data.nova ?? '-'}</td>`;
            let nama_siswa = `<td>${data.nama_siswa}</td>  `;
            let nama_post = ` <td>${data.nama_post}</td> `;
            let nama_tagihan = `<td>${data.nama_tagihan ?? '-'}</td> `;
            let urutan = `<td>${data.FUrutan ?? '-'}</td> `;
            let cicil = ` <td>${data.cicil ? '<span class="badge rounded-pill bg-label-success" text-capitalized="">Ya</span>' : '<span class="badge rounded-pill bg-label-warning" text-capitalized="">Tidak</span>'}</td>`;
            let nominal = ` <td> ${tagihan}</td>`;

            return post + nis + no_daftar + kelas + nova + nama_siswa + nama_post + nama_tagihan + urutan + cicil + nominal;
        }

        function AlertPrint() {
            Swal.fire({
                text: 'Tagihan sukses dibayar, apakah anda ingin mencetak tagihan?',
                icon: "success",
                buttonsStyling: false,
                showCancelButton: true,
                confirmButtonText: 'Cetak Bukti Bayar',
                cancelButtonText: 'Tutup',
                customClass: {
                    confirmButton: "btn btn-outline-success",
                    cancelButton: "btn btn-outline-secondary"
                },
            }).then(function (result) {
                if (result.value) {
                    printPaidTagihan();
                }
            });
        }

        function printPaidTagihan() {
            let url = '{{route('admin.keuangan.pembayaran-manual.cetak-tagihan-dibayar')}}';
            let tipe = 'get';

            let ajaxOptions = {
                url: url,
                type: tipe,
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
            };

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
                    errorAlert('Silahkan melakukan pembayaran manual terlebih dahulu!')
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

        function printTagihan() {
            loadingAlert();
            const formId = $('#bayar-form');
            let data = $(formId).serialize();
            let count = $('input[name^="tagihan"][name$="[post]"]:checked').length;
            let Siswa = $('#siswa').val();
            if (!Siswa) {
                warningAlert('Silahkan pilih siswa');
                return;
            }
            if (count < 1) {
                warningAlert('Silahkan pilih tagihan yang akan dicetak');
                return;
            }
            let url = '{{route('admin.keuangan.pembayaran-manual.cetak-tagihan')}}';
            let tipe = 'get';

            let ajaxOptions = {
                url: url,
                type: tipe,
                data: data,
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
            };

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
                    // const errors = JSON.parse(xhr.responseText).error
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

        function createRow(data, field = false) {
            $(`#${tableId} tbody`).append('<tr></tr>')
            let newRow = $('#main_table tbody tr:last-child');
            if (field) {
                newRow.append(fieldTagihan(data));
            } else {
                newRow.append(`<td class="text-center bg-label-danger" colspan="12">Siswa ini tidak memiliki tagihan yang dapat dibayar</td>`);
            }
        }

        function getSiswa(Angkatan, Kelas) {
            loadingAlert();
            let url = '{{route('admin.keuangan.tagihan-siswa.buat-tagihan.get-siswa')}}';
            let ajaxOptions = {
                url: url,
                type: 'get',
                datatype: 'json',
                data: {
                    'id_thn_aka': Angkatan,
                    'kelas': Kelas
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                },
            }
            $.ajax(ajaxOptions).done(function (response) {
                let siswa = $('#siswa');
                siswa.empty();
                if (response.data && response.data.length > 0) {
                    siswa.append(new Option('', '', false, false))
                    response.data.forEach(function (item) {
                        let show = item.nis + ' - ' + item.nama;
                        let option = new Option(show, item.id, false, false);
                        siswa.append(option);
                    });
                } else {
                    let warningOption = new Option('Data tidak ada', '', false, false);
                    siswa.append(warningOption);
                }
                siswa.trigger('change');
                Swal.close();
            }).fail(function (xhr) {
                if (xhr.status === 422) {
                    errorAlert('Data tidak ditemukan')
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

        function getSaldoSiswa(target, siswa) {
            loadingAlert();
            let url = '{{route('admin.keuangan.saldo.saldo-virtual-account.get-saldo')}}';
            let ajaxOptions = {
                url: url,
                type: 'get',
                datatype: 'json',
                data: {
                    'siswa': siswa,
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                },
            }
            $.ajax(ajaxOptions).done(function (response) {
                let saldo = parseInt(response.replace(/\./g, ''));
                saldo = saldo.toLocaleString('id-ID');

                console.log(saldo)
                $('#saldo').val(saldo);
                Swal.close();
            }).fail(function (xhr) {
                if (xhr.status === 422) {
                    errorAlert('Data tidak ditemukan')
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

        function getTagihan(Siswa) {
            loadingAlert();
            let url = '{{route('admin.keuangan.pembayaran-manual.get-tagihan')}}';
            let ajaxOptions = {
                url: url,
                type: 'get',
                datatype: 'json',
                data: {
                    'siswa': Siswa,
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                },
            }

            $.ajax(ajaxOptions).done(function (response) {
                $('#main_table tbody tr').remove();
                if (response.length < 1) {
                    createRow(false, false);
                } else {
                    $.each(response, function (key, item) {
                        createRow(item, true);
                    });
                }
                Swal.close();
            }).fail(function (xhr) {
                Swal.close();
                if (xhr.status === 422) {
                    errorAlert('Data tidak ditemukan')
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

            formClass.on('change', 'input[name^="tagihan"][name$="[post]"]', function (e) {
                let tagihanDipilih = $('input[name^="tagihan"][name$="[post]"]:checked');
                let totalTagihan = 0;
                tagihanDipilih.each(function () {
                    totalTagihan += $(this).data('tagihan');
                });
                maxBayar = totalTagihan;
                $('input[name=total_tagihan]').val(totalTagihan.toLocaleString('id-ID'));
            })

            formClass.on('submit', function (e) {
                e.preventDefault()
                loadingAlert();
                let url = '{{route('admin.keuangan.pembayaran-manual.store')}}';
                let tipe = 'POST';
                const formId = $(this).attr('id');
                let data = $(this).serialize();

                // console.log(url);
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
                try {
                    let count = $('input[name^="tagihan"][name$="[post]"]:checked').length;
                    let Siswa = $('#siswa').val();
                    if (!Siswa) {
                        warningAlert('Silahkan pilih siswa');
                        return;
                    }
                    if (count < 1) {
                        warningAlert('Silahkan pilih tagihan yang akan dibayar');
                        return;
                    }
                    clearErrorMessages(formId)
                    $.ajax(ajaxOptions).done(function (responses) {
                        document.getElementById(formId).reset();
                        select2.each(function () {
                            $(this).trigger('change');
                        })
                        $("#tanggal").datepicker('update', formattedDate);
                        AlertPrint();
                        $('#main_table tbody tr').remove();
                    }).fail(function (xhr) {
                        if (xhr.status === 422) {
                            const errMessage = xhr.responseJSON.message
                            errorAlert(errMessage)
                            const errors = JSON.parse(xhr.responseText).error
                            if (errors) {
                                processErros(errors)
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
                } catch (e) {
                    errorAlert('terjadi error pada halaman, silahkan muat ulang');
                }
            })

            $('#id_thn_aka').on('change', function (e) {
                let kelasForm = $('#kelas');
                let angkatanForm = $('#id_thn_aka');
                if (kelasForm.val() && angkatanForm.val()) {
                    getSiswa(angkatanForm.val(), kelasForm.val())
                }
            });

            $('#kelas').on('change', function (e) {
                let kelasForm = $('#kelas');
                let angkatanForm = $('#id_thn_aka');
                if (kelasForm.val() && angkatanForm.val()) {
                    getSiswa(angkatanForm.val(), kelasForm.val())
                }
            });

            $('.cari-tagihan').on('click', function (e) {
                let Siswa = $('#siswa').val();
                if (Siswa) {
                    getTagihan(Siswa);
                    $('#total_tagihan').val('');
                } else {
                    warningAlert('Silahkan Pilih Siswa!');
                }
            });

            $("#tanggal").datepicker({
                format: "dd/mm/yyyy",
                autoclose: true,
            }).datepicker('update', formattedDate);


            $(document).on('click', '.cetak-tagihan', function (e) {
                printTagihan()
            });

            $(document).on('click', '.test-tagihan', function (e) {
                AlertPrint()
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

            $(document).on('change', '#siswa', function (e) {
                let siswa = $(this).val();
                if (siswa) {
                    getSaldoSiswa('tarik-siswa', siswa)
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
        });
    </script>

    {!! ($modalLink??'') !!}
@endsection
