@extends('backend.layouts.master')

@section('title')
    Usuarios - Admin Panel
@endsection


@section('admin-content')
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Usuarios </div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i
                                        class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Usuarios</li>
                        </ol>
                    </nav>
                </div>

            </div>
            <!--end breadcrumb-->

            <div class="card">
                <div class="card-body">
                    <h4 class="header-title float-left">Usuarios Lista</h4>
                    <p class="float-right mb-2">
                        {{-- @if (Auth::guard('admin')->user()->can('user.create'))
                            <a class="btn btn-primary px-5 radius-30" href="{{ route('admin.users.create') }}">Crear Nuevo
                                Usuario</a>
                        @endif --}}
                    </p>
                    <br>
                    <div class="table-responsive">
                        @include('backend.layouts.partials.messages')
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="20%">Nombre</th>
                                    <th width="25%">Email</th>
                                    <th width="20%">Username</th>
                                    <th width="10%">Rol</th>
                                    <th width="20%">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="accordionTable">
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $user->usu_login_name }}</td>
                                        <td>{{ $user->usu_login_email }}</td>
                                        <td>{{ $user->usu_login_username }}</td>
                                        <td>
                                            @foreach ($user->roles as $role)
                                                <div
                                                    class="badge rounded-pill text-info bg-light-info p-2 text-uppercase px-3">
                                                    {{ $role->name }}
                                                </div>
                                            @endforeach
                                        </td>
                                        <td>
                                            @if (Auth::guard('admin')->user()->can('user.edit'))
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#updatePassword"
                                                    onclick="showModal({{ $user->usu_login_id }}, '{{ $user->usu_login_username }}')">
                                                    <i class='bx bxs-lock'></i>
                                                </button>
                                            @endif

                                            <!-- Botón para ver detalles del formulario -->
                                            <button class="btn btn-info" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapse{{ $user->usu_login_id }}" aria-expanded="false"
                                                aria-controls="collapse{{ $user->usu_login_id }}">
                                                Ver Formulario
                                            </button>
                                        </td>
                                    </tr>

                                    <tr class="collapse" id="collapse{{ $user->usu_login_id }}"
                                        data-bs-parent="#accordionTable">
                                        <td colspan="6">
                                            <div class="p-3">
                                                @if ($user->datos->formulario)
                                                    <h5>Detalles del Formulario</h5>
                                                    <table class="table table-bordered">
                                                        <tbody>
                                                            <tr>
                                                                <th>Inscrito</th>
                                                                <td>{{ $user->datos->formulario->inscrito }}</td>
                                                                <th>CI</th>
                                                                <td>{{ $user->datos->usu_ci }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Nombre Completo</th>
                                                                <td>{{ $user->datos->formulario->nombre_completo }}</td>
                                                                <th>Fecha de Nacimiento</th>
                                                                <td>{{ $user->datos->formulario->fecha_nacimiento }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Edad</th>
                                                                <td>{{ $user->datos->formulario->edad }}</td>
                                                                <th>Teléfono</th>
                                                                <td>{{ $user->datos->formulario->telefono }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Dirección</th>
                                                                <td>{{ $user->datos->formulario->direccion }}</td>
                                                                <th>Medicamentos</th>
                                                                <td>{{ $user->datos->formulario->medicamentos }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Correo Electrónico</th>
                                                                <td>{{ $user->datos->formulario->correo }}</td>
                                                                <th>Enfermedades</th>
                                                                <td>{{ $user->datos->formulario->enfermedades }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Referencia</th>
                                                                <td>{{ $user->datos->formulario->referencia }}</td>
                                                                <th>Entrenamiento personalizado</th>
                                                                <td>{{ $user->datos->formulario->entrenamiento }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Horario</th>
                                                                <td>{{ $user->datos->formulario->horario }}</td>
                                                                <th>Días a la Semana</th>
                                                                <td>{{ $user->datos->formulario->dias_semana }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Nivel de Entrenamiento</th>
                                                                <td>{{ $user->datos->formulario->nivel_entrenamiento }}
                                                                </td>
                                                                <th>Lesiones</th>
                                                                <td>{{ $user->datos->formulario->lesion }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Objetivos</th>
                                                                <td>{{ implode(', ', $user->datos->formulario->objetivos ?? []) }}
                                                                </td>
                                                                <th>Detalles de Deportes</th>
                                                                <td>{{ $user->datos->formulario->deportes_detalles }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                @else
                                                    <div class="d-flex justify-content-between align-items-start">
                                                        <div class="ms-3">
                                                            <h5>Detalles del Formulario</h5>
                                                            <p>Este usuario aun no lleno el formulario.</p>
                                                        </div>
                                                        <button type="button" class="mt-3 me-3 btn btn-sm btn-primary"
                                                            data-bs-toggle="modal" data-bs-target="#formulario"
                                                            onclick="showFormulario({{ $user->usu_id }})">
                                                            Llenar formulario
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="updatePassword" tabindex="-1" aria-labelledby="updatePasswordLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('admin.users.password') }}" id="formPass">
                @csrf()
                <input type="hidden" name="usu_login_id" id="usu_login_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="updatePasswordLabel">Reestablecer contraseña</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            onclick="resetPass"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="username" class="col-form-label">Nombre de usuario</label>
                            <input type="text" class="form-control" id="username" name="usu_login_username">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="col-form-label">Nueva contraseña</label>
                            <input type="password" class="form-control" id="password" name="usu_login_password">
                        </div>
                        <div class="mb-3">
                            <label for="password_confirm" class="col-form-label">Confirmar contraseña</label>
                            <input type="password" class="form-control" id="password_confirm"
                                name="usu_login_password_confirm">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            onclick="resetPass">Close</button>
                        <button type="submit" class="btn btn-primary">Actualizar contraseña</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal modal-lg fade" id="formulario" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">BIENVENIDOS A MODO GYM!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        onclick="resetForm"></button>
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
                                <input type="radio" name="inscrito" id="inscrito-si" value="si"
                                    class="form-check-input" required>
                                <label for="inscrito-si" class="form-check-label">Si, ya estaba inscrito/a</label>
                            </div>
                            <div class="form-group">
                                <input type="radio" name="inscrito" id="inscrito-no" value="no"
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
                                <label for="direccion" class="form-label required-value">Dirección</label>
                                <input type="text" class="form-control" id="direccion" name="direccion">
                            </div>
                            <div class="form-group mb-3 col-lg-6 col-12">
                                <label for="correo" class="form-label required-value">Correo electrónico</label>
                                <input type="email" class="form-control" id="correo" name="correo">
                            </div>
                            <div class="form-group mb-3 col-lg-6 col-md-12 col-12">
                                <label for="medicamentos" class="form-label required-value">¿Tomas algún
                                    medicamento?</label>
                                <textarea class="form-control" id="medicamentos" name="medicamentos"></textarea>
                            </div>
                            <div class="form-group mb-3 col-lg-6 col-md-12 col-12">
                                <label for="enfermedades" class="form-label required-value">¿Tienes alguna enfermedad
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
                                    <input type="radio" name="entrenamiento" value="no" id="entrenamiento-no">
                                    <label for="entrenamiento-no">No</label>
                                </div>
                                <div class="form-group">
                                    <input type="radio" name="entrenamiento" value="si" id="entrenamiento-si">
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
                                    <label class="form-label required-value">¿Tienes o tuviste alguna lesión reciente?
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
                    <button type="button" data-bs-dismiss="modal" class="btn btn-secondary"
                        onclick="resetForm">Cerrar</button>
                    <button type="submit" form="formInscripcion" class="btn btn-success">Enviar</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function showFormulario(id) {
            $('#usu_id').val(id);
        }

        function resetPass() {
            $('#formPass').reset()
        }

        function resetForm() {
            $('#formInscripcion').reset()
        }

        function showModal(id, username) {
            $('#usu_login_id').val(id);
            $('#username').val(username);
        }

        $(document).ready(function() {
            // Variables para validación de formularios
            var $radioSi = $('#inscrito-si');
            var $radioNo = $('#inscrito-no');
            var $camposAdicionales = $('#campos-adicionales');
            var $entrenamientoSi = $('#entrenamiento-si');
            var $entrenamientoNo = $('#entrenamiento-no');
            var $camposEntrenamiento = $('#campos-entrenamiento');
            var $objetivoRendimiento = $('#objetivo-rendimiento');
            var $detallesRendimiento = $('#detalles-rendimiento');

            // Mostrar/ocultar campos adicionales de inscripción
            $radioSi.on('change', function() {
                if ($radioSi.is(':checked')) {
                    $camposAdicionales.hide();
                }
            });

            $radioNo.on('change', function() {
                if ($radioNo.is(':checked')) {
                    $camposAdicionales.css('display', 'flex');
                }
            });

            // Mostrar/ocultar campos adicionales para entrenamiento personalizado
            $entrenamientoSi.on('change', function() {
                if ($entrenamientoSi.is(':checked')) {
                    $camposEntrenamiento.css('display', 'flex');
                }
            });

            $entrenamientoNo.on('change', function() {
                if ($entrenamientoNo.is(':checked')) {
                    $camposEntrenamiento.hide();
                }
            });

            // Mostrar/ocultar campo de rendimiento deportivo
            $objetivoRendimiento.on('change', function() {
                if ($objetivoRendimiento.is(':checked')) {
                    $detallesRendimiento.css('display', 'flex');
                } else {
                    $detallesRendimiento.hide();
                }
            });

            // Limitar la cantidad de objetivos de rendimiento seleccionados
            const maxAllowed = 2;
            $('.objetivo-checkbox').on('change', function() {
                var checkedCount = $('.objetivo-checkbox:checked').length;

                if (checkedCount >= maxAllowed) {
                    $('.objetivo-checkbox').each(function() {
                        if (!$(this).is(':checked')) {
                            $(this).prop('disabled', true);
                        }
                    });
                } else {
                    $('.objetivo-checkbox').prop('disabled', false);
                }
            });
        });
    </script>
@endsection
