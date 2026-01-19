<form action="#" data-url="" id="deleteForm" class="mainForm">
    <div class="modal modal-blur fade" id="modal-destroy" tabindex="-1" role="dialog" aria-hidden="true"
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
                <div class="modal-body text-center py-4">
                    @method('DELETE')
                    @csrf
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24"
                         viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                         stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M4 7h16"></path>
                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                        <path d="M10 12l4 4m0 -4l-4 4"></path>
                    </svg>
                    <h3>Hapus anggota?</h3>
                    <div class="text-secondary">anda yakin akan menghapus data User?</div>
                    <div class="text-secondary">Anggota dengan username ini akan dihapus!</div>
                </div>
                <div class="modal-footer ">
                    <div class="w-100">
                        <div class="row">
                            <div class="col">
                                <a href="#" class="btn btn-outline-secondary w-100" data-bs-dismiss="modal">
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

<form data-url="#" id="addAnggota" class="mainForm">
    <div class="modal modal-blur fade" id="modal-create" tabindex="-1" role="dialog" aria-hidden="true"
         data-bs-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Admin Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            title="tutup">
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <fieldset class="form-fieldset py-2">
                        <div class="row row-cols-1 row-cols-sm-2">
                            <div class="col mb-3">
                                <label class="form-label required" for="usernameInput">Username</label>
                                <input type="text" class="form-control" id="usernameInput"
                                       placeholder="Username Admin"
                                       name="username" autocomplete="false" required>
                                <div class="invalid-feedback" role="alert">
                                </div>
                            </div>
                            <div class="col mb-3">
                                <label class="form-label required" for="name">Nama Admin</label>
                                <input type="text" class="form-control" id="name"
                                       placeholder="Nama Admin"
                                       name="name" autocomplete="false" required>
                                <div class="invalid-feedback" role="alert">
                                </div>
                            </div>
                            <div class="col mb-3">
                                <label class="form-label required" for="role">Role</label>
                                <select class="form-select" aria-label="Default select example" id="role" name="role"
                                        required>
                                    <option disabled selected>Pilih Role</option>
                                    <option value="super-admin">Super Admin</option>
                                    <option value="admin">Admin CMS</option>

                                </select>
                                <div class="invalid-feedback" role="alert">
                                </div>
                            </div>
                            <div class="col mb-3">
                                <label class="form-label required" for="email">Email</label>
                                <input type="email" class="form-control" id="email"
                                       placeholder="Email Admin"
                                       name="email" autocomplete="off">
                                <div class="invalid-feedback" role="alert">
                                </div>
                            </div>
                            <div class="col mb-3">
                                <label class="form-label required" for="password">Password</label>
                                <input id="password" type="Password" class="form-control"
                                       name="password" placeholder="password" required autocomplete="off">
                                <div class="invalid-feedback" role="alert">
                                </div>
                            </div>
                            <div class="col mb-3">
                                <label class="form-label required" for="password-confirm">Password Confirmation</label>
                                <input id="password-confirm" type="Password" class="form-control"
                                       name="password_confirmation" placeholder="password" required autocomplete="off">
                                <div class="invalid-feedback" role="alert">
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="form-fieldset py-2">
                        <div class="row">
                            <div class="mb-3">
                                <label class="form-label " for="pangkat">Pangkat</label>
                                <input type="text" class="form-control" id="pangkat"
                                       placeholder="Pangkat "
                                       name="pangkat" autocomplete="false">
                                <div class="invalid-feedback" role="alert">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label " for="nip">Nip</label>
                                <input type="number" class="form-control" id="nip"
                                       placeholder="NIP "
                                       name="nip" autocomplete="false">
                                <div class="invalid-feedback" role="alert">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label " for="jabatan">Jabatan</label>
                                <input type="text" class="form-control" id="jabatan"
                                       placeholder="Jabatan "
                                       name="jabatan" autocomplete="false">
                                <div class="invalid-feedback" role="alert">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label " for="agama">Agama</label>
                                <select class="form-select" id="agama" name="agama">
                                    <option value="Islam">Islam</option>
                                    <option value="Kristen">Kristen</option>
                                    <option value="Katolik">Katolik</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Buddha">Buddha</option>
                                    <option value="Konghucu">Konghucu</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                                <div class="invalid-feedback" role="alert">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label " for="jenis_kelamin">Jenis Kelamin</label>
                                <select class="form-select" id="jenis_kelamin" name="jenis_kelamin">
                                    <option value="Laki-Laki">Laki-Laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                                <div class="invalid-feedback" role="alert">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label " for="unit_esl_3">Unit ESL 3</label>
                                <input type="text" class="form-control" id="unit_esl_3"
                                       placeholder="Unit ESL 3 "
                                       name="unit_esl_3" autocomplete="false">
                                <div class="invalid-feedback" role="alert">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label " for="unit_esl_4">Unit ESL 4</label>
                                <input type="text" class="form-control" id="unit_esl_4"
                                       placeholder="Unit ESL 4 "
                                       name="unit_esl_4" autocomplete="false">
                                <div class="invalid-feedback" role="alert">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label " for="pendidikan_terakhir">Pendidikan Terakhir</label>
                                <input type="text" class="form-control" id="pendidikan_terakhir"
                                       placeholder="Pendidikan Terakhir "
                                       name="pendidikan_terakhir" autocomplete="false">
                                <div class="invalid-feedback" role="alert">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label " for="tamat_jabatan">Tamat Jabatan</label>
                                <input type="date" class="form-control" id="tamat_jabatan"
                                       placeholder="Tamat Jabatan "
                                       name="tamat_jabatan" autocomplete="false">
                                <div class="invalid-feedback" role="alert">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label " for="tamat_pangkat">Tamat Pangkat</label>
                                <input type="date" class="form-control" id="tamat_pangkat"
                                       placeholder="tamat Pangkat "
                                       name="tamat_pangkat" autocomplete="false">
                                <div class="invalid-feedback" role="alert">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label " for="nama_kantor">Nama Kantor</label>
                                <input type="text" class="form-control" id="nama_kantor"
                                       placeholder="Nama Kantor "
                                       name="nama_kantor" autocomplete="false">
                                <div class="invalid-feedback" role="alert">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label " for="pendidikan">Pendidikan</label>
                                <input type="text" class="form-control" id="pendidikan"
                                       placeholder="Pendidikan "
                                       name="pendidikan" autocomplete="false">
                                <div class="invalid-feedback" role="alert">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label " for="generasi">Generasi</label>
                                <input type="text" class="form-control" id="generasi"
                                       placeholder="Generasi "
                                       name="generasi" autocomplete="false">
                                <div class="invalid-feedback" role="alert">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label " for="kategori_umur">Kategori Umur</label>
                                <input type="text" class="form-control" id="kategori_umur"
                                       placeholder="Kategori Umur "
                                       name="kategori_umur" autocomplete="false">
                                <div class="invalid-feedback" role="alert">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label " for="golongan">Golongan</label>
                                <input type="text" class="form-control" id="golongan"
                                       placeholder="Golongan "
                                       name="golongan" autocomplete="false">
                                <div class="invalid-feedback" role="alert">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label " for="tanggal_lahir">Tanggal Lahir</label>
                                <input type="datetime-local" class="form-control" id="tanggal_lahir"
                                       placeholder="Tanggal Lahir "
                                       name="tanggal_lahir" autocomplete="false">
                                <div class="invalid-feedback" role="alert">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label " for="jenis_jabatan">Jenis Nabatan</label>
                                <input type="text" class="form-control" id="jenis_jabatan"
                                       placeholder="Jenis Nabatan "
                                       name="jenis_jabatan" autocomplete="false">
                                <div class="invalid-feedback" role="alert">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label " for="tamat_kpg">Tamat KPG</label>
                                <input type="text" class="form-control" id="tamat_kpg"
                                       placeholder="Tamat KPG "
                                       name="tamat_kpg" autocomplete="false">
                                <div class="invalid-feedback" role="alert">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label " for="homebase">Homebase</label>
                                <input type="text" class="form-control" id="homebase"
                                       placeholder="Homebase "
                                       name="homebase" autocomplete="false">
                                <div class="invalid-feedback" role="alert">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label " for="status_menikah">Status Menikah</label>
                                <input type="text" class="form-control" id="status_menikah"
                                       placeholder="Status Menikah "
                                       name="status_menikah" autocomplete="false">
                                <div class="invalid-feedback" role="alert">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label " for="masa_kerja">Masa Kerja</label>
                                <input type="text" class="form-control" id="masa_kerja"
                                       placeholder="Masa Kerja "
                                       name="masa_kerja" autocomplete="false">
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
                                <input type="submit" id="submit-create" class="btn btn-primary w-100"
                                       value="Simpan data admin">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<form id="formImport" enctype="multipart/form-data" class="mainForm"
      method="POST">
    <div class="modal modal-blur fade" id="modal-import" tabindex="-1" role="dialog" aria-hidden="true"
         data-bs-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import Data Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            title="tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label required" for="file">File (.CSV, .XLS, .XLSX)</label>
                        <div class="row col-12">
                            <div class="col-4">
                                <label class="btn btn-outline-success" for="file">Pilih File</label>
                            </div>
                            <div class="col-8">
                                <p id="filename">Silahkan pilih file data untuk di import</p>
                            </div>
                        </div>
                        <input type="file" id="file" class="form-control d-none" accept=".xlsx, .xls, .csv"
                               name="fileImport"
                               placeholder="file" required>
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
                                <button class="btn btn-primary w-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                         viewBox="0 0 24 24"
                                         stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                         stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M12 5l0 14"/>
                                        <path d="M5 12l14 0"/>
                                    </svg>
                                    Import data Anggota
                                </button>
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
            var url = '{{route('admin.users.store')}}'
            const formId = $(this).attr('id');
            // console.log(formId);

            if (formId === "deleteForm") {
                url = '{{route('admin.users.destroy',':id')}}'
                url = url.replace(':id', id_action)
                tipe = 'DELETE';
            } else if (formId === "editForm") {
                url = '{{route('admin.users.update',':id')}}'
                url = url.replace(':id', id_action)
                tipe = 'PUT';
            } else if (formId === "formImport") {
                url = '{{route('admin.users.import')}}'
                tipe = 'POST';
            }

            let formData = new FormData(this);
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            clearErrorMessages(formId)
            $.ajax({
                url: url,
                type: tipe,
                cache: false,
                data: formData,
                datatype: 'json',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                contentType: false,
                processData: false,
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
            })
        })

        $('#modal-create').on('hide.bs.modal', function (e) {
            const formId = this.id
            $(this).parent().trigger('reset')
            clearErrorMessages(formId)
        })

        $('#modal-destroy').on('show.bs.modal', function (e) {
            let data = $(e.relatedTarget).data('val')
            const deleteRoute = "{{route('admin.users.destroy',':id')}}"
            const route = deleteRoute.replace(':id', data.id)
            $(this).parent().attr('data-url', route)
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

        $('#modal-detail').on('show.bs.modal', function (e) {
            let data = $(e.relatedTarget).data('val')

            console.log(data.key)
        })


        $("input[name=fileImport]").change(function () {
            let filename = this.files[0].name;
            $('#filename').text(filename);
            console.log(filename);
        });

        $('#modal-import').on('hidden.bs.modal', function () {
            const filename = 'Silahkan pilih file data untuk di import';
            $('#filename').text(filename);
        })

        // $("#province").on('change', function () {
        //     console.log('province')
        //     if ($(this).val() !== "") {
        //         console.log($(this).val())
        //         clearSelect('regency')
        //         clearSelect('district')
        //         clearSelect('village')

        //         let val = $(this).val();
        //         const route = RegenciesUrl.replace(':id', val)
        //         getDetailLocation(route, 'regency')
        //     }
        // });

        $("#regency").on('change', function () {

            if ($(this).val() !== "") {
                clearSelect('district')
                clearSelect('village')

                let val = $(this).val();
                const route = districtsUrl.replace(':id', val)
                getDetailLocation(route, 'district')
            }
        });

        $("#district").on('change', function () {
            if ($(this).val() !== "") {

                clearSelect('village')
                let val = $(this).val();
                const route = villagesUrl.replace(':id', val)
                getDetailLocation(route, 'village')
            }
        });

        // initTomSelect('role');
        @if(!Request::ajax())
    })
    @endif
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const usernameInput = document.getElementById("usernameInput");

        usernameInput.addEventListener("input", function (event) {
            const inputValue = event.target.value;
            event.target.value = sanitizeUsername(inputValue);
        });

        function sanitizeUsername(inputValue) {
            return inputValue.replace(/[^a-zA-Z0-9_]/g, "");
        }
    });
</script>
