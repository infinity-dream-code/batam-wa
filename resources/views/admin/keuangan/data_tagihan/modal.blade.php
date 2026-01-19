<meta name="csrf-token" content="{{ csrf_token() }}" xmlns="http://www.w3.org/1999/html">

<form id="deleteForm" class="mainForm">
    <div class="modal modal-blur fade" id="modal-delete" tabindex="-1" role="dialog" aria-hidden="true"
         data-bs-backdrop="static">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-status bg-danger"></div>
                <div class="modal-header ">
                    <div class="modal-title">
                        Hapus Data
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-capitalize text-center py-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="84" height="84" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M4 7l16 0"/>
                        <path d="M10 11l0 6"/>
                        <path d="M14 11l0 6"/>
                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"/>
                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"/>
                    </svg>
                    <h3>Hapus Tagihan?</h3>
                    <div class="">
                        anda yakin akan menghapus data Tagihan?
                    </div>

                    <input type="hidden" id="delete_id" name="delete_id" value="12">
                </div>
                <div class="modal-footer ">
                    <div class="w-100">
                        <div class="row">
                            <div class="col">
                                <input type="reset" class="btn btn-outline-secondary w-100" value="Batal"
                                       data-bs-dismiss="modal">
                            </div>
                            <div class="col">
                                <input type="submit" value="Hapus Data" class="btn btn-danger w-100">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<form id="editForm" class="mainForm">
    <div class="modal modal-blur fade" id="modal-edit" tabindex="-1" role="dialog" aria-hidden="true"
         data-bs-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-status bg-warning"></div>
                <div class="modal-header">
                    <div class="modal-title">
                        Edit Data Tagihan
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-capitalize py-2">
                    <fieldset class="form-fieldset">
                        <div class="mb-3">
                            <label class="form-label required" for="edit-nama">Nama Siswa</label>
                            <input type="text" class="form-control" name="nama" id="edit-nama" autocomplete="off"
                                   placeholder="Nama Siswa" readonly>
                            <div class="invalid-feedback" role="alert">
                                <strong></strong>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="edit-nis">Nomor Induk Siswa</label>
                            <input type="text" class="form-control" name="nis" id="edit-nis" autocomplete="off"
                                   placeholder="Nomor Induk Siswa" readonly>
                            <div class="invalid-feedback" role="alert">
                                <strong></strong>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="edit-KodePost">Nama POST</label>
                            <select type="text" class="form-select rounded-end"
                                    name="KodePost" id="edit-KodePost" autocomplete="off" required>
                                @isset($post)
                                    @foreach($post as $item)
                                        <option value="{{$item->kode}}">{{$item->nama_post}}</option>
                                    @endforeach
                                @endisset
                            </select>
                            <div class="invalid-feedback" role="alert"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="edit-BILLNM">Nama Tagihan</label>
                            <input type="text" class="form-control" name="BILLNM" id="edit-BILLNM" autocomplete="off"
                                   placeholder="Nama Post" required>
                            <div class="invalid-feedback" role="alert">
                                <strong></strong>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required " for="edit-BILLAM">Tagihan</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    Rp
                                </span>
                                <input type="text" class="form-control rounded-end formattedNumber" name="BILLAM"
                                       id="edit-BILLAM" autocomplete="off"
                                       placeholder="Tagihan" required>
                                <div class="invalid-feedback" role="alert">
                                    <strong></strong>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="edit-FUrutan">Urutan Tagihan *(Per Siswa)</label>
                            <input type="text" class="form-control numberOnly" name="FUrutan" id="edit-FUrutan"
                                   autocomplete="off"
                                   placeholder="Urutan Tagihan" required>
                            <div class="invalid-feedback" role="alert">
                                <strong></strong>
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
                                <input type="submit" value="Simpan Data" class="btn btn-warning w-100">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    let id_action = '';

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

        $(document).on('keypress', '.formattedNumber', function (e) {
            const charCode = e.which ? e.which : e.keyCode;
            if (charCode < 48 || charCode > 57) {
                e.preventDefault();
            }
        })

        $(document).on('keypress', '.numberOnly', function (e) {
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
            } else {

            }
        });

        $('.mainForm').on('submit', function (e) {
            e.preventDefault()

            loadingAlert()

            let url
            let tipe
            const formId = $(this).attr('id');
            let data

            if (formId === "deleteForm") {
                url = '{{route('admin.keuangan.tagihan-siswa.data-tagihan.destroy',':id')}}'
                url = url.replace(':id', id_action)
                tipe = 'DELETE';
                data = $(this).serialize();
            } else if (formId === "editForm") {
                url = '{{route('admin.keuangan.tagihan-siswa.data-tagihan.update',':id')}}'
                url = url.replace(':id', id_action)
                tipe = 'PUT';
                data = $(this).serialize();
            } else if (formId === "addForm") {
                url = '{{route('admin.keuangan.tagihan-siswa.data-tagihan.store')}}'
                tipe = 'POST';
                data = $(this).serialize();
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
                    errors&&processErros(errors);
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

        $('#modal-create').on('show.bs.modal', function (e) {
            const formId = this.id
            $(this).parent().trigger('reset')
            // initTomSelect('tipe')
            clearErrorMessages(formId)
        })

        $("input[name=fileImport]").change(function () {
            let filename = this.files[0].name;
            $('#filename').text("File: " + filename);
        });

        $('#modal-import').on('hidden.bs.modal', function () {
            const filename = 'Silahkan pilih file data untuk di import';
            $('#filename').text(filename);
        })

        $('#modal-delete').on('show.bs.modal', function (e) {
            let data = $(e.relatedTarget).data('val')
            id_action = data.item_id;
            $("#delete_id").val(id_action)
        })

        $('#modal-edit').on('show.bs.modal', function (e) {
            const formId = $(this).parent().attr('id');
            clearErrorMessages(formId)
            let data = $(e.relatedTarget).data('val')
            id_action = data.item_id
            $.each(data, function (key, value) {
                let input = $("#edit-" + key);
                if (input.hasClass('formattedNumber')) {
                    if (typeof value === 'string') {
                        const parsedNumber = parseInt(value.replace(/\./g, ''));
                        if (!isNaN(parsedNumber)) {
                            value = parsedNumber.toLocaleString('id-ID');
                        }
                    } else if (typeof value === 'number') {
                        value = value.toLocaleString('id-ID');
                    }
                }
                input.val(value);
            });
        })

        $('#modal-detail').on('show.bs.modal', function (e) {
            let data = $(e.relatedTarget).data('val')

            $.each(data, function (key, value) {
                let input = $("#detail-" + key);
                if (input.hasClass('formattedNumber')) {
                    if (typeof value === 'string') {
                        const parsedNumber = parseInt(value.replace(/\./g, ''));
                        if (!isNaN(parsedNumber)) {
                            value = parsedNumber.toLocaleString('id-ID');
                        }
                    } else if (typeof value === 'number') {
                        value = value.toLocaleString('id-ID');
                    }
                }
                input.val(value);
            });
        })
        // initTomSelect('tipe')
        // initTomSelect('edit-tipe')
    })
</script>
