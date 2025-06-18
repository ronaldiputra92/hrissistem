@extends('layouts.dashboard')

@section('content')
<header class="mb-4">
    <a href="#" class="burger-btn d-block d-xl-none">
        <i class="bi bi-justify fs-3"></i>
    </a>
</header>

<div class="page-heading mb-4">
    <h3 class="fw-bold">Dashboard Overview</h3>
    <p class="text-muted">Welcome back! Here's what's happening today.</p>
</div>

<div class="page-content">
    <!-- Stats Cards Section -->
    <div class="row mb-4">
        <div class="col-6 col-lg-3 col-md-6 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body px-4 py-4-5">
                    <div class="row align-items-center">
                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                            <div class="stats-icon purple mb-2 rounded-circle p-3">
                                <i class="icon dripicons dripicons-briefcase fs-4"></i>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                            <h6 class="text-muted font-semibold mb-1">Departments</h6>
                            <h3 class="font-extrabold mb-0">{{ $departments }}</h3>
                            <small class="text-success"><i class="bi bi-arrow-up"></i> 5.2% from last month</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3 col-md-6 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body px-4 py-4-5">
                    <div class="row align-items-center">
                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                            <div class="stats-icon blue mb-2 rounded-circle p-3">
                                <i class="icon dripicons dripicons-user fs-4"></i>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                            <h6 class="text-muted font-semibold mb-1">Employees</h6>
                            <h3 class="font-extrabold mb-0">{{ $employees }}</h3>
                            <small class="text-success"><i class="bi bi-arrow-up"></i> 3.1% from last month</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3 col-md-6 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body px-4 py-4-5">
                    <div class="row align-items-center">
                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                            <div class="stats-icon green mb-2 rounded-circle p-3">
                                <i class="icon dripicons dripicons-alarm fs-4"></i>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                            <h6 class="text-muted font-semibold mb-1">Today's Presence</h6>
                            <h3 class="font-extrabold mb-0">{{ $presences }}</h3>
                            <small class="text-muted">{{ now()->format('l, F j') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3 col-md-6 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body px-4 py-4-5">
                    <div class="row align-items-center">
                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                            <div class="stats-icon red mb-2 rounded-circle p-3">
                                <i class="icon dripicons dripicons-wallet fs-4"></i>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                            <h6 class="text-muted font-semibold mb-1">Payroll Processed</h6>
                            <h3 class="font-extrabold mb-0">{{ $payrolls }}</h3>
                            <small class="text-muted">This month</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Data Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header border-0">
                    <h4 class="fw-bold">Weekly Presence Overview</h4>
                    <p class="text-muted mb-0">Employee attendance this week</p>
                </div>
                <div class="card-body">
                    <canvas id="presence" height="175"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Tasks Section -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header border-bottom border-0 d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="fw-bold mb-0">Recent Tasks</h4>
                        <p class="text-muted mb-0">Showing 5 of {{ $tasks->total() }} tasks</p>
                    </div>
                    <a href="{{ route('tasks.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-lg">
                            <thead class="table-light">
                                <tr>
                                    <th>Employee</th>
                                    <th>Task Details</th>
                                    <th>Status</th>
                                    <th>Due Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tasks as $task)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-md me-3">
                                                <img src="https://ui-avatars.com/api/?name={{$task->employee->full_name}}&color=7F9CF5&background=EBF4FF" class="rounded-circle">
                                            </div>
                                            <div>
                                                <p class="font-bold mb-0">{{$task->employee->full_name}}</p>
                                                <small class="text-muted">{{$task->employee->department->name ?? 'N/A'}}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="mb-0 fw-semibold">{{$task->title}}</p>
                                        <small class="text-muted">{{ Str::limit($task->description, 50) }}</small>
                                    </td>
                                    <td>
                                        @if($task->status == 'done')
                                            <span class="badge bg-success">{{ucfirst($task->status)}}</span>
                                        @elseif($task->status == 'pending')
                                            <span class="badge bg-warning text-dark">{{ucfirst($task->status)}}</span>
                                        @else
                                            <span class="badge bg-danger">{{ucfirst($task->status)}}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $task->due_date ? $task->due_date->format('M d, Y') : 'No due date' }}</small>
                                    </td>
                                </tr>

                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">No tasks found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($tasks->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        <nav aria-label="Tasks pagination">
                            <ul class="pagination">
                                @if($tasks->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">Previous</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $tasks->previousPageUrl() }}" rel="prev">Previous</a>
                                    </li>
                                @endif

                                @foreach(range(1, $tasks->lastPage()) as $i)
                                    @if($i == $tasks->currentPage())
                                        <li class="page-item active">
                                            <span class="page-link">{{ $i }}</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $tasks->url($i) }}">{{ $i }}</a>
                                        </li>
                                    @endif
                                @endforeach

                                @if($tasks->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $tasks->nextPageUrl() }}" rel="next">Next</a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link">Next</span>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .stats-icon {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .stats-icon.purple {
        background-color: #f3e8ff;
        color: #9333ea;
    }
    .stats-icon.blue {
        background-color: #e0f2fe;
        color: #0369a1;
    }
    .stats-icon.green {
        background-color: #dcfce7;
        color: #16a34a;
    }
    .stats-icon.red {
        background-color: #fee2e2;
        color: #dc2626;
    }
    .card {
        border-radius: 12px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .avatar img {
        object-fit: cover;
    }
    .badge {
        font-weight: 500;
        padding: 5px 10px;
        border-radius: 6px;
    }
    .pagination .page-item.active .page-link {
        background-color: #6366f1;
        border-color: #6366f1;
    }
    .pagination .page-link {
        color: #6366f1;
    }
</style>
@endpush
