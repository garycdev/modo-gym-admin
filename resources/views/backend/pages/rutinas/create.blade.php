@extends('backend.layouts.master')

@section('title')
    Nueva rutina - Admin Panel
@endsection

@section('styles')
    <style>
        .custom-checkbox {
            display: none;
        }

        .custom-card {
            cursor: pointer;
            transition: border-color 0.3s;
        }

        .card-body {
            padding: 5px;
        }

        .card-title {
            display: inline-block;
        }

        .custom-checkbox:checked+.custom-card {
            border: 2px solid #007bff;
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

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="ejercicios_rutina">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar ejercicios</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                        onclick="resetEjerciciosRutina()"></button>
                                </div>
                                <div class="modal-body">
                                    @foreach ($ejercicios as $ejer)
                                        <input type="checkbox" name="ejercicios[]" id="{{ $ejer->ejer_id }}"
                                            class="custom-checkbox" data-name="{{ $ejer->ejer_nombre }}"
                                            data-image="{{ asset($ejer->ejer_imagen) }}">
                                        <label for="{{ $ejer->ejer_id }}" class="card custom-card p-3">
                                            <div class="card-body d-flex justify-content-between align-items-center">
                                                <div>
                                                    <img src="{{ asset($ejer->ejer_imagen) }}"
                                                        alt="Ejercicio {{ $ejer->ejer_id }}" width="50">
                                                    <h6 class="card-title">{{ $ejer->ejer_nombre }}</h6>
                                                </div>
                                                <p class="p-0 m-0" style="font-size:0.8em;">
                                                    <span class="fw-bold">Equipo: </span>{{ $ejer->equipo->equi_nombre }}
                                                    <br>
                                                    <span class="fw-bold">Musculo: </span>{{ $ejer->musculo->mus_nombre }}
                                                </p>
                                                <span class="align-end badge bg-dark">Nivel {{ $ejer->ejer_nivel }}</span>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                        onclick="resetEjerciciosRutina()">Cerrar</button>
                                    <button type="button" class="btn btn-dark"
                                        onclick="resetEjerciciosRutina()">Vaciar</button>
                                    <button type="button" class="btn btn-success" onclick="agregarEjercicios()"
                                        data-bs-dismiss="modal">Agregar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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
                                <div class="col-md-8">
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
                                <div class="col-md-4">
                                    <label for="bsValidation9" class="form-label required_value">Dia </label>
                                    <select id="rut_dia" name="rut_dia" class="form-select rut_dia">
                                        <option selected disabled value>[DIA]</option>
                                        <option value="1">Lunes</option>
                                        <option value="2">Martes</option>
                                        <option value="3">Miercoles</option>
                                        <option value="4">Jueves</option>
                                        <option value="5">Viernes</option>
                                        <option value="6">Sabado</option>
                                        <option value="7">Domingo</option>
                                    </select>
                                    @error('rut_dia')
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
                                <button type="button" class="btn btn-primary w-100 mb-3" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal" onclick="addEjercicios(1)">
                                    Agregar ejercicios
                                </button>
                                <div id="rutinas">

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
        let ejercicios = 0;

        function agregarEjercicios() {
            var selectEjercicios = [];

            $('#ejercicios_rutina input[name="ejercicios[]"]:checked').each(function() {
                var id = $(this).attr('id');
                var name = $(this).data('name');
                var image = $(this).data('image');
                selectEjercicios.push({
                    id: id,
                    name: name,
                    image: image
                });
            });
            console.log(selectEjercicios);

            selectEjercicios.forEach(element => {
                $('#rutinas').append(`<hr><div id="ejercicio_${ejercicios}" class="mb-3">
                                        <div class="col-md-12 mb-3 d-flex justify-content-between align-items-center">
                                            <img src="${element.image}" alt=""
                                                width="75">
                                            <h5>${element.name}</h5>
                                            <input type="hidden" name="id_ejer[${ejercicios}][]" value="${element.id}">
                                            <button type="button" class="btn btn-danger" onclick="deleteEjercicio(${ejercicios})">Eliminar</button>
                                        </div>
                                        <div class="series_${ejercicios} col-md-12 w-75 m-auto">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label for="" class="form-label">Serie </label>
                                                    <input type="number" class="form-control" name="series[${ejercicios}][serie][]"
                                                        readonly value="1">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="" class="form-label">Peso </label>
                                                    <input type="number" class="form-control" name="series[${ejercicios}][peso][]"
                                                        placeholder="Peso" step="1" min="0">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="" class="form-label">Repeticiones
                                                    </label>
                                                    <input type="number" class="form-control" name="series[${ejercicios}][rep][]"
                                                        placeholder="Repeticiones" step="1" min="1">
                                                </div>
                                                <div class="col-md-1 d-flex align-items-center justify-content-around">
                                                    <button type="button" class="btn btn-danger"
                                                        onclick="removeSerie()">-</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-3 w-75 m-auto">
                                            <button type="button" class="btn btn-secondary w-100">
                                                Agregar serie
                                            </button>
                                        </div>
                                    </div>`);
                ejercicios++
            });
            resetEjerciciosRutina()
        }

        function deleteEjercicio(ejer) {
            $('#ejercicio_' + ejer).remove()
        }

        function resetEjerciciosRutina() {
            const semana = $('#semana').val()
            $('#ejercicios_rutina')[0].reset()
            $('#semana').val(semana)
        }
    </script>
@endsection
