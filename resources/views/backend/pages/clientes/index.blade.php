@extends('backend.layouts.master')

@section('title')
    Clientes - Admin Panel
@endsection

@section('styles')
@endsection


@section('admin-content')
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Clientes</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Usuarios</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <div class="btn-group">
                        @if (Auth::guard('admin')->user()->can('cliente.view'))
                            <a href="{{ route('admin.clientes.create') }}" class="btn btn-primary">Nuevo cliente</a>
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
            <h6 class="mb-0 text-uppercase">Lista de clientes</h6>
            <hr />
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        @include('backend.layouts.partials.messages')
                        <table id="tabla_clientes" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    {{-- <th>Image</th> --}}
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>CI</th>
                                    <th>Celular</th>
                                    <th>Edad</th>
                                    <th>Huella</th>
                                    <th>Genero</th>
                                    <th>Nivel</th>
                                    {{-- <th>Antecedentes medicos</th>
                                    <th>Lesiones</th>
                                    <th>Objetivo</th>
                                    <th>Frecuencia</th>
                                    <th>Hora</th>
                                    <th>Deportes</th> --}}
                                    <th>Estado</th>
                                    <th>Evaluación</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($clientes as $cliente)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        {{-- <td>
                                            <img src="{{ asset($cliente->usu_imagen) }}" alt="" width="50">
                                        </td> --}}
                                        <td>{{ $cliente->usu_nombre }}</td>
                                        <td>{{ $cliente->usu_apellidos }}</td>
                                        <td>{{ $cliente->usu_ci }}</td>
                                        <td>{{ $cliente->usu_celular ?? '-' }}</td>
                                        <td>{{ $cliente->usu_edad }}</td>
                                        <td>
                                            {{-- <span
                                                class="badge bg-{{ $cliente->usu_huella == '1' ? 'success' : ($cliente->usu_huella == '0' ? 'danger' : 'dark') }}">{{ $cliente->usu_huella }}</span> --}}
                                            @if ($cliente->usu_huella == '1')
                                                <span class="parent-icon badge bg-success">
                                                    <i class='bx bx-check' style="font-weight:bold;"></i>
                                                </span>
                                            @else
                                                <span class="parent-icon badge bg-danger">
                                                    <i class='bx bx-x' style="font-weight:bold;"></i>
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ $cliente->usu_genero }}</td>
                                        <td>{{ $cliente->usu_nivel }}</td>
                                        {{-- <td>{{ $cliente->usu_ante_medicos }}</td>
                                        <td>{{ $cliente->usu_lesiones }}</td>
                                        <td>{{ $cliente->usu_objetivo }}</td>
                                        <td>{{ $cliente->usu_frecuencia }}</td>
                                        <td>{{ $cliente->usu_hora }}</td>
                                        <td>{{ $cliente->usu_deportes }}</td> --}}
                                        <td>
                                            <span
                                                class="badge bg-{{ $cliente->usu_estado == 'ACTIVO' ? 'success' : ($cliente->usu_estado == 'INACTIVO' ? 'danger' : 'dark') }}">{{ $cliente->usu_estado }}</span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-info" type="button" data-bs-toggle="modal"
                                                data-bs-target="#nutricion"
                                                onclick="editNutricion({{ $cliente }}, {{ $cliente->nutricion }})">
                                                Nutrición
                                            </button>

                                            <button class="btn btn-sm btn-info" type="button" data-bs-toggle="modal"
                                                data-bs-target="#medidas"
                                                onclick="editMedidas({{ $cliente }}, {{ $cliente->medidas }})">
                                                Medidas
                                            </button>
                                        </td>
                                        <td>
                                            @if (Auth::guard('admin')->user()->can('cliente.edit'))
                                                <a class="btn btn-sm btn-warning"
                                                    href="{{ route('admin.clientes.edit', $cliente->usu_id) }}">
                                                    <i class="bx bxs-edit"></i>
                                                </a>
                                            @endif

                                            @if (Auth::guard('admin')->user()->can('cliente.delete'))
                                                <a class="btn btn-sm btn-danger text-white"
                                                    href="{{ route('admin.clientes.destroy', $cliente->usu_id) }}"
                                                    onclick="event.preventDefault(); document.getElementById('delete-form-{{ $cliente->usu_id }}').submit();">
                                                    <i class='bx bxs-trash'></i>
                                                </a>
                                                <form id="delete-form-{{ $cliente->usu_id }}"
                                                    action="{{ route('admin.clientes.destroy', $cliente->usu_id) }}"
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
                                    {{-- <th>Image</th> --}}
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>CI</th>
                                    <th>Celular</th>
                                    <th>Edad</th>
                                    <th>Huella</th>
                                    <th>Genero</th>
                                    <th>Nivel</th>
                                    {{-- <th>Antecedentes medicos</th>
                                    <th>Lesiones</th>
                                    <th>Objetivo</th>
                                    <th>Frecuencia</th>
                                    <th>Hora</th>
                                    <th>Deportes</th> --}}
                                    <th>Estado</th>
                                    <th>Evaluación</th>
                                    <th>Acciones</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal modal-md fade" id="nutricion" tabindex="-1" aria-labelledby="nutricion_label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formNutricion" method="POST">
                    @csrf()
                    <input type="hidden" name="nut_id" id="nut_id">
                    <input type="hidden" name="usu_id" id="n_usu_id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="nutricion_label">Evaluación nutricional del cliente</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3 row">
                            <div class="col-md-2 d-flex align-items-center">
                                <label class="form-label required-value">Nombre</label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" name="nombre" id="n_nombre" class="form-control">
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <div class="col-md-2 d-flex align-items-center">
                                <label class="form-label">Edad</label>
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="edad" id="n_edad" class="form-control">
                            </div>
                            <div class="col-md-2 d-flex align-items-center">
                                <label class="form-label">Fecha</label>
                            </div>
                            <div class="col-md-5">
                                <input type="date" name="fecha" id="n_fecha" class="form-control">
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <div class="col-md-4 d-flex align-items-center">
                                <label class="form-label">Antecedentes medicos y familiares</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="antecedentes" id="n_antecedentes" class="form-control">
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <div class="col-md-2 d-flex align-items-center">
                                <label class="form-label">Hijos</label>
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="hijos" id="n_hijos" class="form-control">
                            </div>
                            <div class="col-md-3 d-flex align-items-center">
                                <label class="form-label">Ciclo menstrual</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="ciclo" id="n_ciclo" class="form-control">
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <div class="col-md-4 d-flex align-items-center">
                                <label class="form-label">Medicamentos</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="medicamentos" id="n_medicamentos" class="form-control">
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <div class="col-md-4 d-flex align-items-center">
                                <label class="form-label">Objetivos</label>
                            </div>
                            <div class="col-md-8">
                                <textarea name="objetivo" id="n_objetivo" rows="3" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <div class="col-md-4 d-flex align-items-center">
                                <label class="form-label">Intolerancias y alergias</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="intolerancias_alergias" id="n_intolerancias_alergias"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <div class="col-md-4 d-flex align-items-center">
                                <label class="form-label">Habito intestinal</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="habito" id="n_habito" class="form-control">
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <div class="col-md-2 d-flex align-items-center">
                                <label class="form-label">Alcohol</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="alcohol" id="n_alcohol" class="form-control">
                            </div>
                            <div class="col-md-2 d-flex align-items-center">
                                <label class="form-label">Tabaco</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="tabaco" id="n_tabaco" class="form-control">
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <div class="col-md-4 d-flex align-items-center">
                                <label class="form-label">Actividad fisica</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="fisica" id="n_fisica" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-bs-dismiss="modal" class="btn btn-secondary">Cerrar</button>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal modal-md fade" id="medidas" tabindex="-1" aria-labelledby="medidas_label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formMedidas" method="POST">
                    @csrf()
                    <input type="hidden" name="med_id" id="med_id">
                    <input type="hidden" name="usu_id" id="m_usu_id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="nutricion_label">Medidas antropométricas</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3 row">
                            <div class="col-md-2 d-flex align-items-center">
                                <label class="form-label">Peso</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="peso" id="m_peso" class="form-control">
                            </div>
                            <div class="col-md-2 d-flex align-items-center">
                                <label class="form-label">Talla</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="talla" id="m_talla" class="form-control">
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <div class="col-md-2 d-flex align-items-center">
                                <label class="form-label">IMC</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="imc" id="m_imc" class="form-control">
                            </div>
                            <div class="col-md-2 d-flex align-items-center">
                                <label class="form-label">% Grasa</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="grasa" id="m_grasa" class="form-control">
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <div class="col-md-2 d-flex align-items-center">
                                <label class="form-label">ICC</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="icc" id="m_icc" class="form-control">
                            </div>
                            <div class="col-md-2 d-flex align-items-center">
                                <label class="form-label">RCV</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="rcv" id="m_rcv" class="form-control">
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <div class="col-md-2 d-flex align-items-center">
                                <label class="form-label">Peso ideal</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="peso_ideal" id="m_peso_ideal" class="form-control">
                            </div>
                            <div class="col-md-2 d-flex align-items-center">
                                <label class="form-label">↑↓ /Mes</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="xmes" id="m_xmes" class="form-control">
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <div class="col-md-4 d-flex align-items-center">
                                <label class="form-label">Tiempo estimado</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="tiempo_estimado" id="m_tiempo_estimado"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <div class="col-md-2 d-flex align-items-center">
                                <label class="form-label">Brazo</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="brazo" id="m_brazo" class="form-control">
                            </div>
                            <div class="col-md-2 d-flex align-items-center">
                                <label class="form-label">Antebrazo</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="antebrazo" id="m_antebrazo" class="form-control">
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <div class="col-md-2 d-flex align-items-center">
                                <label class="form-label">Torso</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="torso" id="m_torso" class="form-control">
                            </div>
                            <div class="col-md-2 d-flex align-items-center">
                                <label class="form-label">Cintura es</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="cintura_es" id="m_cintura_es" class="form-control">
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <div class="col-md-2 d-flex align-items-center">
                                <label class="form-label">Cintura om</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="cintura_om" id="m_cintura_om" class="form-control">
                            </div>
                            <div class="col-md-2 d-flex align-items-center">
                                <label class="form-label">Cadera</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="cadera" id="m_cadera" class="form-control">
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <div class="col-md-2 d-flex align-items-center">
                                <label class="form-label">Muslo</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="muslo" id="m_muslo" class="form-control">
                            </div>
                            <div class="col-md-2 d-flex align-items-center">
                                <label class="form-label">Pierna</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="pierna" id="m_pierna" class="form-control">
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <div class="col-md-2 d-flex align-items-center">
                                <label class="form-label">PCB</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="pcb" id="m_pcb" class="form-control">
                            </div>
                            <div class="col-md-2 d-flex align-items-center">
                                <label class="form-label">PCT</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="pct" id="m_pct" class="form-control">
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <div class="col-md-2 d-flex align-items-center">
                                <label class="form-label">PSE</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="pse" id="m_pse" class="form-control">
                            </div>
                            <div class="col-md-2 d-flex align-items-center">
                                <label class="form-label">PSI</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="psi" id="m_psi" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-bs-dismiss="modal" class="btn btn-secondary">Cerrar</button>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </form>
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
        const nutricionUpdateUrl = "{{ route('admin.nutricion.update', ':id') }}";
        const medidasUpdateUrl = "{{ route('admin.medidas.update', ':id') }}";

        $(document).ready(function() {
            var table = $("#tabla_clientes").DataTable({
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
                buttons: ['copy', 'excel', 'pdf', 'print']
            });
        });

        function editNutricion(user, nutricion) {
            const form = $('#formNutricion');
            form.trigger('reset');
            $('#n_objetivo').html('')

            if (nutricion) {
                const actionUrl = nutricionUpdateUrl.replace(':id', nutricion.nut_id);
                form.attr('action', actionUrl);
                if (!form.find('input[name="_method"]').length) {
                    form.append('<input type="hidden" name="_method" value="PUT">');
                }

                $('#n_usu_id').val(nutricion.usu_id);
                $('#n_nombre').val(nutricion.nombre);
                $('#n_edad').val(nutricion.edad);
                $('#n_fecha').val(nutricion.fecha);
                $('#n_antecedentes').val(nutricion.antecedentes_medicos_familiares);
                $('#n_hijos').val(nutricion.hijos);
                $('#n_ciclo').val(nutricion.ciclo_menstrual);
                $('#n_medicamentos').val(nutricion.medicamentos);
                $('#n_objetivo').html(nutricion.objetivo);
                $('#n_intolerancias_alergias').val(nutricion.intolerancias_alergias);
                $('#n_habito').val(nutricion.habito);
                $('#n_alcohol').val(nutricion.alcohol);
                $('#n_tabaco').val(nutricion.tabaco);
                $('#n_fisica').val(nutricion.actividad_fisica);
            } else {
                form.attr('action', "{{ route('admin.nutricion.store') }}");
                form.find('input[name="_method"]').remove();

                $('#n_usu_id').val(user.usu_id);
                $('#n_nombre').val(user.usu_nombre + ' ' + user.usu_apellidos);
                $('#n_edad').val(user.usu_edad);
            }
        }

        function editMedidas(user, medidas) {
            const form = $('#formMedidas');
            form.trigger('reset');

            if (medidas) {
                const actionUrl = medidasUpdateUrl.replace(':id', medidas.med_id);
                form.attr('action', actionUrl);
                if (!form.find('input[name="_method"]').length) {
                    form.append('<input type="hidden" name="_method" value="PUT">');
                }

                $('#m_usu_id').val(medidas.usu_id);
                $('#m_peso').val(medidas.peso);
                $('#m_talla').val(medidas.talla);
                $('#m_imc').val(medidas.imc);
                $('#m_grasa').val(medidas.grasa);
                $('#m_icc').val(medidas.icc);
                $('#m_rcv').val(medidas.rcv);
                $('#m_peso_ideal').val(medidas.peso_ideal);
                $('#m_xmes').val(medidas.xmes);
                $('#m_tiempo_estimado').val(medidas.tiempo_estimado);
                $('#m_brazo').val(medidas.brazo);
                $('#m_antebrazo').val(medidas.antebrazo);
                $('#m_torso').val(medidas.torso);
                $('#m_cintura_es').val(medidas.cintura_es);
                $('#m_cintura_om').val(medidas.cintura_om);
                $('#m_cadera').val(medidas.cadera);
                $('#m_muslo').val(medidas.muslo);
                $('#m_pierna').val(medidas.pierna);
                $('#m_pcb').val(medidas.pcb);
                $('#m_pct').val(medidas.pct);
                $('#m_pse').val(medidas.pse);
                $('#m_psi').val(medidas.psi);
            } else {
                form.attr('action', "{{ route('admin.medidas.store') }}");
                form.find('input[name="_method"]').remove();
                $('#m_usu_id').val(user.usu_id);
            }
        }
    </script>
@endsection
