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
                                                <h5>Detalles del Formulario</h5>
                                                @if ($user->datos->formulario)
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
                                                    No hay formulario disponible para este usuario.
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
                            onclick="reset()"></button>
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
                            onclick="reset()">Close</button>
                        <button type="submit" class="btn btn-primary">Actualizar contraseña</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function reset() {
            $('#formPass').reset()
        }

        function showModal(id, username) {
            console.log('modal');

            $('#usu_login_id').val(id);
            $('#username').val(username);
        }
    </script>
@endsection
