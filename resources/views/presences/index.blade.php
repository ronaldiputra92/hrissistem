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
                <h3><i class="bi bi-calendar-check"></i> Presences</h3>
                <p class="text-subtitle text-muted">Manage employee attendance records</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Presences</li>
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
                        <i class="bi bi-list-ul me-2"></i>Attendance Records
                    </h4>
                    <span class="badge bg-light text-primary fs-6">
                        Total: {{ $presences->count() }} Employees
                    </span>
                </div>
            </div>

            <div class="card-body">
                @if (session('success'))
                <div id="success-alert" class="alert alert-success alert-dismissible fade show mt-2">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <div class="d-flex justify-content-end mb-3 mt-3">
                    <a href="{{ route('presences.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>New Presence
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover" id="table1">
                        <thead class="table-light">
                            <tr>
                                <th>Employee</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                                <th>Date</th>
                                <th>Status</th>
                                @if (session('role') == 'HR')
                                <th class="text-end">Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($presences as $presence)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-3">
                                            <span class="avatar-initial rounded-circle bg-primary text-white">
                                                {{ strtoupper(substr($presence->employee->full_name, 0, 1)) }}
                                            </span>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $presence->employee->full_name }}</h6>
                                            <small class="text-muted">ID: {{ $presence->employee->id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-nowrap">{{ $presence->check_in ? date('H:i', strtotime($presence->check_in)) : '-' }}</td>
                                <td class="text-nowrap">{{ $presence->check_out ? date('H:i', strtotime($presence->check_out)) : '-' }}</td>
                                <td class="text-nowrap">{{ date('d M Y', strtotime($presence->date)) }}</td>
                                <td>
                                    @if ($presence->status == 'present')
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle me-1"></i>Present
                                    </span>
                                    @else
                                    <span class="badge bg-danger">
                                        <i class="bi bi-x-circle me-1"></i>{{ ucfirst($presence->status) }}
                                    </span>
                                    @endif
                                </td>
                                @if (session('role') == 'HR')
                                <td class="text-end">
                                    <div class="btn-group gap-2" role="group">
                                        <a href="{{ route('presences.edit', $presence->id) }}"
                                           class="btn btn-sm btn-outline-warning" data-bs-toggle="tooltip" title="Edit">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        <form action="{{ route('presences.destroy', $presence->id) }}" method="POST"
                                              class="d-inline" onsubmit="return confirm('Delete this presence record?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Delete">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    .card {
        border-radius: 10px;
        border: none;
        overflow: hidden;
    }

    .card-header {
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }

    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
    }

    .avatar {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .avatar-initial {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
    }

    .badge {
        padding: 0.35em 0.65em;
        font-weight: 500;
    }

    .btn-group .btn {
        padding: 0.25rem 0.5rem;
        border-radius: 4px !important;
    }

    .search-bar {
        width: 300px;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(115, 103, 240, 0.05);
    }

    .text-nowrap {
        white-space: nowrap;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Auto-dismiss alert
        let successAlert = document.getElementById("success-alert");
        if (successAlert) {
            setTimeout(() => {
                successAlert.style.transition = "opacity 0.5s";
                successAlert.style.opacity = "0";
                setTimeout(() => successAlert.remove(), 500);
            }, 5000);
        }

        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Search functionality
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                const filter = this.value.toLowerCase();
                const rows = document.querySelectorAll('#table1 tbody tr');

                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(filter) ? '' : 'none';
                });
            });
        }
    });
</script>
@endsection
