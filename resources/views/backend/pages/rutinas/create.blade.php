@extends('backend.layouts.master')

@section('title')
    Nueva rutina - Admin Panel
@endsection

@section('styles')
    <style>
        .custom-checkbox {
            display: none;
        }

        .custom-card {
            cursor: pointer;
            transition: border-color 0.3s;
        }

        .card-body {
            padding: 5px;
        }

        .card-title {
            display: inline-block;
        }

        .custom-checkbox:checked+.custom-card {
            border: 2px solid #007bff;
        }

        .modal-body-scrollable {
            max-height: 70vh;
            overflow-y: auto;
        }
    </style>
@endsection


@section('admin-content')
    @php
        if (Auth::guard('admin')->check()) {
            $usr = Auth::guard('admin')->user();
            $guard = 'admin';
        } else {
            $usr = Auth::guard('user')->user();
            $guard = 'user';
        }
    @endphp
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Nueva rutina</div>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="ejercicios_rutina">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar ejercicios</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                        onclick="resetEjerciciosRutina()"></button>
                                </div>
                                <div class="modal-header">
                                    <input type="text" id="searchInput" class="form-control"
                                        placeholder="Buscar ejercicio...">
                                </div>
                                <div class="modal-body modal-body-scrollable">
                                    @foreach ($ejercicios as $ejer)
                                        <div class="exercise-item">
                                            <input type="checkbox" name="ejercicios[]" id="{{ $ejer->ejer_id }}"
                                                class="custom-checkbox" data-name="{{ $ejer->ejer_nombre }}"
                                                data-image="{{ asset($ejer->ejer_imagen) }}"
                                                data-tipo="{{ $ejer->equipo->tipo }}">
                                            <label for="{{ $ejer->ejer_id }}" class="card custom-card p-3">
                                                <div class="card-body d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <img src="{{ asset($ejer->ejer_imagen) }}"
                                                            alt="Ejercicio {{ $ejer->ejer_id }}" width="50">
                                                        <h6 class="card-title">{{ $ejer->ejer_nombre }}</h6>
                                                    </div>
                                                    <p class="p-0 m-0" style="font-size:0.8em;">
                                                        <span class="fw-bold">Equipo:
                                                        </span>{{ $ejer->equipo->equi_nombre }}
                                                        <br>
                                                        <span class="fw-bold">Musculo:
                                                        </span>{{ $ejer->musculo->mus_nombre }}
                                                    </p>
                                                    <span class="align-end badge bg-dark">Nivel
                                                        {{ $ejer->ejer_nivel }}</span>
                                                </div>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                        onclick="resetEjerciciosRutina()">Cerrar</button>
                                    <button type="button" class="btn btn-dark"
                                        onclick="resetEjerciciosRutina()">Vaciar</button>
                                    <button type="button" class="btn btn-success" onclick="agregarEjercicios()"
                                        data-bs-dismiss="modal">Agregar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Crear rutina</li>
                        </ol>
                    </nav>
                </div>
                {{-- <div class="ms-auto">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary">Settings</button>
                    <button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">	<span class="visually-hidden">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">	<a class="dropdown-item" href="javascript:;">Action</a>
                        <a class="dropdown-item" href="javascript:;">Another action</a>
                        <a class="dropdown-item" href="javascript:;">Something else here</a>
                        <div class="dropdown-divider"></div>	<a class="dropdown-item" href="javascript:;">Separated link</a>
                    </div>
                </div>
            </div> --}}
            </div>

            <!--end breadcrumb-->
            <div class="row">
                <div class="col-xl-6 mx-auto">
                    <div class="card">
                        <div class="card-header px-4 py-3">
                            <h5 class="mb-0">Registrar rutinas</h5>
                        </div>
                        {{-- <div class="row mx-5 pb-1 d-flex justify-content-center align-items-center alert alert-info">
                            <div class="col-3">
                                <p style="font-size:15px;">
                                    <b>CI:</b> {{ $usuario->usu_ci }} <br>
                                    <b>Nombres:</b> {{ $usuario->usu_nombre }} <br>
                                    <b>Apellidos:</b> {{ $usuario->usu_apellidos }} <br>
                                    <b>Edad: </b> {{ $usuario->usu_edad }} años<br>
                                    <b>Genero: </b> {{ $usuario->usu_genero }}
                                </p>
                            </div>
                            <div class="col-3">
                                <p style="font-size:15px;">
                                    <b>Plan: </b> {{ $usuario->costo[0]->nombre }} <br>
                                    <b>Dia: </b> -<span id="text_dia">TODOS</span>- <br>
                                    <b>Musculo: </b> -<span id="text_musculo">TODOS</span>-
                                </p>
                            </div>
                            <div class="col-5">
                                <p style="font-size:15px;">
                                    <b>Antecedentes medicos:</b>
                                    {{ $usuario->usu_ante_medicos ? $usuario->usu_ante_medicos : '-Ninguno-' }} <br>
                                    <b>Lesiones:</b> {{ $usuario->usu_lesiones ? $usuario->usu_lesiones : '-Ninguno-' }}
                                    <br>
                                    <b>Objetivo:</b> {{ $usuario->usu_objetivo ? $usuario->usu_objetivo : '-Ninguno-' }}
                                    <br>
                                    <b>Frecuencia: </b>
                                    {{ $usuario->usu_frecuencia ? $usuario->usu_frecuencia : '-0-' }}<br>
                                    <b>Horas: </b> {{ $usuario->usu_hora ? $usuario->usu_hora : '-0-' }} <br>
                                    <b>Deportes: </b> {{ $usuario->usu_deportes ? $usuario->usu_deportes : '-Ninguno-' }}
                                </p>
                            </div>
                        </div> --}}
                        <div class="card-body p-4">
                            <form class="row g-3 needs-validation" method="POST"
                                action="{{ route('admin.rutinas.store') }}">
                                @csrf
                                @if ($guard == 'admin')
                                    <div class="col-md-8">
                                        <label for="bsValidation9" class="form-label required_value">Usuario </label>
                                        <select id="usu_id" name="usu_id" class="form-select usu_id"
                                            onchange="selectUser()">
                                            <option selected disabled value>[USUARIO]</option>
                                            @foreach ($clientes as $cliente)
                                                <option value="{{ $cliente->usu_id }}"
                                                    data-fecha="{{ $cliente->pago_fecha }}" data-mes="{{ $cliente->mes }}"
                                                    data-ci="{{ $cliente->usu_ci }}"
                                                    data-nombres="{{ $cliente->usu_nombres }}"
                                                    data-usuario="{{ json_encode($cliente) }}"
                                                    data-formulario="{{ json_encode($cliente->formulario) }}">
                                                    {{ $cliente->usu_nombre }}
                                                    {{ $cliente->usu_apellidos }}</option>
                                            @endforeach
                                        </select>
                                        @error('usu_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @else
                                    @if ($guard == 'user')
                                        <div class="col-md-8">
                                            <label for="bsValidation9" class="form-label required_value">Usuario </label>
                                            @php
                                                foreach ($clientes as $cliente) {
                                                    if (Auth::guard('user')->user()->usu_id == $cliente->usu_id) {
                                                        $id = $cliente->usu_id;
                                                        $pago_fecha = $cliente->pago_fecha;
                                                        $mes = $cliente->mes;
                                                        $nombre = $cliente->usu_nombre;
                                                        $apellidos = $cliente->usu_apellidos;

                                                        $fecha = new DateTime($pago_fecha);
                                                        $diasASumar = $mes * 31;
                                                        $fecha->modify('+' . $diasASumar . ' days');

                                                        $anio = $fecha->format('Y');
                                                        $mes = $fecha->format('m');
                                                        $dia = $fecha->format('d');
                                                        $fecha_fin = "$anio-$mes-$dia";
                                                    }
                                                }
                                            @endphp
                                            <input type="text" class="form-control" readonly
                                                value="{{ $nombre }} {{ $apellidos }}">
                                            <input type="hidden" id="usu_id" name="usu_id" value="{{ $id }}"
                                                onload="rutinaUser({{ $id }})">
                                            @error('usu_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    @endif
                                @endif
                                <div class="col-md-4">
                                    <label for="bsValidation9" class="form-label required_value">Dia </label>
                                    <select id="rut_dia" class="form-select rut_dia" required
                                        onchange="selectDia(this)">
                                        <option selected disabled value>[DIA]</option>
                                        <option value="1">{{ strtoupper(dias(1)) }}</option>
                                        <option value="2">{{ strtoupper(dias(2)) }}</option>
                                        <option value="3">{{ strtoupper(dias(3)) }}</option>
                                        <option value="4">{{ strtoupper(dias(4)) }}</option>
                                        <option value="5">{{ strtoupper(dias(5)) }}</option>
                                        <option value="6">{{ strtoupper(dias(6)) }}</option>
                                        <option value="7">{{ strtoupper(dias(7)) }}</option>
                                    </select>
                                    @error('rut_dia')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                @if ($guard == 'admin')
                                    {{-- <div class="col-md-12 d-flex justify-content-center form-check form-switch"
                                        style="display:none!important;" id="cont-anterior">
                                        <input class="form-check-input" type="checkbox" role="switch" id="anterior"
                                            name="anterior">
                                        <label class="form-check-label" for="anterior">&nbsp;Agregar a rutina
                                            anterior</label>
                                        <input type="hidden" name="id_anterior" id="id_anterior" value="0">
                                    </div> --}}
                                    <div class="col-md-6 fechas" style="display: none">
                                        <label for="bsValidation9" class="form-label">Fecha inicio </label>
                                        <input type="date" class="form-control" id="fecha_ini" name="fecha_ini"
                                            readonly>
                                    </div>
                                    <div class="col-md-6 fechas" style="display: none">
                                        <label for="bsValidation9" class="form-label">Fecha fin </label>
                                        <input type="date" class="form-control" id="fecha_fin" name="fecha_fin"
                                            readonly>
                                    </div>
                                    <br>
                                    <div id="info_user" style="display: none!important;"
                                        class="col-12 row ms-1 pb-1 mt-3 d-flex justify-content-center align-items-center alert alert-info">
                                    </div>
                                @else
                                    @if ($guard == 'user')
                                        {{-- <div class="col-md-12 d-flex justify-content-center form-check form-switch"
                                            style="display:none!important;" id="cont-anterior">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                id="anterior" name="anterior">
                                            <label class="form-check-label" for="anterior">&nbsp;Agregar a rutina
                                                anterior</label>
                                            <input type="hidden" name="id_anterior" id="id_anterior" value="0">
                                        </div> --}}
                                        <div class="col-md-6 fechas">
                                            <label for="bsValidation9" class="form-label">Fecha inicio </label>
                                            <input type="date" class="form-control" id="fecha_ini" name="fecha_ini"
                                                readonly value="{{ $pago_fecha }}">
                                        </div>
                                        <div class="col-md-6 fechas">
                                            <label for="bsValidation9" class="form-label">Fecha fin </label>
                                            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin"
                                                readonly value="{{ $fecha_fin }}">
                                        </div>
                                    @endif
                                @endif
                                <hr>
                                <button type="button" class="btn btn-primary w-100 mb-3" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal" onclick="addEjercicios(1)" id="btn-agregar" disabled>
                                    Agregar ejercicios
                                </button>
                                <div id="rutinas">

                                </div>
                                <hr>
                                <div class="col-md-12">
                                    <div class="d-md-flex d-grid align-items-center gap-3">
                                        <button type="submit" class="btn btn-primary px-4">Submit</button>
                                        <button type="reset" class="btn btn-light px-4">Reset</button>
                                    </div>
                                </div>
                            </form>
                        </div>
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
                    <h4 class="header-title">Create New Rutinas</h4>
                    @include('backend.layouts.partials.messages')

                    <form action="{{ route('admin.roles.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Rutinas Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter a Role Name">
                        </div>

                        <div class="form-group">
                            <label for="name">Permissions</label>

                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="checkPermissionAll" value="1">
                                <label class="form-check-label" for="checkPermissionAll">All</label>
                            </div>
                            <hr>
                            @php $i = 1; @endphp
                            @foreach ($permission_groups as $group)
                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="{{ $i }}Management" value="{{ $group->name }}" onclick="checkPermissionByGroup('role-{{ $i }}-management-checkbox', this)">
                                            <label class="form-check-label" for="checkPermission">{{ $group->name }}</label>
                                        </div>
                                    </div>

                                    <div class="col-9 role-{{ $i }}-management-checkbox">
                                        @php
                                            $permissions = App\User::getpermissionsByGroupName($group->name);
                                            $j = 1;
                                        @endphp
                                        @foreach ($permissions as $permission)
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" name="permissions[]" id="checkPermission{{ $permission->id }}" value="{{ $permission->name }}">
                                                <label class="form-check-label" for="checkPermission{{ $permission->id }}">{{ $permission->name }}</label>
                                            </div>
                                            @php  $j++; @endphp
                                        @endforeach
                                        <br>
                                    </div>

                                </div>
                                @php  $i++; @endphp
                            @endforeach


                        </div>


                        <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Save Rutina</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- data table end -->

    </div>
</div> --}}
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        let ejercicios = 0;
        let series = 0;
        let serCount = {}

        $(document).ready(function() {
            $('.usu_id').select2()

            $('#searchInput').on('keyup', function() {
                var searchTerm = $(this).val().toLowerCase();
                $('.exercise-item').each(function() {
                    var exerciseName = $(this).find('.card-title').text().toLowerCase();
                    if (exerciseName.includes(searchTerm)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });

            const id = $('#usu_id').val()
            if (id) {
                rutinaUser()
            }
        });

        function clearSearch() {
            $('#searchInput').val('');
            $('.exercise-item').show();
        }

        function selectDia() {
            $('#btn-agregar').removeAttr('disabled');
        }

        function selectUser() {
            const fecha_ini = $('#usu_id option:selected').data('fecha');
            const meses = parseInt($('#usu_id option:selected').data('mes'), 10);

            $('#fecha_ini').val(fecha_ini);

            const diasASumar = meses * 31;

            const fecha = new Date(fecha_ini);
            fecha.setUTCDate(fecha.getUTCDate() + diasASumar);

            const anio = fecha.getUTCFullYear();
            const mes = ('0' + (fecha.getUTCMonth() + 1)).slice(-2);
            const dia = ('0' + fecha.getUTCDate()).slice(-2);
            const fecha_fin = `${anio}-${mes}-${dia}`;

            $('#fecha_fin').val(fecha_fin);
            // $('.fechas').css('display', 'block');

            $('#info_user').css('display', 'block');
            const usuario = $('#usu_id option:selected').data('usuario')
            const formulario = $('#usu_id option:selected').data('formulario')
            console.log(formulario);
            if (!formulario) {
                $('#info_user').html(`<div class="col-6">
                                    <p>
                                        <b>CI:</b> ${usuario.usu_ci} <br>
                                        <b>Nombres:</b> ${usuario.usu_nombre} <br>
                                        <b>Apellidos:</b> ${usuario.usu_apellidos} <br>
                                        <b>Edad: </b> ${usuario.usu_edad} años<br>
                                        <b>Genero: </b> ${usuario.usu_genero}
                                    </p>
                                </div>
                                <div class="col-6">
                                    <p>
                                        <b>Formulario no llenado</b>
                                    </p>
                                </div>`)
                // $('#info_user').html(`<div class="col-4">
            //                     <p>
            //                         <b>CI:</b> ${usuario.usu_ci} <br>
            //                         <b>Nombres:</b> ${usuario.usu_nombre} <br>
            //                         <b>Apellidos:</b> ${usuario.usu_apellidos} <br>
            //                         <b>Edad: </b> ${usuario.usu_edad} años<br>
            //                         <b>Genero: </b> ${usuario.usu_genero}
            //                     </p>
            //                 </div>
            //                 <div class="col-8">
            //                     <p>
            //                         <b>Antecedentes medicos:</b> ${usuario.usu_ante_medicos ? usuario.usu_ante_medicos : '-Ninguno-'} <br>
            //                         <b>Lesiones:</b> ${usuario.usu_lesiones ? usuario.usu_lesiones : '-Ninguno-'} <br>
            //                         <b>Objetivo:</b> ${usuario.usu_objetivo ? usuario.usu_objetivo : '-Ninguno-'} <br>
            //                         <b>Frecuencia: </b> ${usuario.usu_frecuencia ? usuario.usu_frecuencia : '-0-'} <br>
            //                         <b>Horas: </b> ${usuario.usu_hora ? usuario.usu_hora : '-0-'} <br>
            //                         <b>Deportes: </b>${usuario.usu_deportes ? usuario.usu_deportes : '-Ninguno-'}
            //                     </p>
            //                 </div>`)
            } else {
                $('#info_user').html(`<div class="col-4">
                                    <p>
                                        <b>CI:</b> ${usuario.usu_ci} <br>
                                        <b>Nombre:</b> ${formulario.nombre_completo} <br>
                                        <b>Fecha nacimiento:</b> ${formulario.fecha_nacimiento} <br>
                                        <b>Edad: </b> ${formulario.edad} años<br>
                                        <b>Genero: </b> ${usuario.usu_genero}
                                    </p>
                                </div>
                                <div class="col-8">
                                    <p>
                                        <b>Antecedentes medicos:</b> ${formulario.enfermedades ? formulario.enfermedades : '-'} <br>
                                        <b>Medicamentos:</b> ${formulario.enfermedades ? formulario.enfermedades : '-'} <br>
                                        <b>Lesiones:</b> ${formulario.lesion ? formulario.lesion : '-'} <br>
                                        <b>Objetivo:</b> ${formulario.objetivos ? formulario.objetivos.join(' y ') : '-'} <br>
                                        <b>Horario: </b> ${formulario.dias_semana ? formulario.dias_semana : '-'} <br>
                                        <b>Dias: </b> ${formulario.dias_semana ? formulario.dias_semana : '-'} <br>
                                        <b>Deportes: </b>${formulario.deportes_detalles ? formulario.deportes_detalles : '-'}
                                    </p>
                                </div>`)
            }
            rutinaUser()
        }

        function rutinaUser() {
            const id = $('#usu_id').val()
            $.ajax({
                type: "POST",
                url: "{{ route('admin.rutinas.user') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id
                },
                dataType: "JSON",
                success: function(response) {
                    // $('#cont-anterior').attr('style', 'display:block');
                    // $('#anterior').attr('checked', 'checked');
                    // $('#id_anterior').val(response.rut_grupo);
                },
                error: function(err) {
                    // $('#anterior').removeAttr('checked');
                    // $('#cont-anterior').attr('style', 'display:none!important');
                    // $('#id_anterior').val(0);
                }
            });
        }

        function agregarEjercicios() {
            var selectEjercicios = [];

            var dias = {
                1: 'Lunes',
                2: 'Martes',
                3: 'Miercoles',
                4: 'Jueves',
                5: 'Viernes',
                6: 'Sabado',
                7: 'Domingo'
            }
            $('#ejercicios_rutina input[name="ejercicios[]"]:checked').each(function() {
                var id = $(this).attr('id');
                var name = $(this).data('name');
                var image = $(this).data('image');
                var tipo = $(this).data('tipo');
                var dia = $('#rut_dia').val();
                selectEjercicios.push({
                    id: id,
                    name: name,
                    image: image,
                    tipo: tipo,
                    dia: dia
                });
            });
            console.log(selectEjercicios);

            selectEjercicios.forEach(element => {
                serCount[ejercicios] = 1
                $('#rutinas').append(`<div id="ejercicio_${ejercicios}" class="mb-3">
                                        <hr>
                                        <div class="col-md-12 mb-3 d-flex justify-content-between align-items-center">
                                            <img src="${element.image}" alt=""
                                                width="75">
                                            <div class="d-flex align-items-start">
                                                <h5>${element.name}</h5>
                                                <span class="badge bg-primary">${dias[element.dia]}</span>
                                            </div>
                                            <input type="hidden" name="id_ejer[${ejercicios}][]" value="${element.id}">
                                            <input type="hidden" name="id_ejer[${ejercicios}][]" value="${element.dia}">
                                            <button type="button" class="btn btn-danger" onclick="deleteEjercicio(${ejercicios})">Eliminar</button>
                                        </div>
                                        <div id="series_${ejercicios}" class="col-md-12 w-75 m-auto">
                                            <div id="serie_${series}" class="row">
                                                <div class="col-md-2">
                                                    <label for="" class="form-label">Serie </label>
                                                    <input type="text" class="form-control series_${ejercicios}" name="series[${ejercicios}][serie][]"
                                                        readonly value="${serCount[ejercicios]}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="" class="form-label">Peso (kg) </label>
                                                    <input type="number" class="form-control" name="series[${ejercicios}][peso][]"
                                                        placeholder="Peso" step="1" min="0" ${element.tipo != 'peso' ? 'disabled="disabled"' : ''}>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="" class="form-label">Repeticiones
                                                    </label>
                                                    <input type="number" class="form-control" name="series[${ejercicios}][rep][]"
                                                        placeholder="Repeticiones" step="1" min="1">
                                                </div>
                                                <div class="col-md-1 d-flex align-items-center justify-content-around">
                                                    <button type="button" class="btn btn-outline-danger radius-30"
                                                        onclick="removeSerie(${series}, ${ejercicios})">
                                                        <i class='bx bxs-trash'></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-3 w-75 m-auto">
                                            <button type="button" class="btn btn-secondary w-100" onclick="addSerie(${ejercicios}, '${element.tipo}')">
                                                Agregar serie
                                            </button>
                                        </div>
                                    </div>`);
                ejercicios++
                series++
            });
            resetEjerciciosRutina()
        }

        function addSerie(ejer, tipo) {
            serCount[ejer] = serCount[ejer] + 1;
            const template = `<div id="serie_${series}" class="row">
                                <div class="col-md-2">
                                    <label for="" class="form-label">Serie </label>
                                    <input type="text" class="form-control series_${ejer}" name="series[${ejer}][serie][]"
                                        readonly value="${serCount[ejer]}">
                                </div>
                                <div class="col-md-4">
                                    <label for="" class="form-label">Peso (kg) </label>
                                    <input type="number" class="form-control" name="series[${ejer}][peso][]"
                                        placeholder="Peso" step="1" min="0" ${tipo != 'peso' ? 'disabled="disabled"' : ''}>
                                </div>
                                <div class="col-md-4">
                                    <label for="" class="form-label">Repeticiones
                                    </label>
                                    <input type="number" class="form-control" name="series[${ejer}][rep][]"
                                        placeholder="Repeticiones" step="1" min="1">
                                </div>
                                <div class="col-md-1 d-flex align-items-center justify-content-around">
                                    <button type="button" class="btn btn-outline-danger radius-30"
                                        onclick="removeSerie(${series}, ${ejer})">
                                        <i class='bx bxs-trash'></i>
                                    </button>
                                </div>
                            </div>`
            series++
            $('#series_' + ejer).append(template)
        }

        function removeSerie(serie, ejer) {
            $('#serie_' + serie).remove();
            serCount[ejer] = serCount[ejer] - 1;

            const elementos = $('.series_' + ejer);
            let i = 1;
            elementos.each(function(index) {
                $(this).val(i)
                i++
            });
        }

        function deleteEjercicio(ejer) {
            $('#ejercicio_' + ejer).remove()
        }

        function resetEjerciciosRutina() {
            clearSearch()
            $('#ejercicios_rutina')[0].reset()
        }
    </script>
@endsection
