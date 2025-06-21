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
                    <h3>Ubah Data Gaji</h3>
                    <p class="text-subtitle text-muted">Perbarui rincian penggajian karyawan</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('payrolls.index') }}">Penggajian</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title text-white">
                            <i class="bi bi-pencil-square"></i> Edit Data Penggajian
                        </h4>
                        <a href="{{ route('payrolls.index') }}" class="btn btn-light btn-sm">
                            <i class="bi bi-arrow-left"></i> Kembali ke List
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

                    <form action="{{ route('payrolls.update', $payroll->id) }}" method="POST" class="form form-horizontal">
                        @csrf
                        @method('PUT')

                        <div class="row mt-3">
                            <!-- Employee Selection -->
                            <div class="col-md-6 mb-4">
                                <div class="form-group">
                                    <label for="employee_id" class="form-label">
                                        <i class="bi bi-person-vcard"></i> Karyawan
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select select2 @error('employee_id') is-invalid @enderror"
                                        id="employee_id" name="employee_id" required>
                                        <option value="">-- Pilih Karyawan --</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}"
                                                {{ old('employee_id', $payroll->employee_id) == $employee->id ? 'selected' : '' }}>
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
                                        <i class="bi bi-calendar-date"></i> Tanggal Gajian
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="date"
                                        class="form-control flatpickr @error('pay_date') is-invalid @enderror"
                                        id="pay_date" name="pay_date"
                                        value="{{ old('pay_date', $payroll->pay_date->format('Y-m-d')) }}" required>
                                    @error('pay_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Salary Information -->
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-light">
                                <h6 class="card-title"><i class="bi bi-cash-stack"></i> Detail Penggajian</h6>
                            </div>
                            <div class="card-body">
                                <div class="row mt-3">
                                    <!-- Base Salary -->
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group">
                                            <label for="salary" class="form-label">Gaji Pokok</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp.</span>
                                                <input type="number"
                                                    class="form-control @error('salary') is-invalid @enderror"
                                                    id="salary" name="salary"
                                                    value="{{ old('salary', $payroll->salary) }}" required>
                                            </div>
                                            @error('salary')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Deductions -->
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group">
                                            <label for="deductions" class="form-label">Potongan</label>
                                            <div class="input-group">
                                                <span class="input-group-text">$</span>
                                                <input type="number"
                                                    class="form-control @error('deductions') is-invalid @enderror"
                                                    id="deductions" name="deductions"
                                                    value="{{ old('deductions', $payroll->deductions) }}" required>
                                            </div>
                                            <small class="text-muted">Pajak, asuransi, dan lainnya</small>
                                            @error('deductions')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Bonuses -->
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group">
                                            <label for="bonuses" class="form-label">Bonus</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp.</span>
                                                <input type="number"
                                                    class="form-control @error('bonuses') is-invalid @enderror"
                                                    id="bonuses" name="bonuses"
                                                    value="{{ old('bonuses', $payroll->bonuses) }}" required>
                                            </div>
                                            <small class="text-muted">Kinerja, lembur, dan lainnya.</small>
                                            @error('bonuses')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Net Salary (Calculated) -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="net_salary" class="form-label">Gaji Bersih</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp.</span>
                                                <input type="number" class="form-control bg-light fw-bold"
                                                    id="net_salary" name="net_salary"
                                                    value="{{ old('net_salary', $payroll->net_salary) }}" disabled>
                                            </div>
                                            <small class="text-success">Dihitung secara otomatis</small>
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
                                <i class="bi bi-save"></i> Simpan
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
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                border: none;
            }

            .card-header {
                border-radius: 0.5rem 0.5rem 0 0 !important;
            }

            .bg-gradient-primary {
                background: linear-gradient(135deg, #3a7bd5 0%, #00d2ff 100%);
            }

            .form-label {
                font-weight: 500;
                margin-bottom: 0.5rem;
                color: #495057;
            }

            .input-group-text {
                background-color: #f8f9fa;
                min-width: 40px;
                justify-content: center;
            }

            .select2-container--default .select2-selection--single {
                height: calc(2.25rem + 2px);
                padding: 0.375rem 0.75rem;
                border: 1px solid #ced4da;
                border-radius: 0.25rem;
            }

            .btn-light {
                border: 1px solid #dee2e6;
            }

            .btn-primary {
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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
                    defaultDate: "{{ old('pay_date', $payroll->pay_date->format('Y-m-d')) }}"
                });

                // Calculate net salary when values change
                function calculateNetSalary() {
                    const salary = parseFloat($('#salary').val()) || 0;
                    const deductions = parseFloat($('#deductions').val()) || 0;
                    const bonuses = parseFloat($('#bonuses').val()) || 0;

                    const netSalary = salary - deductions + bonuses;
                    $('#net_salary').val(netSalary.toFixed(2));
                }

                $('#salary, #deductions, #bonuses').on('input', calculateNetSalary);

                // Calculate on page load
                calculateNetSalary();
            });
        </script>
    @endpush

@endsection
