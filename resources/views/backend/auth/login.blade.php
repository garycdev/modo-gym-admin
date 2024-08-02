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
                                            {{-- <div class="col-12">
                            <div class="text-center">
                              <p class="mb-0">
                                Don't have an account yet?
                                <a href="authentication-signup.html"
                                  >Sign up here</a
                                >
                              </p>
                            </div>
                          </div> --}}
                                        </form>
                                    </div>
                                    {{-- <div class="login-separater text-center mb-5">
                        <span>OR SIGN IN WITH</span>
                        <hr />
                      </div>
                      <div class="list-inline contacts-social text-center">
                        <a
                          href="javascript:;"
                          class="list-inline-item bg-facebook text-white border-0 rounded-3"
                          ><i class="bx bxl-facebook"></i
                        ></a>
                        <a
                          href="javascript:;"
                          class="list-inline-item bg-twitter text-white border-0 rounded-3"
                          ><i class="bx bxl-twitter"></i
                        ></a>
                        <a
                          href="javascript:;"
                          class="list-inline-item bg-google text-white border-0 rounded-3"
                          ><i class="bx bxl-google"></i
                        ></a>
                        <a
                          href="javascript:;"
                          class="list-inline-item bg-linkedin text-white border-0 rounded-3"
                          ><i class="bx bxl-linkedin"></i
                        ></a>
                      </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end row-->
            </div>
        </div>
    </div>
    <!--end wrapper-->

    <!-- login area start
                                                                                                                                                                                                                                             <div class="login-area login-bg">
                                                                                                                                                                                                                                                <div class="container">
                                                                                                                                                                                                                                                    <div class="login-box ptb--100">
                                                                                                                                                                                                                                                        <form method="POST" action="{{ route('admin.login.submit') }}">
                                                                                                                                                                                                                                                            @csrf
                                                                                                                                                                                                                                                            <div class="login-form-head">
                                                                                                                                                                                                                                                                <h4>Sign In</h4>
                                                                                                                                                                                                                                                                <p>Hello there, Sign in and start managing your Admin Panel</p>
                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                            <div class="login-form-body">
                                                                                                                                                                                                                                                                @include('backend.layouts.partials.messages')
                                                                                                                                                                                                                                                                <div class="form-gp">
                                                                                                                                                                                                                                                                    <label for="exampleInputEmail1">Email address or Username</label>
                                                                                                                                                                                                                                                                    <input type="text" id="exampleInputEmail1" name="email">
                                                                                                                                                                                                                                                                    <i class="ti-email"></i>
                                                                                                                                                                                                                                                                    <div class="text-danger"></div>
                                                                                                                                                                                                                                                                    @error('email')
        <span class="invalid-feedback" role="alert">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <strong>{{ $message }}</strong>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </span>
    @enderror
                                                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                                                <div class="form-gp">
                                                                                                                                                                                                                                                                    <label for="exampleInputPassword1">Password</label>
                                                                                                                                                                                                                                                                    <input type="password" id="exampleInputPassword1" name="password">
                                                                                                                                                                                                                                                                    <i class="ti-lock"></i>
                                                                                                                                                                                                                                                                    <div class="text-danger"></div>
                                                                                                                                                                                                                                                                    @error('password')
        <span class="invalid-feedback" role="alert">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <strong>{{ $message }}</strong>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </span>
    @enderror
                                                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                                                <div class="row mb-4 rmber-area">
                                                                                                                                                                                                                                                                    <div class="col-6">
                                                                                                                                                                                                                                                                        <div class="custom-control custom-checkbox mr-sm-2">
                                                                                                                                                                                                                                                                            <input type="checkbox" class="custom-control-input" id="customControlAutosizing" name="remember">
                                                                                                                                                                                                                                                                            <label class="custom-control-label" for="customControlAutosizing">Remember Me</label>
                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                                    {{-- <div class="col-6 text-right">
                                <a href="#">Forgot Password?</a>
                            </div> --}}
                                                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                                                <div class="submit-btn-area">
                                                                                                                                                                                                                                                                    <button id="form_submit" type="submit">Sign In <i class="ti-arrow-right"></i></button>
                                                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                        </form>
                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                            login area end -->
@endsection
