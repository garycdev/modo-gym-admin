@extends('backend.layouts.master')

@section('title')
    Nueva rutina - Admin Panel
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
                <div class="breadcrumb-title pe-3">Nueva rutina</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Crear rutina</li>
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
                            <h5 class="mb-0">Registrar rutinas</h5>
                        </div>
                        <div class="card-body p-4">
                            <form class="row g-3 needs-validation" method="POST"
                                action="{{ route('admin.rutinas.store') }}">
                                @csrf
                                <div class="col-md-12">
                                    <label for="bsValidation9" class="form-label required_value">Usuario </label>
                                    <select id="usu_id" name="usu_id" class="form-select usu_id"
                                        onchange="selectUser()">
                                        <option selected disabled value>[USUARIO]</option>
                                        @foreach ($clientes as $cliente)
                                            <option value="{{ $cliente->usu_id }}" data-fecha="{{ $cliente->pago_fecha }}"
                                                data-mes="{{ $cliente->mes }}">
                                                {{ $cliente->usu_nombre }}
                                                {{ $cliente->usu_apellidos }}</option>
                                        @endforeach
                                    </select>
                                    @error('usu_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 fechas" style="display: none">
                                    <label for="bsValidation9" class="form-label">Fecha inicio </label>
                                    <input type="date" class="form-control" id="fecha_ini" name="fecha_ini" readonly>
                                </div>
                                <div class="col-md-6 fechas" style="display: none">
                                    <label for="bsValidation9" class="form-label">Fecha fin </label>
                                    <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" readonly>
                                </div>
                                <hr>
                                <div class="accordion" id="accordionExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#lunes" aria-expanded="true" aria-controls="lunes">
                                                Lunes
                                            </button>
                                        </h2>
                                        <div id="lunes" class="accordion-collapse collapse show"
                                            data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <div id="rutinas_1">
                                                    <input type="hidden" name="rut_1" id="rut_1" value="0">
                                                    <div id="rutina_1_0" class="row">
                                                        <div class="col-md-4">
                                                            <label for="ejer_id-1_0" class="form-label">Ejercicio </label>
                                                            <select id="ejer_id-1_0" name="ejer_id-1_0"
                                                                class="form-select ejer_id" onchange="setEjercicio(1, 0)">
                                                                <option selected disabled value>[EJERCICIO]
                                                                </option>
                                                                @foreach ($ejercicios as $ejer)
                                                                    <option value="{{ $ejer->ejer_id }}"
                                                                        data-tipo="{{ $ejer->equipo->tipo }}">
                                                                        {{ $ejer->ejer_nombre }}
                                                                        [{{ $ejer->equipo->equi_nombre }} -
                                                                        {{ $ejer->musculo->mus_nombre }}]</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="serie-1_0" class="form-label">Serie </label>
                                                            <input type="number" class="form-control" id="serie-1_0"
                                                                name="serie-1_0" placeholder="Serie" readonly step="1"
                                                                min="1">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="repeticiones-1_0" class="form-label">Repeticiones
                                                            </label>
                                                            <input type="number" class="form-control" id="repeticiones-1_0"
                                                                name="repeticiones-1_0" placeholder="Repeticiones"
                                                                step="1" min="1">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="peso-1_0" class="form-label">Peso </label>
                                                            <input type="number" class="form-control" id="peso-1_0"
                                                                name="peso-1_0" placeholder="Peso" step="1"
                                                                min="0" disabled="disabled">
                                                        </div>
                                                        <div
                                                            class="col-md-2 d-flex align-items-center justify-content-around">
                                                            <button type="button" class="btn btn-success"
                                                                onclick="addEjercicio('1')" id="btn_1" disabled
                                                                id="btn_1">+</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#martes" aria-expanded="false"
                                                aria-controls="martes">
                                                Martes
                                            </button>
                                        </h2>
                                        <div id="martes" class="accordion-collapse collapse"
                                            data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <div id="rutinas_2">
                                                    <input type="hidden" name="rut_2" id="rut_2" value="0">
                                                    <div id="rutina_2_0" class="row">
                                                        <div class="col-md-4">
                                                            <label for="ejer_id-2_0" class="form-label">Ejercicio </label>
                                                            <select id="ejer_id-2_0" name="ejer_id-2_0"
                                                                class="form-select ejer_id" onchange="setEjercicio(2, 0)">
                                                                <option selected disabled value>[EJERCICIO]
                                                                </option>
                                                                @foreach ($ejercicios as $ejer)
                                                                    <option value="{{ $ejer->ejer_id }}"
                                                                        data-tipo="{{ $ejer->equipo->tipo }}">
                                                                        {{ $ejer->ejer_nombre }}
                                                                        [{{ $ejer->equipo->equi_nombre }} -
                                                                        {{ $ejer->musculo->mus_nombre }}]</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="serie-2_0" class="form-label">Serie </label>
                                                            <input type="number" class="form-control" id="serie-2_0"
                                                                name="serie-2_0" placeholder="Serie" readonly
                                                                step="1" min="1">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="repeticiones-2_0" class="form-label">Repeticiones
                                                            </label>
                                                            <input type="number" class="form-control"
                                                                id="repeticiones-2_0" name="repeticiones-2_0"
                                                                placeholder="Repeticiones" step="1" min="1">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="peso-2_0" class="form-label">Peso </label>
                                                            <input type="number" class="form-control" id="peso-2_0"
                                                                name="peso-2_0" placeholder="Peso" step="1"
                                                                min="0" disabled="disabled">
                                                        </div>
                                                        <div
                                                            class="col-md-2 d-flex align-items-center justify-content-around">
                                                            <button type="button" class="btn btn-success"
                                                                onclick="addEjercicio('2')" disabled
                                                                id="btn_2">+</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#miercoles"
                                                aria-expanded="false" aria-controls="miercoles">
                                                Miercoles
                                            </button>
                                        </h2>
                                        <div id="miercoles" class="accordion-collapse collapse"
                                            data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <div id="rutinas_3">
                                                    <input type="hidden" name="rut_3" id="rut_3" value="0">
                                                    <div id="rutina_3_0" class="row">
                                                        <div class="col-md-4">
                                                            <label for="ejer_id-3_0" class="form-label">Ejercicio
                                                            </label>
                                                            <select id="ejer_id-3_0" name="ejer_id-3_0"
                                                                class="form-select ejer_id" onchange="setEjercicio(3, 0)">
                                                                <option selected disabled value>[EJERCICIO]
                                                                </option>
                                                                @foreach ($ejercicios as $ejer)
                                                                    <option value="{{ $ejer->ejer_id }}"
                                                                        data-tipo="{{ $ejer->equipo->tipo }}">
                                                                        {{ $ejer->ejer_nombre }}
                                                                        [{{ $ejer->equipo->equi_nombre }} -
                                                                        {{ $ejer->musculo->mus_nombre }}]</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="serie-3_0" class="form-label">Serie </label>
                                                            <input type="number" class="form-control" id="serie-3_0"
                                                                name="serie-3_0" placeholder="Serie" readonly
                                                                step="1" min="1">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="repeticiones-3_0" class="form-label">Repeticiones
                                                            </label>
                                                            <input type="number" class="form-control"
                                                                id="repeticiones-3_0" name="repeticiones-3_0"
                                                                placeholder="Repeticiones" step="1" min="1">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="peso-3_0" class="form-label">Peso </label>
                                                            <input type="number" class="form-control" id="peso-3_0"
                                                                name="peso-3_0" placeholder="Peso" step="1"
                                                                min="0" disabled="disabled">
                                                        </div>
                                                        <div
                                                            class="col-md-2 d-flex align-items-center justify-content-around">
                                                            <button type="button" class="btn btn-success"
                                                                onclick="addEjercicio('3')" disabled
                                                                id="btn_3">+</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#jueves" aria-expanded="false"
                                                aria-controls="jueves">
                                                Jueves
                                            </button>
                                        </h2>
                                        <div id="jueves" class="accordion-collapse collapse"
                                            data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <div id="rutinas_4">
                                                    <input type="hidden" name="rut_4" id="rut_4" value="0">
                                                    <div id="rutina_4_0" class="row">
                                                        <div class="col-md-4">
                                                            <label for="ejer_id-4_0" class="form-label">Ejercicio
                                                            </label>
                                                            <select id="ejer_id-4_0" name="ejer_id-4_0"
                                                                class="form-select ejer_id" onchange="setEjercicio(4, 0)">
                                                                <option selected disabled value>[EJERCICIO]
                                                                </option>
                                                                @foreach ($ejercicios as $ejer)
                                                                    <option value="{{ $ejer->ejer_id }}"
                                                                        data-tipo="{{ $ejer->equipo->tipo }}">
                                                                        {{ $ejer->ejer_nombre }}
                                                                        [{{ $ejer->equipo->equi_nombre }} -
                                                                        {{ $ejer->musculo->mus_nombre }}]</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="serie-4_0" class="form-label">Serie </label>
                                                            <input type="number" class="form-control" id="serie-4_0"
                                                                name="serie-4_0" placeholder="Serie" readonly
                                                                step="1" min="1">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="repeticiones-4_0" class="form-label">Repeticiones
                                                            </label>
                                                            <input type="number" class="form-control"
                                                                id="repeticiones-4_0" name="repeticiones-4_0"
                                                                placeholder="Repeticiones" step="1" min="1">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="peso-4_0" class="form-label">Peso </label>
                                                            <input type="number" class="form-control" id="peso-4_0"
                                                                name="peso-4_0" placeholder="Peso" step="1"
                                                                min="0" disabled="disabled">
                                                        </div>
                                                        <div
                                                            class="col-md-2 d-flex align-items-center justify-content-around">
                                                            <button type="button" class="btn btn-success"
                                                                onclick="addEjercicio('4')" disabled
                                                                id="btn_4">+</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#viernes" aria-expanded="false"
                                                aria-controls="viernes">
                                                Viernes
                                            </button>
                                        </h2>
                                        <div id="viernes" class="accordion-collapse collapse"
                                            data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <div id="rutinas_5">
                                                    <input type="hidden" name="rut_5" id="rut_5" value="0">
                                                    <div id="rutina_5_0" class="row">
                                                        <div class="col-md-4">
                                                            <label for="ejer_id-5_0" class="form-label">Ejercicio </label>
                                                            <select id="ejer_id-5_0" name="ejer_id-5_0"
                                                                class="form-select ejer_id" onchange="setEjercicio(5, 0)">
                                                                <option selected disabled value>[EJERCICIO]
                                                                </option>
                                                                @foreach ($ejercicios as $ejer)
                                                                    <option value="{{ $ejer->ejer_id }}"
                                                                        data-tipo="{{ $ejer->equipo->tipo }}">
                                                                        {{ $ejer->ejer_nombre }}
                                                                        [{{ $ejer->equipo->equi_nombre }} -
                                                                        {{ $ejer->musculo->mus_nombre }}]</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="serie-5_0" class="form-label">Serie </label>
                                                            <input type="number" class="form-control" id="serie-5_0"
                                                                name="serie-5_0" placeholder="Serie" readonly
                                                                step="1" min="1">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="repeticiones-5_0" class="form-label">Repeticiones
                                                            </label>
                                                            <input type="number" class="form-control"
                                                                id="repeticiones-5_0" name="repeticiones-5_0"
                                                                placeholder="Repeticiones" step="1" min="1">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="peso-5_0" class="form-label">Peso </label>
                                                            <input type="number" class="form-control" id="peso-5_0"
                                                                name="peso-5_0" placeholder="Peso" step="1"
                                                                min="0" disabled="disabled">
                                                        </div>
                                                        <div
                                                            class="col-md-2 d-flex align-items-center justify-content-around">
                                                            <button type="button" class="btn btn-success"
                                                                onclick="addEjercicio('5')" disabled
                                                                id="btn_5">+</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#sabado" aria-expanded="false"
                                                aria-controls="sabado">
                                                Sabado
                                            </button>
                                        </h2>
                                        <div id="sabado" class="accordion-collapse collapse"
                                            data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <div id="rutinas_6">
                                                    <input type="hidden" name="rut_6" id="rut_6" value="0">
                                                    <div id="rutina_6_0" class="row">
                                                        <div class="col-md-4">
                                                            <label for="ejer_id-6_0" class="form-label">Ejercicio </label>
                                                            <select id="ejer_id-6_0" name="ejer_id-6_0"
                                                                class="form-select ejer_id" onchange="setEjercicio(6, 0)">
                                                                <option selected disabled value>[EJERCICIO]
                                                                </option>
                                                                @foreach ($ejercicios as $ejer)
                                                                    <option value="{{ $ejer->ejer_id }}"
                                                                        data-tipo="{{ $ejer->equipo->tipo }}">
                                                                        {{ $ejer->ejer_nombre }}
                                                                        [{{ $ejer->equipo->equi_nombre }} -
                                                                        {{ $ejer->musculo->mus_nombre }}]</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="serie-6_0" class="form-label">Serie </label>
                                                            <input type="number" class="form-control" id="serie-6_0"
                                                                name="serie-6_0" placeholder="Serie" readonly
                                                                step="1" min="1">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="repeticiones-6_0" class="form-label">Repeticiones
                                                            </label>
                                                            <input type="number" class="form-control"
                                                                id="repeticiones-6_0" name="repeticiones-6_0"
                                                                placeholder="Repeticiones" step="1" min="1">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="peso-6_0" class="form-label">Peso </label>
                                                            <input type="number" class="form-control" id="peso-6_0"
                                                                name="peso-6_0" placeholder="Peso" step="1"
                                                                min="0" disabled="disabled">
                                                        </div>
                                                        <div
                                                            class="col-md-2 d-flex align-items-center justify-content-around">
                                                            <button type="button" class="btn btn-success"
                                                                onclick="addEjercicio('6')" disabled
                                                                id="btn_6">+</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#domingo" aria-expanded="false"
                                                aria-controls="domingo">
                                                Domingo
                                            </button>
                                        </h2>
                                        <div id="domingo" class="accordion-collapse collapse"
                                            data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <div id="rutinas_7">
                                                    <input type="hidden" name="rut_7" id="rut_7" value="0">
                                                    <div id="rutina_7_0" class="row">
                                                        <div class="col-md-4">
                                                            <label for="ejer_id-7_0" class="form-label">Ejercicio </label>
                                                            <select id="ejer_id-7_0" name="ejer_id-7_0"
                                                                class="form-select ejer_id" onchange="setEjercicio(7, 0)">
                                                                <option selected disabled value>[EJERCICIO]
                                                                </option>
                                                                @foreach ($ejercicios as $ejer)
                                                                    <option value="{{ $ejer->ejer_id }}"
                                                                        data-tipo="{{ $ejer->equipo->tipo }}">
                                                                        {{ $ejer->ejer_nombre }}
                                                                        [{{ $ejer->equipo->equi_nombre }} -
                                                                        {{ $ejer->musculo->mus_nombre }}]</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="serie-7_0" class="form-label">Serie </label>
                                                            <input type="number" class="form-control" id="serie-7_0"
                                                                name="serie-7_0" placeholder="Serie" readonly
                                                                step="1" min="1">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="repeticiones-7_0" class="form-label">Repeticiones
                                                            </label>
                                                            <input type="number" class="form-control"
                                                                id="repeticiones-7_0" name="repeticiones-7_0"
                                                                placeholder="Repeticiones" step="1" min="1">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="peso-7_0" class="form-label">Peso </label>
                                                            <input type="number" class="form-control" id="peso-7_0"
                                                                name="peso-7_0" placeholder="Peso" step="1"
                                                                min="0" disabled="disabled">
                                                        </div>
                                                        <div
                                                            class="col-md-2 d-flex align-items-center justify-content-around">
                                                            <button type="button" class="btn btn-success"
                                                                onclick="addEjercicio('7')" disabled
                                                                id="btn_7">+</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        let rutina_1 = 1;
        let rutina_2 = 1;
        let rutina_3 = 1;
        let rutina_4 = 1;
        let rutina_5 = 1;
        let rutina_6 = 1;
        let rutina_7 = 1;

        $(document).ready(function() {
            $('.usu_id').select2();
        });

        function selectUser() {
            const fecha_ini = $('#usu_id option:selected').data('fecha');
            const meses = parseInt($('#usu_id option:selected').data('mes'), 10);

            $('#fecha_ini').val(fecha_ini);

            const fecha = new Date(fecha_ini);
            // fecha.setHours(0, 0, 0, 0);
            fecha.setDate(fecha.getDate() + (meses * 31));

            const anio = fecha.getFullYear();
            const mes = ('0' + (fecha.getMonth() + 1)).slice(-2);
            const dia = ('0' + fecha.getDate()).slice(-2);
            const fecha_fin = `${anio}-${mes}-${dia}`;

            $('#fecha_fin').val(fecha_fin);

            $('.fechas').css('display', 'block');
        }

        function setEjercicio(dia, ejer) {
            const tipo = $('#ejer_id-' + dia + '_' + ejer + ' option:selected').data('tipo');
            if (tipo == 'peso') {
                $('#peso-' + dia + '_' + ejer).removeAttr('disabled');
            } else {
                $('#peso-' + dia + '_' + ejer).attr('disabled', 'disabled');
            }
            console.log(eval('rutina_' + dia));
            $('#serie-' + dia + '_' + ejer).val(eval('rutina_' + dia))
            $('#btn_' + dia).removeAttr('disabled')
            $('#ejer_id' + dia + '_' + ejer).css('readonly', true);
            // addEjercicio(dia)
        }

        function addEjercicio(dia) {
            const rutina_index = 'rutina_' + dia;
            $('#rut_' + dia).val(eval(rutina_index));
            $('#btnRemove_' + (rutina_index - 1)).css('display', 'none');
            const template = `<div id="rutina_${dia}_${eval(rutina_index)}" class="row">
                                <div class="col-md-4">
                                    <label for="ejer_id-${dia}_${eval(rutina_index)}" class="form-label">Ejercicio </label>
                                    <select id="ejer_id-${dia}_${eval(rutina_index)}" name="ejer_id-${dia}_${eval(rutina_index)}"
                                        class="form-select ejer_id" onchange="setEjercicio(${dia}, ${eval(rutina_index)})">
                                        <option selected disabled value>[EJERCICIO]
                                        </option>
                                        @foreach ($ejercicios as $ejer)
                                            <option value="{{ $ejer->ejer_id }}"
                                                data-tipo="{{ $ejer->equipo->tipo }}">
                                                {{ $ejer->ejer_nombre }}
                                                [{{ $ejer->equipo->equi_nombre }} -
                                                {{ $ejer->musculo->mus_nombre }}]</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="serie-${dia}_${eval(rutina_index)}" class="form-label">Serie </label>
                                    <input type="number" class="form-control" id="serie-${dia}_${eval(rutina_index)}"
                                        name="serie-${dia}_${eval(rutina_index)}" placeholder="Serie" readonly step="1"
                                        min="1" >
                                </div>
                                <div class="col-md-2">
                                    <label for="repeticiones-${dia}_${eval(rutina_index)}" class="form-label">Repeticiones
                                    </label>
                                    <input type="number" class="form-control"
                                        id="repeticiones-${dia}_${eval(rutina_index)}" name="repeticiones-${dia}_${eval(rutina_index)}"
                                        placeholder="Repeticiones" step="1" min="1"
                                        >
                                </div>
                                <div class="col-md-2">
                                    <label for="peso-${dia}_${eval(rutina_index)}" class="form-label">Peso </label>
                                    <input type="number" class="form-control" id="peso-${dia}_${eval(rutina_index)}"
                                        name="peso-${dia}_${eval(rutina_index)}" placeholder="Peso" step="1"
                                        min="0" disabled="disabled" >
                                </div>
                                <div
                                    class="col-md-2 d-flex align-items-center justify-content-around">
                                    <button type="button" class="btn btn-danger"
                                        onclick="removeEjercicio(${dia}, ${eval(rutina_index)})" id="btnRemove_${dia}_${eval(rutina_index)}">-</button>
                                </div>
                            </div>`
            $('#btnRemove_' + dia + '_' + (eval(rutina_index) - 1)).css('display', 'none')
            eval('rutina_' + dia + ' += 1')

            $('#rutinas_' + dia).append(template)
            $('#btn_' + dia).attr('disabled', 'disabled')
        }

        function removeEjercicio(dia, ejer) {
            $('#rutina_' + dia + '_' + ejer).remove();
            $('#btnRemove_' + dia + '_' + (ejer - 1)).css('display', 'block');
            eval('rutina_' + dia + ' -= 1')
            $('#btn_' + dia).removeAttr('disabled')
        }
    </script>
@endsection
