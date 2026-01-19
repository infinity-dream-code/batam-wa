@extends('layouts.login')

@section('content')
    <div class="d-flex flex-column flex-root" id="kt_app_root">

        <style>
            body {
                background-image: url({{asset('images/output.jpg')}});
                /*background-position: center;*/
                /*object-fit: contain;*/
            }

            [data-bs-theme="dark"] body {
                background-image: url({{asset('images/output.jpg')}});
            }
        </style>

        <div class="d-flex flex-column flex-column-fluid flex-lg-row">

            <div class="d-flex flex-center w-lg-50 pt-15 pt-lg-0 px-10">

                <div class="d-flex flex-center flex-lg-start flex-column">

                    <a href="/" class="mb-7">
                        <img alt="Logo"
                             height="63" width="339" src="{{asset('images/1.png')}}"/>

                    </a>
                    <h2 class="text-white fw-normal m-0">Sistem Keuangan</h2>
                </div>
            </div>


            <div
                class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12 p-lg-20">
                <div class="bg-body d-flex flex-column align-items-stretch flex-center rounded-4 w-md-600px p-20">
                    <div class="d-flex flex-center flex-column flex-column-fluid px-lg-10 pb-15 pb-lg-20">
                        <form class="form w-100" id="kt_sign_in_form" action="{{ route('login') }}" method="POST">
                            <div class="text-center mb-11">
                                <h1 class="fw-bolder mb-3">Login</h1>
                                <div class="text-gray-500 fw-semibold fs-6">Login ke sistem keuangan</div>
                            </div>
                            @csrf
                            <div class="fv-row mb-8">
                                <label class="form-label" for="username">Email atau Username</label>
                                <input type="text" placeholder="username atau email akun anda" id="username"
                                       name="username" autocomplete="off"
                                       data-kt-translate="sign-in-input-email"
                                       class="form-control @error('username') is-invalid @enderror bg-transparent"
                                       autofocus
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
                                        <span>
                                            <img class="img-fluid" src="{!! captcha_src('default') !!}">
                                        </span>
                                    <button type="button" class="btn btn-icon btn-secondary" id="reload-captcha"
                                            data-bs-toggle="tooltip" data-bs-trigger="hover"
                                            data-bs-dismiss-="click"
                                            data-bs-placement="bottom"
                                            title="Ganti Captcha">
                                        <i class="ki-solid ki-arrow-circle-right fs-2"></i>
                                    </button>
                                </label>
                                <input type="text" id="captcha"
                                       class="form-control @error('captcha') is-invalid @enderror"
                                       autocomplete="off" name="captcha" required
                                       placeholder="Silahkan isikan tulisan pada gambar diatas">
                                <div class="invalid-feedback" role="alert">
                                    <strong>
                                        @error('captcha')
                                        {{ $message }}
                                        @enderror
                                    </strong>
                                </div>
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
                        </form>
                    </div>
                    <div class="d-flex flex-stack px-lg-10">
                        <div class="me-0">
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


                        <div class="d-flex fw-semibold text-primary fs-base gap-5">
                            <a href="../../demo1/dist/pages/team.html" target="_blank">Terms</a>
                            <a href="../../demo1/dist/pages/pricing/column.html" target="_blank">Plans</a>
                            <a href="../../demo1/dist/pages/contact.html" target="_blank">Contact Us</a>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <script>
        let captchaTimeoutId;

        function captchaTimeout() {
            if (captchaTimeoutId) {
                clearTimeout(captchaTimeoutId);
            }
            captchaTimeoutId = setTimeout(() => {
                const captcha = $('#captcha');
                captcha.addClass('is-invalid');
                captcha.siblings('.invalid-feedback').html('<strong>Captcha sudah tidak berlaku, silahkan <a href="#captcha" class="text-danger-emphasis ganti-captcha"> ganti!</a</strong>');
            }, 60000);
        }

        document.addEventListener("DOMContentLoaded", function () {
            $('#kt_sign_in_form').on('click', '.ganti-captcha', function () {
                $('#reload-captcha').trigger('click');
            })

            captchaTimeout();

            $('#reload-captcha').click(function () {
                $.ajax({
                    type: 'GET',
                    url: 'reload-captcha',
                    success: function (data) {
                        $(".captcha span").html(`<img class="img-fluid" src="${data.captcha}">`);
                        $('#captcha').removeClass('is-invalid');
                        captchaTimeout();
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
