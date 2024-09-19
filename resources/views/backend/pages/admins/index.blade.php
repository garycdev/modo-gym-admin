
@extends('backend.layouts.master')

@section('title')
Admins - Admin Panel
@endsection


@section('admin-content')
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Administrador </div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Usuarios Admin</li>
                    </ol>
                </nav>
            </div>

        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body">
                <h4 class="header-title float-left">Usuarios Admin Lista</h4>
                <p class="float-right mb-2">
                    @if (Auth::guard('admin')->user()->can('admin.create'))
                        <a class="btn btn-primary px-5 radius-30" href="{{ route('admin.admins.create') }}">Crear Nuevo Admin</a>
                    @endif
                </p>
                <br>
                <div class="table-responsive">
                    @include('backend.layouts.partials.messages')
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">#</th>
                                <th width="25%">Nombre</th>
                                <th width="25%">Email</th>
                                <th width="30%">Roles</th>
                                <th width="15%">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($admins as $admin)
                            <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $admin->name }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td>
                                        @foreach ($admin->roles as $role)
                                            <div class="badge rounded-pill text-info bg-light-info p-2 text-uppercase px-3">
                                                {{ $role->name }}
                                            </div>
                                        @endforeach
                                    </td>
                                    <td>
                                        @if (Auth::guard('admin')->user()->can('admin.edit'))
                                            <a class="btn btn-success text-white" href="{{ route('admin.admins.edit', $admin->id) }}">
                                                <i class='bx bxs-edit'></i>
                                            </a>
                                        @endif

                                        @if (Auth::guard('admin')->user()->can('admin.delete'))
                                            <a class="btn btn-danger text-white" href="{{ route('admin.admins.destroy', $admin->id) }}"
                                            onclick="event.preventDefault(); document.getElementById('delete-form-{{ $admin->id }}').submit();">
                                                <i class='bx bxs-trash'></i>
                                            </a>
                                            <form id="delete-form-{{ $admin->id }}" action="{{ route('admin.admins.destroy', $admin->id) }}" method="POST" style="display: none;">
                                                @method('DELETE')
                                                @csrf
                                            </form>
                                        @endif
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
@endsection

