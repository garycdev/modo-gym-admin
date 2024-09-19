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
                <div class="breadcrumb-title pe-3">Editar Cliente</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Actualizar cliente</li>
                        </ol>
                    </nav>
                </div>
                {{-- <div class="ms-auto">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary">Settings</button>
                    <button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">	<span class="visually-hidden">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">	<a class="dropdown-item" href="javascript:;">Action</a>
                        <a class="dropdown-item" href="javascript:;">Another action</a>
                        <a class="dropdown-item" href="javascript:;">Something else here</a>
                        <div class="dropdown-divider"></div>	<a class="dropdown-item" href="javascript:;">Separated link</a>
                    </div>
                </div>
            </div> --}}
            </div>
            <!--end breadcrumb-->
            <div class="row">
                <div class="col-xl-6 mx-auto">
                    <div class="card">
                        <div class="card-header px-4 py-3">
                            <h5 class="mb-0">Registrar cliente</h5>
                        </div>
                        <div class="card-body p-4">
                            <form class="row g-3 needs-validation" method="POST"
                                action="{{ route('admin.clientes.update', $cliente->usu_id) }}"
                                enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <div class="col-md-3">
                                    <label for="bsValidation10" class="form-label required_value">Edad </label>
                                    <input type="number" class="form-control" id="ci" name="ci"
                                        placeholder="CI" value="{{ $cliente->usu_ci }}">
                                    @error('ci')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="bsValidation10" class="form-label required_value">Edad </label>
                                    <input type="number" class="form-control" id="edad" name="edad"
                                        placeholder="Edad" value="{{ $cliente->usu_edad }}">
                                    @error('edad')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="bsValidation10" class="form-label required_value">Huella </label>
                                    <input type="number" class="form-control" id="huella" name="huella"
                                        placeholder="Huella" value="{{ $cliente->usu_huella }}">
                                    @error('huella')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label for="bsValidation1" class="form-label required_value">Nombres </label>
                                    <input type="text" class="form-control" id="nombre" name="nombre"
                                        placeholder="Nombres" value="{{ $cliente->usu_nombre }}">
                                    @error('nombre')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label for="bsValidation2" class="form-label">Apellidos</label>
                                    <input type="text" class="form-control" id="apellidos" name="apellidos"
                                        placeholder="Apellidos" value="{{ $cliente->usu_apellidos }}">
                                </div>
                                <div class="col-md-5">
                                    <label for="bsValidation9" class="form-label required_value">Genero </label>
                                    <select id="genero" name="genero" class="form-select">
                                        <option selected disabled value>[GENERO]</option>
                                        <option
                                            value="MASCULINO"{{ $cliente->usu_genero == 'MASCULINO' ? 'selected' : '' }}>
                                            MASCULINO</option>
                                        <option value="FEMENINO" {{ $cliente->usu_genero == 'FEMENINO' ? 'selected' : '' }}>
                                            FEMENINO</option>
                                        <option value="NO PREFIERO DECIRLO"
                                            {{ $cliente->usu_genero == 'NO PREFIERO DECIRLO' ? 'selected' : '' }}>NO
                                            PREFIERO DECIRLO</option>
                                    </select>
                                    @error('genero')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="bsValidation9" class="form-label required_value">Nivel </label>
                                    <select id="nivel" name="nivel" class="form-select">
                                        <option selected disabled value>[NIVEL]</option>
                                        <option value="BASICO" {{ $cliente->usu_nivel == 'BASICO' ? 'selected' : '' }}>
                                            BASICO</option>
                                        <option value="INTERMEDIO"
                                            {{ $cliente->usu_nivel == 'INTERMEDIO' ? 'selected' : '' }}>INTERMEDIO</option>
                                        <option value="AVANZADO" {{ $cliente->usu_nivel == 'AVANZADO' ? 'selected' : '' }}>
                                            AVANZADO</option>
                                    </select>
                                    @error('nivel')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label for="bsValidation12" class="form-label">Imagen</label>
                                    <input type="file" class="form-control" id="imagen" name="imagen">
                                    @error('imagen')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="bsValidation9" class="form-label">Frecuencia </label>
                                    <input type="number" class="form-control" id="frecuencia" name="frecuencia"
                                        placeholder="Frecuencia" value="{{ $cliente->usu_frecuencia }}">
                                    @error('frecuencia')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="bsValidation9" class="form-label">Hora </label>
                                    <input type="number" class="form-control" id="hora" name="hora"
                                        placeholder="Hora" value="{{ $cliente->usu_hora }}">
                                    @error('hora')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="bsValidation13" class="form-label">Antecedentes medicos</label>
                                    <textarea class="form-control" id="ante_medicos" name="ante_medicos" placeholder="Antecedentes medicos."
                                        rows="3">{{ $cliente->usu_ante_medicos }}</textarea>
                                    <div class="invalid-feedback">
                                        Please enter a valid address.
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="bsValidation13" class="form-label">Lesiones</label>
                                    <textarea class="form-control" id="lesiones" name="lesiones" placeholder="Lesiones." rows="3">{{ $cliente->usu_lesiones }}</textarea>
                                    <div class="invalid-feedback">
                                        Please enter a valid address.
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="bsValidation13" class="form-label">Objetivo</label>
                                    <textarea class="form-control" id="objetivo" name="objetivo" placeholder="Objetivo." rows="3">{{ $cliente->usu_objetivo }}</textarea>
                                    <div class="invalid-feedback">
                                        Please enter a valid address.
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="bsValidation13" class="form-label">Deportes</label>
                                    <textarea class="form-control" id="deportes" name="deportes" placeholder="Deportes." rows="3">{{ $cliente->usu_deportes }}</textarea>
                                    <div class="invalid-feedback">
                                        Please enter a valid address.
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="bsValidation9" class="form-label required_value">Estado </label>
                                    <select id="estado" name="estado" class="form-select">
                                        <option value="ACTIVO" {{ $cliente->usu_estado == 'ACTIVO' ? 'selected' : '' }}>
                                            ACTIVO</option>
                                        <option value="INACTIVO"
                                            {{ $cliente->usu_estado == 'INACTIVO' ? 'selected' : '' }}>INACTIVO</option>
                                        <option value="DESACTIVADO"
                                            {{ $cliente->usu_estado == 'DESACTIVADO' ? 'selected' : '' }}>DESACTIVADO
                                        </option>
                                        <option value="ELIMINADO"
                                            {{ $cliente->usu_estado == 'ELIMINADO' ? 'selected' : '' }}>ELIMINADO</option>
                                    </select>
                                    @error('estado')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <div class="d-md-flex d-grid align-items-center gap-3">
                                        <button type="submit" class="btn btn-primary px-4">Submit</button>
                                        <button type="reset" class="btn btn-light px-4">Reset</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="main-content-inner">
    <div class="row">
        <!-- data table start -->
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Create New Rutinas</h4>
                    @include('backend.layouts.partials.messages')

                    <form action="{{ route('admin.roles.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Rutinas Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter a Role Name">
                        </div>

                        <div class="form-group">
                            <label for="name">Permissions</label>

                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="checkPermissionAll" value="1">
                                <label class="form-check-label" for="checkPermissionAll">All</label>
                            </div>
                            <hr>
                            @php $i = 1; @endphp
                            @foreach ($permission_groups as $group)
                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="{{ $i }}Management" value="{{ $group->name }}" onclick="checkPermissionByGroup('role-{{ $i }}-management-checkbox', this)">
                                            <label class="form-check-label" for="checkPermission">{{ $group->name }}</label>
                                        </div>
                                    </div>

                                    <div class="col-9 role-{{ $i }}-management-checkbox">
                                        @php
                                            $permissions = App\User::getpermissionsByGroupName($group->name);
                                            $j = 1;
                                        @endphp
                                        @foreach ($permissions as $permission)
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" name="permissions[]" id="checkPermission{{ $permission->id }}" value="{{ $permission->name }}">
                                                <label class="form-check-label" for="checkPermission{{ $permission->id }}">{{ $permission->name }}</label>
                                            </div>
                                            @php  $j++; @endphp
                                        @endforeach
                                        <br>
                                    </div>

                                </div>
                                @php  $i++; @endphp
                            @endforeach


                        </div>


                        <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Save Rutina</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- data table end -->

    </div>
</div> --}}
@endsection

@section('scripts')
@endsection
