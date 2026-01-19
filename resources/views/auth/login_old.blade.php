@extends('layouts.login')

@section('content')
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <a href="/" class="d-block d-lg-none mx-auto pt-10">
                <img alt="{{config('app.name')}}" src="{{asset('logo_ict.svg')}}" class="theme-light-show h-100px"/>
                <img alt="{{config('app.name')}}" src="{{asset('logo_ict.svg')}}" class="theme-dark-show h-100px"/>
            </a>
            <div class="d-flex flex-column flex-column-fluid flex-center w-lg-50 p-10">
                <div class="d-flex justify-content-between flex-column-fluid flex-column w-100 mw-450px">
                    <div class="d-flex flex-stack py-2">
                        <div class="me-2"></div>
                    </div>
                    <form class="form w-100" action="{{ route('login') }}" method="POST">
                        <div class="card shadow">
                            <div class="card-header border-0 ">
                                <h2 class="card-title align-items-start flex-column">
                                    Login Sikeu
                                </h2>
                                <!--begin::Toolbar-->
                                <div class="card-toolbar">
                                    <div class="card-actions">
                                        <a href="#"
                                           class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px"
                                           data-kt-menu-trigger="{default:'click'}"
                                           data-kt-menu-attach="parent"
                                           data-kt-menu-placement="bottom-end"
                                           data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss-="click"
                                           data-bs-placement="bottom"
                                           title="Tema">
                                            <i class="ki-solid ki-sun theme-light-show fs-1">
                                            </i>
                                            <i class="ki-solid ki-moon theme-dark-show fs-1">
                                            </i>
                                        </a>
                                        <div
                                            class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px"
                                            data-kt-menu="true" data-kt-element="theme-mode-menu">
                                            <div class="menu-item px-3 my-0">
                                                <a href="#" class="menu-link px-3 py-2" data-kt-element="mode"
                                                   data-kt-value="light">
                                        <span class="menu-icon" data-kt-element="icon">
                                            <i class="ki-solid ki-sun fs-2">
                                            </i>
                                        </span>
                                                    <span class="menu-title">
                                            Terang
                                        </span>
                                                </a>
                                            </div>
                                            <div class="menu-item px-3 my-0">
                                                <a href="#" class="menu-link px-3 py-2" data-kt-element="mode"
                                                   data-kt-value="dark">
                                        <span class="menu-icon" data-kt-element="icon">
                                            <i class="ki-solid ki-moon fs-2">
                                            </i>
                                        </span>
                                                    <span class="menu-title">
                                            Gelap
                                        </span>
                                                </a>
                                            </div>
                                            <div class="menu-item px-3 my-0">
                                                <a href="#" class="menu-link px-3 py-2" data-kt-element="mode"
                                                   data-kt-value="system">
                                        <span class="menu-icon" data-kt-element="icon">
                                            <i class="ki-solid ki-screen fs-2">

                                            </i>
                                        </span>
                                                    <span class="menu-title">
                                            Sistem
                                        </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Toolbar-->
                            </div>
                            <div class="card-body">
                                <div class="text-start mb-10">
                                    <div class="text-gray-400 fw-semibold fs-6" data-kt-translate="general-desc">
                                        Login menggunakan akun anda
                                    </div>
                                </div>
                                @csrf
                                <div class="fv-row mb-8">
                                    <label class="form-label" for="username">Email atau Username</label>
                                    <input type="text" placeholder="username atau email akun anda" id="username"
                                           name="username" autocomplete="off"
                                           data-kt-translate="sign-in-input-email"
                                           class="form-control @error('username') is-invalid @enderror" autofocus
                                           required value="{{old('username')}}"/>
                                    @error('username')
                                    <div class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>

                                <div class="fv-row mb-7">
                                    <div class="row d-flex justify-content-between">
                                        <div class="col-6">
                                            <label class="form-label" for="password">
                                                Password
                                            </label>
                                        </div>
                                        <div class="col-6 text-end">
                                            @if (Route::has('password.request'))
                                                <span class="form-label-description">
                                                    <a href="{{ route('password.request') }}">Lupa Password?</a>
                                            </span>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="input-group">
                                        <input type="password" placeholder="Password" name="password" id="password"
                                               autocomplete="off"
                                               data-kt-translate="sign-in-input-password"
                                               class="form-control @error('password') is-invalid @enderror" required/>
                                        <span class="input-group-text showPassword"
                                              data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss-="click"
                                              data-bs-placement="bottom"
                                              title="Lihat Password">
                                            <i class="ki-solid ki-eye-slash fs-2"></i>
                                        </span>
                                        @error('password')
                                        <div class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="fv-row mb-7 text-center">
                                    <label class="form-label captcha mb-3" for="captcha">
                                        <div class="row">
                                            <div class="col-8 w-sm-30px">
                                                <span>
                                            {!! captcha_img('default') !!}
                                                </span>
                                            </div>
                                            <div class="col">
                                                <button type="button" class="btn btn-icon btn-secondary" id="reload"
                                                        data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                        data-bs-dismiss-="click"
                                                        data-bs-placement="bottom"
                                                        title="Ganti Captcha">
                                                    <i class="ki-solid ki-arrow-circle-right fs-2"></i>
                                                </button>
                                            </div>
                                        </div>


                                    </label>
                                    <input type="text" id="captcha"
                                           class="form-control @error('captcha') is-invalid @enderror"
                                           autocomplete="off" name="captcha" required
                                           placeholder="Silahkan isikan tulisan pada gambar diatas">
                                    @error('captcha')
                                    <div class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>

                                <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-10">
                                    <div></div>
                                    <label class="form-check">
                                        <input type="checkbox" class="form-check-input"/>
                                        <span class="form-check-label">Ingat saya pada perangkat ini</span>
                                    </label>
                                </div>
                                <div class="form-footer">
                                    <button type="submit" class="btn btn-primary shadow w-100">Login</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="d-flex flex-stack py-2">
                        <div class="me-2"></div>
                    </div>
                </div>
            </div>
            <div
                class="d-none d-lg-flex flex-lg-row-fluid w-50 bgi-size-cover bgi-position-y-center bgi-position-x-start bgi-no-repeat"
                style="background-image: url({{asset('images/undraw_secure_login_pdn4.svg')}})"></div>
        </div>
    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            $('#reload').click(function () {
                $.ajax({
                    type: 'GET',
                    url: 'reload-captcha',
                    success: function (data) {
                        $(".captcha span").html(data.captcha);
                    }
                });
            });

            $('.showPassword').click(function () {
                const passInput = $('#password');
                const type = passInput.attr('type');
                const icon = $(this).children();
                const thisText = $(this);
                if (type === 'password') {
                    thisText.attr('title', 'Sembunyikan Password')
                    thisText.attr('data-bs-original-title', 'Sembunyikan Password')
                    passInput.attr('type', 'text')
                    icon.removeClass('ki-eye-slash')
                    icon.addClass('ki-eye')
                } else {
                    thisText.attr('title', 'Lihat Password')
                    thisText.attr('data-bs-original-title', 'Lihat Password')
                    passInput.attr('type', 'password')
                    icon.removeClass('ki-eye')
                    icon.addClass('ki-eye-slash')
                }
            })
        })

    </script>
@endsection
