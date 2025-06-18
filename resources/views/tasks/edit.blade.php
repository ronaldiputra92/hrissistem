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
                <h3>Task Management</h3> {{-- More descriptive title --}}
                <p class="text-subtitle text-muted">Manage and update employee tasks efficiently.</p> {{-- Refined subtitle --}}
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('tasks.index') }}">Tasks</a></li> {{-- Link to index --}}
                        <li class="breadcrumb-item active" aria-current="page">Edit Task</li> {{-- Changed to Edit Task --}}
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card shadow-lg border-0 rounded-4"> {{-- Added larger shadow, no border, and rounded corners for a softer, premium look --}}
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center rounded-top-4 py-3 px-4"> {{-- Gradient background, more padding, rounded top --}}
                <h5 class="card-title mb-0 fs-5"> {{-- Slightly larger font size for title --}}
                    <i class="bi bi-pencil-square me-2"></i> Edit Task Details
                </h5>
            </div>
            <div class="card-body p-4"> {{-- More padding inside the card body --}}
                @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>Error:</strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-octagon-fill me-2"></i>
                    <strong>Validation Errors:</strong> Please correct the following issues.
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row g-3"> {{-- Use row with gutter for spacing between columns --}}
                        <div class="col-md-12"> {{-- Full width for title --}}
                            <div class="mb-3">
                                <label for="title" class="form-label fw-bold text-muted">Task Title</label> {{-- Bold label, darker text --}}
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" value="{{ old('title', $task->title) }}" name="title" placeholder="Enter task title" required> {{-- Larger input, placeholder --}}
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="employee_id" class="form-label fw-bold text-muted">Assigned Employee</label> {{-- Bold label, clearer text --}}
                                <select class="form-select @error('assigned_to') is-invalid @enderror" name="assigned_to" required> {{-- Use assigned_to for consistency with error --}}
                                    <option value="">-- Select Employee --</option>
                                    @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}" {{ old('assigned_to', $task->assigned_to) == $employee->id ? 'selected' : '' }}>{{ $employee->full_name }}</option>
                                    @endforeach
                                </select>
                                @error('assigned_to')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="due_date" class="form-label fw-bold text-muted">Due Date</label>
                                <input type="datetime-local" class="form-control @error('due_date') is-invalid @enderror" id="due_date" name="due_date" value="{{ old('due_date', \Carbon\Carbon::parse($task->due_date)->format('Y-m-d\TH:i')) }}" required> {{-- Format Carbon date for datetime-local --}}
                                @error('due_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12"> {{-- Full width for status --}}
                            <div class="mb-3">
                                <label for="status" class="form-label fw-bold text-muted">Status</label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="">-- Select Status --</option>
                                    <option value="pending" {{ old('status', $task->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="done" {{ old('status', $task->status) == 'done' ? 'selected' : '' }}>Done</option>
                                    <option value="rejected" {{ old('status', $task->status) == 'rejected' ? 'selected' : '' }}>Rejected</option> {{-- Corrected 'reject' to 'rejected' for consistency --}}
                                </select>
                                @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12"> {{-- Full width for description --}}
                            <div class="mb-3">
                                <label for="description" class="form-label fw-bold text-muted">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5" placeholder="Provide a detailed description for the task" required>{{ old('description', $task->description) }}</textarea> {{-- Larger textarea, placeholder, increased rows --}}
                                @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <hr class="my-4"> {{-- Separator for buttons --}}
                    <div class="d-flex justify-content-end gap-1"> {{-- Use gap for spacing between buttons --}}
                        <button type="submit" class="btn btn-primary px-2 d-flex align-items-center">
                            <i class="bi bi-check-circle me-1 mb-2"></i> Update Task
                        </button>
                        <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary px-2 d-flex align-items-center">
                            <i class="bi bi-x-circle me-2 mb-2"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

{{-- Optional: Add custom CSS for gradient background if not already in your dashboard layout --}}
@push('styles')

@endpush

@endsection



