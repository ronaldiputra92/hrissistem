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
                <h3>Create New Task</h3>
                <p class="text-subtitle text-muted">Assign and manage work tasks for employees</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('tasks.index') }}">Tasks</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="card-title text-white mb-0">Task Information</h4>
                    {{-- <i class="bi bi-clipboard-plus fs-4 mb-3"></i> --}}
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('tasks.store') }}" method="POST" class="form form-horizontal">
                    @csrf

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label for="title" class="form-label fw-bold">Task Title</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-card-heading"></i></span>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                           id="title" name="title" placeholder="Enter task title" required>
                                    @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="text-muted">A clear, concise title for the task</small>
                            </div>

                            <div class="form-group mb-4">
                                <label for="employee_id" class="form-label fw-bold">Assign To</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                                    <select class="form-select @error('assigned_to') is-invalid @enderror"
                                            name="assigned_to" required>
                                        <option value="">Select Employee</option>
                                        @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->full_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('assigned_to')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="text-muted">Select the responsible employee</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label for="due_date" class="form-label fw-bold">Due Date</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
                                    <input type="datetime-local"
                                           class="form-control @error('due_date') is-invalid @enderror"
                                           id="due_date" name="due_date" value="{{ old('due_date') }}" required>
                                    @error('due_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="text-muted">Set the deadline for this task</small>
                            </div>

                            <div class="form-group mb-4">
                                <label for="status" class="form-label fw-bold">Status</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-list-check"></i></span>
                                    <select class="form-select @error('status') is-invalid @enderror"
                                            id="status" name="status" required>
                                        <option value="">Select Status</option>
                                        <option value="pending">Pending</option>
                                    </select>
                                    @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="text-muted">Initial task status</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label for="description" class="form-label fw-bold">Task Description</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="5"
                                      placeholder="Provide detailed task description" required>{{ old('description') }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="text-muted">Be specific about task requirements</small>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-5">
                        <a href="{{ route('tasks.index') }}" class="btn btn-light-danger">
                            <i class="bi bi-x-circle me-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Create Task
                        </button>
                    </div>
                </form>
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

    .form-control, .form-select {
        border-radius: 8px;
        padding: 10px 15px;
        box-shadow: none;
        border: 1px solid #e0e0e0;
        transition: all 0.3s;
    }

    .form-control:focus, .form-select:focus {
        border-color: #7367f0;
        box-shadow: 0 0 0 3px rgba(115, 103, 240, 0.1);
    }

    .input-group-text {
        background-color: #f8f9fa;
        border-right: none;
    }

    .form-control {
        border-left: none;
    }

    .btn {
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 500;
        transition: all 0.3s;
    }

    textarea {
        min-height: 120px;
        resize: vertical;
    }
</style>

@endsection
