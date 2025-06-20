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
                <h3><i class="bi bi-person-lines-fill"></i> Employee Details</h3>
                <p class="text-subtitle text-muted">Comprehensive employee information</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('employees.index') }}">Employees</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Details</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="card-title text-white mb-0">
                        <i class="bi bi-person-badge me-2"></i>Employee Profile
                    </h4>
                    <span class="badge bg-light text-primary fs-6">
                        ID: {{ $employee->id }}
                    </span>
                </div>
            </div>

            <div class="card-body">
                <div class="row mt-2">
                    <!-- Left Column -->
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label class="form-label fw-bold text-primary">Full Name</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-person mb-2"></i></span>
                                <input type="text" class="form-control bg-light" value="{{ $employee->full_name }}" readonly>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-primary">Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-envelope mb-2"></i></span>
                                <input type="text" class="form-control bg-light" value="{{ $employee->email }}" readonly>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-primary">Phone Number</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-telephone mb-2"></i></span>
                                <input type="text" class="form-control bg-light" value="{{ $employee->phone_number }}" readonly>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-primary">Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-geo-alt mb-2"></i></span>
                                <textarea class="form-control bg-light" rows="3" readonly>{{ $employee->address }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label class="form-label fw-bold text-primary">Birthdate</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-calendar-heart mb-2"></i></span>
                                <input type="text" class="form-control bg-light"
                                       value="{{ \Carbon\Carbon::parse($employee->birthdate)->format('d F Y') }}" readonly>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-primary">Hire Date</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-calendar-check mb-2"></i></span>
                                <input type="text" class="form-control bg-light"
                                       value="{{ \Carbon\Carbon::parse($employee->hire_date)->format('d F Y') }}" readonly>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-primary">Department</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-building mb-2"></i></span>
                                <input type="text" class="form-control bg-light" value="{{ $employee->department->name }}" readonly>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-primary">Role</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-person-workspace mb-2"></i></span>
                                <input type="text" class="form-control bg-light" value="{{ $employee->role->title }}" readonly>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-primary">Status</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi {{ $employee->status == 'active' ? 'bi-check-circle' : 'bi-x-circle' }} mb-2"></i>
                                </span>
                                <input type="text" class="form-control text-white fw-bold"
                                       value="{{ ucfirst($employee->status) }}" readonly
                                       style="background-color: {{ $employee->status == 'active' ? '#28a745' : '#dc3545' }};">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-primary">Salary</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">Rp</span>
                                <input type="text" class="form-control bg-light"
                                       value="{{ number_format($employee->salary, 0, ',', '.') }}" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-5">
                    <a href="{{ route('employees.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left-circle me-2"></i>Back to List
                    </a>
                </div>
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
        background-color: #f8f9fa;
    }

    .form-control:focus, .form-select:focus {
        border-color: #7367f0;
        box-shadow: 0 0 0 3px rgba(115, 103, 240, 0.1);
    }

    .input-group-text {
        background-color: #f1f1f1;
        border-right: none;
        min-width: 40px;
        justify-content: center;
    }

    .btn {
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 500;
        transition: all 0.3s;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
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
</style>

@endsection
