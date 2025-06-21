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
                    <h3><i class="bi bi-calendar-plus"></i> Tambah Kehadiran</h3>
                    <p class="text-subtitle text-muted">Rekap kehadiran karyawan</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('presences.index') }}">Kehadiran</a></li>
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
                        <i class="bi bi-person-lines-fill me-2"></i>Rekap Data Kehadiran
                    </h4>
                </div>

                <div class="card-body">
                    @if (session('role') == 'HR')
                        <form action="{{ route('presences.store') }}" method="POST" class="form form-horizontal">
                            @csrf

                            <div class="row mt-3">
                                <div class="col-md-10 mx-auto">
                                    @if ($errors->any())
                                        <div class="alert alert-danger alert-dismissible fade show">
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                            <h5 class="alert-heading"><i class="bi bi-exclamation-triangle-fill"></i>
                                                Validation Error</h5>
                                            <ul class="mb-0">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <div class="mb-4">
                                        <label for="employee_id" class="form-label fw-bold">Karyawan</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                                            <select class="form-select @error('employee_id') is-invalid @enderror"
                                                id="employee_id" name="employee_id" required>
                                                <option value="">Pilih Karyawan</option>
                                                @foreach ($employees as $employee)
                                                    <option value="{{ $employee->id }}"
                                                        {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                                        {{ $employee->full_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('employee_id')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-4">
                                                <label for="check_in" class="form-label fw-bold">Masuk</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i
                                                            class="bi bi-clock-history"></i></span>
                                                    <input type="text"
                                                        class="form-control dateTime @error('check_in') is-invalid @enderror"
                                                        id="check_in" name="check_in" value="{{ old('check_in') }}"
                                                        placeholder="HH:MM">
                                                </div>
                                                @error('check_in')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4">
                                                <label for="check_out" class="form-label fw-bold">Keluar</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="bi bi-clock"></i></span>
                                                    <input type="text"
                                                        class="form-control dateTime @error('check_out') is-invalid @enderror"
                                                        id="check_out" name="check_out" value="{{ old('check_out') }}"
                                                        placeholder="HH:MM">
                                                </div>
                                                @error('check_out')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-4">
                                                <label for="date" class="form-label fw-bold">Tanggal</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i
                                                            class="bi bi-calendar-date"></i></span>
                                                    <input type="date"
                                                        class="form-control @error('date') is-invalid @enderror"
                                                        id="date" name="date"
                                                        value="{{ old('date', now()->format('Y-m-d')) }}" required>
                                                </div>
                                                @error('date')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4">
                                                <label for="status" class="form-label fw-bold">Status</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="bi bi-info-circle"></i></span>
                                                    <select class="form-select @error('status') is-invalid @enderror"
                                                        id="status" name="status" required>
                                                        <option value="">Pilih Status</option>
                                                        <option value="present"
                                                            {{ old('status') == 'present' ? 'selected' : '' }}>Hadir
                                                        </option>
                                                        <option value="absent"
                                                            {{ old('status') == 'absent' ? 'selected' : '' }}>Tidak Hadir
                                                        </option>
                                                        <option value="leave"
                                                            {{ old('status') == 'leave' ? 'selected' : '' }}>Izin</option>
                                                    </select>
                                                </div>
                                                @error('status')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end gap-2 mt-4">
                                        <a href="{{ route('presences.index') }}" class="btn btn-light-danger">
                                            <i class="bi bi-x-circle me-1"></i> Batal
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-save me-1"></i> Simpan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @else
                        <form action="{{ route('presences.store') }}" method="POST" class="form form-horizontal">
                            @csrf
                            <div class="row">
                                <div class="col-md-8 mx-auto">
                                    <div class="alert alert-info">
                                        <i class="bi bi-info-circle-fill me-2"></i>
                                        Please enable location access to check in/out.
                                    </div>

                                    <div class="card shadow-sm mb-4">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="latitude" class="form-label fw-bold">Latitude</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i
                                                                    class="bi bi-geo-alt"></i></span>
                                                            <input type="text" class="form-control" id="latitude"
                                                                name="latitude" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="longitude"
                                                            class="form-label fw-bold">Longitude</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i
                                                                    class="bi bi-geo-alt"></i></span>
                                                            <input type="text" class="form-control" id="longitude"
                                                                name="longitude" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-4">
                                                <div class="map-container rounded"
                                                    style="height: 300px; overflow: hidden;">
                                                    <iframe width="100%" height="100%" id="map" frameborder="0"
                                                        style="border:0"></iframe>
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-center">
                                                <button type="submit" class="btn btn-primary" id="present">
                                                    <i class="bi bi-check-circle me-2"></i> Check In
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @endif
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

        .map-container {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .shadow-sm {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const iframe = document.getElementById('map');
            const presentBtn = document.getElementById('present');
            const officeLat = -6.226143123906864; // Replace with your office coordinates
            const officeLong = 106.80971205059875;
            const threshold = 0.01; // ~1.1 km

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const userLat = position.coords.latitude;
                        const userLong = position.coords.longitude;

                        document.getElementById('latitude').value = userLat;
                        document.getElementById('longitude').value = userLong;

                        iframe.src = `https://maps.google.com/maps?q=${userLat},${userLong}&z=17&output=embed`;

                        // Calculate distance
                        const R = 6371;
                        const dLat = (userLat - officeLat) * (Math.PI / 180);
                        const dLon = (userLong - officeLong) * (Math.PI / 180);
                        const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                            Math.cos(officeLat * (Math.PI / 180)) *
                            Math.cos(userLat * (Math.PI / 180)) *
                            Math.sin(dLon / 2) * Math.sin(dLon / 2);
                        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                        const distance = R * c;

                        if (distance <= threshold) {
                            presentBtn.disabled = false;
                            presentBtn.innerHTML = '<i class="bi bi-check-circle me-2"></i> Check In';
                        } else {
                            presentBtn.disabled = true;
                            presentBtn.innerHTML =
                                `<i class="bi bi-x-circle me-2"></i> Too Far (${distance.toFixed(2)} km)`;
                        }
                    },
                    function(error) {
                        console.error("Error getting location: ", error);
                        presentBtn.disabled = true;
                        presentBtn.innerHTML =
                            '<i class="bi bi-exclamation-triangle me-2"></i> Location Required';
                    }
                );
            } else {
                presentBtn.disabled = true;
                presentBtn.innerHTML = '<i class="bi bi-exclamation-triangle me-2"></i> Browser Not Supported';
            }
        });
    </script>
@endsection
