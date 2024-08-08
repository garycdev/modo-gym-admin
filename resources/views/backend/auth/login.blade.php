@extends('backend.auth.auth_master')

@section('auth_title')
    Login | Admin Panel
@endsection

@section('styles')
@endsection

@section('auth-content')
    <!-- login area start -->
    <!--wrapper-->
    <div class="wrapper">
        <div class="section-authentication-cover">
            <div class="">
                <div class="row g-0">
                    <div
                        class="col-12 col-xl-7 col-xxl-8 auth-cover-left align-items-center justify-content-center d-none d-xl-flex">
                        <div class="card shadow-none bg-transparent shadow-none rounded-0 mb-0">
                            <div class="card-body">
                                <img src="{{ asset('modo-gym/logo_2.png') }}" width="650"
                                    class="img-fluid auth-img-cover-logi" alt="" />
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-xl-5 col-xxl-4 auth-cover-right align-items-center justify-content-center">
                        <div class="card rounded-0 m-3 shadow-none bg-transparent mb-0">
                            <div class="card-body p-sm-5">
                                <div class="">
                                    {{-- <div class="mb-3 text-center">
                                        <img src="{{ asset('modo-gym/logo.png') }}" width="250" alt="" />
                                    </div> --}}
                                    <div class="text-center mb-4">
                                        <h5 class="">INICIAR SESIÓN</h5>
                                        <p class="mb-0">Porfavor, ingrese con su cuenta.</p>
                                        @include('backend.layouts.partials.messages')
                                    </div>
                                    <div class="form-body">
                                        <form class="row g-3" method="POST" action="{{ route('admin.login.submit') }}">
                                            @csrf
                                            <div class="col-12">
                                                <label for="email_username" class="form-label">Correo o nombre de
                                                    usuario</label>
                                                <input type="text" class="form-control" id="email_username"
                                                    placeholder="Correo o nombre de usuario" name="email" />
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-12">
                                                <label for="password" class="form-label">Contraseña</label>
                                                <div class="input-group" id="show_hide_password">
                                                    <input type="password" class="form-control border-end-0" id="password"
                                                        placeholder="Ingrese su contraseña" name="password" />
                                                    <a href="javascript:;" class="input-group-text bg-transparent"><i
                                                            class="bx bx-hide"></i></a>
                                                </div>
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="remember"
                                                        name="remember" />
                                                    <label class="form-check-label" for="remember">Recordarme</label>
                                                </div>
                                            </div>
                                            {{-- <div class="col-md-6 text-end">
                                                <a href="authentication-forgot-password.html"
                                                >Forgot Password ?</a
                                                >
                                            </div> --}}
                                            <div class="col-md-12 alert alert-info d-flex" style="font-size:0.9em;">
                                                <i class="bx bx-info-circle" style="font-size:2em;"></i>
                                                <p class="ms-3 mb-0">
                                                    Si es su primera vez use su <b>CI</b> como usuario y <b>NOMBRE_CI</b>
                                                    como contraseña (todo mayuscula).<br>
                                                    Ejemplo:
                                                    <br><br>
                                                    <b>Usuario: </b>100001<br>
                                                    <b>Contraseña: </b>JUAN_100001
                                                </p>
                                            </div>
                                            <div class="col-12">
                                                <div class="d-grid">
                                                    <button id="form_submit" type="submit" class="btn btn-primary">
                                                        Ingresar
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="text-center">
                                                    <p class="mb-0">
                                                        <a href="{{ route('admin.password.request') }}">¿Olvidaste la
                                                            contraseña?</a>
                                                    </p>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="login-separater text-center mb-5">
                                        <span>O</span>
                                        <hr />
                                    </div>
                                    <div class="list-inline contacts-social text-center">
                                        {{-- <a href="javascript:;"
                                            class="list-inline-item bg-facebook text-white border-0 rounded-3"><i
                                                class="bx bxl-facebook"></i></a> --}}
                                        {{-- <a href="javascript:;"
                                            class="list-inline-item bg-twitter text-white border-0 rounded-3"><i
                                                class="bx bxl-twitter"></i></a> --}}
                                        <a href="{{ route('login.redirect') }}" id="sign_google"
                                            class="p-3 rounded-5 border-1 border-black bg-light">
                                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20"
                                                height="20" viewBox="0 0 48 48">
                                                <path fill="#FFC107"
                                                    d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z">
                                                </path>
                                                <path fill="#FF3D00"
                                                    d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z">
                                                </path>
                                                <path fill="#4CAF50"
                                                    d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z">
                                                </path>
                                                <path fill="#1976D2"
                                                    d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z">
                                                </path>
                                            </svg>
                                            <span>
                                                Continuar con Google
                                            </span>
                                        </a>
                                        {{-- <a href="javascript:;"
                                            class="list-inline-item bg-linkedin text-white border-0 rounded-3"><i
                                                class="bx bxl-linkedin"></i></a> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end row-->
            </div>
        </div>
    </div>
@endsection
