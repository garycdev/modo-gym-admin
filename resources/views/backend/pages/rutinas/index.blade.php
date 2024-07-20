@extends('backend.layouts.master')

@section('title')
    Rutinas - Admin Panel
@endsection

@section('styles')
    <style>
        td,
        th {
            vertical-align: top;
            border: 1px solid #ddd;
        }

        ul,
        li {
            padding-left: 5px;
            margin-left: 5px;
        }
    </style>
@endsection


@section('admin-content')
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Rutinas</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Rutinas</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <div class="btn-group">
                        @if (Auth::guard('admin')->user()->can('rutina.create'))
                            <a href="{{ route('admin.rutinas.create') }}" class="btn btn-primary">Nueva rutina</a>
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
            <h6 class="mb-0 text-uppercase">Lista de rutinas</h6>
            <hr />
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        @include('backend.layouts.partials.messages')
                        <table id="tabla_pagos" class="table table-bordered table-hover datatable-multi-row">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Cliente</th>
                                    <th># Rutina</th>
                                    <th>Dia</th>
                                    <th>Ejercicio</th>
                                    <th>Serie</th>
                                    <th>Repeticion</th>
                                    <th>Peso</th>
                                    <th>RID</th>
                                    <th>Tiempo</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                    $userAnterior = '';
                                    $diaAnterior = '';
                                    $grupoAnterior = '';
                                    $userCount = [];
                                    $diaCount = [];
                                    $grupoCount = [];
                                @endphp

                                @foreach ($rutinas as $rut)
                                    @php
                                        $nombreCompleto =
                                            $rut->usuario->usu_nombre . ' ' . $rut->usuario->usu_apellidos;
                                        $dia = $rut->rut_dia;
                                        $grupo = $rut->rut_grupo;

                                        if (!isset($userCount[$nombreCompleto])) {
                                            $userCount[$nombreCompleto] = 0;
                                        }
                                        $userCount[$nombreCompleto]++;

                                        if (!isset($grupoCount[$grupo])) {
                                            $grupoCount[$grupo] = 0;
                                        }
                                        $grupoCount[$grupo]++;

                                        if (!isset($diaCount[$grupo][$dia])) {
                                            $diaCount[$grupo][$dia] = 0;
                                        }
                                        $diaCount[$grupo][$dia]++;
                                    @endphp
                                @endforeach

                                @foreach ($rutinas as $index => $rut)
                                    @php
                                        $nombreCompleto =
                                            $rut->usuario->usu_nombre . ' ' . $rut->usuario->usu_apellidos;
                                        $dia = $rut->rut_dia;
                                        $grupo = $rut->rut_grupo;
                                        $userCount[$nombreCompleto]--;
                                        $grupoCount[$grupo]--;
                                        $diaCount[$grupo][$dia]--;
                                    @endphp
                                    <tr>
                                        @if ($grupo !== $grupoAnterior)
                                            <td rowspan="{{ $grupoCount[$grupo] + 1 }}">
                                                {{ $i }}</td>
                                            <td rowspan="{{ $grupoCount[$grupo] + 1 }}">
                                                {{ $nombreCompleto }}</td>
                                            <td rowspan="{{ $grupoCount[$grupo] + 1 }}">
                                                {{ $rut->rut_grupo }}</td>
                                            @php
                                                $grupoAnterior = $grupo;
                                            @endphp
                                        @endif

                                        @if ($dia !== $diaAnterior)
                                            <td rowspan="{{ $diaCount[$grupo][$dia] + 1 }}">
                                                {{ dias($dia) }}</td>
                                            @php
                                                $diaAnterior = $dia;
                                            @endphp
                                        @endif

                                        <td>{{ $rut->ejercicio->ejer_nombre }}</td>
                                        <td>{{ $rut->rut_serie }}</td>
                                        <td>{{ $rut->rut_repeticiones > 1 ? $rut->rut_repeticiones . ' veces' : $rut->rut_repeticiones . ' vez' }}
                                        </td>
                                        <td>{{ $rut->rut_peso ? $rut->rut_peso . ' kg' : 'No' }}</td>
                                        <td>
                                            <span class="badge {{ $rut->rut_rid == 0 ? 'bg-dark' : 'bg-success' }}">
                                                {{ $rut->rut_rid == 0 ? 'No medido aun' : $rut->rut_rid }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge {{ $rut->rut_tiempo == 0 ? 'bg-dark' : 'bg-success' }}">
                                                {{ $rut->rut_tiempo == 0 ? 'No medido aun' : segundosTiempo($rut->rut_tiempo) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $rut->rut_estado == 'COMPLETADO' ? 'success' : ($rut->rut_estado == 'CANCELADO' ? 'info' : 'warning') }}">
                                                {{ $rut->rut_estado }}
                                            </span>
                                        </td>
                                        <td>
                                            @if (Auth::guard('admin')->user()->can('rutina.edit'))
                                                <a class="btn btn-sm btn-warning"
                                                    href="{{ route('admin.rutinas.edit', $rut->rut_id) }}">
                                                    <i class="bx bxs-edit"></i>
                                                </a>
                                            @endif
                                            @if (Auth::guard('admin')->user()->can('rutina.delete'))
                                                <a class="btn btn-danger text-white"
                                                    href="{{ route('admin.rutinas.destroy', $rut->rut_id) }}"
                                                    onclick="event.preventDefault(); document.getElementById('delete-form-{{ $rut->rut_id }}').submit();">
                                                    <i class='bx bxs-trash'></i>
                                                </a>
                                                <form id="delete-form-{{ $rut->rut_id }}"
                                                    action="{{ route('admin.rutinas.destroy', $rut->rut_id) }}"
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
                                    <th>Cliente</th>
                                    <th>#Rutina</th>
                                    <th>Dia</th>
                                    <th>Ejercicio</th>
                                    <th>Serie</th>
                                    <th>Repeticion</th>
                                    <th>Peso</th>
                                    <th>RID</th>
                                    <th>Tiempo</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </tfoot>
                        </table>

                        {{-- <table id="tabla_pagos" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Cliente</th>
                                    <th># Rutina</th>
                                    <th>Dia</th>
                                    <th>Ejercicio</th>
                                    <th>Serie</th>
                                    <th>Repeticion</th>
                                    <th>Peso</th>
                                    <th>RID</th>
                                    <th>Tiempo</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 1; @endphp
                                @foreach ($rutinas as $rut)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $rut->usuario->usu_nombre }} {{ $rut->usuario->usu_apellidos }}</td>
                                        <td>{{ $rut->rut_grupo }}</td>
                                        <td>{{ dias($rut->rut_dia) }}</td>
                                        <td>{{ $rut->ejercicio->ejer_nombre }}</td>
                                        <td>{{ $rut->rut_serie }}</td>
                                        <td>{{ $rut->rut_repeticiones > 1 ? $rut->rut_repeticiones . ' veces' : $rut->rut_repeticiones . ' vez' }}
                                        </td>
                                        <td>{{ $rut->rut_peso ? $rut->rut_peso . ' kg' : 'No' }}</td>
                                        <td>
                                            <span class="badge {{ $rut->rut_rid == 0 ? 'bg-dark' : 'bg-success' }}">
                                                {{ $rut->rut_rid == 0 ? 'No medido aun' : $rut->rut_rid }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge {{ $rut->rut_tiempo == 0 ? 'bg-dark' : 'bg-success' }}">
                                                {{ $rut->rut_tiempo == 0 ? 'No medido aun' : segundosTiempo($rut->rut_tiempo) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $rut->rut_estado == 'COMPLETADO' ? 'success' : ($rut->rut_estado == 'CANCELADO' ? 'info' : 'warning') }}">
                                                {{ $rut->rut_estado }}
                                            </span>
                                        </td>
                                        <td>
                                            @if (Auth::guard('admin')->user()->can('rutina.edit'))
                                                <a class="btn btn-sm btn-warning"
                                                    href="{{ route('admin.rutinas.edit', $rut->rut_id) }}">
                                                    <i class="bx bxs-edit"></i>
                                                </a>
                                            @endif
                                            @if (Auth::guard('admin')->user()->can('rutina.delete'))
                                                <a class="btn btn-danger text-white"
                                                    href="{{ route('admin.rutinas.destroy', $rut->rut_id) }}"
                                                    onclick="event.preventDefault(); document.getElementById('delete-form-{{ $rut->rut_id }}').submit();">
                                                    <i class='bx bxs-trash'></i>
                                                </a>
                                                <form id="delete-form-{{ $rut->rut_id }}"
                                                    action="{{ route('admin.rutinas.destroy', $rut->rut_id) }}"
                                                    method="POST" style="display: none;">
                                                    @method('DELETE')
                                                    @csrf
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @php $i++; @endphp
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Cliente</th>
                                    <th>#Rutina</th>
                                    <th>Dia</th>
                                    <th>Ejercicio</th>
                                    <th>Serie</th>
                                    <th>Repeticion</th>
                                    <th>Peso</th>
                                    <th>RID</th>
                                    <th>Tiempo</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </tfoot>
                        </table> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        $(document).ready(function() {
            var table = $("#tabla_pagos").DataTable({
                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                    "infoEmpty": "Mostrando 0 a 0 de 0 Entradas",
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
                // fnDrawCallback: () => {

                //     $table = $(this);

                //     // only apply this to specific tables
                //     if ($table.closest(".datatable-multi-row").length) {

                //         // for each row in the table body...
                //         $table.find("tbody>tr").each(function() {
                //             var $tr = $(this);

                //             // get the "extra row" content from the <script> tag.
                //             // note, this could be any DOM object in the row.
                //             var extra_row = $tr.find(".extra-row-content").html();

                //             // in case draw() fires multiple times, 
                //             // we only want to add new rows once.
                //             if (!$tr.next().hasClass('dt-added')) {
                //                 $tr.after(extra_row);
                //                 $tr.find("td").each(function() {

                //                     // for each cell in the top row,
                //                     // set the "rowspan" according to the data value.
                //                     var $td = $(this);
                //                     var rowspan = parseInt($td.data(
                //                         "datatable-multi-row-rowspan"), 10);
                //                     if (rowspan) {
                //                         $td.attr('rowspan', rowspan);
                //                     }
                //                 });
                //             }

                //         });

                //     } // end if the table has the proper class
                // }
            });

            // table.buttons().container().appendTo('#tabla_pagos_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
