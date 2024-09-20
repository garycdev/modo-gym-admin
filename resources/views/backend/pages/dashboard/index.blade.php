@extends('backend.layouts.master')

@section('title')
    Dashboard Page - Admin Panel
@endsection

@section('styles')
    <style>
        input[type="radio"] {
            transform: scale(1.5);
            margin-left: 25px;
            margin-right: 10px;
        }

        input[type="checkbox"] {
            transform: scale(1.5);
            margin-left: 25px;
            margin-right: 10px;
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
        // Colores de badges
        $colors = [
            'deepblue',
            'orange',
            'ohhappiness',
            'ibiza',
            'scooter',
            'bloody',
            'quepal',
            'blooker',
            'cosmic',
            'burning',
            'lush',
            'kyoto',
            'blues',
            'moonlit',
        ];
        // Para grafico de tora respecto a los planes o costos
        $colors2 = ['deepblue', 'quepal', 'burning', 'orange'];
        $i = 0;
    @endphp
    @if ($guard == 'user')
        <!-- Modal -->
        <div class="modal modal-lg fade" id="miModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">BIENVENIDOS A MODO GYM!</h5>
                        {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                    </div>
                    <div class="modal-body">
                        <form id="form-inscripcion" method="POST" class="row"
                            action="{{ route('admin.formulario.store') }}">
                            @csrf()
                            <input type="hidden" name="usu_id" value="{{ Auth::guard('user')->user()->usu_id }}">
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
                                    <input type="number" class="form-control" id="edad" name="edad" min="10">
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
                                                value="Ganancia de masa muscular"
                                                class="objetivo-checkbox form-check-input">
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
                                                value="recuperarme de una lesion"
                                                class="objetivo-checkbox form-check-input">
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
                    <div class="modal-footer d-flex justify-content-between">
                        <a href="javascript:void(0)" class="link" data-bs-dismiss="modal">Llenar en otro momento</a>
                        <button type="submit" form="form-inscripcion" class="btn btn-success">Enviar</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="page-wrapper">
        @if ($guard == 'admin')
            <div class="page-content">
                @include('backend.layouts.partials.messages')
                <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
                    <div class="col" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-title="Desde el 10 del mes anterior">
                        <div class="card radius-10 border-start border-4 border-info">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-secondary">Total de clientes</p>
                                        <h4 class="my-1 text-info">{{ $total['total_users'] }}</h4>
                                        <p class="mb-0 font-13">
                                            <b>{{ $total['porcentaje_users'] }}%</b> del total de este mes
                                        </p>
                                    </div>
                                    <div class="widgets-icons-2 rounded-circle bg-gradient-blues text-white ms-auto">
                                        <i class="bx bxs-group"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-title="Desde el 10 del mes anterior">
                        <div class="card radius-10 border-start border-4 border-warning">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-secondary">Clientes por mes</p>
                                        <h4 class="my-1 text-warning">{{ $total['users'] }}</h4>
                                        <p class="mb-0 font-13">
                                            <b>{{ $total['users_total'] }}%</b> respecto al mes anterior
                                        </p>
                                    </div>
                                    <div class="widgets-icons-2 rounded-circle bg-gradient-orange text-white ms-auto">
                                        <i class="bx bxs-group"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-title="Desde el dia de ayer">
                        <div class="card radius-10 border-start border-4 border-success">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-secondary">Asistencias por dia</p>
                                        <h4 class="my-1 text-success">{{ $total['asistencias'] }}</h4>
                                        <p class="mb-0 font-13">
                                            <b>{{ $total['porcentaje_asistencias'] }}%</b> respecto a ayer
                                        </p>
                                    </div>
                                    <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto">
                                        <i class="bx bxs-bar-chart-alt-2"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-title="Desde el 10 del mes anterior">
                        <div class="card radius-10 border-start border-4 border-danger">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    @php
                                        // Porcentaje de ganancias (mes actual y mes anterior)
                                        $totalGanancia = 0;
                                        foreach ($costos as $costo) {
                                            foreach ($costo->pagosMesActual as $pago) {
                                                $totalGanancia += $pago->pago_monto;
                                            }
                                        }

                                        $totalGananciaAnterior = 0;
                                        foreach ($costos as $costo) {
                                            foreach ($costo->pagosMesAnterior as $pago) {
                                                $totalGananciaAnterior += $pago->pago_monto;
                                            }
                                        }

                                        $porcentajeCambio = 0;
                                        if ($totalGananciaAnterior > 0) {
                                            $porcentajeCambio =
                                                (($totalGanancia - $totalGananciaAnterior) / $totalGananciaAnterior) *
                                                100;
                                        }

                                        $porcentajeGanacia = number_format($porcentajeCambio, 2);
                                        $signo = $porcentajeCambio >= 0 ? '+' : '';
                                        $porcentajeGanacia = $signo . $porcentajeGanacia . '%';
                                    @endphp

                                    <div>
                                        <p class="mb-0 text-secondary">Ganancia mensual</p>
                                        <h4 class="my-1 text-danger">Bs {{ $totalGanancia }}</h4>
                                        <p class="mb-0 font-13">
                                            <b>{{ $porcentajeGanacia }}</b> respecto al mes anterior
                                        </p>
                                    </div>
                                    <div class="widgets-icons-2 rounded-circle bg-gradient-burning text-white ms-auto">
                                        <i class="bx bxs-wallet"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end row-->
                <div class="row">
                    <div class="col-12 col-lg-8 d flex mb-4">
                        <div class="card radius-10">
                            <div class="card-header" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-title="Desde el 10 del mes anterior">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <h6 class="mt-3">Historial mensual</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Plan</th>
                                                <th>Tipo</th>
                                                <th>Periodo</th>
                                                <th>Ganancia</th>
                                                <th>% Porcentaje</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                // Obtener la gananacia total
                                                $totalGanancia = 0;
                                                foreach ($costos as $costo) {
                                                    $ganancia = 0;
                                                    foreach ($costo->pagosMesActual as $pago) {
                                                        $ganancia += $pago->pago_monto;
                                                    }
                                                    $totalGanancia += $ganancia;
                                                }
                                            @endphp
                                            @foreach ($costos as $costo)
                                                @php
                                                    $ganancia = 0;
                                                    foreach ($costo->pagosMesActual as $pago) {
                                                        // if ($pago->pago_estado == 'COMPLETADO') {
                                                        $ganancia += $pago->pago_monto;
                                                        // }
                                                    }
                                                @endphp
                                                @if ($ganancia > 0)
                                                    <tr>
                                                        <td>
                                                            <img src="{{ asset('image/cliente/default.png') }}"
                                                                class="product-img-2" alt="product img" />
                                                        </td>
                                                        <td>{{ $costo->nombre }}</td>
                                                        <td>
                                                            @switch($costo->tipo)
                                                                @case('TODO')
                                                                    TODO INCLUIDO
                                                                @break

                                                                @case('MAQUINAS')
                                                                    SOLO MAQUINAS
                                                                @break

                                                                @default
                                                            @endswitch
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="badge bg-gradient-{{ $colors2[$i] }} text-white shadow-sm w-100">
                                                                {{ $costo->periodo }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            Bs {{ $ganancia }}
                                                        </td>
                                                        <td>
                                                            @php
                                                                // Validar que no se divida por 0
                                                                if ($totalGanancia == 0) {
                                                                    $porcentaje = 0;
                                                                } else {
                                                                    $porcentaje = ($ganancia * 100) / $totalGanancia;
                                                                }
                                                            @endphp
                                                            <p class="m-0 p-0 text-center" style="font-size:0.85em;">
                                                                {{ number_format($porcentaje, 2) }}%</p>
                                                            <div class="progress" style="height: 6px">
                                                                <div class="progress-bar bg-gradient-{{ $colors2[$i] }}"
                                                                    role="progressbar"
                                                                    style="width: {{ $porcentaje }}%">
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @php
                                                        if ($i == count($colors2) - 1) {
                                                            $i = 0;
                                                        } else {
                                                            $i++;
                                                        }
                                                    @endphp
                                                @endif
                                            @endforeach
                                            <tr>
                                                <td colspan="4" align="right" class="fw-bold">Total: </td>
                                                <td class="fw-bold">Bs {{ $totalGanancia }}</td>
                                                <td>
                                                    @php
                                                        // Validar que no se divida por cero
                                                        if ($totalGanancia == 0) {
                                                            $porcentajeT = 0;
                                                        } else {
                                                            $porcentajeT = ($totalGanancia * 100) / $totalGanancia;
                                                        }
                                                    @endphp
                                                    <p class="m-0 p-0 text-center fw-bold" style="font-size:0.85em;">
                                                        {{ number_format($porcentajeT, 2) }}%</p>
                                                    <div class="progress" style="height: 6px">
                                                        <div class="progress-bar bg-gradient-{{ $colors2[$i] }}"
                                                            role="progressbar" style="width: {{ $porcentajeT }}%"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-4 d-flex mb-4">
                        <div class="card radius-10 w-100">
                            <div class="card-header" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-title="Desde el 10 del mes anterior">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <h6 class="mt-3">Planes por mes</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart-container-2">
                                    <canvas id="chart2"></canvas>
                                </div>
                            </div>
                            <ul class="list-group list-group-flush">
                                @php
                                    $j = 0;
                                    $totalPlanes = 0;
                                @endphp
                                @foreach ($costos as $costo)
                                    @if (count($costo->pagosMesActual) > 0)
                                        @php
                                            $totalPlanes += count($costo->pagosMesActual);
                                        @endphp
                                        <li
                                            class="list-group-item d-flex bg-transparent justify-content-between align-items-center border-top">
                                            {{ $costo->nombre }} <span
                                                class="badge bg-gradient-{{ $colors2[$j] }} rounded-pill">{{ count($costo->pagosMesActual) }}</span>
                                        </li>
                                        @php
                                            if ($j == count($colors2) - 1) {
                                                $j = 0;
                                            } else {
                                                $j++;
                                            }
                                        @endphp
                                    @endif
                                @endforeach
                                <li
                                    class="list-group-item d-flex bg-transparent justify-content-between align-items-center border-top">
                                    <b>Total</b>
                                    <span class="badge bg-gradient-{{ $colors2[$j] }} rounded-pill fw-bold">
                                        {{ $totalPlanes }}
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- <div class="col-12 col-lg-12 d-flex">
                    <div class="card radius-10 w-100">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h6 class="mt-3">Sales Overview</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center ms-auto font-13 gap-2 mb-3">
                                <span class="border px-1 rounded cursor-pointer"><i class="bx bxs-circle me-1"
                                        style="color: #14abef"></i>Sales</span>
                                <span class="border px-1 rounded cursor-pointer"><i class="bx bxs-circle me-1"
                                        style="color: #ffc107"></i>Visits</span>
                            </div>
                            <div class="chart-container-1">
                                <canvas id="chart1"></canvas>
                            </div>
                        </div>
                        <div class="row row-cols-1 row-cols-md-3 row-cols-xl-3 g-0 row-group text-center border-top">
                            <div class="col">
                                <div class="p-3">
                                    <h5 class="mb-0">24.15M</h5>
                                    <small class="mb-0">Overall Visitor
                                        <span>
                                            <i class="bx bx-up-arrow-alt align-middle"></i>
                                            2.43%</span></small>
                                </div>
                            </div>
                            <div class="col">
                                <div class="p-3">
                                    <h5 class="mb-0">12:38</h5>
                                    <small class="mb-0">Visitor Duration
                                        <span>
                                            <i class="bx bx-up-arrow-alt align-middle"></i>
                                            12.65%</span></small>
                                </div>
                            </div>
                            <div class="col">
                                <div class="p-3">
                                    <h5 class="mb-0">639.82</h5>
                                    <small class="mb-0">Pages/Visit
                                        <span>
                                            <i class="bx bx-up-arrow-alt align-middle"></i>
                                            5.62%</span></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                </div>
                <!--end row-->
            </div>
        @endif

        @if ($guard == 'user')
            <div class="page-content">
                @include('backend.layouts.partials.messages')
                <div class="row row-cols-1 row-cols-md-3 row-cols-xl-3">
                    <div class="col" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-title="Total de dias asistidos">
                        <div class="card radius-10 border-start border-4 border-info">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-secondary">Total de asistencias</p>
                                        <h4 class="my-1 text-info">{{ $user['asistencias'] }}</h4>
                                        <p class="mb-0 font-13">
                                        </p>
                                    </div>
                                    <div class="widgets-icons-2 rounded-circle bg-gradient-blues text-white ms-auto">
                                        <i class="bx bxs-group"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-title="Rutinas creadas por el usuario">
                        <div class="card radius-10 border-start border-4 border-warning">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-secondary">Total rutinas</p>
                                        <h4 class="my-1 text-warning">{{ $user['rutinas'] }}</h4>
                                        <p class="mb-0 font-13">
                                        </p>
                                    </div>
                                    <div class="widgets-icons-2 rounded-circle bg-gradient-orange text-white ms-auto">
                                        <i class="bx bxs-group"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-title="Total de pagos efectuados">
                        <div class="card radius-10 border-start border-4 border-danger">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-secondary">Total pagos</p>
                                        <h4 class="my-1 text-danger">{{ $user['asistencias'] }}</h4>
                                        <p class="mb-0 font-13">
                                        </p>
                                    </div>
                                    <div class="widgets-icons-2 rounded-circle bg-gradient-burning text-white ms-auto">
                                        <i class="bx bxs-wallet"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end row-->
            </div>
        @endif
    </div>
    <!--end page wrapper -->
    @php
        // Filtrar costos que tengan pagos en el mes actual
        $costosConPagos = $costos->filter(function ($costo) {
            return $costo->pagosMesActual->count() > 0;
        });

        // Obtener nombres y datos solo de los costos con pagos
        $labels = $costosConPagos->pluck('nombre')->values(); // .values() reindexa el array
        $data = $costosConPagos
            ->map(function ($costo) {
                return $costo->pagosMesActual->count();
            })
            ->values(); // .values() reindexa el array
    @endphp
@endsection

@section('scripts')
    <script>
        var ctx = document.getElementById("chart2").getContext('2d');

        var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
        gradientStroke1.addColorStop(0, '#4776e6');
        gradientStroke1.addColorStop(1, '#8e54e9');

        var gradientStroke2 = ctx.createLinearGradient(0, 0, 0, 300);
        gradientStroke2.addColorStop(0, '#42e695');
        gradientStroke2.addColorStop(1, '#3bb2b8');

        var gradientStroke3 = ctx.createLinearGradient(0, 0, 0, 300);
        gradientStroke3.addColorStop(0, '#ee0979');
        gradientStroke3.addColorStop(1, '#ff6a00');

        var gradientStroke4 = ctx.createLinearGradient(0, 0, 0, 300);
        gradientStroke4.addColorStop(0, '#fc4a1a');
        gradientStroke4.addColorStop(1, '#f7b733');

        // Valores para el grafico de torta por planes o costos
        var labels = @json($labels);
        var data = @json($data);

        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    backgroundColor: [
                        gradientStroke1,
                        gradientStroke2,
                        gradientStroke3,
                        gradientStroke4
                    ],
                    hoverBackgroundColor: [
                        gradientStroke1,
                        gradientStroke2,
                        gradientStroke3,
                        gradientStroke4
                    ],
                    data: data,
                    borderWidth: [1, 1, 1, 1]
                }]
            },
            options: {
                maintainAspectRatio: false,
                cutout: 82,
                plugins: {
                    legend: {
                        display: false,
                    }
                }
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            @if (session('formulario') === 0)
                var miModal = new bootstrap.Modal($('#miModal').get(0), {
                    backdrop: 'static',
                    keyboard: false
                });
                miModal.show();
            @endif

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
