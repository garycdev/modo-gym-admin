@extends('backend.layouts.master')

@section('title')
    Usuarios - Admin Panel
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
                        <table class="table table-hover mb-0" id="tabla_usuarios">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Username</th>
                                    <th>Rol</th>
                                    <th>Evaluación</th>
                                    <th>Acciones</th>
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
                                            <button class="btn btn-sm btn-info" type="button" data-bs-toggle="modal"
                                                data-bs-target="#nutricion"
                                                onclick="editNutricion({{ $user->datos }}, {{ $user->datos->nutricion }})">
                                                Nutrición
                                            </button>

                                            <button class="btn btn-sm btn-info" type="button" data-bs-toggle="modal"
                                                data-bs-target="#medidas"
                                                onclick="editMedidas({{ $user->datos }}, {{ $user->datos->medidas }})">
                                                Medidas
                                            </button>
                                        </td>
                                        <td>
                                            @if (Auth::guard('admin')->user()->can('user.edit'))
                                                <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                    data-bs-target="#updatePassword"
                                                    onclick="showModal({{ $user->usu_login_id }}, '{{ $user->usu_login_username }}')">
                                                    <i class='bx bxs-lock'></i>
                                                </button>
                                            @endif

                                            <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal"
                                                data-bs-target="#formularioModal{{ $user->usu_login_id }}">
                                                Ver Formulario
                                            </button>

                                            <div class="modal fade" id="formularioModal{{ $user->usu_login_id }}"
                                                tabindex="-1"
                                                aria-labelledby="formularioModalLabel{{ $user->usu_login_id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="formularioModalLabel{{ $user->usu_login_id }}">Detalles
                                                                del
                                                                Formulario</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            @if ($user->datos->formulario)
                                                                <div class="table-responsive">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-bordered table-hover">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <th>Inscrito</th>
                                                                                    <td>{{ $user->datos->formulario->inscrito }}
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th>CI</th>
                                                                                    <td>{{ $user->datos->usu_ci }}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th>Nombre Completo</th>
                                                                                    <td>{{ $user->datos->formulario->nombre_completo }}
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th>Fecha de Nacimiento</th>
                                                                                    <td>{{ $user->datos->formulario->fecha_nacimiento }}
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th>Edad</th>
                                                                                    <td>{{ $user->datos->formulario->edad }}
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th>Teléfono</th>
                                                                                    <td>{{ $user->datos->formulario->telefono }}
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th>Dirección</th>
                                                                                    <td>{{ $user->datos->formulario->direccion }}
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th>Medicamentos</th>
                                                                                    <td>{{ $user->datos->formulario->medicamentos }}
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th>Correo Electrónico</th>
                                                                                    <td>{{ $user->datos->formulario->correo }}
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th>Enfermedades</th>
                                                                                    <td>{{ $user->datos->formulario->enfermedades }}
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th>Referencia</th>
                                                                                    <td>{{ $user->datos->formulario->referencia }}
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th>Entrenamiento personalizado</th>
                                                                                    <td>{{ $user->datos->formulario->entrenamiento }}
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th>Horario</th>
                                                                                    <td>{{ $user->datos->formulario->horario }}
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th>Días a la Semana</th>
                                                                                    <td>{{ $user->datos->formulario->dias_semana }}
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th>Nivel de Entrenamiento</th>
                                                                                    <td>{{ $user->datos->formulario->nivel_entrenamiento }}
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th>Lesiones</th>
                                                                                    <td>{{ $user->datos->formulario->lesion }}
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th>Objetivos</th>
                                                                                    <td>{{ implode(', ', $user->datos->formulario->objetivos ?? []) }}
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th>Detalles de Deportes</th>
                                                                                    <td>{{ $user->datos->formulario->deportes_detalles }}
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <p>No hay formulario disponible para este usuario.</p>
                                                            @endif
                                                        </div>
                                                        <div class="modal-footer">
                                                            @if (!$user->datos->formulario)
                                                                <button class="btn btn-primary" type="button"
                                                                    data-bs-toggle="modal" data-bs-target="#formulario"
                                                                    onclick="showFormulario({{ $user->usu_id }})">
                                                                    Llenar formulario
                                                                </button>
                                                            @endif

                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Cerrar</button>
                                                        </div>
                                                    </div>
                                                </div>
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
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                        <button type="submit" class="btn btn-primary">Actualizar contraseña</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
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

    <!-- Modal -->
    <div class="modal modal-md fade" id="nutricion" tabindex="-1" aria-labelledby="nutricion_label"
        aria-hidden="true">
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
@endsection

@section('scripts')
    <script>
        const nutricionUpdateUrl = "{{ route('admin.nutricion.update', ':id') }}";
        const medidasUpdateUrl = "{{ route('admin.medidas.update', ':id') }}";

        function showFormulario(id) {
            $('#formInscripcion').get(0).reset()

            $('#usu_id').val(id);
        }

        function showModal(id, username) {
            $('#formPass').get(0).reset()

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

            var table = $("#tabla_usuarios").DataTable({
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
