@extends('layouts.admin')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        <a href="{{route('admin.users.index')}}" class="btn_page">
                            Data Pengguna
                        </a>
                    </div>
                    <h2 class="page-title">
                        Detail Admin
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <div class="btn-list">
                            <button href="" class="btn btn-outline-primary d-sm-inline-block" data-bs-toggle="modal"
                                    data-bs-target="#modal-change">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-key"
                                     width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                     fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path
                                        d="M16.555 3.843l3.602 3.602a2.877 2.877 0 0 1 0 4.069l-2.643 2.643a2.877 2.877 0 0 1 -4.069 0l-.301 -.301l-6.558 6.558a2 2 0 0 1 -1.239 .578l-.175 .008h-1.172a1 1 0 0 1 -.993 -.883l-.007 -.117v-1.172a2 2 0 0 1 .467 -1.284l.119 -.13l.414 -.414h2v-2h2v-2l2.144 -2.144l-.301 -.301a2.877 2.877 0 0 1 0 -4.069l2.643 -2.643a2.877 2.877 0 0 1 4.069 0z"/>
                                    <path d="M15 9h.01"/>
                                </svg>
                                Ganti Password
                            </button>
                            <button href="#" class="btn btn-outline-warning d-sm-inline-block" data-bs-toggle="modal"
                                    data-bs-target="#modal-reset">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-key"
                                     width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                     fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path
                                        d="M16.555 3.843l3.602 3.602a2.877 2.877 0 0 1 0 4.069l-2.643 2.643a2.877 2.877 0 0 1 -4.069 0l-.301 -.301l-6.558 6.558a2 2 0 0 1 -1.239 .578l-.175 .008h-1.172a1 1 0 0 1 -.993 -.883l-.007 -.117v-1.172a2 2 0 0 1 .467 -1.284l.119 -.13l.414 -.414h2v-2h2v-2l2.144 -2.144l-.301 -.301a2.877 2.877 0 0 1 0 -4.069l2.643 -2.643a2.877 2.877 0 0 1 4.069 0z"/>
                                    <path d="M15 9h.01"/>
                                </svg>
                                Reset Password
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="row py-2">
                <div class="col-12 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-center align-items-center flex-column">
                                <div class="avatar avatar-2xl">
                                    <img src="{{asset('default_profile.png')}}" alt="Avatar">
                                </div>

                                <h3 class="mt-3">ADMIN AMARTA</h3>
                                <p class="text-small">{{$anggota->name}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <form action="#" class="submitForm" method="POST" data-url=""
                                  id="editForm1">
                                <div class="form-group mb-3">
                                    <label for="name1" class="form-label">Nama Admin</label>
                                    <input type="text" name="name" id="name1" class="form-control"
                                           placeholder="Nama Admin" value="{{$anggota->name}}" readonly>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="username1" class="form-label">Username Admin</label>
                                    <input type="text" name="username" id="username1" class="form-control"
                                           placeholder="Username Admin" value="{{$anggota->username}}" readonly>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="email1" class="form-label">Email</label>
                                    <input type="text" name="email" id="email1" class="form-control"
                                           placeholder="Email Admin" value="{{$anggota->email}}">
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label required" for="role1">Role</label>
                                    <input class="form-control" type="text" id="role1" value="{{$anggota->role}}"
                                           readonly>
                                    <div class="invalid-feedback" role="alert">
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <button href="#" class="btn btn-warning d-sm-inline-block" data-bs-toggle="modal"
                                    data-bs-target="#modal-edit">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="icon icon-tabler icon-tabler-edit" width="24"
                                     height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                     fill="none"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path
                                        d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                    <path
                                        d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                    <path d="M16 5l3 3"></path>
                                </svg>
                                Edit Akun Admin
                            </button>
                            @if(Auth::id() != $anggota->item_id)
                                <button href="#" class="btn btn-danger d-sm-inline-block" data-bs-toggle="modal"
                                        data-bs-target="#modal-destroy">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="icon icon-tabler icon-tabler-trash-x" width="24"
                                         height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                         fill="none"
                                         stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M4 7h16"></path>
                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                        <path d="M10 12l4 4m0 -4l-4 4"></path>
                                    </svg>
                                    Hapus Akun Admin
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="{{route('admin.users.update',[$anggota->item_id])}}" method="POST" data-url=""
          id="editForm">
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
                    <div class="modal-body">
                        @method('PUT')
                        @csrf
                        <div class="row row-cols-1 row-cols-sm-2">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">Nama Admin</label>
                                <input type="text" name="name" id="name" class="form-control"
                                       placeholder="Nama Admin" value="{{$anggota->name}}" readonly>
                            </div>

                            <div class="form-group mb-3">
                                <label for="username" class="form-label">Username Admin</label>
                                <input type="text" name="username" id="username" class="form-control"
                                       placeholder="Username Admin" value="{{$anggota->username}}" readonly>
                            </div>
                            <div class="form-group mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" name="email" id="email" class="form-control"
                                       placeholder="Email Admin" value="{{$anggota->email}}">
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label required" for="role">Role</label>
                                <select class="form-select" aria-label="Default select example" id="role" name="role"
                                        required>
                                    <option disabled selected>Pilih Role</option>
                                    @if(isset($roles))
                                        @foreach($roles as $item)
                                            <option
                                                value="{{$item->role}}" {{ $anggota->role == $item->name ? 'selected' : '' }}>
                                                {{$item->name}}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <div class="invalid-feedback" role="alert">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="w-100">
                                <div class="row">
                                    <div class="col">
                                        <button type="reset" class="btn btn-outline-secondary w-100"
                                                data-bs-dismiss="modal">
                                            Batal
                                        </button>
                                    </div>
                                    <div class="col">
                                        <input type="submit" id="submit-create" class="btn btn-warning w-100"
                                               value="Simpan data admin">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form data-url="" class="mainForm" id="changePasswordForm">
        <div class="modal modal-blur fade" id="modal-change" tabindex="-1" role="dialog" aria-hidden="true"
             data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-status bg-info"></div>
                    <div class="modal-header ">
                        <div class="modal-title">
                            Ganti Password Admin
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body py-4">
                        @csrf
                        <div class="col mb-3">
                            <label class="form-label required" for="old_password">Password Lama</label>
                            <input id="old_password" type="password" class="form-control" name="old_password"
                                   required placeholder="Password" autocomplete="off">
                            <div class="invalid-feedback" role="alert">
                            </div>
                        </div>
                        <div class="col mb-3">
                            <label class="form-label required" for="password">Password Baru</label>
                            <input id="password" type="password" class="form-control" name="password"
                                   required placeholder="Password" autocomplete="off">
                            <div class="invalid-feedback" role="alert">
                            </div>
                        </div>
                        <div class="col mb-3">
                            <label class="form-label required" for="password-confirm">Konfirmasi Password Baru</label>
                            <input id="password-confirm" type="Password" class="form-control"
                                   name="password_confirmation" placeholder="password" required autocomplete="off">
                            <div class="invalid-feedback" role="alert">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="w-100">
                            <div class="row">
                                <div class="col">
                                    <button type="reset" class="btn btn-outline-secondary w-100"
                                            data-bs-dismiss="modal">
                                        Batal
                                    </button>
                                </div>
                                <div class="col">
                                    <input type="submit" value="Simpan" class="btn btn-danger w-100">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form data-url="" class="mainForm" id="resetPasswordForm">
        <div class="modal modal-blur fade" id="modal-reset" tabindex="-1" role="dialog" aria-hidden="true"
             data-bs-backdrop="static">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-status bg-warning"></div>
                    <div class="modal-header ">
                        <div class="modal-title">
                            Reset Password Admin
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center py-4">
                        @csrf
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-warning icon-lg" width="24"
                             height="24"
                             viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                             stroke-linecap="round"
                             stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4"/>
                            <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4"/>
                            <path d="M12 9l0 3"/>
                            <path d="M12 15l.01 0"/>
                        </svg>
                        <h3>Reset Password akun Admin?</h3>
                        <div class="text-secondary">anda yakin akan mereset password akun Admin?</div>
                        <div class="text-secondary">*password akan diubah menjadi sama dengan username</div>
                    </div>
                    <div class="modal-footer ">
                        <div class="w-100">
                            <div class="row">
                                <div class="col">
                                    <button type="reset" class="btn btn-outline-secondary w-100"
                                            data-bs-dismiss="modal">
                                        Batal
                                    </button>
                                </div>
                                <div class="col">
                                    <button type="submit" value="Reset" class="btn btn-warning w-100">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="icon icon-tabler icon-tabler-refresh-alert" width="24" height="24"
                                             viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                             stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4"/>
                                            <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4"/>
                                            <path d="M12 9l0 3"/>
                                            <path d="M12 15l.01 0"/>
                                        </svg>
                                        reset
                                    </button>
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
    <script src="{{asset('js/button.js')}}"></script>
    <script src="{{asset('js/tableApi.js')}}"></script>


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
                        @csrf
                        @method('DELETE')
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24"
                             height="24"
                             viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                             stroke-linecap="round"
                             stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M4 7h16"></path>
                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                            <path d="M10 12l4 4m0 -4l-4 4"></path>
                        </svg>
                        <h3>Hapus akun Admin?</h3>
                        <div class="text-secondary">anda yakin akan menghapus akun Admin?</div>
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

        document.addEventListener('DOMContentLoaded', function () {
            @if(session()->has('alert'))
            {!! session('alert') !!}
            @endif



            $('.submitForm').on('submit', function (e) {
                loadingAlert()
            })

            $('.mainForm').on('submit', function (e) {
                e.preventDefault()

                loadingAlert()

                let tipe = 'POST';
                var url = ''
                const formId = $(this).attr('id');
                // console.log(formId);
                console.log('test id - ' + formId)

                if (formId === "changePasswordForm") {
                    url = '{{route('admin.users-change-password',[$anggota->item_id])}}'
                    tipe = 'POST';
                } else if (formId === "resetPasswordForm") {
                    url = '{{route('admin.users-reset-password',[$anggota->item_id])}}'
                    tipe = 'POST';
                } else if (formId === "editForm") {
                    url = '{{route('admin.users.update',[$anggota->item_id])}}'
                    tipe = 'PUT';
                }

                let data = $(this).serialize()
                console.log(data);
                const csrfToken = $('meta[name="csrf-token"]').attr('content');
                clearErrorMessages(formId)
                $.ajax({
                    url: url,
                    type: tipe,
                    cache: false,
                    data: data,
                    datatype: 'json',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                }).done(function (responses) {
                    document.getElementById(formId).reset();
                    successAlert(responses.message)
                    $("#" + $(e.target).attr('id')).find('[data-bs-dismiss="modal"]').trigger('click')
                }).fail(function (xhr) {
                    if (xhr.status === 422) {
                        const errors = JSON.parse(xhr.responseText).error
                        const errMessage = xhr.responseJSON.message
                        errorAlert(errMessage)
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
                    } else {
                        errorAlert('terjadi masalah saat menghubungkan ke server, Silahkan coba memuat ulang halaman')
                    }
                })
            })
        })
    </script>

@endsection
