@extends('backend.layouts.master')

@section('title')
    Dashboard Page - Admin Panel
@endsection


@section('admin-content')
    @php
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
        $i = 0;
    @endphp
    <div class="page-wrapper">
        <div class="page-content">
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
                <div class="col" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-title="Desde el 10 del mes anterior">
                    <div class="card radius-10 border-start border-0 border-4 border-info">
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
                    <div class="card radius-10 border-start border-0 border-4 border-warning">
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
                <div class="col" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Desde el dia de ayer">
                    <div class="card radius-10 border-start border-0 border-4 border-success">
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
                    <div class="card radius-10 border-start border-0 border-4 border-danger">
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
                                            (($totalGanancia - $totalGananciaAnterior) / $totalGananciaAnterior) * 100;
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
                <div class="col-12 col-lg-8 d flex">
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
                                            {{-- <th>#</th> --}}
                                            <th>Plan</th>
                                            <th>Tipo</th>
                                            <th>Periodo</th>
                                            <th>Ganancia</th>
                                            <th>% Porcentaje</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            // Obtener la ganancia maxima por costo
                                            $mayorGanacia = 0;
                                            // Obtener la gananacia total
                                            $totalGanancia = 0;
                                            foreach ($costos as $costo) {
                                                $ganancia = 0;
                                                foreach ($costo->pagosMesActual as $pago) {
                                                    $ganancia += $pago->pago_monto;
                                                }
                                                $totalGanancia += $ganancia;
                                                if ($ganancia > $mayorGanacia) {
                                                    $mayorGanacia = $ganancia;
                                                }
                                            }
                                        @endphp
                                        @foreach ($costos as $costo)
                                            <tr>
                                                {{-- <td>
                                                    <img src="{{ asset('image/cliente/default.png') }}"
                                                        class="product-img-2" alt="product img" />
                                                </td> --}}
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
                                                        class="badge bg-gradient-{{ $colors[$i] }} text-white shadow-sm w-100">
                                                        {{ $costo->periodo }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @php
                                                        $ganancia = 0;
                                                        foreach ($costo->pagosMesActual as $pago) {
                                                            // if ($pago->pago_estado == 'COMPLETADO') {
                                                            $ganancia += $pago->pago_monto;
                                                            // }
                                                        }
                                                    @endphp
                                                    Bs {{ $ganancia }}
                                                </td>
                                                <td>
                                                    @php
                                                        // Validar que no se divida por 0
                                                        if ($mayorGanacia == 0) {
                                                            $porcentaje = 0;
                                                            $porcentajeU = 0;
                                                        } else {
                                                            $porcentaje = ($ganancia * 100) / $mayorGanacia;
                                                            $porcentajeU = ($ganancia * 100) / $totalGanancia;
                                                        }
                                                    @endphp
                                                    <p class="m-0 p-0 text-center" style="font-size:0.85em;">
                                                        {{ number_format($porcentajeU, 2) }}%</p>
                                                    <div class="progress" style="height: 6px">
                                                        <div class="progress-bar bg-gradient-{{ $colors[$i] }}"
                                                            role="progressbar" style="width: {{ $porcentaje }}%"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @php
                                                if ($i == count($colors) - 1) {
                                                    $i = 0;
                                                } else {
                                                    $i++;
                                                }
                                            @endphp
                                        @endforeach
                                        <tr>
                                            <td colspan="3" align="right" class="fw-bold">Total: </td>
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
                                                    <div class="progress-bar bg-gradient-{{ $colors[$i] }}"
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

                <div class="col-12 col-lg-4 d-flex">
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
                                // Para grafico de tora respecto a los planes o costos
                                $colors2 = ['deepblue', 'quepal', 'burning', 'orange'];
                                $j = 0;
                            @endphp
                            @foreach ($costos as $costo)
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
                            @endforeach
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
    </div>
    <!--end page wrapper -->
    {{-- <div class="main-content-inner">
  <div class="row">
    <div class="col-lg-8">
        <div class="row">
            <div class="col-md-6 mt-5 mb-3">
                <div class="card">
                    <div class="seo-fact sbg1">
                        <a href="{{ route('admin.roles.index') }}">
                            <div class="p-4 d-flex justify-content-between align-items-center">
                                <div class="seofct-icon"><i class="fa fa-users"></i> Roles</div>
                                <h2>{{ $total_roles }}</h2>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-md-5 mb-3">
                <div class="card">
                    <div class="seo-fact sbg2">
                        <a href="{{ route('admin.admins.index') }}">
                            <div class="p-4 d-flex justify-content-between align-items-center">
                                <div class="seofct-icon"><i class="fa fa-user"></i> Admins</div>
                                <h2>{{ $total_admins }}</h2>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3 mb-lg-0">
                <div class="card">
                    <div class="seo-fact sbg3">
                        <div class="p-4 d-flex justify-content-between align-items-center">
                            <div class="seofct-icon">Permissions</div>
                            <h2>{{ $total_permissions }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</div> --}}
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
        var labels = @json($costos->pluck('nombre'));
        var data = @json(
            $costos->map(function ($costo) {
                return count($costo->pagosMesActual);
            }));

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
@endsection
