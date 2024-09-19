
@extends('backend.layouts.master')

@section('title')
Rutina Edit - Admin Panel
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
            <div class="breadcrumb-title pe-3">Editar Rutina</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Validations</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
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
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="row">
            <div class="col-xl-6 mx-auto">
                <div class="card">
                    <div class="card-header px-4 py-3">
                        <h5 class="mb-0">Bootstrap Validation</h5>
                    </div>
                    <div class="card-body p-4">
                        <form class="row g-3 needs-validation" novalidate>
                            <div class="col-md-6">
                                <label for="bsValidation1" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="bsValidation1" placeholder="First Name" value="Jhon" required>
                                <div class="valid-feedback">
                                    Looks good!
                                  </div>
                            </div>
                            <div class="col-md-6">
                                <label for="bsValidation2" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="bsValidation2" placeholder="Last Name" value="Deo" required>
                                <div class="valid-feedback">
                                    Looks good!
                                  </div>
                            </div>
                            <div class="col-md-12">
                                <label for="bsValidation3" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="bsValidation3" placeholder="Phone" required>
                                <div class="invalid-feedback">
                                    Please choose a username.
                                  </div>
                            </div>
                            <div class="col-md-12">
                                <label for="bsValidation4" class="form-label">Email</label>
                                <input type="email" class="form-control" id="bsValidation4" placeholder="Email" required>
                                <div class="invalid-feedback">
                                    Please provide a valid email.
                                  </div>
                            </div>
                            <div class="col-md-12">
                                <label for="bsValidation5" class="form-label">Password</label>
                                <input type="password" class="form-control" id="bsValidation5" placeholder="Password" required>
                                <div class="invalid-feedback">
                                    Please choose a password.
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="bsValidation6" name="radio-stacked" required>
                                        <label class="form-check-label" for="bsValidation6">Male</label>
                                      </div>
                                      <div class="form-check">
                                        <input type="radio" class="form-check-input" id="bsValidation7" name="radio-stacked" required>
                                        <label class="form-check-label" for="bsValidation7">Female</label>
                                      </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="bsValidation8" class="form-label">DOB</label>
                                <input type="date" class="form-control" id="bsValidation8" placeholder="Date of Birth" required>
                                <div class="invalid-feedback">
                                    Please select date.
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="bsValidation9" class="form-label">Country</label>
                                <select id="bsValidation9" class="form-select" required>
                                    <option selected disabled value>...</option>
                                    <option>One</option>
                                    <option>Two</option>
                                    <option>Three</option>
                                </select>
                                <div class="invalid-feedback">
                                   Please select a valid country.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="bsValidation10" class="form-label">City</label>
                                <input type="text" class="form-control" id="bsValidation10" placeholder="City" required>
                                <div class="invalid-feedback">
                                    Please provide a valid city.
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="bsValidation11" class="form-label">State</label>
                                <select id="bsValidation11" class="form-select" required>
                                    <option selected disabled value>Choose...</option>
                                    <option>One</option>
                                    <option>Two</option>
                                    <option>Three</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please select a valid State.
                                 </div>
                            </div>
                            <div class="col-md-2">
                                <label for="bsValidation12" class="form-label">Zip</label>
                                <input type="text" class="form-control" id="bsValidation12" placeholder="Zip" required>
                                <div class="invalid-feedback">
                                    Please enter a valid Zip code.
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="bsValidation13" class="form-label">Address</label>
                                <textarea class="form-control" id="bsValidation13" placeholder="Address ..." rows="3" required></textarea>
                                <div class="invalid-feedback">
                                    Please enter a valid address.
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="bsValidation14" required>
                                    <label class="form-check-label" for="bsValidation14">Agree to terms and conditions</label>
                                    <div class="invalid-feedback">
                                        You must agree before submitting.
                                      </div>
                                </div>
                            </div>
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
        <!--end row-->
{{-- <div class="main-content-inner">
    <div class="row">
        <!-- data table start -->
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Edit Rutina</h4>
                    @include('backend.layouts.partials.messages')

                    <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="name">Role Name</label>
                            <input type="text" class="form-control" id="name" value="{{ $role->name }}" name="name" placeholder="Enter a Role Name">
                        </div>

                        <div class="form-group">
                            <label for="name">Permissions</label>

                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="checkPermissionAll" value="1" {{ App\User::roleHasPermissions($role, $all_permissions) ? 'checked' : '' }}>
                                <label class="form-check-label" for="checkPermissionAll">All</label>
                            </div>
                            <hr>
                            @php $i = 1; @endphp
                            @foreach ($permission_groups as $group)
                                <div class="row">
                                    @php
                                        $permissions = App\User::getpermissionsByGroupName($group->name);
                                        $j = 1;
                                    @endphp

                                    <div class="col-3">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="{{ $i }}Management" value="{{ $group->name }}" onclick="checkPermissionByGroup('role-{{ $i }}-management-checkbox', this)" {{ App\User::roleHasPermissions($role, $permissions) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="checkPermission">{{ $group->name }}</label>
                                        </div>
                                    </div>

                                    <div class="col-9 role-{{ $i }}-management-checkbox">

                                        @foreach ($permissions as $permission)
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" onclick="checkSinglePermission('role-{{ $i }}-management-checkbox', '{{ $i }}Management', {{ count($permissions) }})" name="permissions[]" {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }} id="checkPermission{{ $permission->id }}" value="{{ $permission->name }}">
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
                        <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Update Rutina</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- data table end -->

    </div>
</div> --}}
@endsection


@section('scripts')
     @include('backend.pages.rutinas.partials.scripts')
@endsection
