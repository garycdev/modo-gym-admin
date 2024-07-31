@extends('backend.layouts.master')

@section('title')
    Equipos Page - Admin Panel

    @php
        $usr = Auth::guard('admin')->user();
    @endphp
@endsection

@section('styles')
@endsection


@section('admin-content')
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Tabla</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i
                                        class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Tabla Equipos</li>
                        </ol>
                    </nav>
                </div>

            </div>
            <!--end breadcrumb-->
            <h6 class="mb-0 text-uppercase">Tabla de Equipos </h6>
            <hr />
            <div class="card">
                <div class="card-body">
                    <p class="float-right mb-2">
                        @if (Auth::guard('admin')->user()->can('equipo.create'))
                            <a class="btn btn-primary px-5 radius-30" href="{{ route('admin.equipos.create') }}">Crear
                                Nuevo</a>
                        @endif
                    </p>
                    <br>
                    <div class="table-responsive">
                        @include('backend.layouts.partials.messages')
                        <table id="example2" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Imagen</th>
                                    <th>Tipo</th>
                                    <th>Estado</th>
                                    {{-- <th>Fecha Actualizado</th> --}}
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($equipos as $equipo)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $equipo->equi_nombre }}</td>
                                        <td>
                                            @if ($equipo->equi_imagen)
                                                <div class="d-flex flex-column align-items-center text-center">
                                                    <img src="{{ asset($equipo->equi_imagen) }}" class="product-img-2"
                                                        alt="product img" width="120">
                                                </div>
                                            @else
                                                <div class="d-flex flex-column align-items-center text-center">
                                                    <img src="{{ asset('modo-gym/blank.png') }}" class="product-img-2"
                                                        alt="product img" width="120">
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{ strtoupper($equipo->tipo) }}</td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $equipo->equi_estado == 'ACTIVO' ? 'success' : 'danger' }}">
                                                {{ $equipo->equi_estado }}
                                            </span>
                                        </td>
                                        {{-- <td>{{ $equipo->updated_at->format('d \d\e M \H\o\r\a\s: H:i A') }}</td> --}}
                                        <td>
                                            @if (Auth::guard('admin')->user()->can('equipo.edit'))
                                                <a class="btn btn-success text-white"
                                                    href="{{ route('admin.equipos.edit', $equipo->equi_id) }}">
                                                    <i class='bx bxs-edit'></i>
                                                </a>
                                            @endif

                                            @if (Auth::guard('admin')->user()->can('equipo.delete'))
                                                <a class="btn btn-danger text-white"
                                                    href="{{ route('admin.equipos.destroy', $equipo->equi_id) }}"
                                                    onclick="event.preventDefault(); document.getElementById('delete-form-{{ $equipo->equi_id }}').submit();">
                                                    <i class='bx bxs-trash'></i>
                                                </a>
                                                <form id="delete-form-{{ $equipo->equi_id }}"
                                                    action="{{ route('admin.equipos.destroy', $equipo->equi_id) }}"
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
                                    <th>Nombre</th>
                                    <th>Imagen</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        $(document).ready(function() {
            var table = $("#example2").DataTable({
                lengthChange: false,
                buttons: ["copy", "excel", "pdf", "print"],
            });

            table
                .buttons()
                .container()
                .appendTo("#example2_wrapper .col-md-6:eq(0)");
        });
    </script>
@endsection
