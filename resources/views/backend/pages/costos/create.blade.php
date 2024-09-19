@extends('backend.layouts.master')

@section('title')
    Costos nuevo - Admin Panel
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
                <div class="breadcrumb-title pe-3">Create Costos</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Nuevo costo</li>
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
                            <h5 class="mb-0">Registrar costo</h5>
                        </div>
                        <div class="card-body p-4">
                            <form class="row g-3 needs-validation" method="POST"
                                action="{{ route('admin.costos.store') }}">
                                @csrf
                                <div class="col-md-6">
                                    <label for="bsValidation9" class="form-label required_value">Periodo </label>
                                    <select id="periodo" name="periodo" class="form-select" onchange="setPeriodo(this)">
                                        <option selected disabled value>[PERIODO]</option>
                                        <option value="ANUAL" data-periodo="true" data-mes="12">ANUAL</option>
                                        <option value="MENSUAL" data-periodo="true" data-mes="1">MENSUAL</option>
                                        <option value="TRIMESTRAL" data-periodo="true" data-mes="3">TRIMESTRAL</option>
                                        <option value="SEMESTRAL" data-periodo="true" data-mes="6">SEMESTRAL</option>
                                        <option value="PRODUCTO" data-periodo="false">PRODUCTO</option>
                                    </select>
                                    @error('periodo')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <input type="hidden" name="meses" id="meses">
                                </div>
                                <div class="col-md-6">
                                    <label for="bsValidation9" class="form-label required_value">Monto </label>
                                    <input type="number" class="form-control" id="monto" name="monto"
                                        placeholder="Monto" step="any">
                                    @error('monto')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label for="bsValidation9" class="form-label">Nombre </label>
                                    <input type="text" id="nombre" name="nombre" class="form-control"
                                        placeholder="Nombre">
                                    @error('nombre')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div id="form-periodo" style="display:none" class="col-12 g-3 row">
                                    <div class="col-md-6">
                                        <label for="bsValidation9" class="form-label">Tipo </label>
                                        <select id="tipo" name="tipo" class="form-select">
                                            <option selected disabled value>[TIPO]</option>
                                            <option value="TODO">TODO INCLUIDO</option>
                                            <option value="MAQUINAS">SOLO MAQUINAS</option>
                                        </select>
                                        @error('tipo')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="bsValidation9" class="form-label">Ingresos por dia </label>
                                        <input type="number" placeholder="..." id="ingreso_dia" name="ingreso_dia"
                                            class="form-control">
                                        <span class="text-primary">Dias hábiles</span>
                                        @error('ingreso_dia')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="bsValidation9" class="form-label">Ingresos por semana </label>
                                        <input type="number" placeholder="..." id="ingreso_semana" name="ingreso_semana"
                                            class="form-control">
                                        <span class="text-primary">Dias hábiles</span>
                                        @error('ingreso_semana')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
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
    <script>
        function setPeriodo(select) {
            const periodo = $('#periodo option:selected').data('periodo')
            console.log(periodo);
            if (periodo) {
                $('#form-periodo').removeAttr('style')
                const meses = $('#periodo option:selected').data('mes')
                $('#meses').val(meses)
                $('#ingreso_dia').attr('value', 1)
                $('#ingreso_semana').attr('value', 7)
            } else {
                $('#form-periodo').attr('style', 'display:none;')
                $('#meses').val(0)
                $('#ingreso_dia').attr('value', 0)
                $('#ingreso_semana').attr('value', 0)
                $('#tipo').val('')
            }
        }
    </script>
@endsection
