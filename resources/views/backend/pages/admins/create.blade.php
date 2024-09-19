
@extends('backend.layouts.master')

@section('title')
Crear Usuario Admin - Admin Panel
@endsection

@section('styles')

<style>
    .form-check-label {
        text-transform: capitalize;
    }
</style>
@endsection

@section('admin-content')

<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Administrador </div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Crear Usuario Admin</li>
                    </ol>
                </nav>
            </div>

        </div>
        <!--end breadcrumb-->
        <div class="col-xl-6 mx-auto">
            <div class="card">
                <div class="card-body p-4">
                    <h5 class="mb-4">Crear nuevo Usuario Admin</h5>
                    @include('backend.layouts.partials.messages')

                    <form action="{{ route('admin.admins.store') }}" class="row g-3" method="POST">
                        @csrf
                        <div class="col-md-12">
                            <label for="name" class="form-label">Admin Nombre</label>
                            <div class="position-relative input-icon">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Ingrese su nombre">
                                <span class="position-absolute top-50 translate-middle-y"><i class='bx bx-user'></i></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="email">Admin Email</label>
                            <div class="position-relative input-icon">
                                <input type="text" class="form-control" id="email" name="email" placeholder="Ingrese su Email">
                                <span class="position-absolute top-50 translate-middle-y"><i class='bx bx-envelope'></i></span>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label for="password">Password</label>
                            <div class="position-relative input-icon">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese su Password">
                                <span class="position-absolute top-50 translate-middle-y"><i class='bx bx-lock-alt'></i></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="password_confirmation">Confirmar Password</label>
                            <div class="position-relative input-icon">
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Ingrese su Password">
                                <span class="position-absolute top-50 translate-middle-y"><i class='bx bx-lock-alt'></i></span>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label for="multiple-select-field">Asignar Roles</label>
                            <select class="form-select" name="roles[]" id="multiple-select-field" data-placeholder="Asignar Roles" multiple>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label for="username">Admin Username</label>
                            <div class="position-relative input-icon">
                                <input type="text" class="form-control" id="username" name="username" placeholder="Ingrese su Username" required>
                                <span class="position-absolute top-50 translate-middle-y"><i class='bx bx-user'></i></span>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Guardar Admin</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@endsection

