@extends('backend.layouts.master')

@section('title')
    Medidas antropometricas - Admin Panel
@endsection

@section('styles')
    <style>

    </style>
@endsection

@section('admin-content')
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Medidas antropometricas </div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i
                                        class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Medidas</li>
                        </ol>
                    </nav>
                </div>

            </div>
            <!--end breadcrumb-->
            {{-- @dd($medidas) --}}
            bs5

            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="header-title float-left">
                            Medidas "{{ $medidas->usuario->usu_nombre }}
                            {{ $medidas->usuario->usu_apellidos }}"
                        </h4>
                        <a class="btn btn-primary px-5 radius-30" href="{{ route('admin.users.create') }}">
                            Registrar medidas
                        </a>
                    </div>
                    <br>
                    <form id="formMedidas" method="POST" action="{{ route('admin.medidas.update', $medidas->usu_id) }}"
                        class="row">
                        @csrf()
                        @method('PUT')
                        <div class="col-6">
                            <div class="form-group mb-3 row">
                                <div class="col-md-1 d-flex align-items-center">
                                    <label class="form-label">Peso</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" name="peso" id="m_peso" class="form-control"
                                        value="{{ $medidas->peso }}">
                                </div>
                                <div class="col-md-1 d-flex align-items-center">
                                    <label class="form-label">Talla</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" name="talla" id="m_talla" class="form-control"
                                        value="{{ $medidas->talla }}">
                                </div>
                                <div class="col-md-1 d-flex align-items-center">
                                    <label class="form-label">IMC</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" name="imc" id="m_imc" class="form-control"
                                        value="{{ $medidas->imc }}">
                                </div>
                                <div class="col-md-1 d-flex align-items-center">
                                    <label class="form-label">% Grasa</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" name="grasa" id="m_grasa" class="form-control"
                                        value="{{ $medidas->grasa }}">
                                </div>
                            </div>
                            <div class="form-group mb-3 row">
                                <div class="col-md-1 d-flex align-items-center">
                                    <label class="form-label">ICC</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" name="icc" id="m_icc" class="form-control"
                                        value="{{ $medidas->icc }}">
                                </div>
                                <div class="col-md-1 d-flex align-items-center">
                                    <label class="form-label">RCV</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" name="rcv" id="m_rcv" class="form-control"
                                        value="{{ $medidas->rcv }}">
                                </div>
                                <div class="col-md-1 d-flex align-items-center">
                                    <label class="form-label">Peso ideal</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" name="peso_ideal" id="m_peso_ideal" class="form-control"
                                        value="{{ $medidas->peso_ideal }}">
                                </div>
                                <div class="col-md-1 d-flex align-items-center">
                                    <label class="form-label">↑↓ /Mes</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" name="xmes" id="m_xmes" class="form-control"
                                        value="{{ $medidas->xmes }}">
                                </div>
                            </div>
                            <div class="form-group mb-3 row">
                                <div class="col-md-2 d-flex align-items-center">
                                    <label class="form-label">Tiempo
                                        estimado</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="tiempo_estimado" id="m_tiempo_estimado" class="form-control"
                                        value="{{ $medidas->tiempo_estimado }}">
                                </div>
                                <div class="col-1">
                                    <button type="submit" class="btn btn-warning">Actualizar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="header-title float-left">
                        Medidas Lista
                    </h4>
                    <br>
                    <table class="table table-hover table-bordered" id="tabla_medidas">
                        <thead>
                            <tr>
                                <th>Medida / Fecha</th>
                                @foreach ($fechas as $fecha)
                                    <th>{{ $fecha }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $nombreMedida => $valoresPorFecha)
                                <tr>
                                    <th>{{ ucfirst(str_replace('_', ' ', $nombreMedida)) }}
                                    </th>
                                    @foreach ($fechas as $fecha)
                                        <td>
                                            {{ $valoresPorFecha[$fecha] ?? '-' }}
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal modal-lg fade" id="formulario" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">BIENVENIDOS A MODO GYM!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formInscripcion" method="POST" class="row"
                        action="{{ route('admin.formulario.store') }}">
                        @csrf()
                        <input type="hidden" name="usu_id" id="usu_id">
                        <!-- Pregunta inicial -->
                        <div class="mb-3 col-12">
                            <label class="form-label required-value">¿Ya estabas inscrito?</label>
                            <div class="form-group mb-2">
                                <input type="radio" name="inscrito" id="inscrito-si" value="Si, ya estaba inscrito/a"
                                    class="form-check-input" required>
                                <label for="inscrito-si" class="form-check-label">Si, ya estaba inscrito/a</label>
                            </div>
                            <div class="form-group">
                                <input type="radio" name="inscrito" id="inscrito-no" value="No, es la primera vez"
                                    class="form-check-input" required>
                                <label for="inscrito-no" class="form-check-label">No, es la primera vez</label>
                            </div>
                        </div>
                        <hr>
                        <div class="mb-3 col-12">
                            <label for="nombre_completo" class="form-label required-value">Nombre completo</label>
                            <input type="text" class="form-control" id="nombre" name="nombre_completo" required>
                        </div>
                        <div id="campos-adicionales" style="display: none;" class="m-auto col-12 row">
                            <div class="form-group mb-3 col-lg-4 col-md-6 col-12">
                                <label for="fecha-nacimiento" class="form-label required-value">Fecha de
                                    nacimiento</label>
                                <input type="date" class="form-control" id="fecha-nacimiento"
                                    name="fecha_nacimiento">
                            </div>
                            <div class="form-group mb-3 col-lg-2 col-md-6 col-12">
                                <label for="edad" class="form-label required-value">Edad</label>
                                <input type="number" class="form-control" id="edad" name="edad"
                                    min="10">
                            </div>
                            <div class="form-group mb-3 col-lg-6 col-md-6 col-12">
                                <label for="telefono" class="form-label required-value">Número de celular</label>
                                <input type="tel" class="form-control" id="telefono" name="telefono">
                            </div>
                            <div class="form-group mb-3 col-md-6 col-12">
                                <label for="direccion" class="form-label">Dirección</label>
                                <input type="text" class="form-control" id="direccion" name="direccion">
                            </div>
                            <div class="form-group mb-3 col-lg-6 col-12">
                                <label for="correo" class="form-label required-value">Correo electrónico</label>
                                <input type="email" class="form-control" id="correo" name="correo">
                            </div>
                            <div class="form-group mb-3 col-lg-6 col-md-12 col-12">
                                <label for="medicamentos" class="form-label">¿Tomas algún
                                    medicamento?</label>
                                <textarea class="form-control" id="medicamentos" name="medicamentos"></textarea>
                            </div>
                            <div class="form-group mb-3 col-lg-6 col-md-12 col-12">
                                <label for="enfermedades" class="form-label">¿Tienes alguna enfermedad
                                    diagnostica?</label>
                                <textarea class="form-control" id="enfermedades" name="enfermedades"></textarea>
                            </div>
                            <div class="form-group mb-3 col-lg-6 col-12">
                                <label for="referencia" class="form-label required-value">¿Cómo te enteraste de
                                    nosotros?</label>
                                <select class="form-select" id="referencia" name="referencia">
                                    <option value="">[Seleccione una opción]</option>
                                    <option value="Los vi al pasar">Los vi al pasar</option>
                                    <option value="Recomendación de otras personas">Recomendación de otras personas
                                    </option>
                                    <option value="Los ví en redes sociales">Los ví en redes sociales</option>
                                </select>
                            </div>
                            <div class="form-group mb-3 col-lg-6 col-12">
                                <label class="form-label required-value">¿Deseas entrenamiento personalizado?</label>
                                <div class="form-group mb-2">
                                    <input type="radio" name="entrenamiento" value="Si" id="entrenamiento-no">
                                    <label for="entrenamiento-no">No</label>
                                </div>
                                <div class="form-group">
                                    <input type="radio" name="entrenamiento" value="No" id="entrenamiento-si">
                                    <label for="entrenamiento-si">Si</label>
                                </div>
                            </div>
                            <!-- Campos adicionales de entrenamiento personalizado -->
                            <div id="campos-entrenamiento" style="display: none;" class="m-auto col-12 row">
                                <hr>
                                <div class="form-group mb-3 col-lg-6 col-md-6 col-12">
                                    <label class="form-label required-value">¿En qué horario vendrás a
                                        entrenar?</label>
                                    <select class="form-select" id="horario" name="horario">
                                        <option value="">[Seleccione una opción]</option>
                                        <option value="Mañana (6 a 11 am)">Mañana (6 a 11 am)</option>
                                        <option value="Mediodia (11 a 2 pm)">Mediodia (11 a 2 pm)</option>
                                        <option value="Tarde (2 a 6 pm)">Tarde (2 a 6 pm)</option>
                                        <option value="Noche (6 a 10 pm)">Noche (6 a 10 pm)</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3 col-lg-6 col-md-6 col-12">
                                    <label class="form-label required-value">¿Cuántos días a la semana
                                        entrenarás?</label>
                                    <select class="form-select" id="dias-semana" name="dias_semana">
                                        <option value="">[Seleccione una opción]</option>
                                        <option value="3 días">3 días</option>
                                        <option value="4 días">4 días</option>
                                        <option value="5 días">5 días</option>
                                        <option value="6 días">6 días</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3 col-lg-6 col-md-6 col-12">
                                    <label class="form-label required-value">¿Cuál es tu nivel de
                                        entrenamiento?</label>
                                    <select class="form-select" id="nivel-entrenamiento" name="nivel_entrenamiento">
                                        <option value="">[Seleccione una opción]</option>
                                        <option value="Principiante (1 a 6 meses)">Principiante (1 a 6 meses)</option>
                                        <option value="Intermedio (6 meses a 1 año)">Intermedio (6 meses a 1 año)
                                        </option>
                                        <option value="Intermedio (pero lo estoy retomando de mucho tiempo)">
                                            Intermedio (pero lo estoy retomando de mucho tiempo)
                                        </option>
                                        <option value="Avanzado (más de 1 año)">Avanzado (más de 1 año)</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3 col-lg-6 col-md-6 col-12">
                                    <label class="form-label">¿Tienes o tuviste alguna lesión reciente?
                                        (Especifica cual)</label>
                                    <textarea class="form-control" id="lesion" name="lesion"></textarea>
                                </div>
                                <div class="form-group mb-3 col-12">
                                    <label class="form-label required-value">¿Cuáles son tus objetivos? (Elije máximo 2
                                        opciones)</label>
                                    <div class="form-group mb-2">
                                        <input type="checkbox" name="objetivos[]" id="obj1"
                                            value="Ganancia de masa muscular" class="objetivo-checkbox form-check-input">
                                        <label for="obj1">Ganancia de masa muscular</label>
                                    </div>
                                    <div class="form-group mb-2">
                                        <input type="checkbox" name="objetivos[]" id="obj2"
                                            value="Perdida de peso o definicion"
                                            class="objetivo-checkbox form-check-input">
                                        <label for="obj2">Pérdida de peso o definición</label>
                                    </div>
                                    <div class="form-group mb-2">
                                        <input type="checkbox" name="objetivos[]"
                                            value="Mejora del rendimiento deportivo" id="objetivo-rendimiento"
                                            class="objetivo-checkbox form-check-input">
                                        <label for="objetivo-rendimiento">Mejora del rendimiento deportivo</label>
                                    </div>
                                    <div class="form-group mb-2">
                                        <input type="checkbox" name="objetivos[]" id="obj3"
                                            value="recuperarme de una lesion" class="objetivo-checkbox form-check-input">
                                        <label for="obj3">Recuperarme de una lesión</label>
                                    </div>
                                    <div class="form-group mb-2">
                                        <input type="checkbox" name="objetivos[]" id="obj4"
                                            value="Mejora de la resistencia cardiovascular"
                                            class="objetivo-checkbox form-check-input">
                                        <label for="obj4">Mejora de la resistencia cardiovascular</label>
                                    </div>
                                    <div class="form-group mb-2">
                                        <input type="checkbox" name="objetivos[]" id="obj5"
                                            value="Bienestar general" class="objetivo-checkbox form-check-input">
                                        <label for="obj5">Bienestar general</label>
                                    </div>
                                </div>

                                <!-- Campo adicional para "Mejora del rendimiento deportivo" -->
                                <div id="detalles-rendimiento" style="display: none;" class="m-auto col-12 row">
                                    <hr>
                                    <div class="form-group mb-2 col-12">
                                        <label class="form-label">
                                            Especifica qué deportes practicas, qué días a la semana y cuántas horas
                                        </label>
                                        <textarea class="form-control" id="deportes-detalles" name="deportes_detalles"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" data-bs-dismiss="modal" class="btn btn-secondary">Cerrar</button>
                    <button type="submit" form="formInscripcion" class="btn btn-success">Enviar</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            var table = $("#tabla_medidas").DataTable({
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
    </script>
@endsection
