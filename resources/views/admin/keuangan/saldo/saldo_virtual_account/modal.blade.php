@php use Carbon\Carbon; @endphp
<meta name="csrf-token" content="{{ csrf_token() }}" xmlns="http://www.w3.org/1999/html">
<link rel="stylesheet" href="{{asset('main/vendor/libs/select2/select2.css')}}">

<form id="addForm" class="mainForm">
    <div class="modal modal-blur fade" id="modal-create" tabindex="-1" role="dialog" aria-hidden="true"
         data-bs-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Top Up Saldo
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <fieldset class="form-fieldset">
                        <div class="mb-3">
                            <label class="required form-label" for="siswa">
                                Siswa
                            </label>
                            <select class="form-select" id="siswa" name="siswa"
                                    data-control="select2-ajax-siswa" data-placeholder="Pilih Siswa">
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="total_top_up">Nominal Top Up</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text">Rp. </span>
                                <input type="text" id="total_top_up" inputmode="number" name="total_top_up"
                                       placeholder="Nominal Top Up"
                                       class="form-control formattedNumber"/>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="modal-footer">
                    <div class="w-100">
                        <div class="row">
                            <div class="col">
                                <input type="reset" value="Batal" class="btn btn-outline-secondary w-100"
                                       data-bs-dismiss="modal">
                            </div>
                            <div class="col">
                                <input type="submit" value="Top Up" class="btn btn-primary w-100">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<form id="tarikForm" class="mainForm">
    <div class="modal modal-blur fade" id="modal-tarik" tabindex="-1" role="dialog" aria-hidden="true"
         data-bs-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Tarik Saldo
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <fieldset class="form-fieldset">
                        <div class="mb-3">
                            <label class="required form-label" for="tarik-siswa">
                                Siswa
                            </label>
                            <select class="form-select" id="tarik-siswa" name="siswa"
                                    data-control="select2-ajax-siswa" data-placeholder="Pilih Siswa">
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="tarik-saldo">Saldo Siswa</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text">Rp. </span>
                                <input type="text" id="tarik-saldo" inputmode="number" name="saldo"
                                       placeholder="Saldo"
                                       class="form-control formattedNumber" readonly/>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="tarik-total">Nominal Penarikan</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text">Rp. </span>
                                <input type="text" id="tarik-total" inputmode="number" name="total"
                                       placeholder="Nominal Penarikan"
                                       class="form-control formattedNumber" required/>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="modal-footer">
                    <div class="w-100">
                        <div class="row">
                            <div class="col">
                                <input type="reset" value="Batal" class="btn btn-outline-secondary w-100"
                                       data-bs-dismiss="modal">
                            </div>
                            <div class="col">
                                <input type="submit" value="Tarik" class="btn btn-warning w-100">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    const select2 = $(`[data-control='select2']`);
    const csrfToken = $('meta[name="csrf-token"]').attr('content');
    const formClass = $('.mainForm');
    let select2Param = '';

    function clearErrorMessages(formId) {
        const form = document.querySelector(`#${formId}`);
        const errorElements = form.querySelectorAll('.invalid-feedback');
        const errorClass = form.querySelectorAll('.is-invalid');

        errorElements.forEach(element => element.textContent = '');
        errorClass.forEach(element => element.classList.remove('is-invalid'));
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
            $('#tarik-saldo').val(response.toLocaleString('id-ID'));
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

    function getSiswa(target, Angkatan, Kelas) {
        loadingAlert();
        let url = '{{route('admin.master-data.data-siswa.get-siswa')}}';
        let ajaxOptions = {
            url: url,
            type: 'get',
            datatype: 'json',
            data: {
                'id_thn_aka': Angkatan,
                'id_kelas': Kelas
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            },
        }
        $.ajax(ajaxOptions).done(function (response) {
            let siswa = $(`#${target}`);
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
                    language: 'id',
                    dropdownParent: $this.parent()
                });
            });
        }

        formClass.on('reset', function (e) {
            const formId = $(this).attr('id');
            const select2InForm = $(`#${formId} [data-control="select2-ajax-siswa"]`);
            if (select2InForm.length) {
                select2InForm.each(function () {
                    let $this = $(this);
                    $this.find('option').remove()
                    $this.val(null).trigger('change');
                });
            }
        })

        formClass.on('submit', function (e) {
            e.preventDefault()

            loadingAlert()

            let url
            let tipe = 'POST';
            const formId = $(this).attr('id');
            let data = $(this).serialize();


            if (formId === "addForm") {
                url = '{{route('admin.keuangan.saldo.saldo-virtual-account.store')}}'
            } else if (formId === 'tarikForm') {
                url = '{{route('admin.keuangan.saldo.saldo-virtual-account.tarik')}}'
            }

            const csrfToken = $('meta[name="csrf-token"]').attr('content');
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

            if (formId === "formImport") {
                ajaxOptions.contentType = false;
                ajaxOptions.processData = false;
            }

            // console.log(ajaxOptions)
            clearErrorMessages(formId)
            $.ajax(ajaxOptions).done(function (responses) {
                document.getElementById(formId).reset();
                $("#" + $(e.target).attr('id')).find('[data-bs-dismiss="modal"]').trigger('click')
                successAlert(responses.message);
                dataReload('main_table');
            }).fail(function (xhr) {
                if (xhr.status === 422) {
                    const errors = JSON.parse(xhr.responseText).error
                    const errMessage = xhr.responseJSON.message
                    errorAlert(errMessage)
                    errors && processErros(errors);
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

        $(document).on('keypress', '.formattedNumber', function (e) {
            const charCode = e.which ? e.which : e.keyCode;
            if (charCode < 48 || charCode > 57) {
                e.preventDefault();
            }
        })

        $(document).on('input', '.formattedNumber', function (e) {
            const formattedValue = $(this).val();
            const parsedNumber = parseInt(formattedValue.replace(/\./g, ''));

            if (!isNaN(parsedNumber)) {
                const formattedString = parsedNumber.toLocaleString('id-ID');
                $(this).val(formattedString);
            }
        });

        $('#tarik-siswa').on('change', function (e) {
            let siswa = $(this).val();
            if (siswa) {
                getSaldoSiswa('tarik-siswa', siswa)
            }
        });

        $('#tarik-total').on('input', function (e) {
            let maxVal = $('#tarik-saldo').val();
            let value = parseInt($(this).val().replace(/\./g, ''));
            const parsedNumber = parseInt(maxVal.replace(/\./g, ''));
            if (value > parsedNumber) {
                $(this).val(maxVal);
            }
        });

        $('[data-control="select2-ajax-siswa"]').each(function () {
            $(this).select2({
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
                },
                language: {
                    inputTooShort: function () {
                        return "Masukkan NIS atau Nama Siswa";
                    },
                    noResults: function () {
                        let w = $.isNumeric(select2Param) ? 'NIS' : 'Nama';
                        return "Siswa dengan " + w + ": <span class='bg-label-danger'><b>" + select2Param + "</b></span> tidak ditemukan!";
                    },
                    searching: function () {
                        return "Mencari Siswa ......"
                    }
                },
                escapeMarkup: function (markup) {
                    return markup;
                },
                minimumInputLength: 4,
                dropdownParent: $(this).closest('.modal'),
            }).on('select2:selecting', function (e) {
                if (e.params.args.data.id === '') {
                    e.preventDefault();
                }
            });
        });
    })
</script>
