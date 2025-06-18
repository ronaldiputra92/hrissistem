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
                <h3>Create New Payroll</h3>
                <p class="text-subtitle text-muted">Add payroll details for employees</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('payrolls.index') }}">Payrolls</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="card-title text-white">Payroll Information</h4>
                    <a href="{{ route('payrolls.index') }}" class="btn btn-light btn-sm">
                        <i class="bi bi-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <h5 class="alert-heading">Validation Errors</h5>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('payrolls.store') }}" method="POST" class="form form-horizontal">
                    @csrf

                    <div class="row mt-3">
                        <!-- Employee Selection -->
                        <div class="col-md-6 mb-4">
                            <div class="form-group">
                                <label for="employee_id" class="form-label">
                                    <i class="bi bi-person-vcard"></i> Employee
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select select2 @error('employee_id') is-invalid @enderror" id="employee_id" name="employee_id" required>
                                    <option value="">-- Select Employee --</option>
                                    @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                        {{ $employee->full_name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('employee_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Pay Date -->
                        <div class="col-md-6 mb-4">
                            <div class="form-group">
                                <label for="pay_date" class="form-label">
                                    <i class="bi bi-calendar-date"></i> Pay Date
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="date" class="form-control flatpickr @error('pay_date') is-invalid @enderror"
                                    id="pay_date" name="pay_date" value="{{ old('pay_date', now()->format('Y-m-d')) }}" required>
                                @error('pay_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Salary Information -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h6 class="card-title"><i class="bi bi-cash-stack"></i> Salary Details</h6>
                        </div>
                        <div class="card-body">
                            <div class="row mt-3">
                                <!-- Base Salary -->
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="salary" class="form-label">Base Salary</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp.</span>
                                            <input type="number" class="form-control @error('salary') is-invalid @enderror"
                                                id="salary" name="salary" value="{{ old('salary') }}" required>
                                        </div>
                                        @error('salary')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Deductions -->
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="deductions" class="form-label">Deductions</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp.</span>
                                            <input type="number" class="form-control @error('deductions') is-invalid @enderror"
                                                id="deductions" name="deductions" value="{{ old('deductions', 0) }}" required>
                                        </div>
                                        <small class="text-muted">Taxes, insurance, etc.</small>
                                        @error('deductions')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Bonuses -->
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="bonuses" class="form-label">Bonuses</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp.</span>
                                            <input type="number" class="form-control @error('bonuses') is-invalid @enderror"
                                                id="bonuses" name="bonuses" value="{{ old('bonuses', 0) }}" required>
                                        </div>
                                        <small class="text-muted">Performance, overtime, etc.</small>
                                        @error('bonuses')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Net Salary (Calculated) -->
                            <div class="row my-0">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="net_salary" class="form-label">Net Salary</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp.</span>
                                            <input type="number" class="form-control bg-light fw-bold"
                                                id="net_salary" name="net_salary" value="{{ old('net_salary') }}" disabled>
                                        </div>
                                        <small class="text-success">Calculated automatically</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="d-flex justify-content-end gap-2">
                        <button type="reset" class="btn btn-light">
                            <i class="bi bi-eraser"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Save Payroll
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

@push('styles')
<link rel="stylesheet" href="{{ asset('vendors/select2/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}">
<style>
    .card {
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }
    .card-header {
        border-radius: 0.5rem 0.5rem 0 0 !important;
    }
    .form-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
    .input-group-text {
        background-color: #f8f9fa;
    }
    .select2-container--default .select2-selection--single {
        height: calc(2.25rem + 2px);
        padding: 0.375rem 0.75rem;
        border: 1px solid #ced4da;
    }
</style>
@endpush

@push('scripts')
<script src="{{ asset('vendors/select2/select2.min.js') }}"></script>
<script src="{{ asset('vendors/flatpickr/flatpickr.min.js') }}"></script>
<script>
    $(document).ready(function() {
        // Initialize Select2
        $('.select2').select2({
            placeholder: "-- Select Employee --",
            allowClear: true
        });

        // Initialize Flatpickr
        $(".flatpickr").flatpickr({
            dateFormat: "Y-m-d",
            defaultDate: "{{ now()->format('Y-m-d') }}"
        });

        // Calculate net salary when values change
        $('#salary, #deductions, #bonuses').on('input', function() {
            const salary = parseFloat($('#salary').val()) || 0;
            const deductions = parseFloat($('#deductions').val()) || 0;
            const bonuses = parseFloat($('#bonuses').val()) || 0;

            const netSalary = salary - deductions + bonuses;
            $('#net_salary').val(netSalary.toFixed(2));
        });

        // Trigger calculation on page load if values exist
        if ($('#salary').val() || $('#deductions').val() || $('#bonuses').val()) {
            $('#salary').trigger('input');
        }
    });
</script>
@endpush

@endsection
