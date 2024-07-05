@extends('backend.layouts.master')

@section('title')
    Costos - Admin Panel
@endsection

@section('styles')
@endsection


@section('admin-content')
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Costos</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Costos</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <div class="btn-group">
                        @if (Auth::guard('admin')->user()->can('cliente.view'))
                            <a href="{{ route('admin.costos.create') }}" class="btn btn-primary">Nuevo costo</a>
                        @endif
                        {{-- <button type="button"
                            class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split"
                            data-bs-toggle="dropdown"> <span class="visually-hidden">Toggle Dropdown</span>
                        </button> --}}
                        {{-- <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
                            <a class="dropdown-item" href="javascript:;">Action</a>
                            <a class="dropdown-item" href="javascript:;">Another action</a>
                            <a class="dropdown-item" href="javascript:;">Something else here</a>
                            <div class="dropdown-divider"></div> <a class="dropdown-item" href="javascript:;">Separated
                                link</a>
                        </div> --}}
                    </div>
                </div>
            </div>
            <!--end breadcrumb-->
            <h6 class="mb-0 text-uppercase">Lista de costos</h6>
            <hr />
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        @include('backend.layouts.partials.messages')
                        <table id="tabla_costos" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Tipo</th>
                                    <th>Periodo</th>
                                    <th>Monto</th>
                                    <th>Ingreso x dia</th>
                                    <th>Ingreso x semana</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($costos as $costo)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $costo->nombre }}</td>
                                        <td>
                                            @switch($costo->tipo)
                                                @case('TODO')
                                                    TODO INCLUIDO
                                                @break

                                                @case('MAQUINAS')
                                                    SOLO MAQUINAS
                                                @break

                                                @default
                                            @endswitch
                                        </td>
                                        <td><span class="badge bg-dark">{{ $costo->periodo }}</span></td>
                                        <td>{{ $costo->monto }}&nbsp;bs.</td>
                                        <td><span class="badge bg-primary">{{ $costo->ingreso_dia }}</span></td>
                                        <td><span class="badge bg-success">{{ $costo->ingreso_semana }}</span></td>
                                        <td>
                                            @if (Auth::guard('admin')->user()->can('costo.edit'))
                                                <a class="btn btn-sm btn-warning"
                                                    href="{{ route('admin.costos.edit', $costo->costo_id) }}">
                                                    <i class="bx bxs-edit"></i>
                                                </a>
                                            @endif

                                            @if (Auth::guard('admin')->user()->can('costo.view'))
                                                <a class="btn btn-danger text-white"
                                                    href="{{ route('admin.costos.destroy', $costo->costo_id) }}"
                                                    onclick="event.preventDefault(); document.getElementById('delete-form-{{ $costo->costo_id }}').submit();">
                                                    <i class='bx bxs-trash'></i>
                                                </a>
                                                <form id="delete-form-{{ $costo->costo_id }}"
                                                    action="{{ route('admin.costos.destroy', $costo->costo_id) }}"
                                                    method="POST" style="display: none;">
                                                    @method('DELETE')
                                                    @csrf
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @php
                                        $i++;
                                    @endphp
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Tipo</th>
                                    <th>Periodo</th>
                                    <th>Monto</th>
                                    <th>Ingreso x dia</th>
                                    <th>Ingreso x semana</th>
                                    <th>Acciones</th>
                                </tr>
                            </tfoot>
                        </table>
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
                    <h4 class="header-title float-left">Rutinas Lista</h4>
                    <p class="float-right mb-2">
                        @if (Auth::guard('admin')->user()->can('rutina.create'))
                            <a class="btn btn-primary text-white" href="{{ route('admin.rutinas.create') }}">Create New Rutina</a>
                        @endif
                    </p>
                    <div class="clearfix"></div>
                    <div class="data-tables">
                        @include('backend.layouts.partials.messages')
                        <table id="dataTable" class="text-center">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th width="5%">Sl</th>
                                    <th width="10%">Name</th>
                                    <th width="60%">Permissions</th>
                                    <th width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($rutinas as $rutina)
                               <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $rutina->rut_serie }}</td>
                                    <td>
                                        {{ $rutina->rut_peso }}
                                    </td>
                                    <td>
                                        @if (Auth::guard('admin')->user()->can('admin.edit'))
                                            <a class="btn btn-success text-white" href="{{ route('admin.rutinas.edit', $rutina->rut_id) }}">Edit</a>
                                        @endif

                                        @if (Auth::guard('admin')->user()->can('admin.edit'))
                                            <a class="btn btn-danger text-white" href="{{ route('admin.rutinas.destroy', $rutina->rut_id) }}"
                                            onclick="event.preventDefault(); document.getElementById('delete-form-{{ $rutina->rut_id }}').submit();">
                                                Delete
                                            </a>

                                            <form id="delete-form-{{ $rutina->rut_id }}" action="{{ route('admin.rutinas.destroy', $rutina->rut_id) }}" method="POST" style="display: none;">
                                                @method('DELETE')
                                                @csrf
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                               @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- data table end -->

    </div>
</div> --}}
@endsection


@section('scripts')
    <script>
        $(document).ready(function() {
            var table = $("#tabla_costos").DataTable({
                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                    "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Entradas",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
                lengthChange: false,
                buttons: ["copy", "excel", "pdf", "print"],
            });

            table
                .buttons()
                .container()
                .appendTo("#example2_wrapper .col-md-6:eq(0)");
        });
    </script>
@endsection
