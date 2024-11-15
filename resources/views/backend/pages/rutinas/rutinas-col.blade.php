@extends('backend.layouts.master')

@section('title')
    Rutinas - Admin Panel
@endsection

@section('styles')
    <style>
        .contenedor-scroll {
            overflow-x: auto;
            white-space: nowrap;
        }

        .tabla-columnas {
            display: inline-flex;
            padding: 10px;
        }

        .columna {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
            margin: 0;
            padding: 0;
            border-left: 1px solid #cccccc;
            border-right: 1px solid #cccccc;
            min-width: 200px;
            max-width: 500px;
        }

        .tabla-columnas {
            display: flex;
            align-items: stretch;
        }

        .columna h4 {
            margin: 0;
            padding: 10px;
            font-weight: bold;
            width: 100%;
            text-align: center;
            border-bottom: 1px solid #cccccc;
            /* position: sticky; */
            /* top: 0; */
            /* z-index: 10; */
        }

        .item {
            margin: 0;
            padding: 10px;
            display: flex;
            flex-direction: column;
            width: 100%;
            height: 230px;
            border-bottom: 1px solid #cccccc;
            justify-content: center;
            font-size: .95em;
        }

        .item-avanzado {
            background-color: #ff000022;
        }

        .item-intermedio {
            background-color: #ffff0044;
        }

        .item-basico {
            background-color: #037DE233;
        }

        .titulo-item {
            font-weight: bold;
            text-align: center;
            word-wrap: break-word;
            overflow-wrap: break-word;
            white-space: normal;
            font-size: .95em;
        }

        .campo {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 5px 0;
        }

        input[type="number"] {
            width: 50px;
            padding: 5px;
            text-align: center;
            font-size: .95em;
        }

        .boton {
            padding: 5px 10px;
            font-size: 14px;
        }

        .boton-guardar {
            width: 90%;
            margin: auto;
            margin-top: 5px;
        }

        .boton-eliminar {
            width: 40px;
            float: right;
            text-align: center;
            margin-left: 10px;
        }

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
                    <div class="row p-2 d-flex justify-content-end align-items-center">
                        {{-- <div class="col-lg-2 col-md-3 col-12">
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
                        </div> --}}
                        {{-- <div class="col-lg-8 col-md-8 col-12">
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
                        </div> --}}
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
                    <div class="contenedor-scroll">
                        <div class="tabla-columnas">
                            <div class="columna">
                                <h4>Lunes</h4>
                                @if (count($lunes) > 0)
                                    @foreach ($lunes as $lun)
                                        @php
                                            $nivel = '';
                                            if ($lun->ejercicio->ejer_nivel >= 0 && $lun->ejercicio->ejer_nivel <= 2) {
                                                $nivel = 'item-basico';
                                            } elseif (
                                                $lun->ejercicio->ejer_nivel > 2 &&
                                                $lun->ejercicio->ejer_nivel <= 3
                                            ) {
                                                $nivel = 'item-intermedio';
                                            } elseif (
                                                $lun->ejercicio->ejer_nivel > 3 &&
                                                $lun->ejercicio->ejer_nivel <= 5
                                            ) {
                                                $nivel = 'item-avanzado';
                                            }
                                        @endphp
                                        <div class="item {{ $nivel }}">
                                            <div class="titulo-item">
                                                {{ $lun->ejercicio->ejer_nombre }}
                                            </div>
                                            <div class="campo">
                                                <span>Series</span>
                                                <input min="0" class="form-control" type="number"
                                                    value="{{ $lun->rut_serie }}" id="rseries_{{ $lun->rut_id }}">
                                            </div>
                                            <div class="campo">
                                                <span>Repeticiones</span>
                                                <input min="0" class="form-control" type="number"
                                                    value="{{ $lun->rut_repeticiones }}"
                                                    id="rrepeticiones_{{ $lun->rut_id }}">
                                            </div>
                                            <div class="campo">
                                                <span>RIR</span>
                                                <input min="0" class="form-control" type="number"
                                                    value="{{ $lun->rut_rid }}" id="rrir_{{ $lun->rut_id }}">
                                            </div>
                                            <div class="campo">
                                                <button class="boton boton-guardar btn btn-primary"
                                                    onclick="guardarRutina({{ $lun->rut_id }})">Guardar</button>
                                                @if ($usr->roles[0]->name == 'superadmin' || $usr->roles[0]->name == 'Modo GYM')
                                                    <button class="boton boton-eliminar btn btn-danger"
                                                        onclick="eliminarRutina({{ $lun->rut_id }})">-</button>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="item">
                                        <div class="titulo-item">
                                            No hay rutinas
                                        </div>
                                    </div>
                                @endif
                                @if ($usr->roles[0]->name == 'superadmin' || $usr->roles[0]->name == 'Modo GYM')
                                    <button class="boton boton-guardar btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal" onclick="addEjercicios(1)"
                                        id="btn-agregar">+</button>
                                @endif
                            </div>
                            <div class="columna">
                                <h4>Martes</h4>
                                @if (count($martes) > 0)
                                    @foreach ($martes as $mar)
                                        @php
                                            $nivel = '';
                                            if ($mar->ejercicio->ejer_nivel >= 0 && $mar->ejercicio->ejer_nivel <= 2) {
                                                $nivel = 'item-basico';
                                            } elseif (
                                                $mar->ejercicio->ejer_nivel > 2 &&
                                                $mar->ejercicio->ejer_nivel <= 3
                                            ) {
                                                $nivel = 'item-intermedio';
                                            } elseif (
                                                $mar->ejercicio->ejer_nivel > 3 &&
                                                $mar->ejercicio->ejer_nivel <= 5
                                            ) {
                                                $nivel = 'item-avanzado';
                                            }
                                        @endphp
                                        <div class="item {{ $nivel }}">
                                            <div class="titulo-item">
                                                {{ $mar->ejercicio->ejer_nombre }}
                                            </div>
                                            <div class="campo">
                                                <span>Series</span>
                                                <input min="0" class="form-control" type="number"
                                                    value="{{ $mar->rut_serie }}" id="rseries_{{ $mar->rut_id }}">
                                            </div>
                                            <div class="campo">
                                                <span>Repeticiones</span>
                                                <input min="0" class="form-control" type="number"
                                                    value="{{ $mar->rut_repeticiones }}"
                                                    id="rrepeticiones_{{ $mar->rut_id }}">
                                            </div>
                                            <div class="campo">
                                                <span>RIR</span>
                                                <input min="0" class="form-control" type="number"
                                                    value="{{ $mar->rut_rid }}" id="rrir_{{ $mar->rut_id }}">
                                            </div>
                                            <div class="campo">
                                                <button class="boton boton-guardar btn btn-primary"
                                                    onclick="guardarRutina({{ $mar->rut_id }})">Guardar</button>
                                                @if ($usr->roles[0]->name == 'superadmin' || $usr->roles[0]->name == 'Modo GYM')
                                                    <button class="boton boton-eliminar btn btn-danger"
                                                        onclick="eliminarRutina({{ $mar->rut_id }})">-</button>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="item">
                                        <div class="titulo-item">
                                            No hay rutinas
                                        </div>
                                    </div>
                                @endif
                                @if ($usr->roles[0]->name == 'superadmin' || $usr->roles[0]->name == 'Modo GYM')
                                    <button class="boton boton-guardar btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal" onclick="addEjercicios(2)"
                                        id="btn-agregar">+</button>
                                @endif
                            </div>
                            <div class="columna">
                                <h4>Miercoles</h4>
                                @if (count($miercoles) > 0)
                                    @foreach ($miercoles as $mie)
                                        @php
                                            $nivel = '';
                                            if ($mie->ejercicio->ejer_nivel >= 0 && $mie->ejercicio->ejer_nivel <= 2) {
                                                $nivel = 'item-basico';
                                            } elseif (
                                                $mie->ejercicio->ejer_nivel > 2 &&
                                                $mie->ejercicio->ejer_nivel <= 3
                                            ) {
                                                $nivel = 'item-intermedio';
                                            } elseif (
                                                $mie->ejercicio->ejer_nivel > 3 &&
                                                $mie->ejercicio->ejer_nivel <= 5
                                            ) {
                                                $nivel = 'item-avanzado';
                                            }
                                        @endphp
                                        <div class="item {{ $nivel }}">
                                            <div class="titulo-item">
                                                {{ $mie->ejercicio->ejer_nombre }}
                                            </div>
                                            <div class="campo">
                                                <span>Series</span>
                                                <input min="0" class="form-control" type="number"
                                                    value="{{ $mie->rut_serie }}" id="rseries_{{ $mie->rut_id }}">
                                            </div>
                                            <div class="campo">
                                                <span>Repeticiones</span>
                                                <input min="0" class="form-control" type="number"
                                                    value="{{ $mie->rut_repeticiones }}"
                                                    id="rrepeticiones_{{ $mie->rut_id }}">
                                            </div>
                                            <div class="campo">
                                                <span>RIR</span>
                                                <input min="0" class="form-control" type="number"
                                                    value="{{ $mie->rut_rid }}" id="rrir_{{ $mie->rut_id }}">
                                            </div>
                                            <div class="campo">
                                                <button class="boton boton-guardar btn btn-primary"
                                                    onclick="guardarRutina({{ $mie->rut_id }})">Guardar</button>
                                                @if ($usr->roles[0]->name == 'superadmin' || $usr->roles[0]->name == 'Modo GYM')
                                                    <button class="boton boton-eliminar btn btn-danger"
                                                        onclick="eliminarRutina({{ $mie->rut_id }})">-</button>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="item">
                                        <div class="titulo-item">
                                            No hay rutinas
                                        </div>
                                    </div>
                                @endif
                                @if ($usr->roles[0]->name == 'superadmin' || $usr->roles[0]->name == 'Modo GYM')
                                    <button class="boton boton-guardar btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal" onclick="addEjercicios(3)"
                                        id="btn-agregar">+</button>
                                @endif
                            </div>
                            <div class="columna">
                                <h4>Jueves</h4>
                                @if (count($jueves) > 0)
                                    @foreach ($jueves as $jue)
                                        @php
                                            $nivel = '';
                                            if ($jue->ejercicio->ejer_nivel >= 0 && $jue->ejercicio->ejer_nivel <= 2) {
                                                $nivel = 'item-basico';
                                            } elseif (
                                                $jue->ejercicio->ejer_nivel > 2 &&
                                                $jue->ejercicio->ejer_nivel <= 3
                                            ) {
                                                $nivel = 'item-intermedio';
                                            } elseif (
                                                $jue->ejercicio->ejer_nivel > 3 &&
                                                $jue->ejercicio->ejer_nivel <= 5
                                            ) {
                                                $nivel = 'item-avanzado';
                                            }
                                        @endphp
                                        <div class="item {{ $nivel }}">
                                            <div class="titulo-item">
                                                {{ $jue->ejercicio->ejer_nombre }}
                                            </div>
                                            <div class="campo">
                                                <span>Series</span>
                                                <input min="0" class="form-control" type="number"
                                                    value="{{ $jue->rut_serie }}" id="rseries_{{ $jue->rut_id }}">
                                            </div>
                                            <div class="campo">
                                                <span>Repeticiones</span>
                                                <input min="0" class="form-control" type="number"
                                                    value="{{ $jue->rut_repeticiones }}"
                                                    id="rrepeticiones_{{ $jue->rut_id }}">
                                            </div>
                                            <div class="campo">
                                                <span>RIR</span>
                                                <input min="0" class="form-control" type="number"
                                                    value="{{ $jue->rut_rid }}" id="rrir_{{ $jue->rut_id }}">
                                            </div>
                                            <div class="campo">
                                                <button class="boton boton-guardar btn btn-primary"
                                                    onclick="guardarRutina({{ $jue->rut_id }})">Guardar</button>
                                                @if ($usr->roles[0]->name == 'superadmin' || $usr->roles[0]->name == 'Modo GYM')
                                                    <button class="boton boton-eliminar btn btn-danger"
                                                        onclick="eliminarRutina({{ $jue->rut_id }})">-</button>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="item">
                                        <div class="titulo-item">
                                            No hay rutinas
                                        </div>
                                    </div>
                                @endif
                                @if ($usr->roles[0]->name == 'superadmin' || $usr->roles[0]->name == 'Modo GYM')
                                    <button class="boton boton-guardar btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal" onclick="addEjercicios(4)"
                                        id="btn-agregar">+</button>
                                @endif
                            </div>
                            <div class="columna">
                                <h4>Viernes</h4>
                                @if (count($viernes) > 0)
                                    @foreach ($viernes as $vie)
                                        @php
                                            $nivel = '';
                                            if ($vie->ejercicio->ejer_nivel >= 0 && $vie->ejercicio->ejer_nivel <= 2) {
                                                $nivel = 'item-basico';
                                            } elseif (
                                                $vie->ejercicio->ejer_nivel > 2 &&
                                                $vie->ejercicio->ejer_nivel <= 3
                                            ) {
                                                $nivel = 'item-intermedio';
                                            } elseif (
                                                $vie->ejercicio->ejer_nivel > 3 &&
                                                $vie->ejercicio->ejer_nivel <= 5
                                            ) {
                                                $nivel = 'item-avanzado';
                                            }
                                        @endphp
                                        <div class="item {{ $nivel }}">
                                            <div class="titulo-item">
                                                {{ $vie->ejercicio->ejer_nombre }}
                                            </div>
                                            <div class="campo">
                                                <span>Series</span>
                                                <input min="0" class="form-control" type="number"
                                                    value="{{ $vie->rut_serie }}" id="rseries_{{ $vie->rut_id }}">
                                            </div>
                                            <div class="campo">
                                                <span>Repeticiones</span>
                                                <input min="0" class="form-control" type="number"
                                                    value="{{ $vie->rut_repeticiones }}"
                                                    id="rrepeticiones_{{ $vie->rut_id }}">
                                            </div>
                                            <div class="campo">
                                                <span>RIR</span>
                                                <input min="0" class="form-control" type="number"
                                                    value="{{ $vie->rut_rid }}" id="rrir_{{ $vie->rut_id }}">
                                            </div>
                                            <div class="campo">
                                                <button class="boton boton-guardar btn btn-primary"
                                                    onclick="guardarRutina({{ $vie->rut_id }})">Guardar</button>
                                                @if ($usr->roles[0]->name == 'superadmin' || $usr->roles[0]->name == 'Modo GYM')
                                                    <button class="boton boton-eliminar btn btn-danger"
                                                        onclick="eliminarRutina({{ $vie->rut_id }})">-</button>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="item">
                                        <div class="titulo-item">
                                            No hay rutinas
                                        </div>
                                    </div>
                                @endif
                                @if ($usr->roles[0]->name == 'superadmin' || $usr->roles[0]->name == 'Modo GYM')
                                    <button class="boton boton-guardar btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal" onclick="addEjercicios(5)"
                                        id="btn-agregar">+</button>
                                @endif
                            </div>
                            <div class="columna">
                                <h4>Sabado</h4>
                                @if (count($sabado) > 0)
                                    @foreach ($sabado as $sab)
                                        @php
                                            $nivel = '';
                                            if ($sab->ejercicio->ejer_nivel >= 0 && $sab->ejercicio->ejer_nivel <= 2) {
                                                $nivel = 'item-basico';
                                            } elseif (
                                                $sab->ejercicio->ejer_nivel > 2 &&
                                                $sab->ejercicio->ejer_nivel <= 3
                                            ) {
                                                $nivel = 'item-intermedio';
                                            } elseif (
                                                $sab->ejercicio->ejer_nivel > 3 &&
                                                $sab->ejercicio->ejer_nivel <= 5
                                            ) {
                                                $nivel = 'item-avanzado';
                                            }
                                        @endphp
                                        <div class="item {{ $nivel }}">
                                            <div class="titulo-item">
                                                {{ $sab->ejercicio->ejer_nombre }}
                                            </div>
                                            <div class="campo">
                                                <span>Series</span>
                                                <input min="0" class="form-control" type="number"
                                                    value="{{ $sab->rut_serie }}" id="rseries_{{ $sab->rut_id }}">
                                            </div>
                                            <div class="campo">
                                                <span>Repeticiones</span>
                                                <input min="0" class="form-control" type="number"
                                                    value="{{ $sab->rut_repeticiones }}"
                                                    id="rrepeticiones_{{ $sab->rut_id }}">
                                            </div>
                                            <div class="campo">
                                                <span>RIR</span>
                                                <input min="0" class="form-control" type="number"
                                                    value="{{ $sab->rut_rid }}" id="rrir_{{ $sab->rut_id }}">
                                            </div>
                                            <div class="campo">
                                                <button class="boton boton-guardar btn btn-primary"
                                                    onclick="guardarRutina({{ $sab->rut_id }})">Guardar</button>
                                                @if ($usr->roles[0]->name == 'superadmin' || $usr->roles[0]->name == 'Modo GYM')
                                                    <button class="boton boton-eliminar btn btn-danger"
                                                        onclick="eliminarRutina({{ $sab->rut_id }})">-</button>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="item">
                                        <div class="titulo-item">
                                            No hay rutinas
                                        </div>
                                    </div>
                                @endif
                                @if ($usr->roles[0]->name == 'superadmin' || $usr->roles[0]->name == 'Modo GYM')
                                    <button class="boton boton-guardar btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal" onclick="addEjercicios(6)"
                                        id="btn-agregar">+</button>
                                @endif
                            </div>
                            <div class="columna">
                                <h4>Domingo</h4>
                                @if (count($domingo) > 0)
                                    @foreach ($domingo as $dom)
                                        @php
                                            $nivel = '';
                                            if ($dom->ejercicio->ejer_nivel >= 0 && $dom->ejercicio->ejer_nivel <= 2) {
                                                $nivel = 'item-basico';
                                            } elseif (
                                                $dom->ejercicio->ejer_nivel > 2 &&
                                                $dom->ejercicio->ejer_nivel <= 3
                                            ) {
                                                $nivel = 'item-intermedio';
                                            } elseif (
                                                $dom->ejercicio->ejer_nivel > 3 &&
                                                $dom->ejercicio->ejer_nivel <= 5
                                            ) {
                                                $nivel = 'item-avanzado';
                                            }
                                        @endphp
                                        <div class="item {{ $nivel }}">
                                            <div class="titulo-item">
                                                {{ $dom->ejercicio->ejer_nombre }}
                                            </div>
                                            <div class="campo">
                                                <span>Series</span>
                                                <input min="0" class="form-control" type="number"
                                                    value="{{ $dom->rut_serie }}" id="rseries_{{ $dom->rut_id }}">
                                            </div>
                                            <div class="campo">
                                                <span>Repeticiones</span>
                                                <input min="0" class="form-control" type="number"
                                                    value="{{ $dom->rut_repeticiones }}"
                                                    id="rrepeticiones_{{ $dom->rut_id }}">
                                            </div>
                                            <div class="campo">
                                                <span>RIR</span>
                                                <input min="0" class="form-control" type="number"
                                                    value="{{ $dom->rut_rid }}" id="rrir_{{ $dom->rut_id }}">
                                            </div>
                                            <div class="campo">
                                                <button class="boton boton-guardar btn btn-primary"
                                                    onclick="guardarRutina({{ $dom->rut_id }})">Guardar</button>
                                                @if ($usr->roles[0]->name == 'superadmin' || $usr->roles[0]->name == 'Modo GYM')
                                                    <button class="boton boton-eliminar btn btn-danger"
                                                        onclick="eliminarRutina({{ $dom->rut_id }})">-</button>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="item">
                                        <div class="titulo-item">
                                            No hay rutinas
                                        </div>
                                    </div>
                                @endif
                                @if ($usr->roles[0]->name == 'superadmin' || $usr->roles[0]->name == 'Modo GYM')
                                    <button class="boton boton-guardar btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal" onclick="addEjercicios(7)"
                                        id="btn-agregar">+</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($usr->roles[0]->name == 'superadmin' || $usr->roles[0]->name == 'Modo GYM')
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="ejercicios_rutina">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar ejercicios - <span
                                    id="title_dia"></span></h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                onclick="resetEjerciciosRutina()"></button>
                        </div>
                        <div class="modal-header">
                            <input type="text" id="searchInput" class="form-control"
                                placeholder="Buscar ejercicio...">
                            <input type="hidden" id="dia_rut">
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
                            <button type="button" class="btn btn-dark" onclick="resetEjerciciosRutina()">Vaciar</button>
                            <button type="button" class="btn btn-success" onclick="agregarEjercicios()"
                                data-bs-dismiss="modal">Agregar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
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

            $('#searchInput').on('keyup', function() {
                var searchTerm = $(this).val().toLowerCase();
                $('.exercise-item').each(function() {
                    var exerciseName = $(this).find('.card-title').text().toLowerCase();
                    if (exerciseName.startsWith(searchTerm)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });

        function resetEjerciciosRutina() {
            clearSearch()
            $('#ejercicios_rutina')[0].reset()
        }

        function clearSearch() {
            $('#searchInput').val('');
            $('.exercise-item').show();
        }

        function addEjercicios(dia) {
            var dias = {
                1: 'Lunes',
                2: 'Martes',
                3: 'Miercoles',
                4: 'Jueves',
                5: 'Viernes',
                6: 'Sabado',
                7: 'Domingo'
            }

            $('#title_dia').html(dias[dia]);
            $('#dia_rut').val(dia)
        }

        function guardarRutina(id) {
            const series = $('#rseries_' + id).val();
            const repeticiones = $('#rrepeticiones_' + id).val();
            const rir = $('#rrir_' + id).val();
            console.log(`${id} ${series} ${repeticiones} ${rir}`);

            $.ajax({
                type: "POST",
                url: "{{ route('admin.rutinas.guardar') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    series: series,
                    repeticiones: repeticiones,
                    rir: rir
                },
                dataType: "JSON",
                success: function(response) {
                    // console.log(response);
                    location.reload()
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function eliminarRutina(id) {
            $.ajax({
                type: "POST",
                url: "{{ route('admin.rutinas.eliminar') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id
                },
                dataType: "JSON",
                success: function(response) {
                    // console.log(response);
                    location.reload()
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function agregarEjercicios() {
            var selectEjercicios = [];
            const dia = $('#dia_rut').val()

            $('#ejercicios_rutina input[name="ejercicios[]"]:checked').each(function() {
                var id = $(this).attr('id');
                // var name = $(this).data('name');
                // var image = $(this).data('image');
                // var tipo = $(this).data('tipo');
                // selectEjercicios.push({
                //     id: id,
                //     name: name,
                //     image: image,
                //     tipo: tipo,
                //     id_usuario: '{{ $usuario->usu_id }}'
                // });
                selectEjercicios.push(id)
            });
            console.log(selectEjercicios);
            resetEjerciciosRutina()

            $.ajax({
                type: "POST",
                url: "{{ route('admin.rutinas.storeRutinas') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    dia: dia,
                    rutinas: selectEjercicios,
                    usu_id: '{{ $usuario->usu_id }}'
                },
                dataType: "JSON",
                success: function(response) {
                    // console.log(response)
                    location.reload()
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
    </script>
@endsection
