@extends('layouts.admin_new')
@section('style')
    <link rel="stylesheet" href="{{asset('main/vendor/libs/select2/select2.css')}}">
    <link rel="stylesheet" href="{{asset('main/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('main/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
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

<form id="create-form">
    @csrf
    <div class="card">
        <div class="card-header">
            <div class="row mb-3">
                <h5 class="mb-0 me-2">{{($dataTitle??$mainTitle)}}</h5>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6">
                    <div class="mb-5">
                        <label class="required form-label" for="per">
                            Kirim Ke
                        </label>
                        <select class="form-select" id="per" name="per"
                                data-control="select2" data-placeholder="Pilih Tagihan Per"
                                required>
                            <option value="id_thn_aka" selected>Angkatan</option>
                            <option value="kelas">Kelas</option>
                            <option value="siswa">Siswa</option>
                        </select>
                    </div>
                    <div class="mb-5">
                        <label class="required form-label" for="id_thn_aka">
                            Angkatan
                        </label>
                        <select class="form-select form-select-sm" id="id_thn_aka"
                                name="id_thn_aka" data-width="100%"
                                data-control="select2"
                                data-placeholder="Pilih Tahun Akademik">
                            @isset($thn_aka)
                                <option value="all" selected>Semua</option>
                                @foreach($thn_aka as $item)
                                    <option
                                        value="{{$item->thn_aka}}">{{$item->thn_aka}}</option>
                                @endforeach
                            @else
                                <option>data kosong</option>
                            @endisset
                        </select>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-5">
                        <label class="form-label" for="kelas">
                            Kelas
                        </label>
                        <div class="row">
                            <div class="col">
                                <select class="form-select" id="unit" name="unit"
                                        data-control="select2"
                                        data-placeholder="Pilih Jenis Unit">
                                    <option></option>
                                    <option>Semua</option>
                                    @isset($kelas)
                                        @foreach ($kelas as $k)
                                            <option value="{{$k->jenjang}}-{{$k->unit}}">{{$k->jenjang}} {{$k->unit}}</option>
                                        @endforeach
                                    @else
                                        <option>Tidak Ada Data</option>
                                    @endisset
                                </select>
                            </div>
                            <div class="col">
                                <select class="form-select" id="index-kelas" name="kelas" data-control="select2"
                                        data-placeholder="Pilih Jenis Kelas" disabled>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-5">
                        <label class="form-label" for="cari_siswa">
                            Nis / Nama
                        </label>
                        <input class="form-control" id="cari_siswa" name="cari_siswa" placeholder="Nis / Nama">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer border-0 pt-0">
            <div class="d-flex justify-content-end gap-4">
                <button type="button" class="btn btn-primary button_cari_cari">
                    <span class="ri-search-line me-2"></span>
                    Cari
                </button>
            </div>
        </div>
        <div class="card-body mb-0 pb-0 d-none">
            <h6 class="card-title">Data Siswa *(Silahkan pilih siswa)</h6>
        </div>
        <div class="card-datatable table-responsive text-nowrap px-5 card-siswa d-none">
            <table class="table table-sm table-bordered table-hover"
                   id="table-siswa">
                <thead class="table-light">
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div class="card-body">
            <div class="mb-5">
                <label class="required form-label" for="pesan">
                    Pesan
                </label>
                <textarea class="form-control" name="pesan" id="pesan" cols="30" rows="5"
                          placeholder="Tuliskan pesan anda" required></textarea>
            </div>
        </div>
        <div class="card-footer border-0 pt-0">
            <div class="d-flex justify-content-end gap-4">
                <button type="submit" class="btn btn-success">
                    <span class="ri-whatsapp-line me-2"></span>
                    Kirim
                </button>
            </div>
        </div>
    </div>
</form>
@endsection

@section('script')
    <meta name="csrf-token" content="{{ csrf_token() }}" xmlns="http://www.w3.org/1999/html">
    <script src="{{asset('main/vendor/libs/select2/select2.js')}}"></script>
    <script src="{{asset('main/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
    <script src="{{asset('js/datatableCustom/Datatable0-2.js')}}"></script>

    <script type="text/javascript">
        let dataColumns = [];
        let dataTableInit;
        let dataUrl = '{{($datasUrl??null)}}';
        let columnUrl = '{{($columnsUrl??null)}}';
        let formId = '';
        let tableId = 'main_table';
        const select2 = $(`[data-control='select2']`);
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        const createForm = $('#create-form');
        let cardSiswa = $('.card-siswa');
        let tableSiswa;

        function refreshDataTable(newData = []) {
            tableSiswa.rows().deselect();
            tableSiswa.clear();
            tableSiswa.rows.add(newData);
            tableSiswa.draw();
            // newData.length === 0 ? '' : $('.select-all').prop('checked', true);
        }

        function getSiswa(Per, Angkatan, Kelas, unit, siswa = null) {
            let url = '{{route('admin.notifikasi-whatsapp.get-siswa')}}';
            let ajaxOptions = {
                url: url,
                type: 'get',
                datatype: 'json',
                data: {
                    'per': Per,
                    'angkatan': Angkatan,
                    'kelas': Kelas,
                    'unit': unit,
                    'cari_siswa': siswa
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                },
            }

            console.log("Mengirim data ke server:", ajaxOptions.data);

            $.ajax(ajaxOptions).done(function (response) {
                console.log(response.data);

                refreshDataTable(response.data);
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
                    $('#index-kelas').empty().append('<option value="">Pilih Kelas</option>').prop('disabled', true);
                }
            });

            $(createForm).on('click', '.button_cari_cari', function (e) {
                let kelas = $('#index-kelas').val();
                if (kelas == '' || kelas == null) {
                    e.preventDefault();
                    warningAlert("Silahkan isi filter kelas terlebih dahulu");
                    return;
                }
                let per = $('#per').val()
                let angkatan = $('#id_thn_aka').val()
                let unit = $('#unit').val()
                let cariSiswa = $('#cari_siswa').val()
                console.log(per)
                refreshDataTable();
                if (per === 'siswa' || per === 'kelas') {
                    cardSiswa.removeClass('d-none');
                    cardSiswa.prev().removeClass('d-none');
                    if (angkatan && kelas) {
                        getSiswa(per, angkatan, kelas, unit, cariSiswa)
                    }
                }
            });

            tableSiswa = $('#table-siswa').DataTable({
                columns: [
                    {data: 'nis'},
                    {data: 'nis', title: 'NIS'},
                    {data: 'nama', title: 'NAMA'},
                    {data: 'unit', title: 'Unit'},
                    {data: 'kelas', title: 'Kelas'},
                    {data: 'thn_aka', title: 'Angkatan'},
                    {data: 'nowa', title: 'Nomor Whatsapp'},
                ],
                columnDefs: [
                    {
                        targets: 0,
                        searchable: false,
                        orderable: false,
                        render: function (data) {
                            return `<input type="checkbox" class="dt-checkboxes form-check-input" name="siswa[]" value="${data}">`;
                        },
                        checkboxes: {
                            selectRow: true,
                            selectAllRender: '<input type="checkbox" class="form-check-input select-all">'
                        },
                        className: 'text-center',
                    },
                ],
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/2.0.6/i18n/id.json',
                    emptyTable: "Tidak ada siswa pada Kelas dan Angkatan yang dipilih"
                },
                paging: true,
                serverSide: false,
                searching: false,
                lengthMenu: [10, 25, 50, 100],
                pageLength: 50,
                info: true,
                order: [[1, 'desc']],
                select: {
                    style: 'multi'
                },
                scrollY: '500px',
                scrollX: true,
            });

            $(createForm).on('change', '#per', function () {
                let data = [];
                if($(this).val() === 'id_thn_aka'){
                    cardSiswa.addClass('d-none');
                    cardSiswa.prev().addClass('d-none');
                }else {
                    cardSiswa.removeClass('d-none');
                    cardSiswa.prev().removeClass('d-none');
                }
            });

            $(createForm).on('submit',function (e){
                e.preventDefault();
                loadingAlert('Mengirim pesan <br><span class="text-danger"> *</span>Jangan menutup atau memuat ulang halaman!');

                let mainForm = $(this);
                let url = '{{route('admin.notifikasi-whatsapp.send-wa')}}';
                let tipe = 'POST';
                const formId = mainForm.attr('id');
                let data = mainForm.serialize();

                let ajaxOptions = {
                    url: url,
                    type: tipe,
                    data: data,
                    datatype: 'json',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                    },
                }
                clearErrorMessages(formId)
                $.ajax(ajaxOptions).done(function (responses) {
                    document.getElementById(formId).reset();

                    refreshDataTable();
                    cardSiswa.addClass('d-none');
                    cardSiswa.prev().addClass('d-none');
                    successAlert(responses.message);
                }).fail(function (xhr) {
                    if (xhr.status === 422) {
                        const errMessage = xhr.responseJSON.message
                        errorAlert(errMessage)
                        const errors = JSON.parse(xhr.responseText).error
                        if (errors) {
                            processErros(errors)
                        }
                    } else if (xhr.status === 419) {
                        errorAlert('Sesi anda telah habis, Silahkan Login Kembali');
                    } else if (xhr.status === 500) {
                        errorAlert('Tidak dapat terhubung ke server, Silahkan periksa koneksi internet anda');
                    } else if (xhr.status === 403) {
                        errorAlert('Anda tidak memiliki izin untuk mengakses halaman ini');
                    } else if (xhr.status === 404) {
                        errorAlert('Halaman tidak ditemukan');
                    } else {
                        errorAlert('Terjadi kesalahan, silahkan coba memuat ulang halaman');
                    }
                })
            });
        });



    </script>

    {!! ($modalLink??'') !!}
@endsection
