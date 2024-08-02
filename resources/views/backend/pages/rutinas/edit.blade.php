@extends('backend.layouts.master')

@section('title')
    Editar rutina - Admin Panel
@endsection

@section('styles')
    <style>
        .img-flag {
            width: 50px;
            height: 50px;
            margin-right: 10px;
        }

        .select2-container--default .select2-selection--single {
            height: 55px;
            display: flex;
            align-items: center;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 50px;
            display: flex;
            align-items: center;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 50px;
        }

        .select2-results__option {
            display: flex;
            align-items: center;
            height: 50px;
        }
    </style>
@endsection


@section('admin-content')
    @php
        if (Auth::guard('admin')->check()) {
            $usr = Auth::guard('admin')->user();
            $guard = 'admin';
        } else {
            $usr = Auth::guard('user')->user();
            $guard = 'user';
        }
    @endphp
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Editar rutina</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Editar rutina</li>
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
                            <h5 class="mb-0">Actualizar rutina</h5>
                        </div>
                        <div class="card-body p-4">
                            <form class="row g-3 needs-validation" method="POST"
                                action="{{ route('admin.rutinas.update', $rutina->rut_id) }}">
                                @csrf
                                @method('PUT')
                                @if ($guard == 'admin')
                                    <div class="col-md-12">
                                        <label for="bsValidation9" class="form-label required_value">Usuario </label>
                                        <select id="usu_id" name="usu_id" class="form-select usu_id">
                                            <option selected disabled value>[CLIENTE]</option>
                                            @foreach ($clientes as $cliente)
                                                <option value="{{ $cliente->usu_id }}"
                                                    {{ $cliente->usu_id == $rutina->usu_id ? 'selected' : '' }}>
                                                    {{ $cliente->usu_nombre }}
                                                    {{ $cliente->usu_apellidos }}</option>
                                            @endforeach
                                        </select>
                                        @error('usu_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @else
                                    @if ($guard == 'user')
                                        @php
                                            foreach ($clientes as $cliente) {
                                                if (Auth::guard('user')->user()->usu_id == $cliente->usu_id) {
                                                    $id = $cliente->usu_id;
                                                    $nombre = $cliente->usu_nombre;
                                                    $apellidos = $cliente->usu_apellidos;
                                                }
                                            }
                                        @endphp
                                        <div class="col-md-12">
                                            <label for="bsValidation9" class="form-label required_value">Usuario </label>
                                            <input type="text" class="form-control"
                                                value="{{ $nombre }} {{ $apellidos }}" readonly>
                                            <input type="hidden" id="usu_id" name="usu_id" value="{{ $id }}">
                                            </input>
                                            @error('usu_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    @endif
                                @endif
                                <div class="col-md-8">
                                    <label for="bsValidation9" class="form-label required_value">Ejercicio </label>
                                    <select id="ejer_id" name="ejer_id" class="select-ejercicios form-select" required>
                                        <option value="{{ $rutina->ejer_id }}"
                                            data-image="{{ asset($rutina->ejercicio->ejer_imagen) }}">
                                            {{ $rutina->ejercicio->ejer_nombre }}
                                        </option>
                                        @foreach ($ejercicios as $ejer)
                                            <option value="{{ $ejer->ejer_id }}"
                                                data-image="{{ asset($ejer->ejer_imagen) }}">
                                                {{ $ejer->ejer_nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('ejer_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="bsValidation9" class="form-label required_value">Dia </label>
                                    <select id="dia" name="dia" class="form-select rut_dia" required>
                                        <option selected disabled value>[DIA]</option>
                                        <option value="1" {{ $rutina->rut_dia == 1 ? 'selected' : '' }}>
                                            Lunes
                                        </option>
                                        <option value="2" {{ $rutina->rut_dia == 2 ? 'selected' : '' }}>
                                            Martes
                                        </option>
                                        <option value="3" {{ $rutina->rut_dia == 3 ? 'selected' : '' }}>
                                            Miercoles
                                        </option>
                                        <option value="4" {{ $rutina->rut_dia == 4 ? 'selected' : '' }}>
                                            Jueves
                                        </option>
                                        <option value="5" {{ $rutina->rut_dia == 5 ? 'selected' : '' }}>
                                            Viernes
                                        </option>
                                        <option value="6" {{ $rutina->rut_dia == 6 ? 'selected' : '' }}>
                                            Sabado
                                        </option>
                                        <option value="7" {{ $rutina->rut_dia == 7 ? 'selected' : '' }}>
                                            Domingo
                                        </option>
                                    </select>
                                    @error('dia')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-2">
                                    <label for="bsValidation9" class="form-label required_value">Serie </label>
                                    <input type="number" class="form-control" id="serie" name="serie"
                                        placeholder="Serie" step="1" min="0" value="{{ $rutina->rut_serie }}">
                                    @error('serie')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="bsValidation9" class="form-label required_value">Repeticiones </label>
                                    <input type="number" class="form-control" id="repeticiones" name="repeticiones"
                                        placeholder="Repeticiones" step="1" min="0"
                                        value="{{ $rutina->rut_repeticiones }}">
                                    @error('repeticiones')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-2">
                                    <label for="bsValidation9" class="form-label required_value">Peso </label>
                                    <input type="number" class="form-control" id="peso" name="peso"
                                        placeholder="Peso" step="1" min="0" value="{{ $rutina->rut_peso }}">
                                    @error('peso')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-2">
                                    <label for="bsValidation9" class="form-label required_value">RID </label>
                                    <input type="number" class="form-control" id="rid" name="rid"
                                        placeholder="RID" step="1" min="0" value="{{ $rutina->rut_rid }}">
                                    @error('rid')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="bsValidation9" class="form-label required_value">Tiempo </label>
                                    <input type="number" class="form-control" id="tiempo" name="tiempo"
                                        placeholder="Tiempo" step="1" min="0"
                                        value="{{ $rutina->rut_tiempo }}">
                                    @error('tiempo')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="bsValidation9" class="form-label required_value">Fecha inicial </label>
                                    <input type="date" class="form-control" id="date_ini" name="date_ini"
                                        value="{{ $rutina->rut_date_ini }}">
                                    @error('date_ini')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="bsValidation9" class="form-label required_value">Fecha final </label>
                                    <input type="date" class="form-control" id="date_fin" name="date_fin"
                                        value="{{ $rutina->rut_date_fin }}">
                                    @error('date_fin')
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            function formatState(state) {
                if (!state.id) {
                    return state.text;
                }
                var image = state.element.getAttribute('data-image');
                var baseUrl = '';
                const extensionesValidas = /\.(png|jpg|jpeg)$/i;

                if (extensionesValidas.test(image)) {
                    baseUrl = image;
                } else {
                    baseUrl = image + "modo-gym/blank.png";
                }
                var $state = $(
                    '<span><img src="' + baseUrl + '" class="img-flag" /> ' + state.text + '</span>'
                );
                return $state;
            };

            $('.select-ejercicios').select2({
                templateResult: formatState,
                templateSelection: formatState
            });
        })
    </script>
@endsection
