@extends('backend.layouts.master')

@section('title')
    Pagos - Admin Panel
@endsection

@section('styles')
    <style>
        .max-width-td {
            width: 350px !important;
            max-width: 500px !important;
            white-space: normal;
            word-wrap: break-word;
            overflow: hidden;
            font-size: 0.8em;
        }
    </style>
@endsection


@section('admin-content')
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Pagos</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Pagos</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <div class="btn-group">
                        @if (Auth::guard('admin')->user()->can('pago.create'))
                            <a href="{{ route('admin.pagos.create') }}" class="btn btn-primary">Registrar pago</a>
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
            <h6 class="mb-0 text-uppercase">Lista de pagos</h6>
            <hr />
            <div class="card">
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label for="filter-select" class="form-label">Filtrar por: </label>
                        <select name="filter" id="filter-select" class="form-select filter-select">
                            <option value="">[TODO]</option>
                            @foreach ($costos as $costo)
                                <option value="{{ $costo->nombre }}">{{ strtoupper($costo->nombre) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="table-responsive">
                        @include('backend.layouts.partials.messages')
                        <table id="tabla_pagos" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Cliente</th>
                                    <th>CI</th>
                                    <th>Cel</th>
                                    <th>Pago</th>
                                    <th>Costo</th>
                                    <th>Fecha</th>
                                    <th>Registro</th>
                                    {{-- <th>Metodo</th> --}}
                                    <th>Dias</th>
                                    <th>Estado</th>
                                    <th>Observacion</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                    use Carbon\Carbon;
                                @endphp
                                @foreach ($pagos as $pago)
                                    @php
                                        // Fecha de pago obtenida del modelo $pago
                                        $fechaPago = new DateTime($pago->pago_fecha); // Convertir a objeto DateTime para asegurar formato

                                        // Calcular la fecha límite para completar el mes
                                        $fechaLimite = clone $fechaPago;
                                        $fechaLimite->modify('+' . $pago->costo->mes * 30 . ' days'); // Sumar el número de meses correspondiente

                                        // Fecha actual sin la hora (00:00:00)
                                        // $fechaActual = new \DateTime(); // Fecha actual sin la hora (00:00:00)
                                        $fechaActual = today(); // Se usa today() en lugar de now()

                                        // Calcular la diferencia en días
                                        $diff = $fechaActual->diff($fechaLimite);
                                        $diferenciaDias = $diff->format('%r%a'); // Obtener la diferencia en días con el signo

                                        // Determinar el estilo del badge basado en los días restantes
                                        $badgeClass = $diferenciaDias > 0 ? 'bg-warning text-black' : 'bg-danger'; // Si faltan días, usar warning, si no, danger

                                        $asistencias = 0;

                                        // Texto de días restantes para completar el mes
                                        if ($diferenciaDias > 0) {
                                            if ($diferenciaDias >= $pago->costo->mes * 30) {
                                                $textoFaltante = $pago->costo->mes * 30 . ' días';
                                            } else {
                                                $textoFaltante = "$diferenciaDias días";
                                            }
                                        } elseif ($diferenciaDias == 0) {
                                            $textoFaltante = 'Hoy es el último día';
                                            // } elseif (
                                            //     $diferenciaDias >= -30 &&
                                            //     $diferenciaDias < 0 &&
                                            //     count($pago->cliente->asistencias(abs($diferenciaDias))) > 0
                                            // ) {
                                            //     $textoFaltante = 'Se pasaron ' . abs($diferenciaDias) . ' días';
                                            //     $asistencias = count($pago->cliente->asistencias(abs($diferenciaDias)));
                                        } else {
                                            $textoFaltante = 0;
                                        }
                                    @endphp
                                    {{-- @if ($diferenciaDias >= 0 || ($diferenciaDias >= -30 && $asistencias > 0)) --}}
                                    @if ($diferenciaDias >= 0)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $pago->cliente->usu_nombre }} {{ $pago->cliente->usu_apellidos }}</td>
                                            <td>
                                                {{ $pago->cliente->usu_ci }}
                                            </td>
                                            <td>
                                                {{ $pago->cliente->usu_celular }}
                                                @if ($pago->cliente->usu_celular)
                                                    <br>
                                                    <a href="https://wa.me/591{{ $pago->cliente->usu_celular }}"
                                                        class="btn btn-sm btn-success" target="_blank">
                                                        <svg fill="#ffffff" height="15px" width="15px" version="1.1"
                                                            id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 308 308"
                                                            xml:space="preserve">
                                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                                stroke-linejoin="round"></g>
                                                            <g id="SVGRepo_iconCarrier">
                                                                <g id="XMLID_468_">
                                                                    <path id="XMLID_469_"
                                                                        d="M227.904,176.981c-0.6-0.288-23.054-11.345-27.044-12.781c-1.629-0.585-3.374-1.156-5.23-1.156 c-3.032,0-5.579,1.511-7.563,4.479c-2.243,3.334-9.033,11.271-11.131,13.642c-0.274,0.313-0.648,0.687-0.872,0.687 c-0.201,0-3.676-1.431-4.728-1.888c-24.087-10.463-42.37-35.624-44.877-39.867c-0.358-0.61-0.373-0.887-0.376-0.887 c0.088-0.323,0.898-1.135,1.316-1.554c1.223-1.21,2.548-2.805,3.83-4.348c0.607-0.731,1.215-1.463,1.812-2.153 c1.86-2.164,2.688-3.844,3.648-5.79l0.503-1.011c2.344-4.657,0.342-8.587-0.305-9.856c-0.531-1.062-10.012-23.944-11.02-26.348 c-2.424-5.801-5.627-8.502-10.078-8.502c-0.413,0,0,0-1.732,0.073c-2.109,0.089-13.594,1.601-18.672,4.802 c-5.385,3.395-14.495,14.217-14.495,33.249c0,17.129,10.87,33.302,15.537,39.453c0.116,0.155,0.329,0.47,0.638,0.922 c17.873,26.102,40.154,45.446,62.741,54.469c21.745,8.686,32.042,9.69,37.896,9.69c0.001,0,0.001,0,0.001,0 c2.46,0,4.429-0.193,6.166-0.364l1.102-0.105c7.512-0.666,24.02-9.22,27.775-19.655c2.958-8.219,3.738-17.199,1.77-20.458 C233.168,179.508,230.845,178.393,227.904,176.981z">
                                                                    </path>
                                                                    <path id="XMLID_470_"
                                                                        d="M156.734,0C73.318,0,5.454,67.354,5.454,150.143c0,26.777,7.166,52.988,20.741,75.928L0.212,302.716 c-0.484,1.429-0.124,3.009,0.933,4.085C1.908,307.58,2.943,308,4,308c0.405,0,0.813-0.061,1.211-0.188l79.92-25.396 c21.87,11.685,46.588,17.853,71.604,17.853C240.143,300.27,308,232.923,308,150.143C308,67.354,240.143,0,156.734,0z M156.734,268.994c-23.539,0-46.338-6.797-65.936-19.657c-0.659-0.433-1.424-0.655-2.194-0.655c-0.407,0-0.815,0.062-1.212,0.188 l-40.035,12.726l12.924-38.129c0.418-1.234,0.209-2.595-0.561-3.647c-14.924-20.392-22.813-44.485-22.813-69.677 c0-65.543,53.754-118.867,119.826-118.867c66.064,0,119.812,53.324,119.812,118.867 C276.546,215.678,222.799,268.994,156.734,268.994z">
                                                                    </path>
                                                                </g>
                                                            </g>
                                                        </svg>
                                                    </a>
                                                    <a href="https://web.whatsapp.com/send?phone=591{{ $pago->cliente->usu_celular }}"
                                                        class="btn btn-sm btn-success" target="_blank">
                                                        <svg fill="#ffffff" height="15px" width="15px" version="1.1"
                                                            id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 308 308"
                                                            xml:space="preserve">
                                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                                stroke-linejoin="round"></g>
                                                            <g id="SVGRepo_iconCarrier">
                                                                <g id="XMLID_468_">
                                                                    <path id="XMLID_469_"
                                                                        d="M227.904,176.981c-0.6-0.288-23.054-11.345-27.044-12.781c-1.629-0.585-3.374-1.156-5.23-1.156 c-3.032,0-5.579,1.511-7.563,4.479c-2.243,3.334-9.033,11.271-11.131,13.642c-0.274,0.313-0.648,0.687-0.872,0.687 c-0.201,0-3.676-1.431-4.728-1.888c-24.087-10.463-42.37-35.624-44.877-39.867c-0.358-0.61-0.373-0.887-0.376-0.887 c0.088-0.323,0.898-1.135,1.316-1.554c1.223-1.21,2.548-2.805,3.83-4.348c0.607-0.731,1.215-1.463,1.812-2.153 c1.86-2.164,2.688-3.844,3.648-5.79l0.503-1.011c2.344-4.657,0.342-8.587-0.305-9.856c-0.531-1.062-10.012-23.944-11.02-26.348 c-2.424-5.801-5.627-8.502-10.078-8.502c-0.413,0,0,0-1.732,0.073c-2.109,0.089-13.594,1.601-18.672,4.802 c-5.385,3.395-14.495,14.217-14.495,33.249c0,17.129,10.87,33.302,15.537,39.453c0.116,0.155,0.329,0.47,0.638,0.922 c17.873,26.102,40.154,45.446,62.741,54.469c21.745,8.686,32.042,9.69,37.896,9.69c0.001,0,0.001,0,0.001,0 c2.46,0,4.429-0.193,6.166-0.364l1.102-0.105c7.512-0.666,24.02-9.22,27.775-19.655c2.958-8.219,3.738-17.199,1.77-20.458 C233.168,179.508,230.845,178.393,227.904,176.981z">
                                                                    </path>
                                                                    <path id="XMLID_470_"
                                                                        d="M156.734,0C73.318,0,5.454,67.354,5.454,150.143c0,26.777,7.166,52.988,20.741,75.928L0.212,302.716 c-0.484,1.429-0.124,3.009,0.933,4.085C1.908,307.58,2.943,308,4,308c0.405,0,0.813-0.061,1.211-0.188l79.92-25.396 c21.87,11.685,46.588,17.853,71.604,17.853C240.143,300.27,308,232.923,308,150.143C308,67.354,240.143,0,156.734,0z M156.734,268.994c-23.539,0-46.338-6.797-65.936-19.657c-0.659-0.433-1.424-0.655-2.194-0.655c-0.407,0-0.815,0.062-1.212,0.188 l-40.035,12.726l12.924-38.129c0.418-1.234,0.209-2.595-0.561-3.647c-14.924-20.392-22.813-44.485-22.813-69.677 c0-65.543,53.754-118.867,119.826-118.867c66.064,0,119.812,53.324,119.812,118.867 C276.546,215.678,222.799,268.994,156.734,268.994z">
                                                                    </path>
                                                                </g>
                                                            </g>
                                                        </svg> web
                                                    </a>
                                                @endif
                                            </td>
                                            <td>{{ $pago->pago_monto }} bs
                                                {{-- <span style="font-size:0.7em">[{{ $pago->pago_metodo }}]</span> --}}
                                            </td>
                                            <td>
                                                {{ $pago->costo->nombre }}
                                                {{-- {{ $pago->costo->monto }} --}}
                                            </td>
                                            <td>{{ $pago->pago_fecha }}</td>
                                            <td>{{ $pago->creado_en->format('H:i:s') }}</td>
                                            {{-- <td>{{ $pago->pago_metodo }}</td> --}}
                                            <td>
                                                <span class="badge {{ $badgeClass }}">
                                                    {{ $textoFaltante }}
                                                    @if ($asistencias > 0)
                                                        <br>
                                                        {{ $asistencias }} asistencias
                                                    @endif
                                                </span>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $pago->pago_estado == 'COMPLETADO' ? 'success' : ($pago->pago_estado == 'CANCELADO' ? 'info' : 'warning') }}">{{ $pago->pago_estado }}</span>
                                            </td>
                                            <td>{{ $pago->pago_observaciones }}</td>
                                            <td>
                                                @if (Auth::guard('admin')->user()->can('pago.edit'))
                                                    <a class="btn btn-sm btn-warning"
                                                        href="{{ route('admin.pagos.edit', $pago->pago_id) }}">
                                                        <i class="bx bxs-edit"></i>
                                                    </a>
                                                @endif

                                                @if (Auth::guard('admin')->user()->can('pago.delete'))
                                                    <a class="btn btn-sm btn-danger"
                                                        href="{{ route('admin.pagos.destroy', $pago->pago_id) }}"
                                                        onclick="event.preventDefault(); document.getElementById('delete-form-{{ $pago->pago_id }}').submit();">
                                                        <i class='bx bxs-trash'></i>
                                                    </a>
                                                    <form id="delete-form-{{ $pago->pago_id }}"
                                                        action="{{ route('admin.pagos.destroy', $pago->pago_id) }}"
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
                                    @endif
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Cliente</th>
                                    <th>CI</th>
                                    <th>Cel</th>
                                    <th>Pago</th>
                                    <th>Costo</th>
                                    <th>Fecha</th>
                                    <th>Registro</th>
                                    {{-- <th>Metodo</th> --}}
                                    <th>Dias</th>
                                    <th>Estado</th>
                                    <th>Observacion</th>
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
            var table = $('#tabla_pagos').DataTable({
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
                pageLength: 15,
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'copy',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                        },
                    }
                ],
                columnDefs: [{
                    targets: 9, // Índice de la columna a la que deseas aplicar el ancho máximo
                    createdCell: function(td, cellData, rowData, row, col) {
                        // $(td).css('max-width', '300px');
                        // $(td).css('overflow', 'hidden');
                        // $(td).css('text-overflow', 'ellipsis');
                        // $(td).css('white-space', 'normal');
                        // $(td).css('word-wrap', 'break-word');
                        $(td).addClass('max-width-td');
                    }
                }]
            });

            // table
            //     .buttons()
            //     .container()
            //     .appendTo("#example2_wrapper .col-md-6:eq(0)");

            $('#filter-select').on('change', function() {
                var selectedValue = $(this).val();
                table.column(4).search(selectedValue).draw();
            });

            $('.filter-select').select2();
        });
    </script>
@endsection
