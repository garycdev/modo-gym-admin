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
                                        } elseif (
                                            $diferenciaDias >= -30 &&
                                            $diferenciaDias < 0 &&
                                            count($pago->cliente->asistencias(abs($diferenciaDias))) > 0
                                        ) {
                                            $textoFaltante = 'Se pasaron ' . abs($diferenciaDias) . ' días';
                                            $asistencias = count($pago->cliente->asistencias(abs($diferenciaDias)));
                                        } else {
                                            $textoFaltante = 0;
                                        }
                                    @endphp
                                    @if ($diferenciaDias >= 0 || ($diferenciaDias >= -30 && $asistencias > 0))
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $pago->cliente->usu_nombre }} {{ $pago->cliente->usu_apellidos }}</td>
                                            <td>{{ $pago->cliente->usu_ci }}</td>
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
