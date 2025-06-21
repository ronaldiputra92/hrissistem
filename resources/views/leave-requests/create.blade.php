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
                    <h3><i class="bi bi-calendar-plus me-2"></i>Pengajuan Cuti</h3>
                    <p class="text-subtitle text-muted">Ajukan permohonan cuti Anda</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/"><i class="bi bi-house-door"></i> Dashboard</a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ route('leave-requests.index') }}"><i
                                        class="bi bi-calendar-check"></i> Permintaan Cuti</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-plus-circle"></i> Tambah
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h4 class="card-title text-white"><i class="bi bi-file-earmark-plus"></i> Tambah Pengajuan Cuti</h4>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            <h5 class="alert-heading"><i class="bi bi-exclamation-triangle"></i> Validation Errors</h5>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('leave-requests.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf

                        <div class="row mt-3">
                            @if (session('role') == 'HR')
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex flex-column">
                                        <select class="form-select @error('employee_id') is-invalid @enderror"
                                            id="employee_id" name="employee_id" required>
                                            <option value="">-- Pilih Karyawan --</option>
                                            @foreach ($employees as $employee)
                                                <option value="{{ $employee->id }}"
                                                    {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                                    {{ $employee->full_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="employee_id" class="form-label">
                                            <i class="bi bi-person-badge"></i> Karyawan <span class="text-danger">*</span>
                                        </label>
                                        @error('employee_id')
                                            <div class="invalid-feedback">
                                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            @endif

                            <div class="col-md-6 mb-4">
                                <div class="d-flex flex-column">
                                    <select class="form-select @error('leave_type') is-invalid @enderror" id="leave_type"
                                        name="leave_type" required>
                                        <option value="">-- Pilih Jenis Cuti --</option>
                                        <option value="Sick Leave"
                                            {{ old('leave_type') == 'Sick Leave' ? 'selected' : '' }}>Cuti Sakit</option>
                                        <option value="Annual Leave"
                                            {{ old('leave_type') == 'Annual Leave' ? 'selected' : '' }}>Cuti Tahunan
                                        </option>
                                        <option value="Casual Leave"
                                            {{ old('leave_type') == 'Casual Leave' ? 'selected' : '' }}>Cuti Biasa
                                        </option>
                                        <option value="Maternity Leave"
                                            {{ old('leave_type') == 'Maternity Leave' ? 'selected' : '' }}>Cuti Melahirkan
                                        </option>
                                        <option value="Personal Leave"
                                            {{ old('leave_type') == 'Personal Leave' ? 'selected' : '' }}>Cuti Khusus
                                        </option>
                                    </select>
                                    <label for="leave_type" class="form-label">
                                        <i class="bi bi-tag"></i> Jenis Cuti <span class="text-danger">*</span>
                                    </label>
                                    @error('leave_type')
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="d-flex flex-column">
                                    <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                                        id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                                    <label for="start_date" class="form-label">
                                        <i class="bi bi-calendar-date"></i> Tanggal Mulai <span class="text-danger">*</span>
                                    </label>
                                    @error('start_date')
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="d-flex flex-column">
                                    <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                                        id="end_date" name="end_date" value="{{ old('end_date') }}" required>
                                    <label for="end_date" class="form-label">
                                        <i class="bi bi-calendar-date"></i> Tanggal Selesai <span
                                            class="text-danger">*</span>
                                    </label>
                                    @error('end_date')
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('leave-requests.index') }}" class="btn btn-light-secondary me-3">
                                <i class="bi bi-arrow-left"></i> Kembali ke List
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send-check"></i> Ajukan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>

    <!-- Include Datepicker and Validation JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize date picker
            flatpickr(".form-control[type='date']", {
                dateFormat: "Y-m-d",
                minDate: "today"
            });

            // Date validation
            const startDate = document.getElementById('start_date');
            const endDate = document.getElementById('end_date');

            startDate.addEventListener('change', function() {
                if (startDate.value && endDate.value && endDate.value < startDate.value) {
                    endDate.value = '';
                    Swal.fire({
                        icon: 'warning',
                        title: 'Invalid Date',
                        text: 'End date must be after start date',
                        confirmButtonColor: '#3085d6',
                    });
                }
                endDate.min = startDate.value;
            });

            endDate.addEventListener('change', function() {
                if (startDate.value && endDate.value && endDate.value < startDate.value) {
                    endDate.value = '';
                    Swal.fire({
                        icon: 'warning',
                        title: 'Invalid Date',
                        text: 'End date must be after start date',
                        confirmButtonColor: '#3085d6',
                    });
                }
            });

            // Form validation
            (() => {
                'use strict'
                const forms = document.querySelectorAll('.needs-validation')

                Array.from(forms).forEach(form => {
                    form.addEventListener('submit', event => {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })
            })()
        });
    </script>
@endsection
