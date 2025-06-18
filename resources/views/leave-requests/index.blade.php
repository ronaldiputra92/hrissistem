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
                <h3>Leave Requests</h3>
                <p class="text-subtitle text-muted">Manage employee leave applications</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Leave Requests</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header bg-primary text-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="card-title text-white mb-0">
                        <i class="bi bi-list-ul me-2"></i>Leave Request Records
                    </h4>
                    <span class="badge bg-light text-primary fs-6">
                        Total: {{ $leaveRequests->count() }} Employees
                    </span>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-end align-items-center mb-3 me-2 mt-3">
                    <a href="{{ route('leave-requests.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> New Request
                    </a>
                </div>

                @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" id="alert" role="alert">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover" id="table1">
                        <thead class="table-light">
                            <tr>
                                <th>Employee</th>
                                <th>Leave Type</th>
                                <th>Date Range</th>
                                <th>Duration</th>
                                <th>Status</th>
                                @if (session('role') == 'HR')
                                <th class="text-end">Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($leaveRequests as $leaveRequest)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-md me-3">
                                            <span class="avatar-content bg-primary text-white">
                                                {{ substr($leaveRequest->employee->full_name, 0, 1) }}
                                            </span>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $leaveRequest->employee->full_name }}</h6>
                                            <small class="text-muted">{{ $leaveRequest->employee->employee_id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light-primary text-primary">
                                        {{ ucfirst($leaveRequest->leave_type) }}
                                    </span>
                                </td>
                                <td>
                                    {{ date('M d, Y', strtotime($leaveRequest->start_date)) }} -
                                    {{ date('M d, Y', strtotime($leaveRequest->end_date)) }}
                                </td>
                                <td>
                                    @php
                                        $start = new DateTime($leaveRequest->start_date);
                                        $end = new DateTime($leaveRequest->end_date);
                                        $duration = $start->diff($end)->days + 1;
                                    @endphp
                                    {{ $duration }} day{{ $duration > 1 ? 's' : '' }}
                                </td>
                                <td>
                                    @if ($leaveRequest->status === 'pending')
                                    <span class="badge bg-warning text-dark">
                                        <i class="bi bi-hourglass-split"></i> Pending
                                    </span>
                                    @elseif ($leaveRequest->status === 'confirm')
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle"></i> Approved
                                    </span>
                                    @elseif ($leaveRequest->status === 'reject')
                                    <span class="badge bg-danger">
                                        <i class="bi bi-x-circle"></i> Rejected
                                    </span>
                                    @endif
                                </td>
                                @if (session('role') == 'HR')
                                <td class="text-end">
                                    <div class="btn-group gap-2" role="group">
                                        @if ($leaveRequest->status !== 'confirm')
                                        <a href="{{ route('leave-requests.confirm', $leaveRequest->id) }}"
                                           class="btn btn-sm btn-outline-success" data-bs-toggle="tooltip" title="Approve">
                                            <i class="bi bi-check-lg"></i>
                                        </a>
                                        @endif
                                        @if ($leaveRequest->status !== 'reject')
                                        <a href="{{ route('leave-requests.reject', $leaveRequest->id) }}"
                                           class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Reject">
                                            <i class="bi bi-x-lg"></i>
                                        </a>
                                        @endif
                                        <a href="{{ route('leave-requests.edit', $leaveRequest->id) }}"
                                           class="btn btn-sm btn-outline-warning" data-bs-toggle="tooltip" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('leave-requests.destroy', $leaveRequest->id) }}"
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    data-bs-toggle="tooltip" title="Delete"
                                                    onclick="return confirm('Are you sure you want to delete this leave request?')">
                                                <i class="bi bi-trash"></i>
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Search functionality
        const searchInput = document.getElementById('searchInput');
        const table = document.getElementById('leaveTable');
        const rows = table.getElementsByTagName('tr');

        searchInput.addEventListener('keyup', function() {
            const searchValue = this.value.toLowerCase();

            for (let i = 1; i < rows.length; i++) {
                const rowText = rows[i].textContent.toLowerCase();
                rows[i].style.display = rowText.includes(searchValue) ? '' : 'none';
            }
        });
    });
</script>

<script>
    //alert menghilang setelah 5 detik
    setTimeout(function() {
        var alert = document.getElementById('alert');
        if (alert) {
            alert.style.display = 'none';
        }
    }, 5000);
</script>
@endsection
