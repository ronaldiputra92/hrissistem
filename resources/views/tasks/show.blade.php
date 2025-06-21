@extends('layouts.dashboard')

@section('content')
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <div class="page-title">
            <div class="row align-items-center">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Detail Tugas</h3>
                    <p class="text-subtitle text-muted">Tampilan lengkap informasi tugas</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('tasks.index') }}">Tugas</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Detail</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title text-white mb-0">Informasi Tugas</h4>
                        <span class="badge bg-white text-primary fs-6">
                            ID : {{ $task->id }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-12 mt-3">
                            <!-- Title Section -->
                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-card-heading me-3 fs-4 text-primary" style="width: 24px;"></i>
                                    <h6 class="fw-bold mb-0 ms-2">Judul</h6>
                                </div>
                                <div class="ps-5">
                                    <p class="mb-0">{{ $task->title }}</p>
                                </div>
                            </div>
                            <!-- Employee Section -->
                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-person-badge me-3 fs-4 text-primary" style="width: 24px;"></i>
                                    <h6 class="fw-bold mb-0 ms-2">Karyawan yang ditugaskan</h6>
                                </div>
                                <div class="ps-5">
                                    <p class="mb-0">
                                        {{ $task->employee->full_name }}
                                        <span class="text-muted">({{ $task->employee->email }})</span>
                                    </p>
                                </div>
                            </div>
                            <!-- Due Date Section -->
                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-calendar-date me-3 fs-4 text-primary" style="width: 24px;"></i>
                                    <h6 class="fw-bold mb-0 ms-2">Batas Waktu</h6>
                                </div>
                                <div class="ps-5">
                                    <p class="mb-0">
                                        {{ \Carbon\Carbon::parse($task->due_date)->format('l, d F Y') }}

                                    </p>
                                </div>
                            </div>
                            <!-- Status Section -->
                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-activity me-3 fs-4 text-primary" style="width: 24px;"></i>
                                    <h6 class="fw-bold mb-0 ms-2">Status</h6>
                                </div>
                                <div class="ps-5">
                                    @if ($task->status == 'pending')
                                        <span class="badge bg-warning text-dark px-3 py-2">
                                            <i class="bi bi-hourglass-split me-1"></i> Menunggu
                                        </span>
                                    @elseif ($task->status == 'done')
                                        <span class="badge bg-success text-white px-3 py-2">
                                            <i class="bi bi-check-circle me-1"></i> Diterima
                                        </span>
                                    @else
                                        <span class="badge bg-danger text-white px-3 py-2">
                                            <i class="bi bi-x-circle me-1"></i> Ditolak
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <!-- Description Section -->
                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-card-text me-3 text-primary" style="width: 24px;"></i>
                                    <h6 class="fw-bold mb-0 ms-2">Deskripsi</h6>
                                </div>
                                <div class="ps-5">
                                    <div class="card bg-light p-3 border">
                                        {!! nl2br(e($task->description)) !!}
                                    </div>
                                </div>
                            </div>
                            <!-- Action Buttons -->
                            <div class="d-flex justify-content-between mt-5 pt-3 border-top">
                                <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary px-4">
                                    <i class="bi bi-arrow-left me-2"></i> Kembali ke List
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
