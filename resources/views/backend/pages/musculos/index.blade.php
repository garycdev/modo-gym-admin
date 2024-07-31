@extends('backend.layouts.master')

@section('title')
    Musculos Page - Admin Panel

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
                            <li class="breadcrumb-item active" aria-current="page">Tabla Musculos</li>
                        </ol>
                    </nav>
                </div>

            </div>
            <!--end breadcrumb-->
            <h6 class="mb-0 text-uppercase">Tabla de Musculos </h6>
            <hr />
            <div class="card">
                <div class="card-body">
                    <p class="float-right mb-2">
                        @if (Auth::guard('admin')->user()->can('musculo.create'))
                            <a class="btn btn-primary px-5 radius-30" href="{{ route('admin.musculos.create') }}">Crear
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
                                    <th>Descripcion</th>
                                    <th>Estado</th>
                                    {{-- <th>Fecha Actualizado</th> --}}
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($musculos as $musculo)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $musculo->mus_nombre }}</td>
                                        <td>
                                            @if ($musculo->mus_imagen)
                                                <div class="d-flex flex-column align-items-center text-center">
                                                    <img src="{{ asset($musculo->mus_imagen) }}" class="product-img-2"
                                                        alt="product img" width="120">
                                                </div>
                                            @else
                                                <div class="d-flex flex-column align-items-center text-center">
                                                    <img src="{{ asset('modo-gym/blank.png') }}" class="product-img-2"
                                                        alt="product img" width="120">
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{ $musculo->mus_descripcion }}</td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $musculo->mus_estado == 'ACTIVO' ? 'success' : 'danger' }}">
                                                {{ $musculo->mus_estado }}
                                            </span>
                                        </td>
                                        {{-- <td>{{$musculo->updated_at->format('d \d\e M \H\o\r\a\s: H:i A')}}</td> --}}
                                        <td>
                                            @if (Auth::guard('admin')->user()->can('musculo.edit'))
                                                <a class="btn btn-warning"
                                                    href="{{ route('admin.musculos.edit', $musculo->mus_id) }}">
                                                    <i class='bx bxs-edit'></i>
                                                </a>
                                            @endif

                                            @if (Auth::guard('admin')->user()->can('musculo.delete'))
                                                <a class="btn btn-danger"
                                                    href="{{ route('admin.musculos.destroy', $musculo->mus_id) }}"
                                                    onclick="event.preventDefault(); document.getElementById('delete-form-{{ $musculo->mus_id }}').submit();">
                                                    <i class='bx bxs-trash'></i>
                                                </a>
                                                <form id="delete-form-{{ $musculo->mus_id }}"
                                                    action="{{ route('admin.musculos.destroy', $musculo->mus_id) }}"
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
