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
                    <h3>Detail Data Penggajian</h3>
                    <p class="text-subtitle text-muted">Informasi Data Penggajian Karyawan</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                            <li class="breadcrumb-item" aria-current="page">Penggajian</li>
                            <li class="breadcrumb-item active" aria-current="page">Detail</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        Detail Data
                    </h5>
                </div>
                <div class="card-body" id="print-area">
                    <div class="print-header d-none d-print-block">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h2 class="mb-0">Slip Gaji</h2>
                                <p class="text-muted mb-0">{{ date('d F Y') }}</p>
                            </div>
                            <div class="text-end">
                                <p class="text-muted mb-0">PT Indocoll</p>
                            </div>
                        </div>
                        <hr class="my-3">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="employee" class="form-label fw-bold">Karyawan</label>
                                <input type="text" class="form-control-plaintext border-bottom pb-2" id="employee"
                                    value="{{ $payroll->employee->full_name }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="salary" class="form-label fw-bold">Gaji Pokok</label>
                                <input type="text" class="form-control-plaintext border-bottom pb-2" id="salary"
                                    value="Rp.{{ number_format($payroll->salary, 0, ',', '.') }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="bonuses" class="form-label fw-bold">Bonus</label>
                                <input type="text" class="form-control-plaintext border-bottom pb-2" id="bonuses"
                                    value="Rp.{{ number_format($payroll->bonuses, 0, ',', '.') }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="deductions" class="form-label fw-bold">Potongan</label>
                                <input type="text" class="form-control-plaintext border-bottom pb-2" id="deductions"
                                    value="Rp.{{ number_format($payroll->deductions, 0, ',', '.') }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="pay_date" class="form-label fw-bold">Tanggal Gajian</label>
                                <input type="text" class="form-control-plaintext border-bottom pb-2" id="pay_date"
                                    value="{{ $payroll->pay_date->format('d F Y') }}" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="print-summary mt-4">
                        <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded">
                            <h5 class="mb-0 fw-bold">Gaji Bersih</h5>
                            <h4 class="mb-0 text-primary">Rp.{{ number_format($payroll->net_salary, 0, ',', '.') }}</h4>
                        </div>
                    </div>

                    <div class="print-footer mt-5 d-none d-print-block">
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Tanda Tangan Karyawan</strong></p>
                                <div class="signature-line mt-4 mb-2"></div>
                                <p class="text-muted small">Tanggal: _______________</p>
                            </div>
                            <div class="col-md-6 text-end">
                                <p class="mb-1"><strong>Stempel Perusahaan</strong></p>
                                <div class="stamp-placeholder mt-4"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex gap-2">
                    <a href="{{ route('payrolls.index') }}" class="btn btn-secondary">Kembali List</a>
                    <button type="button" id="print" class="btn btn-primary d-flex align-items-center">
                        <i class="bi bi-printer me-1 mb-2"></i>
                        <span>Print</span>
                    </button>
                </div>
            </div>
        </section>
    </div>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            #print-area,
            #print-area * {
                visibility: visible;
            }

            #print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                padding: 20px;
                background: white;
            }

            .print-header {
                margin-bottom: 30px;
            }

            .form-control-plaintext {
                background-color: transparent !important;
                padding-left: 0 !important;
            }

            .signature-line {
                width: 200px;
                border-bottom: 1px solid #000;
            }

            .stamp-placeholder {
                width: 150px;
                height: 80px;
                border: 1px dashed #ccc;
                display: inline-block;
            }

            .print-summary {
                margin-top: 30px;
            }

            .print-footer {
                margin-top: 50px;
            }

            .no-print {
                display: none !important;
            }
        }

        @page {
            size: A4;
            margin: 20mm;
        }
    </style>

    <script>
        document.getElementById('print').addEventListener('click', function() {
            // Add loading state
            this.innerHTML = '<i class="bi bi-printer me-2"></i><span>Printing...</span>';

            setTimeout(() => {
                window.print();

                // Restore button state after print
                this.innerHTML = '<i class="bi bi-printer me-2"></i><span>Print Receipt</span>';
            }, 500);
        });

        // Reload after print dialog closes (optional)
        window.addEventListener('afterprint', function() {
            // You can add any post-print logic here
        });
    </script>
@endsection
