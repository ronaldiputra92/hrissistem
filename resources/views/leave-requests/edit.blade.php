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
                    <h3>Pengajuan Cuti</h3>
                    <p class="text-subtitle text-muted">Kelola pengajuan cuti karyawan</p>
                    {{-- Changed subtitle for clarity --}}
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('leave-requests.index') }}">Permohonan Cuti</a>
                            </li>
                            {{-- Added link to index --}}
                            <li class="breadcrumb-item active" aria-current="page">Edit</li> {{-- Changed to Edit Request --}}
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card shadow-sm"> {{-- Added shadow for depth --}}
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    {{-- Styled header --}}
                    <h5 class="card-title mb-0">
                        <i class="bi bi-pencil-square me-2"></i> Edit Pengajuan Cuti
                    </h5>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert"> {{-- Added dismissible alert --}}
                            <strong>Oops! There were some issues:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <form action="{{ route('leave-requests.update', $leaveRequest->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="employee_id" class="form-label fw-bold">Karyawan</label>
                                    {{-- Bold label --}}
                                    <select class="form-select form-control-lg @error('employee_id') is-invalid @enderror"
                                        id="employee_id" name="employee_id" required> {{-- Larger select --}}
                                        <option value="">-- Pilih Karyawan --</option> {{-- Changed text --}}
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}"
                                                {{ $leaveRequest->employee_id == $employee->id ? 'selected' : '' }}>
                                                {{ $employee->full_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('employee_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="leave_type" class="form-label fw-bold">Jenis Cuti</label>
                                    {{-- Bold label --}}
                                    <select class="form-select form-control-lg @error('leave_type') is-invalid @enderror"
                                        id="leave_type" name="leave_type" required> {{-- Larger select --}}
                                        <option value="Sick Leave"
                                            {{ $leaveRequest->leave_type == 'Sick Leave' ? 'selected' : '' }}>Cuti Sakit
                                        </option>
                                        <option value="Annual Leave"
                                            {{ $leaveRequest->leave_type == 'Annual Leave' ? 'selected' : '' }}>Cuti Tahunan
                                        </option>
                                        <option value="Casual Leave"
                                            {{ $leaveRequest->leave_type == 'Casual Leave' ? 'selected' : '' }}>Cuti Biasa
                                        </option>
                                        <option value="Maternity Leave"
                                            {{ $leaveRequest->leave_type == 'Maternity Leave' ? 'selected' : '' }}>Cuti
                                            Melahirkan
                                        </option>
                                        <option value="Personal Leave"
                                            {{ $leaveRequest->leave_type == 'Personal Leave' ? 'selected' : '' }}>Cuti
                                            Khusus
                                        </option>
                                    </select>
                                    @error('leave_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="start_date" class="form-label fw-bold">Start Date</label>
                                    {{-- Bold label --}}
                                    <input type="date"
                                        class="form-control form-control-lg @error('start_date') is-invalid @enderror"
                                        id="start_date" name="start_date"
                                        value="{{ old('start_date', $leaveRequest->start_date) }}" required>
                                    {{-- Larger input --}}
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="end_date" class="form-label fw-bold">End Date</label> {{-- Bold label --}}
                                    <input type="date"
                                        class="form-control form-control-lg @error('end_date') is-invalid @enderror"
                                        id="end_date" name="end_date"
                                        value="{{ old('end_date', $leaveRequest->end_date) }}" required>
                                    {{-- Larger input --}}
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4"> {{-- Align buttons to the right --}}
                            <button type="submit" class="btn btn-primary  me-2">
                                <i class="bi bi-save me-1"></i> Update Leave
                            </button> {{-- Larger primary button with icon --}}
                            <a href="{{ route('leave-requests.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle me-1"></i> Cancel
                            </a> {{-- Larger outline secondary button with icon --}}
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
