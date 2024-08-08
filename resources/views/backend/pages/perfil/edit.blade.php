@extends('backend.layouts.master')

@section('title')
    Clientes editar - Admin Panel
@endsection

@section('styles')
    <style>
        .required_value::after {
            content: '*';
            color: #f00;
        }

        .text-danger {
            font-size: .85em;
        }
    </style>
@endsection


@section('admin-content')
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Editar</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Actualizar perfil</li>
                        </ol>
                    </nav>
                </div>
            </div>

            @include('backend.layouts.partials.messages')
            <!--end breadcrumb-->
            <div class="row">
                <div class="col-xl-6 mx-auto">
                    <div class="card">
                        <div class="card-header px-4 py-3">
                            <h5 class="mb-0">Editar datos de usuario</h5>
                        </div>
                        <div class="card-body p-4">
                            <form class="row g-3 needs-validation" method="POST"
                                action="{{ route('admin.perfil.update', $user['id']) }}">
                                @method('PUT')
                                @csrf
                                <div class="col-md-6">
                                    <label for="bsValidation1" class="form-label required_value">Nombres </label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Nombres" value="{{ $user['name'] }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="bsValidation1" class="form-label required_value">Nombre de usuario </label>
                                    <input type="text" class="form-control" id="username" name="username"
                                        placeholder="Nombres" value="{{ $user['username'] }}">
                                </div>
                                @if ($user['google_id'])
                                    <div class="col-md-12 mt-4">
                                        <input type="hidden" name="email" value="{{ $user['email'] }}">
                                        <div
                                            class="card d-flex justify-content-between align-items-center flex-row p-3 rounded-4">
                                            <div class="d-flex justify-between align-items-center flex-row">
                                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="30"
                                                    height="30" viewBox="0 0 48 48">
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
                                                <span class="ms-2 fw-bold">{{ $user['email'] }}</span>
                                            </div>

                                            <a onclick="event.preventDefault(); document.getElementById('google_unlink').submit();"
                                                class="btn btn-danger rounded-5 px-3">
                                                Desvincular
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-md-12">
                                        <label for="bsValidation1" class="form-label">Correo </label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="user@example.com" value="{{ $user['email'] }}">
                                    </div>
                                @endif

                                <div class="col-md-12">
                                    <div class="d-md-flex d-grid align-items-center gap-3">
                                        <button type="submit" class="btn btn-primary px-4">Actualizar datos</button>
                                    </div>
                                </div>
                            </form>
                            <form id="google_unlink" action="{{ route('admin.google.unlink') }}" method="POST"
                                style="display: none;">
                                @csrf
                                <input type="hidden" name="type" value="{{ $user['type'] }}">
                                <input type="hidden" name="google_id" value="{{ $user['google_id'] }}">
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-6 mx-auto">
                    <div class="card">
                        <div class="card-header px-4 py-3">
                            <h5 class="mb-0">Editar contraseña</h5>
                        </div>
                        <div class="card-body p-4">
                            <form class="row g-3 needs-validation" method="POST"
                                action="{{ route('admin.perfil.update', $user['id']) }}">
                                @method('PUT')
                                @csrf
                                <input type="hidden" name="tipo" value="password">
                                <div class="col-md-6">
                                    <label for="new_password" class="form-label">Nueva contraseña</label>
                                    <input type="password" class="form-control border-end-0" id="new_password"
                                        placeholder="Ingrese su cont raseña" name="new_password" />
                                </div>
                                <div class="col-md-6">
                                    <label for="new_password_confirmation" class="form-label">Confirmar nueva
                                        contraseña</label>
                                    <input type="password" class="form-control border-end-0"
                                        id="new_password_confirmation" placeholder="Ingrese su contraseña"
                                        name="new_password_confirmation" />
                                </div>
                                <div class="col-md-12">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="show_pass"
                                            onchange="showPass()">
                                        <label class="form-check-label" for="show_pass"> Ver contraseñas</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="d-md-flex d-grid align-items-center gap-3">
                                        <button type="submit" class="btn btn-warning px-4">Actualizar contraseña</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function showPass() {
            var password = document.getElementById("new_password");
            var repeatPassword = document.getElementById("new_password_confirmation");
            if (password.type === "password") {
                password.type = "text";
                repeatPassword.type = "text";
            } else {
                password.type = "password";
                repeatPassword.type = "password";
            }
        }

        // Disable form submission if any field is invalid
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var form = document.getElementsByClassName('needs-validation')[0];
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            }, false);
        })();
    </script>
@endsection
