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
                                <div class="col-md-12">
                                    <label for="bsValidation1" class="form-label required_value">Correo </label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="user@example.com" value="{{ $user['email'] }}">
                                </div>
                                <div class="col-md-12">
                                    <div class="d-md-flex d-grid align-items-center gap-3">
                                        <button type="submit" class="btn btn-primary px-4">Actualizar datos</button>
                                    </div>
                                </div>
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
                                    <input type="password" class="form-control border-end-0" id="new_password_confirmation"
                                        placeholder="Ingrese su contraseña" name="new_password_confirmation" />
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
