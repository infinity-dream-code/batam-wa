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

    <form class="mainForm" id="form-pindah-kelas" action="#">
        @csrf
        <div class="card">
            <div class="card-header">
                <div class="row mb-3">
                    <h5 class="mb-0 me-2">{{($dataTitle??$mainTitle)}}</h5>
                </div>
                <form id="rekapForm">
                    <div class="row">
                        <div class="mb-5">
                            <label class="form-label required" for="angkatan">
                                Angkatan
                            </label>
                            <select class="form-select" id="angkatan"
                                    name="angkatan"
                                    data-control="select2"
                                    data-placeholder="Pilih Angkatan" required>
                                <option></option>
                                @isset($thn_aka)
                                    @foreach($thn_aka as $item)
                                        <option
                                            value="{{$item->id}}">{{$item->thn_aka}}</option>
                                    @endforeach
                                @else
                                    <option>data kosong</option>
                                @endisset
                            </select>
                        </div>
                        <div class="mb-5">
                            <label class="required form-label" for="dari_kelas">
                                Dari Kelas
                            </label>
                            <select class="form-select" id="dari_kelas" name="dari_kelas"
                                    data-control="select2" data-placeholder="Dari Kelas">
                                <option></option>
                                @isset($kelas)
                                    @foreach($kelas as $item)
                                        <option value="{{$item->id}}">{{$item->unit}}  -  {{$item->kelas}} {{$item->kelompok}}</option>
                                    @endforeach
                                @else
                                    <option>data kosong</option>
                                @endisset
                            </select>
                        </div>
                        <div class="mb-5">
                            <label class="required form-label" for="ke_kelas">
                                Ke Kelas
                            </label>
                            <select class="form-select" id="ke_kelas" name="ke_kelas"
                                    data-control="select2" data-placeholder="Ke Kelas">
                                <option></option>
                                @isset($kelas)
                                    @foreach($kelas as $item)
                                        <option value="{{$item->id}}">{{$item->unit}}  -  {{$item->kelas}} {{$item->kelompok}}</option>
                                    @endforeach
                                @else
                                    <option>data kosong</option>
                                @endisset
                            </select>
                        </div>
                        <div class="mb-5">
                            <label class="form-label" for="cari_siswa">
                                Nis / Nama Siswa
                            </label>
                            <input class="form-control" id="cari_siswa" name="cari_siswa"
                                   placeholder="Nis / Nama Siswa">
                        </div>
                        <div class="mb-5">
                            <label class="form-label required" for="pindah">
                                Pemindahan
                            </label>
                            <select class="form-select" id="pindah" name="pindah"
                                    data-control="select2"
                                    data-placeholder="Pilih Pemindahan Tagihan" required>
                                <option value="all" selected>Pindahkan semua Anak Pada Kelas</option>
                                <option value="satuan">Pindahkan Hanya Anak Yang Dipilih</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer border-0 pt-0">
                <div class="row">
                    <div class="w-100">
                        <div class="row">
                            <div class="d-flex justify-content-center justify-content-md-end gap-4">
                                <button type="reset" class="btn btn-secondary">
                                    <span class="ri-reset-left-line me-2"></span>
                                    Reset
                                </button>
                                <button type="button" class="btn btn-primary button_cari_cari">
                                    <span class="ri-search-line me-2"></span>
                                    Cari
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-datatable table-responsive text-nowrap">
                <table class="table table-sm table-bordered table-hover"
                       id="table-siswa">
                    <thead class="table-light">

                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <div class="card-footer border-0 pt-0">
                <div class="row">
                    <div class="w-100">
                        <div class="row">
                            <div class="d-flex justify-content-center justify-content-md-end gap-4">
                                <button type="submit" class="btn btn-primary ">
                                    <span class="ri-drag-move-line me-2"></span>
                                    Pindah
                                </button>
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

    <script type="text/javascript">
        let dataColumns = [];
        let dataTableInit;
        let dataUrl = '{{($datasUrl??null)}}';
        let columnUrl = '{{($columnsUrl??null)}}';
        let formClass = '.mainForm';
        let formPage =  $('#form-pindah-kelas');
        let tableId = 'main_table';
        const select2 = $(`[data-control='select2']`);
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        let tableSiswa;

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

        function refreshDataTable(newData = []) {
            tableSiswa.rows().deselect();
            tableSiswa.clear();
            tableSiswa.rows.add(newData);
            tableSiswa.draw();
            // newData.length === 0 ? '' : $('.select-all').prop('checked', true);
        }

        function getSiswa(Per, Angkatan, Kelas, siswa = null) {
            let url = '{{route('admin.master-data.data-siswa.get-siswa')}}';
            let ajaxOptions = {
                url: url,
                type: 'get',
                datatype: 'json',
                data: {
                    'per': Per,
                    'angkatan': Angkatan,
                    'kelas': Kelas,
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                },
            }

            $.ajax(ajaxOptions).done(function (response) {
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

            $(formPage).on('click', '.button_cari_cari', function (e) {
                let per = 'kelas';
                let angkatan = $('#angkatan').val()
                let kelas = $('#dari_kelas').val()
                refreshDataTable();
                if (per === 'siswa' || per === 'kelas') {
                    if (angkatan && kelas) {
                        getSiswa(per, angkatan, kelas)
                    }
                }
            });

            $(formPage).on('reset', function (e) {
                console.log('test')
                setTimeout(function () {
                    refreshDataTable();
                    const select2InForm = select2.filter(formClass+` [data-control='select2']`);
                    $('#main_table tbody tr:not(:first)').remove();
                    if (select2InForm.length) {
                        select2InForm.each(function () {
                            let $this = $(this);
                            $this.trigger('change');
                        });
                    }
                }, 0)
            });

            $(formPage).on('submit', function (e) {
                e.preventDefault();
                loadingAlert('Memindah Kelas Siswa');
            });

            tableSiswa = $('#table-siswa').DataTable({
                columns: [
                    {data: 'nis'},
                    {data: 'nis', title: 'NIS'},
                    {data: 'nama', title: 'NAMA'},
                    {data: 'kelas', title: 'Kelas'},
                    {data: 'thn_aka', title: 'Angkatan'},
                ],
                columnDefs: [
                    {
                        targets: 0,
                        searchable: false,
                        orderable: false,
                        render: function (data) {
                            return `<input type="checkbox" id="siswa-checkbox-${data}" class="dt-checkboxes form-check-input" name="siswa[]" value="${data}">`;
                        },
                        checkboxes: {
                            selectRow: true,
                            selectAllRender: '<input id="siswa-checkbox" name="siswa-checkbox" type="checkbox" class="form-check-input select-all">'
                        },
                        className: 'text-center',
                    },
                ],
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/2.0.6/i18n/id.json',
                    emptyTable: "Tidak ada siswa yang sesuai kriteria pencarian"
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
        });

    </script>

    {!! ($modalLink??'') !!}
@endsection
