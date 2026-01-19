<form data-url="#" id="form-create" class="mainForm">
    <div class="modal modal-borderless modal-blur fade" id="modal-create" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
             role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Role</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <fieldset class="form-fieldset">
                        <div class="row">
                            <div class="mb-3">
                                <label class="form-label required" for="name">Nama Role</label>
                                <input type="text" class="form-control" id="name"
                                       placeholder="Nama Role"
                                       name="name" autocomplete="false" required>
                                <div class="invalid-feedback" role="alert">
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary"
                            data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Batal</span>
                    </button>
                    <input type="submit" class="btn btn-primary ms-1" value="SImpan Data">
                </div>
            </div>
        </div>
    </div>
</form>


<form action="#" data-url="" id="deleteForm" class="mainForm">
    <div class="modal modal-borderless modal-blur fade" id="modal-destroy" tabindex="-1" role="dialog"
         aria-hidden="true"
         data-bs-backdrop="static">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-status bg-danger"></div>
                <div class="modal-header">
                    <div class="modal-title">
                        Hapus Data
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24"
                         --}}
                         viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                         stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M4 7h16"></path>
                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                        <path d="M10 12l4 4m0 -4l-4 4"></path>
                    </svg>
                    @method('DELETE')
                    @csrf
                    <h5>Hapus Data?</h5>
                    <div class="text-secondary">
                        anda yakin akan menghapus data?
                    </div>

                    <input type="hidden" id="delete_id" name="delete_id" value="12">
                </div>
                <div class="modal-footer ">
                    <div class="w-100">
                        <div class="row">
                            <div class="col">
                                <a href="#" class="btn btn-light-secondary w-100" data-bs-dismiss="modal">
                                    Batal
                                </a>
                            </div>
                            <div class="col">
                                <input type="submit" value="Hapus" class="btn btn-danger w-100">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<form data-url="#" id="editForm" class="mainForm">
    @method('PUT')
    <div class="modal modal-blur fade" id="modal-edit" tabindex="-1" role="dialog" aria-hidden="true"
         data-bs-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-status bg-warning"></div>
                <div class="modal-header">
                    <div class="modal-title">
                        Edit Data
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <div class="mb-3">
                        <div class="mb-3">
                            <label class="form-label required" for="value">value</label>
                            <input type="text" class="form-control" name="value" id="edit-value" required>
                            <div class="invalid-feedback" role="alert">
                                <strong></strong>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <div class="w-100">
                            <div class="row">
                                <div class="col">
                                    <input type="reset" value="Batal" class="btn btn-outline-secondary w-100"
                                           data-bs-dismiss="modal">
                                </div>
                                <div class="col">
                                    <label for="edit-submit-create" class="btn btn-primary w-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                             viewBox="0 0 24 24"
                                             stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                             stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M12 5l0 14"/>
                                            <path d="M5 12l14 0"/>
                                        </svg>
                                        Simpan data kanwil
                                    </label>
                                    <input type="submit" id="edit-submit-create" class="d-none">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script src="{{asset('js/alerts.js')}}"></script>

<script>
    let htmlElement = document.querySelector('html');
    let idAction = '';
    let themeValue = '';

    function clearErrorMessages(formId) {
        const form = document.querySelector(`#${formId}`);
        const errorElements = form.querySelectorAll('.invalid-feedback');
        const errorClass = form.querySelectorAll('.is-invalid');

        errorElements.forEach(element => element.textContent = '');
        errorClass.forEach(element => element.classList.remove('is-invalid'));
    }

    function clearSelect(id) {
        var $select = $(`#${id}`);
        $select.find('option').remove();
        console.log($select)
    }

    @if(!Request::ajax())
    document.addEventListener("DOMContentLoaded", function () {
        @endif

        $('.mainForm').on('submit', function (e) {
            e.preventDefault()
            loadingAlert()

            let tipe = 'POST';
            let url = '{{route('admin.roles.store')}}'
            const formId = $(this).attr('id');

            if (formId === "deleteForm") {
                url = '{{route('admin.roles.destroy',':id')}}'
                url = url.replace(':id', idAction)
                tipe = 'DELETE';
            } else if (formId === "editForm") {
                url = '{{route('admin.roles.update',':id')}}'
                url = url.replace(':id', idAction)
                tipe = 'PUT';
            }

            const formData = new FormData(this);

            // let data = $(this).serialize()
            //
            // files.forEach((file, index) => {
            //     formData.append(`file_${index}`, file.file);
            // });

            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            clearErrorMessages(formId)

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                url: url,
                type: tipe,
                cache: false,
                data: formData,
                datatype: 'json',
                processData: false,
                contentType: false,

            }).done(function (responses) {
                document.getElementById(formId).reset();
                successAlert(responses.message)
                dataReload()
                $("#" + $(e.target).attr('id')).find('[data-bs-dismiss="modal"]').trigger('click')
            }).fail(function (xhr) {
                if (xhr.status === 422) {
                    const errors = JSON.parse(xhr.responseText).error
                    const errMessage = xhr.responseJSON.message
                    errorAlert(errMessage)
                    if (errors) {
                        for (const [key, value] of Object.entries(errors)) {
                            console.log(key + ': ', value[0]);
                            const field = $(`[name="${key}"]`);
                            field.addClass('is-invalid');
                            field.next('.invalid-feedback').html(value[0]);

                            if (key === 'password') {
                                const confirm = $(`[name="${key + '_confirmation'}"]`);
                                confirm.addClass('is-invalid');
                            }
                        }
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

                if (formId === 'deleteForm') {
                    $("#" + $(e.target).attr('id')).find('[data-bs-dismiss="modal"]').trigger('click')
                }
            })
        })

        $('#modal-edit').on('show.bs.modal', function (e) {
            let data = $(e.relatedTarget).data('val')
            const deleteRoute = "{{route('admin.users.update',':id')}}"
            const route = deleteRoute.replace(':id', data.custid)
            $(this).parent().attr('data-url', route)

            $.each(data, function (key, value) {
                let input = $("#edit-" + key);
                input.val(value);
            });
        })

        $('#modal-destroy').on('show.bs.modal', function (e) {
            let data = $(e.relatedTarget).data('val')
            idAction = data.item_id
            $("#delete_id").val(data.item_id)
        })

        $('#modal-create').on('show.bs.modal', function (e) {
            const formId = this.id;
            // document.getElementById(formId).reset();

            $(this).parent().trigger('reset')
            clearErrorMessages(formId)
        })

        @if(!Request::ajax())
    })
    @endif
</script>
{{--<script>--}}
{{--    document.addEventListener("DOMContentLoaded", function () {--}}
{{--        const usernameInput = document.getElementById("usernameInput");--}}

{{--        usernameInput.addEventListener("input", function (event) {--}}
{{--            const inputValue = event.target.value;--}}
{{--            event.target.value = sanitizeUsername(inputValue);--}}
{{--        });--}}

{{--        function sanitizeUsername(inputValue) {--}}
{{--            return inputValue.replace(/[^a-zA-Z0-9_]/g, "");--}}
{{--        }--}}
{{--    });--}}
{{--</script>--}}
