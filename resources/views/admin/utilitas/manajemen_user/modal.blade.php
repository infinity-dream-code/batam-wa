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
                    <i class="ti ti-trash-x ti-3xl text-danger"></i>
                    <h3>Hapus Data User?</h3>
                    <div class="text-secondary">
                        anda yakin akan menghapus data Master Kelas?
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
                        Edit Data User
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-capitalize py-2">
                    <fieldset class="form-fieldset">
                        <div class="mb-3">
                            <label class="form-label required" for="username">Username</label>
                            <input type="text" class="form-control" id="edit-username" name="username" autocomplete="off"
                                   placeholder="Username" required>
                            <div class="invalid-feedback" role="alert">
                                <strong></strong>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="nama">Nama</label>
                            <input type="text" class="form-control" name="nama" id="edit-nama" autocomplete="off"
                                   placeholder="Nama" required>
                            <div class="invalid-feedback" role="alert">
                                <strong></strong>
                            </div>
                        </div>

                        {{-- <div class="mb-3">
                            <label class="form-label" for="role">
                                Role
                            </label>
                            <select class="form-select required" id="edit-role" name="role"
                                    data-control="select2" data-placeholder="Pilih Role">
                                <option value="all">Semua</option>
                                @isset($role)
                                    @foreach($role as $item)
                                        <option
                                            value="{{$item->name}}">{{$item->name}}</option>
                                    @endforeach
                                @else
                                    <option>data kosong</option>
                                @endisset
                            </select>
                        </div> --}}

                        <div class="mb-3">
                            <label class="form-label" for="email">Email</label>
                            <input type="email" class="form-control required" id="edit-email" name="email" autocomplete="off"
                                   placeholder="Email" required>
                            <div class="invalid-feedback" role="alert">
                                <strong></strong>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="passwordInput">Password User</label>
                            <div class="input-group">
                                <input type="password" class="form-control required" id="edit-passwordInput" placeholder="Password" name="password" autocomplete="false">

                                <span class="input-group-text showPassword" title="Lihat Password">
                                    <i class="ri-eye-off-fill"></i>
                                </span>
                                <div class="invalid-feedback" role="alert">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="passwordConfirmationInput">Password Confirmation</label>
                            <div class="input-group">
                                <input type="password" class="form-control required" id="edit-passwordConfirmationInput" placeholder="Password Confirmation" name="password_confirmation" autocomplete="false">

                                <span class="input-group-text showPasswordConfirmation" title="Lihat Password">
                                    <i class="ri-eye-off-fill"></i>
                                </span>
                                <div class="invalid-feedback" role="alert">
                                </div>
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

<form id="addForm" class="mainForm">
    <div class="modal modal-blur fade" id="modal-create" tabindex="-1" role="dialog" aria-hidden="true"
         data-bs-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Tambah Data User
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <fieldset class="form-fieldset">
                        <div class="mb-3">
                            <label class="form-label required" for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" autocomplete="off"
                                   placeholder="Username" required>
                            <div class="invalid-feedback" role="alert">
                                <strong></strong>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required" for="nama">Nama</label>
                            <input type="text" class="form-control" name="nama" id="nama" autocomplete="off"
                                   placeholder="Nama" required>
                            <div class="invalid-feedback" role="alert">
                                <strong></strong>
                            </div>
                        </div>

                        {{-- <div class="mb-3">
                            <label class="form-label" for="role">
                                Role
                            </label>
                            <select class="form-select required" id="role" name="role"
                                    data-control="select2" data-placeholder="Pilih Role">
                                <option value="all">Semua</option>
                                @isset($role)
                                    @foreach($role as $item)
                                        <option
                                            value="{{$item->name}}">{{$item->name}}</option>
                                    @endforeach
                                @else
                                    <option>data kosong</option>
                                @endisset
                            </select>
                        </div> --}}

                        <div class="mb-3">
                            <label class="form-label" for="email">Email</label>
                            <input type="email" class="form-control required" id="email" name="email" autocomplete="off"
                                   placeholder="Email" required>
                            <div class="invalid-feedback" role="alert">
                                <strong></strong>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="passwordInput">Password User</label>
                            <div class="input-group">
                                <input type="password" class="form-control required" id="passwordInput" placeholder="Password" name="password" autocomplete="false">

                                <span class="input-group-text showPassword" title="Lihat Password">
                                    <i class="ri-eye-off-fill"></i>
                                </span>
                                <div class="invalid-feedback" role="alert">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="passwordConfirmationInput">Password Confirmation</label>
                            <div class="input-group">
                                <input type="password" class="form-control required" id="passwordConfirmationInput" placeholder="Password Confirmation" name="password_confirmation" autocomplete="false">

                                <span class="input-group-text showPasswordConfirmation" title="Lihat Password">
                                    <i class="ri-eye-off-fill"></i>
                                </span>
                                <div class="invalid-feedback" role="alert">
                                </div>
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
                                <input type="submit" value="Simpan Data" class="btn btn-primary w-100">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<link rel="stylesheet" href="{{asset('main/vendor/libs/select2/select2.css')}}">
<script src="{{asset('main/vendor/libs/select2/select2.js')}}"></script>
<script>
    let id_action = '';

    function clearErrorMessages(formId) {
        const form = document.querySelector(`#${formId}`);
        const errorElements = form.querySelectorAll('.invalid-feedback');
        const errorClass = form.querySelectorAll('.is-invalid');

        errorElements.forEach(element => element.textContent = '');
        errorClass.forEach(element => element.classList.remove('is-invalid'));
    }

    document.addEventListener("DOMContentLoaded", function () {

        $('.showPassword').click(function () {
            const passInput = $('#passwordInput');
            const type = passInput.attr('type');
            const icon = $(this).children();
            const thisText = $(this);
            if (type === 'password') {
                thisText.attr('title', 'Sembunyikan Password')
                passInput.attr('type', 'text')
                icon.removeClass('ri-eye-off-fill')
                icon.addClass('ri-eye-fill')
            } else {
                thisText.attr('title', 'Lihat Password')
                passInput.attr('type', 'password')
                icon.removeClass('ri-eye-fill')
                icon.addClass('ri-eye-off-fill')
            }
        })
        $('.showPasswordConfirmation').click(function () {
            const passInput = $('#passwordConfirmationInput');
            const type = passInput.attr('type');
            const icon = $(this).children();
            const thisText = $(this);
            if (type === 'password') {
                thisText.attr('title', 'Sembunyikan Password')
                passInput.attr('type', 'text')
                icon.removeClass('ri-eye-off-fill')
                icon.addClass('ri-eye-fill')
            } else {
                thisText.attr('title', 'Lihat Password')
                passInput.attr('type', 'password')
                icon.removeClass('ri-eye-fill')
                icon.addClass('ri-eye-off-fill')
            }
        })

        $('.mainForm').on('submit', function (e) {
            e.preventDefault()
            let formId = $(this).attr('id');
            let formData = $('#' + formId).serialize();
            var pesan;
            let url
            let tipe
            let data = $(this).serialize();
            if (formId === "deleteForm") {
                loadingAlert('Menghapus data user');
                url = '{{route('admin.manajemen-user.destroy',':id')}}'
                url = url.replace(':id', id_action)
                tipe = 'DELETE';
                pesan = "Data Akan Dihapus"
            } else if (formId === "editForm") {
                loadingAlert('Mengubah data user');
                url = '{{route('admin.manajemen-user.update',':id')}}'
                url = url.replace(':id', id_action)
                tipe = 'PUT';
                pesan = "Data Anda Akan Di Update"
            } else if (formId === "addForm") {
                loadingAlert('Menyimpan data user');
                url = '{{route('admin.manajemen-user.store')}}'
                tipe = 'POST';
                pesan = "Data Sudah Benar?"
            };
            Swal.fire({
                title: pesan,
                text: "Anda dapat membatalkan aksi ini",
                icon: "warning",
                showCancelButton: true,
                showDenyButton: false,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya",
                cancelButtonText: "Batal",
                customClass: {
                    actions: 'my-actions',
                    cancelButton: 'btn btn-danger',
                    confirmButton: 'btn btn-success',
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    loadingAlert()
                    const csrfToken = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                      url: url,
                        type: tipe,
                        cache: false,
                        data: formData,
                        datatype: 'json',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        contentType: 'application/x-www-form-urlencoded; charset=UTF-8', // Menentukan content-type untuk serialized data
                        processData: true, // Mengatur proses data
                    }).done(function (responses) {
                        document.getElementById(formId).reset();
                        successAlert(responses.message);
                        dataReload('main_table');
                        $("#" + $(e.target).attr('id')).find('[data-bs-dismiss="modal"]').trigger('click')
                    }).fail(function (xhr) {
                        if (xhr.status === 422) {
                            const errors = JSON.parse(xhr.responseText).error
                            console.log(errors);
                            const errMessage = xhr.responseJSON.message
                            errorAlert(errMessage)
                            if(errors){
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
                    })
                }
            });
        })

        $('#modal-create').on('show.bs.modal', function (e) {
            const formId = this.id
            $(this).parent().trigger('reset')
            // initTomSelect('tipe')
            clearErrorMessages(formId)
        })

        $('#modal-import').on('hidden.bs.modal', function () {
            const filename = 'Silahkan pilih file data untuk di import';
            $('#filename').text(filename);
        });

        $('#modal-delete').on('show.bs.modal', function (e) {
            let data = $(e.relatedTarget).data('val')
            id_action = data.item_id;
            $("#delete_id").val(id_action)
        });

        $('#modal-edit').on('show.bs.modal', function (e) {
            const formId = $(this).parent().attr('id');
            clearErrorMessages(formId);
            let data = $(e.relatedTarget).data('val');
            id_action = data.item_id;
            $.each(data, function (key, value) {
                let input = $("#edit-" + key);
                console.log("edit-" + key);
                console.log(value);
                input.val(value);
            });
            console.log(id_action);

        })

        $('#role').select2({
            dropdownParent: $('#modal-create')
        });


        $('#modal-detail').on('show.bs.modal', function (e) {
            let data = $(e.relatedTarget).data('val')

            $.each(data, function (key, value) {
                let input = $("#detail-" + key);
                input.val(value);
            });
        })
        // initTomSelect('tipe')
        // initTomSelect('edit-tipe')
    })
</script>
