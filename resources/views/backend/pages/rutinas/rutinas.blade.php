@extends('backend.layouts.master')

@section('title')
    Rutinas - Admin Panel
@endsection

@section('styles')
    <style>
        #tabla_rutinas.dataTable td.child ul.dtr-details {
            margin-left: 50px;
        }
    </style>
@endsection

@section('admin-content')
    @php
        $usr = Auth::guard('admin')->check() ? Auth::guard('admin')->user() : Auth::guard('user')->user();
    @endphp
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Rutinas</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Rutinas</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <h6 class="mb-0 text-uppercase">Lista de rutinas</h6>
            <hr />
            <div class="card">
                <div class="card-body">
                    <div class="row mx-lg-5 pb-1 d-flex justify-content-center align-items-center alert alert-info">
                        <div class="col-lg-3 col-md-6 col-12">
                            <p style="font-size:1.1em;">
                                <b>CI:</b> {{ $usuario->usu_ci }} <br>
                                <b>Nombres:</b> {{ $usuario->usu_nombre }} <br>
                                <b>Apellidos:</b> {{ $usuario->usu_apellidos }} <br>
                                <b>Edad: </b> {{ $usuario->usu_edad }} años<br>
                                <b>Genero: </b> {{ $usuario->usu_genero }}
                            </p>
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <p style="font-size:1.1em;">
                                <b>Plan: </b> {{ $usuario->costo[0]->nombre }} <br>
                                <b>Dia: </b> -<span id="text_dia">TODOS</span>- <br>
                                <b>Musculo: </b> -<span id="text_musculo">TODOS</span>-
                            </p>
                        </div>
                        <div class="col-lg-5 col-md-6 col-12">
                            <p style="font-size:1.1em;">
                                {{-- @dd($usuario->formulario) --}}
                                @if ($usuario->formulario)
                                    @php
                                        $form = $usuario->formulario;
                                    @endphp
                                    <b>Antecedentes medicos:</b>
                                    {{ $form->enfermedades ? $form->enfermedades : '-' }}
                                    <br>
                                    <b>Medicamentos:</b> {{ $form->medicamentos ? $form->medicamentos : '-' }}
                                    <br>
                                    <b>Lesiones:</b> {{ $form->lesion ? $form->lesion : '-' }} <br>
                                    <b>Objetivo:</b> {{ $form->objetivos ? implode(' y ', $form->objetivos) : '-' }}
                                    <br>
                                    <b>Horario: </b> {{ $form->horario ? $form->horario : '-' }} <br>
                                    <b>Dias: </b> {{ $form->dias_semana ? $form->dias_semana : '-' }} <br>
                                    <b>Deportes:</b>
                                    {{ $form->deportes_detalles ? $form->deportes_detalles : '-' }}
                                @else
                                    <b>Formulario no llenado</b>
                                @endif
                                {{-- <b>Antecedentes medicos:</b>
                                {{ $usuario->usu_ante_medicos ? $usuario->usu_ante_medicos : '-Ninguno-' }} <br>
                                <b>Lesiones:</b> {{ $usuario->usu_lesiones ? $usuario->usu_lesiones : '-Ninguno-' }} <br>
                                <b>Objetivo:</b> {{ $usuario->usu_objetivo ? $usuario->usu_objetivo : '-Ninguno-' }} <br>
                                <b>Frecuencia: </b> {{ $usuario->usu_frecuencia ? $usuario->usu_frecuencia : '-0-' }}<br>
                                <b>Horas: </b> {{ $usuario->usu_hora ? $usuario->usu_hora : '-0-' }} <br>
                                <b>Deportes: </b> {{ $usuario->usu_deportes ? $usuario->usu_deportes : '-Ninguno-' }} --}}
                            </p>
                        </div>
                    </div>
                    <div class="row p-2 d-flex justify-content-center align-items-center">
                        <div class="col-lg-2 col-md-3 col-12">
                            <label for="filter_dia">Filtrar por día</label>
                            <select name="dia" id="filter_dia" class="form-control">
                                <option value="" data-dia="TODOS">[TODOS]</option>
                                <option value="1" data-dia="{{ strtoupper(dias(1)) }}">
                                    {{ strtoupper(dias(1)) }}
                                </option>
                                <option value="2" data-dia="{{ strtoupper(dias(2)) }}">
                                    {{ strtoupper(dias(2)) }}
                                </option>
                                <option value="3" data-dia="{{ strtoupper(dias(3)) }}">
                                    {{ strtoupper(dias(3)) }}
                                </option>
                                <option value="4" data-dia="{{ strtoupper(dias(4)) }}">
                                    {{ strtoupper(dias(4)) }}
                                </option>
                                <option value="5" data-dia="{{ strtoupper(dias(5)) }}">
                                    {{ strtoupper(dias(5)) }}
                                </option>
                                <option value="6" data-dia="{{ strtoupper(dias(6)) }}">
                                    {{ strtoupper(dias(6)) }}
                                </option>
                                <option value="7" data-dia="{{ strtoupper(dias(7)) }}">
                                    {{ strtoupper(dias(7)) }}
                                </option>
                            </select>
                        </div>
                        <div class="col-lg-8 col-md-8 col-12">
                            <label for="filter_musculo">Filtrar por Músculo</label>
                            <select name="musculo" id="filter_musculo" class="form-control filter_musculo">
                                <option value="" data-musculo="TODOS">[TODOS]</option>
                                @foreach ($musculos as $mus)
                                    <option value="{{ $mus->mus_id }}" data-musculo="{{ $mus->mus_nombre }}">
                                        {{ $mus->mus_nombre }} - <span
                                            style="font-size:10px;">{{ $mus->mus_descripcion }}</span>
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <p class="col-lg-2 col-md-2 col-12">
                            @if ($usr->can('rutina.create'))
                                <a href="{{ route('admin.rutinas.create') }}" class="btn btn-primary float-end">Nueva
                                    rutina</a>
                            @endif
                        </p>
                    </div>

                    <br>

                    <br>
                    @include('backend.layouts.partials.messages')

                    <br>
                    <div class="table-responsive w-100">
                        <table id="tabla_rutinas" class="table table-bordered table-hover w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Ejercicio</th>
                                    <th>Ejercicio</th>
                                    <th>Dia</th>
                                    <th>Dia</th>
                                    <th>Musculo</th>
                                    <th>Musculo</th>
                                    <th>Series</th>
                                    <th>Repeticiones</th>
                                    <th>Peso</th>
                                    <th>RIR</th>
                                    <th>Tiempo</th>
                                    {{-- <th>Estado</th> --}}
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 1; @endphp
                                @foreach ($rutinas as $rut)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $rut->ejercicio->ejer_nombre }}</td>
                                        <td>{{ $rut->ejercicio->ejer_nombre }}</td>
                                        <td>{{ $rut->rut_dia }}</td>
                                        <td>{{ dias($rut->rut_dia) }}</td>
                                        <td>{{ $rut->ejercicio->musculo->mus_id }}</td>
                                        <td>{{ $rut->ejercicio->musculo->mus_nombre }}</td>
                                        <td>
                                            {{ $rut->rut_serie }}
                                        </td>
                                        <td>
                                            {{ $rut->rut_repeticiones }}
                                        </td>
                                        <td>{{ $rut->rut_peso ? $rut->rut_peso . ' kg' : '-' }}</td>
                                        <td>{{ $rut->rut_rid == 0 ? '-' : $rut->rut_rid }}</span>
                                        </td>
                                        <td>
                                            <span class="badge {{ $rut->rut_tiempo == 0 ? 'bg-dark' : 'bg-success' }}">
                                                {{ $rut->rut_tiempo == 0 ? 'No medido aún' : segundosTiempo($rut->rut_tiempo) }}
                                            </span>
                                        </td>
                                        {{-- <td>
                                            <span
                                                class="badge bg-{{ $rut->rut_estado == 'COMPLETADO' ? 'success' : ($rut->rut_estado == 'CANCELADO' ? 'info' : 'warning') }}">
                                                {{ $rut->rut_estado }}
                                            </span>
                                        </td> --}}
                                        <td>
                                            @if ($usr->can('rutina.edit'))
                                                <a class="btn btn-sm btn-warning"
                                                    href="{{ route('admin.rutinas.edit', $rut->rut_id) }}">
                                                    <i class="bx bxs-edit"></i>
                                                </a>
                                            @endif
                                            @if ($usr->can('rutina.delete'))
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
                                    <th>Ejercicio</th>
                                    <th>Ejercicio</th>
                                    <th>Dia</th>
                                    <th>Dia</th>
                                    <th>Musculo</th>
                                    <th>Musculo</th>
                                    <th>Series</th>
                                    <th>Repeticiones</th>
                                    <th>Peso</th>
                                    <th>RIR</th>
                                    <th>Tiempo</th>
                                    {{-- <th>Estado</th> --}}
                                    <th>Acciones</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.filter_musculo').select2();
            var table = $("#tabla_rutinas").DataTable({
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
                dom: 'Bfrtip',
                buttons: ["copy", "excel", "pdf", "print"],
                // dom: 'Bfrtip',
                buttons: [{
                        extend: 'copy',
                        exportOptions: {
                            columns: [0, 2, 6, 7, 8, 9, 10, 11]
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 2, 6, 7, 8, 9, 10, 11]
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0, 2, 6, 7, 8, 9, 10, 11]
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [0, 2, 6, 7, 8, 9, 10, 11]
                        },
                    },
                ],
                responsive: {
                    details: {
                        type: 'column',
                        target: 1
                    }
                },
                columnDefs: [{
                        className: 'control',
                        orderable: false,
                        targets: 1
                    },
                    {
                        targets: [3, 4, 5, 6], // Asegúrate de que estos índices sean correctos
                        visible: false
                    },
                    {
                        targets: '_all',
                        orderable: true
                    },
                    // {
                    //     targets: [7, 8],
                    //     className: 'text-center fw-bold'
                    // },
                ]
            });

            $('#filter_dia').on('change', function() {
                table.column(3).search(this.value).draw();
                var dia = $(this).find('option:selected').data('dia');
                $('#text_dia').html(dia);
            });

            $('#filter_musculo').on('change', function() {
                table.column(5).search(this.value).draw();
                var musculo = $(this).find('option:selected').data('musculo');
                $('#text_musculo').html(musculo);
            });
        });
    </script>
@endsection
