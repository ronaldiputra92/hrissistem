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
                    <h3><i class="bi bi-shield-plus"></i> Role Baru</h3>
                    <p class="text-subtitle text-muted">Tambahkan peran sistem baru dengan pengaturan izin</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white py-3">
                    <h4 class="card-title text-white mb-0">
                        <i class="bi bi-file-earmark-plus"></i> Informasi Role
                    </h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('roles.store') }}" method="POST" class="form form-horizontal">
                        @csrf

                        <div class="row mt-3">
                            <div class="col-md-10 mx-auto">
                                @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show">
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                        <h5 class="alert-heading"><i class="bi bi-exclamation-triangle-fill"></i> Validation
                                            Error</h5>
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="mb-4">
                                    <label for="title" class="form-label fw-bold">Role</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-shield"></i></span>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                            id="title" name="title" value="{{ old('title') }}"
                                            placeholder="Enter role title (e.g. Administrator)" required>
                                    </div>
                                    @error('title')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="description" class="form-label fw-bold">Deksripsi</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-text-paragraph"></i></span>
                                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                            rows="5" placeholder="Enter role description and permissions" required>{{ old('description') }}</textarea>
                                    </div>
                                    @error('description')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-end gap-2 mt-4">
                                    <a href="{{ route('roles.index') }}" class="btn btn-light-danger">
                                        <i class="bi bi-x-circle me-1"></i> Batal
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-save me-1"></i> Simpan
                                    </button>
                                </div>
                            </div>
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
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        }

        .card-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            padding: 10px 15px;
            box-shadow: none;
            border: 1px solid #e0e0e0;
            transition: all 0.3s;
        }

        .form-control:focus,
        .form-select:focus {
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
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
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
