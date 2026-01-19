@extends('layouts.admin_new')
@section('style')
    <link rel="stylesheet" href="{{asset('main/vendor/libs/select2/select2.css')}}">

    <style>
        .input-tagihan {
            min-width: 200px;
        }
    </style>

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

    <form id="create-form" class="mainForm">
        @csrf
        <div class="card mb-6">
            <div class="card-header header-elements">
                <h5 class="mb-0 me-2">{{($dataTitle??$mainTitle)}}</h5>
                <div class="card-header-elements ms-auto">
                    <div class="w-100">
                        <div class="row">
                            <div class="d-flex justify-content-center justify-content-md-end gap-4">
                                <a type="button" class="btn btn-success"
                                   href="{{ route('admin.keuangan.tagihan-siswa.buat-tagihan.import.index') }}"
                                   title="Import Tagihan">
                                    <span class="ri-file-excel-2-line me-2"></span>
                                    Import Tagihan
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body py-0">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-5">
                            <div class="row d-flex align-items-center">
                                <div class="col-3">
                                    <label class="required form-label" for="per">
                                        Tagihan Per
                                    </label>
                                </div>
                                <div class="col">
                                    <select class="form-select" id="per" name="per"
                                            data-control="select2" data-placeholder="Pilih Tagihan Per"
                                            required>
                                        <option value="id_angkatan" selected>Angkatan</option>
                                        <option value="kelas">Kelas</option>
                                        <option value="siswa">Siswa</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row d-flex align-items-center">
                                <div class="col-3">
                                </div>
                                <div class="col">
                                    <div class="text-muted fs-7">
                                        * tagihan per (angkatan/kelas/siswa)
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-5">
                            <div class="row d-flex align-items-center">
                                <div class="col-3">
                                    <label class="required form-label" for="id_thn_aka">
                                        Tahun Akademik
                                    </label>
                                </div>
                                <div class="col">
                                    <select class="form-select form-select-sm" id="id_thn_aka"
                                            name="id_thn_aka" data-width="100%"
                                            data-control="select2"
                                            data-placeholder="Pilih Tahun Akademik">
                                        @isset($thn_aka)
                                            @foreach($thn_aka as $item)
                                                <option
                                                    value="{{$item->id}}" {{ $loop->first ? 'selected' : '' }}>{{$item->thn_aka}}</option>
                                            @endforeach
                                        @else
                                            <option>data kosong</option>
                                        @endisset
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-5">
                            <div class="row d-flex align-items-center">
                                <div class="col-3">
                                    <label class="required form-label" for="id_angkatan">
                                        Angkatan
                                    </label>
                                </div>
                                <div class="col">
                                    <select class="form-select form-select-sm" id="id_angkatan"
                                            name="id_angkatan" data-width="100%"
                                            data-control="select2"
                                            data-placeholder="Pilih Tahun Akademik">
                                        @isset($thn_aka)
                                            <option value="all" selected>Semua</option>
                                            @foreach($thn_aka as $item)
                                                <option
                                                    value="{{$item->id}}">{{$item->thn_aka}}</option>
                                            @endforeach
                                        @else
                                            <option>data kosong</option>
                                        @endisset
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-5">
                            <div class="row d-flex align-items-center">
                                <div class="col-3">
                                    <label class="form-label" for="kelas">
                                        Kelas
                                    </label>
                                </div>
                                <div class="col">
                                    <select class="form-select" id="kelas" name="kelas"
                                            data-control="select2" data-placeholder="Pilih Kelas">
                                        @isset($kelas)
                                            <option value="all" selected>Semua</option>
                                            @foreach($kelas as $item)
                                                <option
                                                    value="{{$item->id}}">{{$item->unit}}  -  {{$item->kelas}} {{$item->kelompok}}</option>
                                            @endforeach
                                        @else
                                            <option>data kosong</option>
                                        @endisset
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-5">
                            <div class="row d-flex align-items-center">
                                <div class="col-3">
                                    <label class="form-label" for="cari_siswa">
                                        Nis / Nama
                                    </label>
                                </div>
                                <div class="col">
                                    <input class="form-control" id="cari_siswa" name="cari_siswa"
                                           placeholder="Nis / Nama">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-100">
                    <div class="row">
                        <div class="d-flex justify-content-center justify-content-md-end gap-4">
                            <button type="reset" class="btn btn-outline-secondary button_reset_cari">
                                <span class="ri-reset-left-line me-2"></span>
                                Reset
                            </button>
                            <button type="button" class="btn btn-outline-primary button_cari_cari">
                                <span class="ri-search-line me-2"></span>
                                Cari
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body mb-0 pb-0 d-none">
                <h6 class="card-title">Data Siswa *(silahkan pilih siswa)</h6>
            </div>
            <div class="card-datatable table-responsive text-nowrap px-5 d-none card-siswa">
                <table class="table table-sm table-bordered table-hover"
                       id="table-siswa">
                    <thead class="table-light">
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="card-body mb-0 pb-0">
                <h6 class="card-title">Data Post</h6>
            </div>
            <div class="card-datatable table-responsive text-nowrap px-5">
                <table class="table table-sm table-bordered table-hover"
                       id="main_table">
                    <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Post</th>
                        <th>Nama Tagihan</th>
                        <th>Nominal</th>
                        <th>Cicilan</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td>
                            <div class="input-group input-tagihan">
                                <select type="text" class="form-select select-post"
                                        data-placeholder="Pilih Post"
                                        name="tagihan[0][post]" id="tagihan[0][post]" autocomplete="off" required>
                                    <option></option>
                                    @foreach($post as $item)
                                        <option value="{{$item->kode}}" data-nominal="{{$item->nominal}}"
                                                data-nama="{{$item->nama_post}}">{{$item->kode}}
                                            - {{$item->nama_post}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback" role="alert"></div>
                            </div>
                        </td>
                        <td>
                            <input type="text" class="form-control form-control-sm nama-tagihan-input rounded-end"
                                   name="tagihan[0][nama_tagihan]" id="tagihan[0][nama_tagihan]" autocomplete="off"
                                   value="" placeholder="Nama Tagihan" required>
                            <div class="invalid-feedback" role="alert"></div>
                        </td>
                        <td>
                            <div class="input-group input-tagihan">
                                        <span class="input-group-text">
                                            Rp
                                        </span>
                                <input type="text" class="form-control formattedNumber nominal-input rounded-end"
                                       name="tagihan[0][tagihan]" id="tagihan[0][tagihan]" autocomplete="off"
                                       value=""
                                       placeholder="Nominal Tagihan" required>
                                <div class="invalid-feedback" role="alert"></div>
                            </div>
                        </td>
                        <td>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="tagihan[0][cicilan]"
                                       id="tagihan[0][cicilan]" value="cicilan">
                                <label class="form-check-label" for="tagihan[0][cicilan]">Cicilan</label>
                            </div>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-primary btn-add-tagihan" type="button">
                                <span class="ri-insert-row-bottom me-2"></span>
                                TAMBAH
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="card-footer border-0">
                <div class="w-100">
                    <div class="row">
                        <div class="d-flex justify-content-center justify-content-md-end gap-4">
                            <button type="submit" value="Buat Tagihan" class="btn btn-primary">
                                <span class="ri-add-line me-2"></span>
                                Buat Tagihan
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
    <script src="{{asset('main/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>

    <script>
        let dataColumns = [];
        let dataTableInit;
        let formId = '';
        let tableId = 'main_table';
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        const select2 = $(`[data-control='select2']`);
        let htmlTable = '';
        let tableSiswa;
        let cardSiswa = $('.card-siswa');
        let mainElementId = 'tagihan[0][post]';

        let fileIdCOunt = 1;


        function fieldTagihan() {
            let mstPostField = `
            <td>
            <div class="input-group input-tagihan">
                                <select type="text" class="form-select rounded-end select-post" data-placeholder="Pilih Post"
                                        name="tagihan[${fileIdCOunt}][post]" id="tagihan[${fileIdCOunt}][post]" autocomplete="off" required>
                                    <option></option>
                                    @foreach($post as $item)
            <option value="{{$item->kode}}" data-nominal="{{$item->nominal}}" data-nama="{{$item->nama_post}}">{{$item->kode}} - {{$item->nama_post}}</option>
                                    @endforeach
            </select>
            <div class="invalid-feedback" role="alert"></div>
        </div>
        </td>
`;

            let namaTagihanField = `
        <td>
            <input type="text" class="form-control  rounded nama-tagihan-input"
                                       name="tagihan[${fileIdCOunt}][nama_tagihan]" id="tagihan[${fileIdCOunt}][nama_tagihan]" autocomplete="off"
                                       value="" placeholder="Nama Tagihan" required>
                <div class="invalid-feedback" role="alert"></div>
        </td>
        `;

            let tagihanField = `
        <td>
            <div class="input-group input-tagihan">
                <span class="input-group-text">Rp.</span>
                <input type="text" class="form-control rounded-end nominal-input formattedNumber" name="tagihan[${fileIdCOunt}][tagihan]"
                    id="tagihan[${fileIdCOunt}][tagihan]" autocomplete="off" placeholder="Nominal Tagihan" required>
                <div class="invalid-feedback" role="alert"></div>
            </div>
        </td>
        `;

            let cicilanField = `
        <td>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="tagihan[${fileIdCOunt}][cicilan]" id="tagihan[${fileIdCOunt}][cicilan]" value="cicilan">
                <label class="form-check-label" for="tagihan[${fileIdCOunt}][cicilan]">Cicilan</label>
            </div>
        </td>
        `;

            let hapusLokasiField = `
            <td class="text-center">
                <button class="btn btn-outline-danger btn-remove-row" type="button">
                  <span class="ri-delete-row me-2"></span>
                    HAPUS
                </button>
            </td>
        `;

            return '<td></td>' + mstPostField + namaTagihanField + tagihanField + cicilanField + hapusLokasiField;
        }

        function addRowNumbers() {
            const table = document.getElementById('main_table');
            const tbody = table.querySelector('tbody');
            const rows = tbody.getElementsByTagName('tr');

            for (let i = 0; i < rows.length; i++) {
                const firstCell = rows[i].getElementsByTagName('td')[0];
                firstCell.textContent = i + 1;
            }
        }

        function addTagihan() {
            $('#main_table tbody').append('<tr></tr>')
            let newRow = $('#main_table tbody tr:last-child');
            newRow.append(fieldTagihan());
            // $('#main_table tbody tr:last-child').append(newRow);

            let elementId = `tagihan[${fileIdCOunt}][post]`;
            $('#' + elementId.replace(/([[\]])/g, '\\$1')).select2();
            fileIdCOunt++;
            addRowNumbers();
        }

        function clearErrorMessages(formId) {
            const form = document.querySelector(`#${formId}`);
            const errorElements = form.querySelectorAll('.invalid-feedback');
            const errorClass = form.querySelectorAll('.is-invalid');

            errorElements.forEach(element => element.textContent = '');
            errorClass.forEach(element => element.classList.remove('is-invalid'));
        }

        function resetSelect2(elementId) {
            $('#' + elementId).val(null).trigger('change');
        }

        function resetTextInput(elementId) {
            $('#' + elementId).val('');
        }

        function detailForm(data) {
            let input = [
                $('#id_thn_aka'),
                $('#kelas'),
                $('#cari_siswa'),
            ];
            input.forEach(function (item, key) {
                if (!data[key]) {
                    item.parent().parent().parent().parent().addClass('d-none');
                    item.prop('required', false);
                } else {
                    item.parent().parent().parent().parent().removeClass('d-none');
                    item.prop('required', true);
                }
                resetMainForm();
                // console.log(key, data[key], item);
            })
        }

        function resetMainForm() {
            resetSelect2('id_thn_aka');
            resetTextInput('id_thn_aka');
            resetSelect2('kelas');
            resetTextInput('kelas');
        }

        function refreshDataTable(newData = []) {
            tableSiswa.rows().deselect();
            tableSiswa.clear();
            tableSiswa.rows.add(newData);
            tableSiswa.draw();
            // newData.length === 0 ? '' : $('.select-all').prop('checked', true);
        }


        function getSiswa(Per, Angkatan, Kelas, siswa = null) {
            let url = '{{route('admin.keuangan.tagihan-siswa.buat-tagihan.get-siswa')}}';
            let ajaxOptions = {
                url: url,
                type: 'get',
                datatype: 'json',
                data: {
                    'per': Per,
                    'angkatan': Angkatan,
                    'kelas': Kelas,
                    'cari_siswa': siswa
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

        function createTagihan() {

        }

        document.addEventListener("DOMContentLoaded", function () {
            const createForm = $('#create-form');

            tableSiswa = $('#table-siswa').DataTable({
                columns: [
                    {data: 'nis'},
                    {data: 'nis', title: 'NIS'},
                    {data: 'nama', title: 'NAMA'},
                    {data: 'kelas', title: 'Kelas'},
                    {data: 'angkatan', title: 'Angkatan'},
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

            $('#create-form').on('reset', function (e) {
                setTimeout(function () {
                    refreshDataTable();
                    cardSiswa.addClass('d-none');
                    cardSiswa.prev().addClass('d-none');
                    const select2InForm = select2.filter(`#create-form [data-control='select2']`);
                    $('#main_table tbody tr:not(:first)').remove();
                    let element = $('#' + mainElementId.replace(/([[\]])/g, '\\$1'));
                    if (element) {
                        element.trigger('change');
                    }
                    if (select2InForm.length) {
                        select2InForm.each(function () {
                            let $this = $(this);
                            $this.trigger('change');
                        });
                    }
                }, 0)
            });

            $('#create-form').on('submit', function (e) {
                e.preventDefault();
                loadingAlert();

                let mainForm = $('#create-form');
                let url = '{{route('admin.keuangan.tagihan-siswa.buat-tagihan.store')}}';
                let tipe = 'POST';
                const formId = mainForm.attr('id');
                let data = mainForm.serialize();
                console.log(data);
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
                    successAlert(responses.message);
                }).fail(function (xhr) {
                    if (xhr.status === 422) {
                        const errors = JSON.parse(xhr.responseText).error
                        const errMessage = xhr.responseJSON.message
                        errorAlert(errMessage);
                        if (errors) {
                            for (const [key, value] of Object.entries(errors)) {
                                console.log(key + ': ', value[0]);
                                const field = $(`[name="${key}"]`);
                                field.addClass('is-invalid');
                                field.next('.invalid-feedback').html(value[0]);
                            }
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
            })

            let jenis = $('#jenis');
            jenis.on('change', function (e) {
                let isChecked = $(this).is(':checked');
                if (jenis.val() === 1) {
                    row.find('tagihan[*]cicilan').prop('readonly', isChecked);
                    row.find('tagihan[*]cicilan').prop('required', !isChecked);
                }
            })

            $(createForm).on('change', '.row-checkbox', function () {
                let isChecked = $(this).is(':checked');
                let row = $(this).closest('tr');

                row.find('input.form-control').prop('readonly', !isChecked);
                row.find('input.form-control').prop('required', isChecked);
                if (jenis.val() === 1) {
                    row.find('tagihan[*]cicilan').prop('readonly', isChecked);
                    row.find('tagihan[*]cicilan').prop('required', !isChecked);
                }
            });

            $(createForm).on('change', '#check-all', function () {
                let isChecked = $(this).is(':checked');
                $('.row-checkbox').prop('checked', isChecked).trigger('change');
            });

            $(createForm).on('change', '#per', function () {
                let data = [];
                if ($(this).val() === 'id_angkatan') {
                    cardSiswa.addClass('d-none');
                    cardSiswa.prev().addClass('d-none');
                } else {
                    cardSiswa.removeClass('d-none');
                    cardSiswa.prev().removeClass('d-none');
                }

                // switch ($(this).val()) {
                //     // case 'id_thn_aka':
                //     //     data = [true, false, false];
                //     //     detailForm(data);
                //     //     break;
                //     case 'kelas':
                //         cardSiswa.removeClass('d-none');
                //         cardSiswa.prev().removeClass('d-none');
                //         break;
                //     case 'siswa':
                //         cardSiswa.removeClass('d-none');
                //         cardSiswa.prev().removeClass('d-none');
                //         break;
                //     default:
                //         break;
                // }
            });


            $(createForm).on('click', '.button_cari_cari', function (e) {
                let per = $('#per').val()
                let angkatan = $('#id_angkatan').val()
                let kelas = $('#kelas').val()
                let cariSiswa = $('#cari_siswa').val()
                refreshDataTable();
                if (per === 'siswa' || per === 'kelas') {
                    cardSiswa.removeClass('d-none');
                    cardSiswa.prev().removeClass('d-none');
                    if (angkatan && kelas) {
                        getSiswa(per, angkatan, kelas, cariSiswa)
                    }
                }
            });

            $(document).on('keypress', '.formattedNumber', function (e) {
                const charCode = e.which ? e.which : e.keyCode;
                if (charCode < 48 || charCode > 57) {
                    e.preventDefault();
                }
            });

            $(document).on('input', '.formattedNumber', function (e) {
                const formattedValue = $(this).val();
                const parsedNumber = parseInt(formattedValue.replace(/\./g, ''));

                if (!isNaN(parsedNumber)) {
                    const formattedString = parsedNumber.toLocaleString('id-ID');
                    $(this).val(formattedString);
                } else {

                }
            });

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

            $('.btn-add-tagihan').on('click', function (e) {
                e.preventDefault();
                addTagihan();
            });

            $('#main_table').on('click', '.btn-remove-row', function () {
                $(this).closest('tr').remove();
                addRowNumbers();
            });

            $(document).on('change', '.select-post', function (e) {
                const selectedOption = $(this).find('option:selected');
                if (!selectedOption.val()) {
                    return;
                }
                const nominal = selectedOption.data('nominal');
                const nama = selectedOption.data('nama');
                const parentTd = this.closest('td');
                const siblingNominalInput = parentTd.nextElementSibling.nextElementSibling.querySelector('.nominal-input');
                const siblingNamaInput = parentTd.nextElementSibling.querySelector('.nama-tagihan-input');
                siblingNominalInput.value = nominal.toLocaleString('id-ID');
                siblingNamaInput.value = nama;
            });

            $('#' + mainElementId.replace(/([[\]])/g, '\\$1')).select2();
        });
    </script>
@endsection
