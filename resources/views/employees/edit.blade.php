@extends('layouts.dashboard')

@section('content')
<header class="mb-3">
    <a href="#" class="burger-btn d-block d-xl-none">
        <i class="bi bi-justify fs-3"></i>
    </a>
</header>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3><i class="bi bi-person-gear"></i> Edit Employee</h3>
                <p class="text-subtitle text-muted">Update employee information</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('employees.index') }}">Employees</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white py-3">
                <h4 class="card-title text-white mb-0">
                    <i class="bi bi-person-lines-fill me-2"></i>Edit Employee Profile
                </h4>
            </div>

            <div class="card-body">
                @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <h5 class="alert-heading"><i class="bi bi-exclamation-triangle-fill"></i> Validation Error</h5>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('employees.update', $employee->id) }}" method="POST" class="form form-horizontal">
                    @csrf
                    @method('PUT')

                    <div class="row mt-3">
                        <!-- Personal Information Column -->
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="full_name" class="form-label fw-bold">Full Name</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                                    <input type="text" class="form-control @error('full_name') is-invalid @enderror"
                                           id="full_name" name="full_name" value="{{ old('full_name', $employee->full_name) }}" required>
                                </div>
                                @error('full_name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="email" class="form-label fw-bold">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                           id="email" name="email" value="{{ old('email', $employee->email) }}" required>
                                </div>
                                @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="phone_number" class="form-label fw-bold">Phone Number</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                    <input type="text" class="form-control @error('phone_number') is-invalid @enderror"
                                           id="phone_number" name="phone_number" value="{{ old('phone_number', $employee->phone_number) }}" required>
                                </div>
                                @error('phone_number')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="birthdate" class="form-label fw-bold">Birthdate</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
                                    <input type="date" class="form-control @error('birthdate') is-invalid @enderror"
                                           id="birthdate" name="birthdate" value="{{ old('birthdate', $employee->birthdate) }}" required>
                                </div>
                                @error('birthdate')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="address" class="form-label fw-bold">Address</label>
                                <textarea class="form-control @error('address') is-invalid @enderror"
                                          id="address" name="address" rows="3" required>{{ old('address', $employee->address) }}</textarea>
                                @error('address')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Employment Information Column -->
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="hire_date" class="form-label fw-bold">Hire Date</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-calendar-check"></i></span>
                                    <input type="date" class="form-control @error('hire_date') is-invalid @enderror"
                                           id="hire_date" name="hire_date" value="{{ old('hire_date', $employee->hire_date) }}" required>
                                </div>
                                @error('hire_date')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="department_id" class="form-label fw-bold">Department</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-building"></i></span>
                                    <select class="form-select @error('department_id') is-invalid @enderror"
                                            id="department_id" name="department_id" required>
                                        <option value="">Select Department</option>
                                        @foreach ($departments as $department)
                                        <option value="{{ $department->id }}" {{ old('department_id', $employee->department_id) == $department->id ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('department_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="role_id" class="form-label fw-bold">Role</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person-workspace"></i></span>
                                    <select class="form-select @error('role_id') is-invalid @enderror"
                                            id="role_id" name="role_id" required>
                                        <option value="">Select Role</option>
                                        @foreach ($roles as $role)
                                        <option value="{{ $role->id }}" {{ old('role_id', $employee->role_id) == $role->id ? 'selected' : '' }}>
                                            {{ $role->title }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('role_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="status" class="form-label fw-bold">Status</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person-check"></i></span>
                                    <select class="form-select @error('status') is-invalid @enderror"
                                            id="status" name="status" required>
                                        <option value="">Select Status</option>
                                        <option value="active" {{ old('status', $employee->status) == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status', $employee->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                                @error('status')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="salary" class="form-label fw-bold">Salary</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control @error('salary') is-invalid @enderror"
                                           id="salary" name="salary" value="{{ old('salary', $employee->salary) }}" required>
                                </div>
                                @error('salary')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('employees.index') }}" class="btn btn-light-danger">
                            <i class="bi bi-x-circle me-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Update Employee
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<style>
    .card {
        border-radius: 12px;
        border: none;
        overflow: hidden;
        box-shadow: 0 6px 20px rgba(0,0,0,0.08);
    }

    .card-header {
        border-bottom: 1px solid rgba(255, 255, 255, 0.15);
    }

    .form-control, .form-select {
        border-radius: 8px;
        padding: 10px 15px;
        box-shadow: none;
        border: 1px solid #e0e0e0;
        transition: all 0.3s;
    }

    .form-control:focus, .form-select:focus {
        border-color: #7367f0;
        box-shadow: 0 0 0 3px rgba(115, 103, 240, 0.1);
    }

    .input-group-text {
        background-color: #f8f9fa;
        border-right: none;
        min-width: 40px;
        justify-content: center;
    }

    .btn {
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 500;
        transition: all 0.3s;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    textarea {
        min-height: 120px;
        resize: vertical;
    }

    .form-label {
        color: #5e5873;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .input-group {
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        margin-bottom: 1rem;
    }

    .alert-danger {
        border-left: 4px solid #dc3545;
    }

    .invalid-feedback.d-block {
        display: block;
        margin-top: -0.5rem;
        margin-bottom: 1rem;
        color: #dc3545;
        font-size: 0.875em;
    }
</style>

@endsection
