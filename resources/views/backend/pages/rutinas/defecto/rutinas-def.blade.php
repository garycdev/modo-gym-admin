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
            min-width: 300px;
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
            /* height: 230px; */
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
            /* font-size: .95em; */
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

                    @include('backend.layouts.partials.messages')

                    <br>
                    <div class="contenedor-scroll">
                        <div class="tabla-columnas">
                            <div class="columna">
                                <h4>Lunes</h4>
                                @if (count($lunes) > 0)
                                    @foreach ($lunes as $lun)
                                        @php
                                            $ruti = $lun->ejer_id;
                                            $ruts = $lun->rut_serie;

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
                                            <h6 class="titulo-item">
                                                {{ $lun->ejercicio->ejer_nombre }}
                                            </h6>
                                            <div class="row me-1">
                                                <label for="rut_tiempo_{{ $lun->rd_id }}" class="col-8">Temporizador de
                                                    descanso: </label>
                                                <select name="tiempo" id="rut_tiempo_{{ $lun->rd_id }}" class="col-4"
                                                    onchange="guardarTiempo({{ $lun->rd_id }},{{ $lun->def_id }}, {{ $lun->ejer_id }}, {{ $lun->rut_dia }})">
                                                    <option value="0" {{ $lun->rut_tiempo == 0 ? 'selected' : '' }}>
                                                        [Apagado]
                                                    </option>
                                                    <option value="5" {{ $lun->rut_tiempo == 5 ? 'selected' : '' }}>
                                                        5s
                                                    </option>
                                                    <option value="10" {{ $lun->rut_tiempo == 10 ? 'selected' : '' }}>
                                                        10s
                                                    </option>
                                                    <option value="15" {{ $lun->rut_tiempo == 15 ? 'selected' : '' }}>
                                                        15s
                                                    </option>
                                                    <option value="20" {{ $lun->rut_tiempo == 20 ? 'selected' : '' }}>
                                                        20s
                                                    </option>
                                                    <option value="25" {{ $lun->rut_tiempo == 25 ? 'selected' : '' }}>
                                                        25s
                                                    </option>
                                                    <option value="30" {{ $lun->rut_tiempo == 30 ? 'selected' : '' }}>
                                                        30s
                                                    </option>
                                                    <option value="35" {{ $lun->rut_tiempo == 35 ? 'selected' : '' }}>
                                                        35s
                                                    </option>
                                                    <option value="40" {{ $lun->rut_tiempo == 40 ? 'selected' : '' }}>
                                                        40s
                                                    </option>
                                                    <option value="45" {{ $lun->rut_tiempo == 45 ? 'selected' : '' }}>
                                                        45s
                                                    </option>
                                                    <option value="50" {{ $lun->rut_tiempo == 50 ? 'selected' : '' }}>
                                                        50s
                                                    </option>
                                                    <option value="55" {{ $lun->rut_tiempo == 55 ? 'selected' : '' }}>
                                                        55s
                                                    </option>
                                                    <option value="60" {{ $lun->rut_tiempo == 60 ? 'selected' : '' }}>
                                                        1min 0s
                                                    </option>
                                                    <option value="65" {{ $lun->rut_tiempo == 65 ? 'selected' : '' }}>
                                                        1min 5s
                                                    </option>
                                                    <option value="70" {{ $lun->rut_tiempo == 70 ? 'selected' : '' }}>
                                                        1min 10s
                                                    </option>
                                                    <option value="75" {{ $lun->rut_tiempo == 75 ? 'selected' : '' }}>
                                                        1min 15s
                                                    </option>
                                                    <option value="80" {{ $lun->rut_tiempo == 80 ? 'selected' : '' }}>
                                                        1min 20s
                                                    </option>
                                                    <option value="85" {{ $lun->rut_tiempo == 85 ? 'selected' : '' }}>
                                                        1min 25s
                                                    </option>
                                                    <option value="90" {{ $lun->rut_tiempo == 90 ? 'selected' : '' }}>
                                                        1min 30s
                                                    </option>
                                                    <option value="95" {{ $lun->rut_tiempo == 95 ? 'selected' : '' }}>
                                                        1min 35s
                                                    </option>
                                                    <option value="100" {{ $lun->rut_tiempo == 100 ? 'selected' : '' }}>
                                                        1min 40s
                                                    </option>
                                                    <option value="105" {{ $lun->rut_tiempo == 105 ? 'selected' : '' }}>
                                                        1min 45s
                                                    </option>
                                                    <option value="110" {{ $lun->rut_tiempo == 110 ? 'selected' : '' }}>
                                                        1min 50s
                                                    </option>
                                                    <option value="115" {{ $lun->rut_tiempo == 115 ? 'selected' : '' }}>
                                                        1min 55s
                                                    </option>
                                                    <option value="120" {{ $lun->rut_tiempo == 120 ? 'selected' : '' }}>
                                                        2min 0s
                                                    </option>
                                                    <option value="135" {{ $lun->rut_tiempo == 135 ? 'selected' : '' }}>
                                                        2min 15s
                                                    </option>
                                                    <option value="150" {{ $lun->rut_tiempo == 150 ? 'selected' : '' }}>
                                                        2min 30s
                                                    </option>
                                                    <option value="165" {{ $lun->rut_tiempo == 165 ? 'selected' : '' }}>
                                                        2min 45s
                                                    </option>
                                                    <option value="180" {{ $lun->rut_tiempo == 180 ? 'selected' : '' }}>
                                                        3min 0s
                                                    </option>
                                                    <option value="195" {{ $lun->rut_tiempo == 195 ? 'selected' : '' }}>
                                                        3min 15s
                                                    </option>
                                                    <option value="210" {{ $lun->rut_tiempo == 210 ? 'selected' : '' }}>
                                                        3min 30s
                                                    </option>
                                                    <option value="225" {{ $lun->rut_tiempo == 225 ? 'selected' : '' }}>
                                                        3min 45s
                                                    </option>
                                                    <option value="240" {{ $lun->rut_tiempo == 240 ? 'selected' : '' }}>
                                                        4min 0s
                                                    </option>
                                                    <option value="255" {{ $lun->rut_tiempo == 255 ? 'selected' : '' }}>
                                                        4min 15s
                                                    </option>
                                                    <option value="270" {{ $lun->rut_tiempo == 270 ? 'selected' : '' }}>
                                                        4min 30s
                                                    </option>
                                                    <option value="285" {{ $lun->rut_tiempo == 285 ? 'selected' : '' }}>
                                                        4min 45s
                                                    </option>
                                                    <option value="300" {{ $lun->rut_tiempo == 300 ? 'selected' : '' }}>
                                                        5min 0s
                                                    </option>
                                                </select>
                                            </div>
                                            @php
                                                $latest = 0;
                                                foreach ($dias[$lun->rut_dia] as $value) {
                                                    if ($value->ejer_id == $lun->ejer_id) {
                                                        $latest++;
                                                    }
                                                }
                                                $count = 0;
                                            @endphp
                                            @foreach ($dias[$lun->rut_dia] as $rut)
                                                @if ($ruti == $rut->ejer_id)
                                                    <div class="item-content">
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <span>SERIE</span>
                                                                <input min="1" class="form-control" type="text"
                                                                    value="{{ $rut->rut_serie }}"
                                                                    id="rseries_{{ $rut->rd_id }}">
                                                            </div>
                                                            <div class="col-3">
                                                                <span>KG</span>
                                                                <input min="0" class="form-control" type="number"
                                                                    value="{{ $rut->rut_peso }}"
                                                                    id="rpeso_{{ $rut->rd_id }}">
                                                            </div>
                                                            <div class="col-3">
                                                                <span>RIR</span>
                                                                <input min="0" class="form-control" type="number"
                                                                    value="{{ $rut->rut_rid }}"
                                                                    id="rrir_{{ $rut->rd_id }}">
                                                            </div>
                                                            <div class="col-3">
                                                                <span>REPS</span>
                                                                <input min="1" class="form-control" type="number"
                                                                    value="{{ $rut->rut_repeticiones }}"
                                                                    id="rrepeticiones_{{ $rut->rd_id }}">
                                                            </div>
                                                        </div>
                                                        <div class="campo">
                                                            @if ($usr->roles[0]->name == 'superadmin' || $usr->roles[0]->name == 'Modo GYM')
                                                                <button class="boton boton-guardar btn btn-primary"
                                                                    onclick="guardarRutina({{ $rut->rd_id }})">Guardar</button>
                                                                @if ($latest - 1 == $count)
                                                                    <button class="boton boton-eliminar btn btn-danger"
                                                                        onclick="eliminarRutina({{ $rut->rd_id }})">
                                                                        <i class='bx bx-trash'></i>
                                                                    </button>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    @php
                                                        $ruts = $rut->rut_serie;
                                                        $count++;
                                                    @endphp
                                                @endif
                                            @endforeach
                                            <button class="btn btn-sm btn-light"
                                                onclick="addSerie({{ $lun->def_id }}, {{ $lun->ejer_id }}, {{ $lun->rut_dia }}, {{ $ruts }})">Agregar
                                                serie</button>
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
                                            $ruti = $mar->ejer_id;
                                            $ruts = $mar->rut_serie;

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
                                            <h6 class="titulo-item">
                                                {{ $mar->ejercicio->ejer_nombre }}
                                            </h6>
                                            <div class="row me-1">
                                                <label for="rut_tiempo_{{ $mar->rd_id }}" class="col-8">Temporizador
                                                    de
                                                    descanso: </label>
                                                <select name="tiempo" id="rut_tiempo_{{ $mar->rd_id }}"
                                                    class="col-4"
                                                    onchange="guardarTiempo({{ $mar->rd_id }},{{ $mar->def_id }}, {{ $mar->ejer_id }}, {{ $mar->rut_dia }})">
                                                    <option value="0" {{ $mar->rut_tiempo == 0 ? 'selected' : '' }}>
                                                        [Apagado]
                                                    </option>
                                                    <option value="5" {{ $mar->rut_tiempo == 5 ? 'selected' : '' }}>
                                                        5s
                                                    </option>
                                                    <option value="10" {{ $mar->rut_tiempo == 10 ? 'selected' : '' }}>
                                                        10s
                                                    </option>
                                                    <option value="15" {{ $mar->rut_tiempo == 15 ? 'selected' : '' }}>
                                                        15s
                                                    </option>
                                                    <option value="20" {{ $mar->rut_tiempo == 20 ? 'selected' : '' }}>
                                                        20s
                                                    </option>
                                                    <option value="25" {{ $mar->rut_tiempo == 25 ? 'selected' : '' }}>
                                                        25s
                                                    </option>
                                                    <option value="30" {{ $mar->rut_tiempo == 30 ? 'selected' : '' }}>
                                                        30s
                                                    </option>
                                                    <option value="35" {{ $mar->rut_tiempo == 35 ? 'selected' : '' }}>
                                                        35s
                                                    </option>
                                                    <option value="40" {{ $mar->rut_tiempo == 40 ? 'selected' : '' }}>
                                                        40s
                                                    </option>
                                                    <option value="45" {{ $mar->rut_tiempo == 45 ? 'selected' : '' }}>
                                                        45s
                                                    </option>
                                                    <option value="50" {{ $mar->rut_tiempo == 50 ? 'selected' : '' }}>
                                                        50s
                                                    </option>
                                                    <option value="55" {{ $mar->rut_tiempo == 55 ? 'selected' : '' }}>
                                                        55s
                                                    </option>
                                                    <option value="60" {{ $mar->rut_tiempo == 60 ? 'selected' : '' }}>
                                                        1min 0s
                                                    </option>
                                                    <option value="65" {{ $mar->rut_tiempo == 65 ? 'selected' : '' }}>
                                                        1min 5s
                                                    </option>
                                                    <option value="70" {{ $mar->rut_tiempo == 70 ? 'selected' : '' }}>
                                                        1min 10s
                                                    </option>
                                                    <option value="75" {{ $mar->rut_tiempo == 75 ? 'selected' : '' }}>
                                                        1min 15s
                                                    </option>
                                                    <option value="80" {{ $mar->rut_tiempo == 80 ? 'selected' : '' }}>
                                                        1min 20s
                                                    </option>
                                                    <option value="85" {{ $mar->rut_tiempo == 85 ? 'selected' : '' }}>
                                                        1min 25s
                                                    </option>
                                                    <option value="90" {{ $mar->rut_tiempo == 90 ? 'selected' : '' }}>
                                                        1min 30s
                                                    </option>
                                                    <option value="95" {{ $mar->rut_tiempo == 95 ? 'selected' : '' }}>
                                                        1min 35s
                                                    </option>
                                                    <option value="100"
                                                        {{ $mar->rut_tiempo == 100 ? 'selected' : '' }}>
                                                        1min 40s
                                                    </option>
                                                    <option value="105"
                                                        {{ $mar->rut_tiempo == 105 ? 'selected' : '' }}>
                                                        1min 45s
                                                    </option>
                                                    <option value="110"
                                                        {{ $mar->rut_tiempo == 110 ? 'selected' : '' }}>
                                                        1min 50s
                                                    </option>
                                                    <option value="115"
                                                        {{ $mar->rut_tiempo == 115 ? 'selected' : '' }}>
                                                        1min 55s
                                                    </option>
                                                    <option value="120"
                                                        {{ $mar->rut_tiempo == 120 ? 'selected' : '' }}>
                                                        2min 0s
                                                    </option>
                                                    <option value="135"
                                                        {{ $mar->rut_tiempo == 135 ? 'selected' : '' }}>
                                                        2min 15s
                                                    </option>
                                                    <option value="150"
                                                        {{ $mar->rut_tiempo == 150 ? 'selected' : '' }}>
                                                        2min 30s
                                                    </option>
                                                    <option value="165"
                                                        {{ $mar->rut_tiempo == 165 ? 'selected' : '' }}>
                                                        2min 45s
                                                    </option>
                                                    <option value="180"
                                                        {{ $mar->rut_tiempo == 180 ? 'selected' : '' }}>
                                                        3min 0s
                                                    </option>
                                                    <option value="195"
                                                        {{ $mar->rut_tiempo == 195 ? 'selected' : '' }}>
                                                        3min 15s
                                                    </option>
                                                    <option value="210"
                                                        {{ $mar->rut_tiempo == 210 ? 'selected' : '' }}>
                                                        3min 30s
                                                    </option>
                                                    <option value="225"
                                                        {{ $mar->rut_tiempo == 225 ? 'selected' : '' }}>
                                                        3min 45s
                                                    </option>
                                                    <option value="240"
                                                        {{ $mar->rut_tiempo == 240 ? 'selected' : '' }}>
                                                        4min 0s
                                                    </option>
                                                    <option value="255"
                                                        {{ $mar->rut_tiempo == 255 ? 'selected' : '' }}>
                                                        4min 15s
                                                    </option>
                                                    <option value="270"
                                                        {{ $mar->rut_tiempo == 270 ? 'selected' : '' }}>
                                                        4min 30s
                                                    </option>
                                                    <option value="285"
                                                        {{ $mar->rut_tiempo == 285 ? 'selected' : '' }}>
                                                        4min 45s
                                                    </option>
                                                    <option value="300"
                                                        {{ $mar->rut_tiempo == 300 ? 'selected' : '' }}>
                                                        5min 0s
                                                    </option>
                                                </select>
                                            </div>
                                            @php
                                                $latest = 0;
                                                foreach ($dias[$mar->rut_dia] as $value) {
                                                    if ($value->ejer_id == $mar->ejer_id) {
                                                        $latest++;
                                                    }
                                                }
                                                $count = 0;
                                            @endphp
                                            @foreach ($dias[$mar->rut_dia] as $rut)
                                                @if ($ruti == $rut->ejer_id)
                                                    <div class="item-content">
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <span>SERIE</span>
                                                                <input min="1" class="form-control" type="text"
                                                                    value="{{ $rut->rut_serie }}"
                                                                    id="rseries_{{ $rut->rd_id }}">
                                                            </div>
                                                            <div class="col-3">
                                                                <span>KG</span>
                                                                <input min="0" class="form-control" type="number"
                                                                    value="{{ $rut->rut_peso }}"
                                                                    id="rpeso_{{ $rut->rd_id }}">
                                                            </div>
                                                            <div class="col-3">
                                                                <span>RIR</span>
                                                                <input min="0" class="form-control" type="number"
                                                                    value="{{ $rut->rut_rid }}"
                                                                    id="rrir_{{ $rut->rd_id }}">
                                                            </div>
                                                            <div class="col-3">
                                                                <span>REPS</span>
                                                                <input min="1" class="form-control" type="number"
                                                                    value="{{ $rut->rut_repeticiones }}"
                                                                    id="rrepeticiones_{{ $rut->rd_id }}">
                                                            </div>
                                                        </div>
                                                        <div class="campo">
                                                            @if ($usr->roles[0]->name == 'superadmin' || $usr->roles[0]->name == 'Modo GYM')
                                                                <button class="boton boton-guardar btn btn-primary"
                                                                    onclick="guardarRutina({{ $rut->rd_id }})">Guardar</button>
                                                                @if ($latest - 1 == $count)
                                                                    <button class="boton boton-eliminar btn btn-danger"
                                                                        onclick="eliminarRutina({{ $rut->rd_id }})">
                                                                        <i class='bx bx-trash'></i>
                                                                    </button>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    @php
                                                        $ruts = $rut->rut_serie;
                                                        $count++;
                                                    @endphp
                                                @endif
                                            @endforeach
                                            <button class="btn btn-sm btn-light"
                                                onclick="addSerie({{ $mar->def_id }}, {{ $mar->ejer_id }}, {{ $mar->rut_dia }}, {{ $ruts }})">Agregar
                                                serie</button>
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
                                            $ruti = $mie->ejer_id;
                                            $ruts = $mie->rut_serie;

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
                                            <h6 class="titulo-item">
                                                {{ $mie->ejercicio->ejer_nombre }}
                                            </h6>
                                            <div class="row me-1">
                                                <label for="rut_tiempo_{{ $mie->rd_id }}" class="col-8">Temporizador
                                                    de
                                                    descanso: </label>
                                                <select name="tiempo" id="rut_tiempo_{{ $mie->rd_id }}"
                                                    class="col-4"
                                                    onchange="guardarTiempo({{ $mie->rd_id }},{{ $mie->def_id }}, {{ $mie->ejer_id }}, {{ $mie->rut_dia }})">
                                                    <option value="0" {{ $mie->rut_tiempo == 0 ? 'selected' : '' }}>
                                                        [Apagado]
                                                    </option>
                                                    <option value="5" {{ $mie->rut_tiempo == 5 ? 'selected' : '' }}>
                                                        5s
                                                    </option>
                                                    <option value="10"
                                                        {{ $mie->rut_tiempo == 10 ? 'selected' : '' }}>
                                                        10s
                                                    </option>
                                                    <option value="15"
                                                        {{ $mie->rut_tiempo == 15 ? 'selected' : '' }}>
                                                        15s
                                                    </option>
                                                    <option value="20"
                                                        {{ $mie->rut_tiempo == 20 ? 'selected' : '' }}>
                                                        20s
                                                    </option>
                                                    <option value="25"
                                                        {{ $mie->rut_tiempo == 25 ? 'selected' : '' }}>
                                                        25s
                                                    </option>
                                                    <option value="30"
                                                        {{ $mie->rut_tiempo == 30 ? 'selected' : '' }}>
                                                        30s
                                                    </option>
                                                    <option value="35"
                                                        {{ $mie->rut_tiempo == 35 ? 'selected' : '' }}>
                                                        35s
                                                    </option>
                                                    <option value="40"
                                                        {{ $mie->rut_tiempo == 40 ? 'selected' : '' }}>
                                                        40s
                                                    </option>
                                                    <option value="45"
                                                        {{ $mie->rut_tiempo == 45 ? 'selected' : '' }}>
                                                        45s
                                                    </option>
                                                    <option value="50"
                                                        {{ $mie->rut_tiempo == 50 ? 'selected' : '' }}>
                                                        50s
                                                    </option>
                                                    <option value="55"
                                                        {{ $mie->rut_tiempo == 55 ? 'selected' : '' }}>
                                                        55s
                                                    </option>
                                                    <option value="60"
                                                        {{ $mie->rut_tiempo == 60 ? 'selected' : '' }}>
                                                        1min 0s
                                                    </option>
                                                    <option value="65"
                                                        {{ $mie->rut_tiempo == 65 ? 'selected' : '' }}>
                                                        1min 5s
                                                    </option>
                                                    <option value="70"
                                                        {{ $mie->rut_tiempo == 70 ? 'selected' : '' }}>
                                                        1min 10s
                                                    </option>
                                                    <option value="75"
                                                        {{ $mie->rut_tiempo == 75 ? 'selected' : '' }}>
                                                        1min 15s
                                                    </option>
                                                    <option value="80"
                                                        {{ $mie->rut_tiempo == 80 ? 'selected' : '' }}>
                                                        1min 20s
                                                    </option>
                                                    <option value="85"
                                                        {{ $mie->rut_tiempo == 85 ? 'selected' : '' }}>
                                                        1min 25s
                                                    </option>
                                                    <option value="90"
                                                        {{ $mie->rut_tiempo == 90 ? 'selected' : '' }}>
                                                        1min 30s
                                                    </option>
                                                    <option value="95"
                                                        {{ $mie->rut_tiempo == 95 ? 'selected' : '' }}>
                                                        1min 35s
                                                    </option>
                                                    <option value="100"
                                                        {{ $mie->rut_tiempo == 100 ? 'selected' : '' }}>
                                                        1min 40s
                                                    </option>
                                                    <option value="105"
                                                        {{ $mie->rut_tiempo == 105 ? 'selected' : '' }}>
                                                        1min 45s
                                                    </option>
                                                    <option value="110"
                                                        {{ $mie->rut_tiempo == 110 ? 'selected' : '' }}>
                                                        1min 50s
                                                    </option>
                                                    <option value="115"
                                                        {{ $mie->rut_tiempo == 115 ? 'selected' : '' }}>
                                                        1min 55s
                                                    </option>
                                                    <option value="120"
                                                        {{ $mie->rut_tiempo == 120 ? 'selected' : '' }}>
                                                        2min 0s
                                                    </option>
                                                    <option value="135"
                                                        {{ $mie->rut_tiempo == 135 ? 'selected' : '' }}>
                                                        2min 15s
                                                    </option>
                                                    <option value="150"
                                                        {{ $mie->rut_tiempo == 150 ? 'selected' : '' }}>
                                                        2min 30s
                                                    </option>
                                                    <option value="165"
                                                        {{ $mie->rut_tiempo == 165 ? 'selected' : '' }}>
                                                        2min 45s
                                                    </option>
                                                    <option value="180"
                                                        {{ $mie->rut_tiempo == 180 ? 'selected' : '' }}>
                                                        3min 0s
                                                    </option>
                                                    <option value="195"
                                                        {{ $mie->rut_tiempo == 195 ? 'selected' : '' }}>
                                                        3min 15s
                                                    </option>
                                                    <option value="210"
                                                        {{ $mie->rut_tiempo == 210 ? 'selected' : '' }}>
                                                        3min 30s
                                                    </option>
                                                    <option value="225"
                                                        {{ $mie->rut_tiempo == 225 ? 'selected' : '' }}>
                                                        3min 45s
                                                    </option>
                                                    <option value="240"
                                                        {{ $mie->rut_tiempo == 240 ? 'selected' : '' }}>
                                                        4min 0s
                                                    </option>
                                                    <option value="255"
                                                        {{ $mie->rut_tiempo == 255 ? 'selected' : '' }}>
                                                        4min 15s
                                                    </option>
                                                    <option value="270"
                                                        {{ $mie->rut_tiempo == 270 ? 'selected' : '' }}>
                                                        4min 30s
                                                    </option>
                                                    <option value="285"
                                                        {{ $mie->rut_tiempo == 285 ? 'selected' : '' }}>
                                                        4min 45s
                                                    </option>
                                                    <option value="300"
                                                        {{ $mie->rut_tiempo == 300 ? 'selected' : '' }}>
                                                        5min 0s
                                                    </option>
                                                </select>
                                            </div>
                                            @php
                                                $latest = 0;
                                                foreach ($dias[$mie->rut_dia] as $value) {
                                                    if ($value->ejer_id == $mie->ejer_id) {
                                                        $latest++;
                                                    }
                                                }
                                                $count = 0;
                                            @endphp
                                            @foreach ($dias[$mie->rut_dia] as $rut)
                                                @if ($ruti == $rut->ejer_id)
                                                    <div class="item-content">
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <span>SERIE</span>
                                                                <input min="1" class="form-control" type="text"
                                                                    value="{{ $rut->rut_serie }}"
                                                                    id="rseries_{{ $rut->rd_id }}">
                                                            </div>
                                                            <div class="col-3">
                                                                <span>KG</span>
                                                                <input min="0" class="form-control" type="number"
                                                                    value="{{ $rut->rut_peso }}"
                                                                    id="rpeso_{{ $rut->rd_id }}">
                                                            </div>
                                                            <div class="col-3">
                                                                <span>RIR</span>
                                                                <input min="0" class="form-control" type="number"
                                                                    value="{{ $rut->rut_rid }}"
                                                                    id="rrir_{{ $rut->rd_id }}">
                                                            </div>
                                                            <div class="col-3">
                                                                <span>REPS</span>
                                                                <input min="1" class="form-control" type="number"
                                                                    value="{{ $rut->rut_repeticiones }}"
                                                                    id="rrepeticiones_{{ $rut->rd_id }}">
                                                            </div>
                                                        </div>
                                                        <div class="campo">
                                                            @if ($usr->roles[0]->name == 'superadmin' || $usr->roles[0]->name == 'Modo GYM')
                                                                <button class="boton boton-guardar btn btn-primary"
                                                                    onclick="guardarRutina({{ $rut->rd_id }})">Guardar</button>
                                                                @if ($latest - 1 == $count)
                                                                    <button class="boton boton-eliminar btn btn-danger"
                                                                        onclick="eliminarRutina({{ $rut->rd_id }})">
                                                                        <i class='bx bx-trash'></i>
                                                                    </button>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    @php
                                                        $ruts = $rut->rut_serie;
                                                        $count++;
                                                    @endphp
                                                @endif
                                            @endforeach
                                            <button class="btn btn-sm btn-light"
                                                onclick="addSerie({{ $mie->def_id }}, {{ $mie->ejer_id }}, {{ $mie->rut_dia }}, {{ $ruts }})">Agregar
                                                serie</button>
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
                                            $ruti = $jue->ejer_id;
                                            $ruts = $jue->rut_serie;

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
                                            <h6 class="titulo-item">
                                                {{ $jue->ejercicio->ejer_nombre }}
                                            </h6>
                                            <div class="row me-1">
                                                <label for="rut_tiempo_{{ $jue->rd_id }}" class="col-8">Temporizador
                                                    de
                                                    descanso: </label>
                                                <select name="tiempo" id="rut_tiempo_{{ $jue->rd_id }}"
                                                    class="col-4"
                                                    onchange="guardarTiempo({{ $jue->rd_id }},{{ $jue->def_id }}, {{ $jue->ejer_id }}, {{ $jue->rut_dia }})">
                                                    <option value="0" {{ $jue->rut_tiempo == 0 ? 'selected' : '' }}>
                                                        [Apagado]
                                                    </option>
                                                    <option value="5" {{ $jue->rut_tiempo == 5 ? 'selected' : '' }}>
                                                        5s
                                                    </option>
                                                    <option value="10"
                                                        {{ $jue->rut_tiempo == 10 ? 'selected' : '' }}>
                                                        10s
                                                    </option>
                                                    <option value="15"
                                                        {{ $jue->rut_tiempo == 15 ? 'selected' : '' }}>
                                                        15s
                                                    </option>
                                                    <option value="20"
                                                        {{ $jue->rut_tiempo == 20 ? 'selected' : '' }}>
                                                        20s
                                                    </option>
                                                    <option value="25"
                                                        {{ $jue->rut_tiempo == 25 ? 'selected' : '' }}>
                                                        25s
                                                    </option>
                                                    <option value="30"
                                                        {{ $jue->rut_tiempo == 30 ? 'selected' : '' }}>
                                                        30s
                                                    </option>
                                                    <option value="35"
                                                        {{ $jue->rut_tiempo == 35 ? 'selected' : '' }}>
                                                        35s
                                                    </option>
                                                    <option value="40"
                                                        {{ $jue->rut_tiempo == 40 ? 'selected' : '' }}>
                                                        40s
                                                    </option>
                                                    <option value="45"
                                                        {{ $jue->rut_tiempo == 45 ? 'selected' : '' }}>
                                                        45s
                                                    </option>
                                                    <option value="50"
                                                        {{ $jue->rut_tiempo == 50 ? 'selected' : '' }}>
                                                        50s
                                                    </option>
                                                    <option value="55"
                                                        {{ $jue->rut_tiempo == 55 ? 'selected' : '' }}>
                                                        55s
                                                    </option>
                                                    <option value="60"
                                                        {{ $jue->rut_tiempo == 60 ? 'selected' : '' }}>
                                                        1min 0s
                                                    </option>
                                                    <option value="65"
                                                        {{ $jue->rut_tiempo == 65 ? 'selected' : '' }}>
                                                        1min 5s
                                                    </option>
                                                    <option value="70"
                                                        {{ $jue->rut_tiempo == 70 ? 'selected' : '' }}>
                                                        1min 10s
                                                    </option>
                                                    <option value="75"
                                                        {{ $jue->rut_tiempo == 75 ? 'selected' : '' }}>
                                                        1min 15s
                                                    </option>
                                                    <option value="80"
                                                        {{ $jue->rut_tiempo == 80 ? 'selected' : '' }}>
                                                        1min 20s
                                                    </option>
                                                    <option value="85"
                                                        {{ $jue->rut_tiempo == 85 ? 'selected' : '' }}>
                                                        1min 25s
                                                    </option>
                                                    <option value="90"
                                                        {{ $jue->rut_tiempo == 90 ? 'selected' : '' }}>
                                                        1min 30s
                                                    </option>
                                                    <option value="95"
                                                        {{ $jue->rut_tiempo == 95 ? 'selected' : '' }}>
                                                        1min 35s
                                                    </option>
                                                    <option value="100"
                                                        {{ $jue->rut_tiempo == 100 ? 'selected' : '' }}>
                                                        1min 40s
                                                    </option>
                                                    <option value="105"
                                                        {{ $jue->rut_tiempo == 105 ? 'selected' : '' }}>
                                                        1min 45s
                                                    </option>
                                                    <option value="110"
                                                        {{ $jue->rut_tiempo == 110 ? 'selected' : '' }}>
                                                        1min 50s
                                                    </option>
                                                    <option value="115"
                                                        {{ $jue->rut_tiempo == 115 ? 'selected' : '' }}>
                                                        1min 55s
                                                    </option>
                                                    <option value="120"
                                                        {{ $jue->rut_tiempo == 120 ? 'selected' : '' }}>
                                                        2min 0s
                                                    </option>
                                                    <option value="135"
                                                        {{ $jue->rut_tiempo == 135 ? 'selected' : '' }}>
                                                        2min 15s
                                                    </option>
                                                    <option value="150"
                                                        {{ $jue->rut_tiempo == 150 ? 'selected' : '' }}>
                                                        2min 30s
                                                    </option>
                                                    <option value="165"
                                                        {{ $jue->rut_tiempo == 165 ? 'selected' : '' }}>
                                                        2min 45s
                                                    </option>
                                                    <option value="180"
                                                        {{ $jue->rut_tiempo == 180 ? 'selected' : '' }}>
                                                        3min 0s
                                                    </option>
                                                    <option value="195"
                                                        {{ $jue->rut_tiempo == 195 ? 'selected' : '' }}>
                                                        3min 15s
                                                    </option>
                                                    <option value="210"
                                                        {{ $jue->rut_tiempo == 210 ? 'selected' : '' }}>
                                                        3min 30s
                                                    </option>
                                                    <option value="225"
                                                        {{ $jue->rut_tiempo == 225 ? 'selected' : '' }}>
                                                        3min 45s
                                                    </option>
                                                    <option value="240"
                                                        {{ $jue->rut_tiempo == 240 ? 'selected' : '' }}>
                                                        4min 0s
                                                    </option>
                                                    <option value="255"
                                                        {{ $jue->rut_tiempo == 255 ? 'selected' : '' }}>
                                                        4min 15s
                                                    </option>
                                                    <option value="270"
                                                        {{ $jue->rut_tiempo == 270 ? 'selected' : '' }}>
                                                        4min 30s
                                                    </option>
                                                    <option value="285"
                                                        {{ $jue->rut_tiempo == 285 ? 'selected' : '' }}>
                                                        4min 45s
                                                    </option>
                                                    <option value="300"
                                                        {{ $jue->rut_tiempo == 300 ? 'selected' : '' }}>
                                                        5min 0s
                                                    </option>
                                                </select>
                                            </div>
                                            @php
                                                $latest = 0;
                                                foreach ($dias[$jue->rut_dia] as $value) {
                                                    if ($value->ejer_id == $jue->ejer_id) {
                                                        $latest++;
                                                    }
                                                }
                                                $count = 0;
                                            @endphp
                                            @foreach ($dias[$jue->rut_dia] as $rut)
                                                @if ($ruti == $rut->ejer_id)
                                                    <div class="item-content">
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <span>SERIE</span>
                                                                <input min="1" class="form-control" type="text"
                                                                    value="{{ $rut->rut_serie }}"
                                                                    id="rseries_{{ $rut->rd_id }}">
                                                            </div>
                                                            <div class="col-3">
                                                                <span>KG</span>
                                                                <input min="0" class="form-control" type="number"
                                                                    value="{{ $rut->rut_peso }}"
                                                                    id="rpeso_{{ $rut->rd_id }}">
                                                            </div>
                                                            <div class="col-3">
                                                                <span>RIR</span>
                                                                <input min="0" class="form-control" type="number"
                                                                    value="{{ $rut->rut_rid }}"
                                                                    id="rrir_{{ $rut->rd_id }}">
                                                            </div>
                                                            <div class="col-3">
                                                                <span>REPS</span>
                                                                <input min="1" class="form-control" type="number"
                                                                    value="{{ $rut->rut_repeticiones }}"
                                                                    id="rrepeticiones_{{ $rut->rd_id }}">
                                                            </div>
                                                        </div>
                                                        <div class="campo">
                                                            @if ($usr->roles[0]->name == 'superadmin' || $usr->roles[0]->name == 'Modo GYM')
                                                                <button class="boton boton-guardar btn btn-primary"
                                                                    onclick="guardarRutina({{ $rut->rd_id }})">Guardar</button>
                                                                @if ($latest - 1 == $count)
                                                                    <button class="boton boton-eliminar btn btn-danger"
                                                                        onclick="eliminarRutina({{ $rut->rd_id }})">
                                                                        <i class='bx bx-trash'></i>
                                                                    </button>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    @php
                                                        $ruts = $rut->rut_serie;
                                                        $count++;
                                                    @endphp
                                                @endif
                                            @endforeach
                                            <button class="btn btn-sm btn-light"
                                                onclick="addSerie({{ $jue->def_id }}, {{ $jue->ejer_id }}, {{ $jue->rut_dia }}, {{ $ruts }})">Agregar
                                                serie</button>
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
                                            $ruti = $vie->ejer_id;
                                            $ruts = $vie->rut_serie;

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
                                            <h6 class="titulo-item">
                                                {{ $vie->ejercicio->ejer_nombre }}
                                            </h6>
                                            <div class="row me-1">
                                                <label for="rut_tiempo_{{ $vie->rd_id }}" class="col-8">Temporizador
                                                    de
                                                    descanso: </label>
                                                <select name="tiempo" id="rut_tiempo_{{ $vie->rd_id }}"
                                                    class="col-4"
                                                    onchange="guardarTiempo({{ $vie->rd_id }},{{ $vie->def_id }}, {{ $vie->ejer_id }}, {{ $vie->rut_dia }})">
                                                    <option value="0" {{ $vie->rut_tiempo == 0 ? 'selected' : '' }}>
                                                        [Apagado]
                                                    </option>
                                                    <option value="5" {{ $vie->rut_tiempo == 5 ? 'selected' : '' }}>
                                                        5s
                                                    </option>
                                                    <option value="10"
                                                        {{ $vie->rut_tiempo == 10 ? 'selected' : '' }}>
                                                        10s
                                                    </option>
                                                    <option value="15"
                                                        {{ $vie->rut_tiempo == 15 ? 'selected' : '' }}>
                                                        15s
                                                    </option>
                                                    <option value="20"
                                                        {{ $vie->rut_tiempo == 20 ? 'selected' : '' }}>
                                                        20s
                                                    </option>
                                                    <option value="25"
                                                        {{ $vie->rut_tiempo == 25 ? 'selected' : '' }}>
                                                        25s
                                                    </option>
                                                    <option value="30"
                                                        {{ $vie->rut_tiempo == 30 ? 'selected' : '' }}>
                                                        30s
                                                    </option>
                                                    <option value="35"
                                                        {{ $vie->rut_tiempo == 35 ? 'selected' : '' }}>
                                                        35s
                                                    </option>
                                                    <option value="40"
                                                        {{ $vie->rut_tiempo == 40 ? 'selected' : '' }}>
                                                        40s
                                                    </option>
                                                    <option value="45"
                                                        {{ $vie->rut_tiempo == 45 ? 'selected' : '' }}>
                                                        45s
                                                    </option>
                                                    <option value="50"
                                                        {{ $vie->rut_tiempo == 50 ? 'selected' : '' }}>
                                                        50s
                                                    </option>
                                                    <option value="55"
                                                        {{ $vie->rut_tiempo == 55 ? 'selected' : '' }}>
                                                        55s
                                                    </option>
                                                    <option value="60"
                                                        {{ $vie->rut_tiempo == 60 ? 'selected' : '' }}>
                                                        1min 0s
                                                    </option>
                                                    <option value="65"
                                                        {{ $vie->rut_tiempo == 65 ? 'selected' : '' }}>
                                                        1min 5s
                                                    </option>
                                                    <option value="70"
                                                        {{ $vie->rut_tiempo == 70 ? 'selected' : '' }}>
                                                        1min 10s
                                                    </option>
                                                    <option value="75"
                                                        {{ $vie->rut_tiempo == 75 ? 'selected' : '' }}>
                                                        1min 15s
                                                    </option>
                                                    <option value="80"
                                                        {{ $vie->rut_tiempo == 80 ? 'selected' : '' }}>
                                                        1min 20s
                                                    </option>
                                                    <option value="85"
                                                        {{ $vie->rut_tiempo == 85 ? 'selected' : '' }}>
                                                        1min 25s
                                                    </option>
                                                    <option value="90"
                                                        {{ $vie->rut_tiempo == 90 ? 'selected' : '' }}>
                                                        1min 30s
                                                    </option>
                                                    <option value="95"
                                                        {{ $vie->rut_tiempo == 95 ? 'selected' : '' }}>
                                                        1min 35s
                                                    </option>
                                                    <option value="100"
                                                        {{ $vie->rut_tiempo == 100 ? 'selected' : '' }}>
                                                        1min 40s
                                                    </option>
                                                    <option value="105"
                                                        {{ $vie->rut_tiempo == 105 ? 'selected' : '' }}>
                                                        1min 45s
                                                    </option>
                                                    <option value="110"
                                                        {{ $vie->rut_tiempo == 110 ? 'selected' : '' }}>
                                                        1min 50s
                                                    </option>
                                                    <option value="115"
                                                        {{ $vie->rut_tiempo == 115 ? 'selected' : '' }}>
                                                        1min 55s
                                                    </option>
                                                    <option value="120"
                                                        {{ $vie->rut_tiempo == 120 ? 'selected' : '' }}>
                                                        2min 0s
                                                    </option>
                                                    <option value="135"
                                                        {{ $vie->rut_tiempo == 135 ? 'selected' : '' }}>
                                                        2min 15s
                                                    </option>
                                                    <option value="150"
                                                        {{ $vie->rut_tiempo == 150 ? 'selected' : '' }}>
                                                        2min 30s
                                                    </option>
                                                    <option value="165"
                                                        {{ $vie->rut_tiempo == 165 ? 'selected' : '' }}>
                                                        2min 45s
                                                    </option>
                                                    <option value="180"
                                                        {{ $vie->rut_tiempo == 180 ? 'selected' : '' }}>
                                                        3min 0s
                                                    </option>
                                                    <option value="195"
                                                        {{ $vie->rut_tiempo == 195 ? 'selected' : '' }}>
                                                        3min 15s
                                                    </option>
                                                    <option value="210"
                                                        {{ $vie->rut_tiempo == 210 ? 'selected' : '' }}>
                                                        3min 30s
                                                    </option>
                                                    <option value="225"
                                                        {{ $vie->rut_tiempo == 225 ? 'selected' : '' }}>
                                                        3min 45s
                                                    </option>
                                                    <option value="240"
                                                        {{ $vie->rut_tiempo == 240 ? 'selected' : '' }}>
                                                        4min 0s
                                                    </option>
                                                    <option value="255"
                                                        {{ $vie->rut_tiempo == 255 ? 'selected' : '' }}>
                                                        4min 15s
                                                    </option>
                                                    <option value="270"
                                                        {{ $vie->rut_tiempo == 270 ? 'selected' : '' }}>
                                                        4min 30s
                                                    </option>
                                                    <option value="285"
                                                        {{ $vie->rut_tiempo == 285 ? 'selected' : '' }}>
                                                        4min 45s
                                                    </option>
                                                    <option value="300"
                                                        {{ $vie->rut_tiempo == 300 ? 'selected' : '' }}>
                                                        5min 0s
                                                    </option>
                                                </select>
                                            </div>
                                            @php
                                                $latest = 0;
                                                foreach ($dias[$vie->rut_dia] as $value) {
                                                    if ($value->ejer_id == $vie->ejer_id) {
                                                        $latest++;
                                                    }
                                                }
                                                $count = 0;
                                            @endphp
                                            @foreach ($dias[$vie->rut_dia] as $rut)
                                                @if ($ruti == $rut->ejer_id)
                                                    <div class="item-content">
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <span>SERIE</span>
                                                                <input min="1" class="form-control" type="text"
                                                                    value="{{ $rut->rut_serie }}"
                                                                    id="rseries_{{ $rut->rd_id }}">
                                                            </div>
                                                            <div class="col-3">
                                                                <span>KG</span>
                                                                <input min="0" class="form-control" type="number"
                                                                    value="{{ $rut->rut_peso }}"
                                                                    id="rpeso_{{ $rut->rd_id }}">
                                                            </div>
                                                            <div class="col-3">
                                                                <span>RIR</span>
                                                                <input min="0" class="form-control" type="number"
                                                                    value="{{ $rut->rut_rid }}"
                                                                    id="rrir_{{ $rut->rd_id }}">
                                                            </div>
                                                            <div class="col-3">
                                                                <span>REPS</span>
                                                                <input min="1" class="form-control" type="number"
                                                                    value="{{ $rut->rut_repeticiones }}"
                                                                    id="rrepeticiones_{{ $rut->rd_id }}">
                                                            </div>
                                                        </div>
                                                        <div class="campo">
                                                            @if ($usr->roles[0]->name == 'superadmin' || $usr->roles[0]->name == 'Modo GYM')
                                                                <button class="boton boton-guardar btn btn-primary"
                                                                    onclick="guardarRutina({{ $rut->rd_id }})">Guardar</button>
                                                                @if ($latest - 1 == $count)
                                                                    <button class="boton boton-eliminar btn btn-danger"
                                                                        onclick="eliminarRutina({{ $rut->rd_id }})">
                                                                        <i class='bx bx-trash'></i>
                                                                    </button>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    @php
                                                        $ruts = $rut->rut_serie;
                                                        $count++;
                                                    @endphp
                                                @endif
                                            @endforeach
                                            <button class="btn btn-sm btn-light"
                                                onclick="addSerie({{ $vie->def_id }}, {{ $vie->ejer_id }}, {{ $vie->rut_dia }}, {{ $ruts }})">Agregar
                                                serie</button>
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
                                            $ruti = $sab->ejer_id;
                                            $ruts = $sab->rut_serie;

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
                                            <h6 class="titulo-item">
                                                {{ $sab->ejercicio->ejer_nombre }}
                                            </h6>
                                            <div class="row me-1">
                                                <label for="rut_tiempo_{{ $sab->rd_id }}" class="col-8">Temporizador
                                                    de
                                                    descanso: </label>
                                                <select name="tiempo" id="rut_tiempo_{{ $sab->rd_id }}"
                                                    class="col-4"
                                                    onchange="guardarTiempo({{ $sab->rd_id }},{{ $sab->def_id }}, {{ $sab->ejer_id }}, {{ $sab->rut_dia }})">
                                                    <option value="0" {{ $sab->rut_tiempo == 0 ? 'selected' : '' }}>
                                                        [Apagado]
                                                    </option>
                                                    <option value="5" {{ $sab->rut_tiempo == 5 ? 'selected' : '' }}>
                                                        5s
                                                    </option>
                                                    <option value="10"
                                                        {{ $sab->rut_tiempo == 10 ? 'selected' : '' }}>
                                                        10s
                                                    </option>
                                                    <option value="15"
                                                        {{ $sab->rut_tiempo == 15 ? 'selected' : '' }}>
                                                        15s
                                                    </option>
                                                    <option value="20"
                                                        {{ $sab->rut_tiempo == 20 ? 'selected' : '' }}>
                                                        20s
                                                    </option>
                                                    <option value="25"
                                                        {{ $sab->rut_tiempo == 25 ? 'selected' : '' }}>
                                                        25s
                                                    </option>
                                                    <option value="30"
                                                        {{ $sab->rut_tiempo == 30 ? 'selected' : '' }}>
                                                        30s
                                                    </option>
                                                    <option value="35"
                                                        {{ $sab->rut_tiempo == 35 ? 'selected' : '' }}>
                                                        35s
                                                    </option>
                                                    <option value="40"
                                                        {{ $sab->rut_tiempo == 40 ? 'selected' : '' }}>
                                                        40s
                                                    </option>
                                                    <option value="45"
                                                        {{ $sab->rut_tiempo == 45 ? 'selected' : '' }}>
                                                        45s
                                                    </option>
                                                    <option value="50"
                                                        {{ $sab->rut_tiempo == 50 ? 'selected' : '' }}>
                                                        50s
                                                    </option>
                                                    <option value="55"
                                                        {{ $sab->rut_tiempo == 55 ? 'selected' : '' }}>
                                                        55s
                                                    </option>
                                                    <option value="60"
                                                        {{ $sab->rut_tiempo == 60 ? 'selected' : '' }}>
                                                        1min 0s
                                                    </option>
                                                    <option value="65"
                                                        {{ $sab->rut_tiempo == 65 ? 'selected' : '' }}>
                                                        1min 5s
                                                    </option>
                                                    <option value="70"
                                                        {{ $sab->rut_tiempo == 70 ? 'selected' : '' }}>
                                                        1min 10s
                                                    </option>
                                                    <option value="75"
                                                        {{ $sab->rut_tiempo == 75 ? 'selected' : '' }}>
                                                        1min 15s
                                                    </option>
                                                    <option value="80"
                                                        {{ $sab->rut_tiempo == 80 ? 'selected' : '' }}>
                                                        1min 20s
                                                    </option>
                                                    <option value="85"
                                                        {{ $sab->rut_tiempo == 85 ? 'selected' : '' }}>
                                                        1min 25s
                                                    </option>
                                                    <option value="90"
                                                        {{ $sab->rut_tiempo == 90 ? 'selected' : '' }}>
                                                        1min 30s
                                                    </option>
                                                    <option value="95"
                                                        {{ $sab->rut_tiempo == 95 ? 'selected' : '' }}>
                                                        1min 35s
                                                    </option>
                                                    <option value="100"
                                                        {{ $sab->rut_tiempo == 100 ? 'selected' : '' }}>
                                                        1min 40s
                                                    </option>
                                                    <option value="105"
                                                        {{ $sab->rut_tiempo == 105 ? 'selected' : '' }}>
                                                        1min 45s
                                                    </option>
                                                    <option value="110"
                                                        {{ $sab->rut_tiempo == 110 ? 'selected' : '' }}>
                                                        1min 50s
                                                    </option>
                                                    <option value="115"
                                                        {{ $sab->rut_tiempo == 115 ? 'selected' : '' }}>
                                                        1min 55s
                                                    </option>
                                                    <option value="120"
                                                        {{ $sab->rut_tiempo == 120 ? 'selected' : '' }}>
                                                        2min 0s
                                                    </option>
                                                    <option value="135"
                                                        {{ $sab->rut_tiempo == 135 ? 'selected' : '' }}>
                                                        2min 15s
                                                    </option>
                                                    <option value="150"
                                                        {{ $sab->rut_tiempo == 150 ? 'selected' : '' }}>
                                                        2min 30s
                                                    </option>
                                                    <option value="165"
                                                        {{ $sab->rut_tiempo == 165 ? 'selected' : '' }}>
                                                        2min 45s
                                                    </option>
                                                    <option value="180"
                                                        {{ $sab->rut_tiempo == 180 ? 'selected' : '' }}>
                                                        3min 0s
                                                    </option>
                                                    <option value="195"
                                                        {{ $sab->rut_tiempo == 195 ? 'selected' : '' }}>
                                                        3min 15s
                                                    </option>
                                                    <option value="210"
                                                        {{ $sab->rut_tiempo == 210 ? 'selected' : '' }}>
                                                        3min 30s
                                                    </option>
                                                    <option value="225"
                                                        {{ $sab->rut_tiempo == 225 ? 'selected' : '' }}>
                                                        3min 45s
                                                    </option>
                                                    <option value="240"
                                                        {{ $sab->rut_tiempo == 240 ? 'selected' : '' }}>
                                                        4min 0s
                                                    </option>
                                                    <option value="255"
                                                        {{ $sab->rut_tiempo == 255 ? 'selected' : '' }}>
                                                        4min 15s
                                                    </option>
                                                    <option value="270"
                                                        {{ $sab->rut_tiempo == 270 ? 'selected' : '' }}>
                                                        4min 30s
                                                    </option>
                                                    <option value="285"
                                                        {{ $sab->rut_tiempo == 285 ? 'selected' : '' }}>
                                                        4min 45s
                                                    </option>
                                                    <option value="300"
                                                        {{ $sab->rut_tiempo == 300 ? 'selected' : '' }}>
                                                        5min 0s
                                                    </option>
                                                </select>
                                            </div>
                                            @php
                                                $latest = 0;
                                                foreach ($dias[$sab->rut_dia] as $value) {
                                                    if ($value->ejer_id == $sab->ejer_id) {
                                                        $latest++;
                                                    }
                                                }
                                                $count = 0;
                                            @endphp
                                            @foreach ($dias[$sab->rut_dia] as $rut)
                                                @if ($ruti == $rut->ejer_id)
                                                    <div class="item-content">
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <span>SERIE</span>
                                                                <input min="1" class="form-control" type="text"
                                                                    value="{{ $rut->rut_serie }}"
                                                                    id="rseries_{{ $rut->rd_id }}">
                                                            </div>
                                                            <div class="col-3">
                                                                <span>KG</span>
                                                                <input min="0" class="form-control" type="number"
                                                                    value="{{ $rut->rut_peso }}"
                                                                    id="rpeso_{{ $rut->rd_id }}">
                                                            </div>
                                                            <div class="col-3">
                                                                <span>RIR</span>
                                                                <input min="0" class="form-control" type="number"
                                                                    value="{{ $rut->rut_rid }}"
                                                                    id="rrir_{{ $rut->rd_id }}">
                                                            </div>
                                                            <div class="col-3">
                                                                <span>REPS</span>
                                                                <input min="1" class="form-control" type="number"
                                                                    value="{{ $rut->rut_repeticiones }}"
                                                                    id="rrepeticiones_{{ $rut->rd_id }}">
                                                            </div>
                                                        </div>
                                                        <div class="campo">
                                                            @if ($usr->roles[0]->name == 'superadmin' || $usr->roles[0]->name == 'Modo GYM')
                                                                <button class="boton boton-guardar btn btn-primary"
                                                                    onclick="guardarRutina({{ $rut->rd_id }})">Guardar</button>
                                                                @if ($latest - 1 == $count)
                                                                    <button class="boton boton-eliminar btn btn-danger"
                                                                        onclick="eliminarRutina({{ $rut->rd_id }})">
                                                                        <i class='bx bx-trash'></i>
                                                                    </button>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    @php
                                                        $ruts = $rut->rut_serie;
                                                        $count++;
                                                    @endphp
                                                @endif
                                            @endforeach
                                            <button class="btn btn-sm btn-light"
                                                onclick="addSerie({{ $sab->def_id }}, {{ $sab->ejer_id }}, {{ $sab->rut_dia }}, {{ $ruts }})">Agregar
                                                serie</button>
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
                                            $ruti = $dom->ejer_id;
                                            $ruts = $dom->rut_serie;

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
                                            <h6 class="titulo-item">
                                                {{ $dom->ejercicio->ejer_nombre }}
                                            </h6>
                                            <div class="row me-1">
                                                <label for="rut_tiempo_{{ $dom->rd_id }}" class="col-8">Temporizador
                                                    de
                                                    descanso: </label>
                                                <select name="tiempo" id="rut_tiempo_{{ $dom->rd_id }}"
                                                    class="col-4"
                                                    onchange="guardarTiempo({{ $dom->rd_id }},{{ $dom->def_id }}, {{ $dom->ejer_id }}, {{ $dom->rut_dia }})">
                                                    <option value="0" {{ $dom->rut_tiempo == 0 ? 'selected' : '' }}>
                                                        [Apagado]
                                                    </option>
                                                    <option value="5" {{ $dom->rut_tiempo == 5 ? 'selected' : '' }}>
                                                        5s
                                                    </option>
                                                    <option value="10"
                                                        {{ $dom->rut_tiempo == 10 ? 'selected' : '' }}>
                                                        10s
                                                    </option>
                                                    <option value="15"
                                                        {{ $dom->rut_tiempo == 15 ? 'selected' : '' }}>
                                                        15s
                                                    </option>
                                                    <option value="20"
                                                        {{ $dom->rut_tiempo == 20 ? 'selected' : '' }}>
                                                        20s
                                                    </option>
                                                    <option value="25"
                                                        {{ $dom->rut_tiempo == 25 ? 'selected' : '' }}>
                                                        25s
                                                    </option>
                                                    <option value="30"
                                                        {{ $dom->rut_tiempo == 30 ? 'selected' : '' }}>
                                                        30s
                                                    </option>
                                                    <option value="35"
                                                        {{ $dom->rut_tiempo == 35 ? 'selected' : '' }}>
                                                        35s
                                                    </option>
                                                    <option value="40"
                                                        {{ $dom->rut_tiempo == 40 ? 'selected' : '' }}>
                                                        40s
                                                    </option>
                                                    <option value="45"
                                                        {{ $dom->rut_tiempo == 45 ? 'selected' : '' }}>
                                                        45s
                                                    </option>
                                                    <option value="50"
                                                        {{ $dom->rut_tiempo == 50 ? 'selected' : '' }}>
                                                        50s
                                                    </option>
                                                    <option value="55"
                                                        {{ $dom->rut_tiempo == 55 ? 'selected' : '' }}>
                                                        55s
                                                    </option>
                                                    <option value="60"
                                                        {{ $dom->rut_tiempo == 60 ? 'selected' : '' }}>
                                                        1min 0s
                                                    </option>
                                                    <option value="65"
                                                        {{ $dom->rut_tiempo == 65 ? 'selected' : '' }}>
                                                        1min 5s
                                                    </option>
                                                    <option value="70"
                                                        {{ $dom->rut_tiempo == 70 ? 'selected' : '' }}>
                                                        1min 10s
                                                    </option>
                                                    <option value="75"
                                                        {{ $dom->rut_tiempo == 75 ? 'selected' : '' }}>
                                                        1min 15s
                                                    </option>
                                                    <option value="80"
                                                        {{ $dom->rut_tiempo == 80 ? 'selected' : '' }}>
                                                        1min 20s
                                                    </option>
                                                    <option value="85"
                                                        {{ $dom->rut_tiempo == 85 ? 'selected' : '' }}>
                                                        1min 25s
                                                    </option>
                                                    <option value="90"
                                                        {{ $dom->rut_tiempo == 90 ? 'selected' : '' }}>
                                                        1min 30s
                                                    </option>
                                                    <option value="95"
                                                        {{ $dom->rut_tiempo == 95 ? 'selected' : '' }}>
                                                        1min 35s
                                                    </option>
                                                    <option value="100"
                                                        {{ $dom->rut_tiempo == 100 ? 'selected' : '' }}>
                                                        1min 40s
                                                    </option>
                                                    <option value="105"
                                                        {{ $dom->rut_tiempo == 105 ? 'selected' : '' }}>
                                                        1min 45s
                                                    </option>
                                                    <option value="110"
                                                        {{ $dom->rut_tiempo == 110 ? 'selected' : '' }}>
                                                        1min 50s
                                                    </option>
                                                    <option value="115"
                                                        {{ $dom->rut_tiempo == 115 ? 'selected' : '' }}>
                                                        1min 55s
                                                    </option>
                                                    <option value="120"
                                                        {{ $dom->rut_tiempo == 120 ? 'selected' : '' }}>
                                                        2min 0s
                                                    </option>
                                                    <option value="135"
                                                        {{ $dom->rut_tiempo == 135 ? 'selected' : '' }}>
                                                        2min 15s
                                                    </option>
                                                    <option value="150"
                                                        {{ $dom->rut_tiempo == 150 ? 'selected' : '' }}>
                                                        2min 30s
                                                    </option>
                                                    <option value="165"
                                                        {{ $dom->rut_tiempo == 165 ? 'selected' : '' }}>
                                                        2min 45s
                                                    </option>
                                                    <option value="180"
                                                        {{ $dom->rut_tiempo == 180 ? 'selected' : '' }}>
                                                        3min 0s
                                                    </option>
                                                    <option value="195"
                                                        {{ $dom->rut_tiempo == 195 ? 'selected' : '' }}>
                                                        3min 15s
                                                    </option>
                                                    <option value="210"
                                                        {{ $dom->rut_tiempo == 210 ? 'selected' : '' }}>
                                                        3min 30s
                                                    </option>
                                                    <option value="225"
                                                        {{ $dom->rut_tiempo == 225 ? 'selected' : '' }}>
                                                        3min 45s
                                                    </option>
                                                    <option value="240"
                                                        {{ $dom->rut_tiempo == 240 ? 'selected' : '' }}>
                                                        4min 0s
                                                    </option>
                                                    <option value="255"
                                                        {{ $dom->rut_tiempo == 255 ? 'selected' : '' }}>
                                                        4min 15s
                                                    </option>
                                                    <option value="270"
                                                        {{ $dom->rut_tiempo == 270 ? 'selected' : '' }}>
                                                        4min 30s
                                                    </option>
                                                    <option value="285"
                                                        {{ $dom->rut_tiempo == 285 ? 'selected' : '' }}>
                                                        4min 45s
                                                    </option>
                                                    <option value="300"
                                                        {{ $dom->rut_tiempo == 300 ? 'selected' : '' }}>
                                                        5min 0s
                                                    </option>
                                                </select>
                                            </div>
                                            @php
                                                $latest = 0;
                                                foreach ($dias[$dom->rut_dia] as $value) {
                                                    if ($value->ejer_id == $dom->ejer_id) {
                                                        $latest++;
                                                    }
                                                }
                                                $count = 0;
                                            @endphp
                                            @foreach ($dias[$dom->rut_dia] as $rut)
                                                @if ($ruti == $rut->ejer_id)
                                                    <div class="item-content">
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <span>SERIE</span>
                                                                <input min="1" class="form-control" type="text"
                                                                    value="{{ $rut->rut_serie }}"
                                                                    id="rseries_{{ $rut->rd_id }}">
                                                            </div>
                                                            <div class="col-3">
                                                                <span>KG</span>
                                                                <input min="0" class="form-control" type="number"
                                                                    value="{{ $rut->rut_peso }}"
                                                                    id="rpeso_{{ $rut->rd_id }}">
                                                            </div>
                                                            <div class="col-3">
                                                                <span>RIR</span>
                                                                <input min="0" class="form-control" type="number"
                                                                    value="{{ $rut->rut_rid }}"
                                                                    id="rrir_{{ $rut->rd_id }}">
                                                            </div>
                                                            <div class="col-3">
                                                                <span>REPS</span>
                                                                <input min="1" class="form-control" type="number"
                                                                    value="{{ $rut->rut_repeticiones }}"
                                                                    id="rrepeticiones_{{ $rut->rd_id }}">
                                                            </div>
                                                        </div>
                                                        <div class="campo">
                                                            @if ($usr->roles[0]->name == 'superadmin' || $usr->roles[0]->name == 'Modo GYM')
                                                                <button class="boton boton-guardar btn btn-primary"
                                                                    onclick="guardarRutina({{ $rut->rd_id }})">Guardar</button>
                                                                @if ($latest - 1 == $count)
                                                                    <button class="boton boton-eliminar btn btn-danger"
                                                                        onclick="eliminarRutina({{ $rut->rd_id }})">
                                                                        <i class='bx bx-trash'></i>
                                                                    </button>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    @php
                                                        $ruts = $rut->rut_serie;
                                                        $count++;
                                                    @endphp
                                                @endif
                                            @endforeach
                                            <button class="btn btn-sm btn-light"
                                                onclick="addSerie({{ $dom->def_id }}, {{ $dom->ejer_id }}, {{ $dom->rut_dia }}, {{ $ruts }})">Agregar
                                                serie</button>
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
                                            @switch($ejer->ejer_nivel)
                                                @case(1)
                                                @case(2)
                                                    <span class="align-end badge bg-primary">Nivel
                                                        {{ $ejer->ejer_nivel }}</span>
                                                @break

                                                @case(3)
                                                    <span class="align-end badge bg-warning">Nivel
                                                        {{ $ejer->ejer_nivel }}</span>
                                                @break

                                                @case(4)
                                                @case(5)
                                                    <span class="align-end badge bg-danger">Nivel
                                                        {{ $ejer->ejer_nivel }}</span>
                                                @break

                                                @default
                                                    <span class="align-end badge bg-dark">Nivel
                                                        {{ $ejer->ejer_nivel }}</span>
                                            @endswitch
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
            const serie = $('#rseries_' + id).val();
            const peso = $('#rpeso_' + id).val();
            const rir = $('#rrir_' + id).val();
            const repeticiones = $('#rrepeticiones_' + id).val();

            const rut_tiempo = $('#rut_tiempo_' + id).val()

            $.ajax({
                type: "POST",
                url: "{{ route('admin.rutinas-def.guardar') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    serie: serie,
                    peso: peso,
                    rir: rir,
                    repeticiones: repeticiones,
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

        function guardarTiempo(id, def_id, ejer_id, dia) {
            const rut_tiempo = $('#rut_tiempo_' + id).val()

            $.ajax({
                type: "POST",
                url: "{{ route('admin.rutinas-def.guardar') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    def_id: def_id,
                    ejer_id: ejer_id,
                    dia: dia,
                    tiempo: rut_tiempo,
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

        function addSerie(id, ejer_id, dia, serie) {
            $.ajax({
                type: "POST",
                url: "{{ route('admin.rutinas-def.guardar') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    def_id: id,
                    ejer_id: ejer_id,
                    dia: dia,
                    serie: serie
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
                url: "{{ route('admin.rutinas-def.eliminar') }}",
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
                selectEjercicios.push(id)
            });
            console.log(selectEjercicios);
            resetEjerciciosRutina()

            $.ajax({
                type: "POST",
                url: "{{ route('admin.rutinas-def.store') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    dia: dia,
                    rutinas: selectEjercicios,
                    def_id: '{{ $defecto->def_id }}'
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
