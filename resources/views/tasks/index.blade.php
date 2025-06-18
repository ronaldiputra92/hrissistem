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
                <h3>Task Management</h3>
                <p class="text-subtitle text-muted">Efficiently manage and track employee tasks</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tasks</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="card-title fw-bold mb-0 text-white">
                       <i class="bi bi-clipboard-plus fs-4 mb-2"></i> All Records
                    </div>
                    <div class="card-title fw-bold mb-0 text-white">
                        <span class="badge bg-white text-primary fs-6">
                            Total: {{ $tasks->count() }} Tasks
                        </span>
                    </div>
                </div>
            </div>

            <div class="card-body">
                {{-- @if (session('role') == 'HR') --}}
                  <div class="d-flex justify-content-end">
                      <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-sm mt-3 mb-2">
                        <i class="bi bi-plus-circle me-1"></i> New Task
                    </a>
                  </div>
                    {{-- @endif --}}
                @if (session('success'))
                <div id="success-alert" class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-hover" id="table1">
                        <thead class="table-light">
                            <tr>
                            <th class="fw-semibold">Task Title</th>
                            <th class="fw-semibold">Assigned To</th>
                            <th class="fw-semibold">Due Date</th>
                            <th class="fw-semibold">Status</th>
                            <th class="fw-semibold text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tasks as $task)
                            <tr class="align-middle">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-card-checklist me-2 text-primary"></i>
                                        <span class="fw-medium">{{ $task->title }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm me-2">
                                            <img src="https://ui-avatars.com/api/?name={{ $task->employee->full_name }}&background=random" class="rounded-circle">
                                        </div>
                                        <span>{{ $task->employee->full_name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-nowrap {{ $task->due_date < now() && $task->status != 'done' ? 'text-danger' : '' }}">
                                        {{ $task->due_date->format('M d, Y') }}
                                    </span>
                                </td>
                                <td>
                                    @if ($task->status == 'pending')
                                    {{-- <span class="badge rounded-pill bg-warning-soft text-warning"> --}}
                                    <span class="badge bg-warning">
                                        <i class="bi bi-clock-history me-1"></i> Pending
                                    </span>
                                    @elseif ($task->status == 'done')
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle me-1"></i> Done
                                    </span>
                                    @elseif ($task->status == 'rejected')
                                    <span class="badge bg-danger">
                                        <i class="bi bi-x-circle me-1"></i> Rejected
                                    </span>
                                    @else
                                    <span class="badge rounded-pill bg-secondary-soft text-secondary text-capitalize">
                                        {{ $task->status }}
                                    </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-sm btn-outline-info" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @if (session('role') == 'HR')
                                        @if ($task->status == 'pending')
                                        <a href="{{ route('tasks.done', $task->id) }}" class="btn btn-sm btn-outline-success" title="Mark as Done">
                                            <i class="bi bi-check-lg"></i>
                                        </a>
                                        <a href="{{ route('tasks.rejected', $task->id) }}" class="btn btn-sm btn-outline-danger" title="Reject">
                                            <i class="bi bi-x-lg"></i>
                                        </a>
                                        @elseif ($task->status == 'done')
                                        <a href="{{ route('tasks.pending', $task->id) }}" class="btn btn-sm btn-outline-warning" title="Pending">
                                            <i class="bi bi-arrow-counterclockwise"></i>
                                        </a>
                                        @elseif ($task->status == 'rejected')
                                        <a href="{{ route('tasks.pending', $task->id) }}" class="btn btn-sm btn-outline-warning" title="Pending">
                                            <i class="bi bi-arrow-counterclockwise"></i>
                                        </a>
                                        @endif

                                        <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this task?');">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="bi bi-inbox text-muted" style="font-size: 2.5rem;"></i>
                                        <p class="text-muted mt-2 mb-0">No tasks found</p>
                                        @if (session('role') == 'HR')
                                        <a href="{{ route('tasks.create') }}" class="btn btn-sm btn-primary mt-3 rounded-pill">
                                            <i class="bi bi-plus-circle me-1"></i> Create New Task
                                        </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                @if ($tasks->hasPages())
                <div class="d-flex justify-content-end align-items-center mt-3">
                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-sm mb-0">
                            {{-- Previous Page Link --}}
                            @if ($tasks->onFirstPage())
                            <li class="page-item disabled" aria-disabled="true">
                                <span class="page-link">&laquo;</span>
                            </li>
                            @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $tasks->previousPageUrl() }}" rel="prev">&laquo;</a>
                            </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($tasks->getUrlRange(1, $tasks->lastPage()) as $page => $url)
                            @if ($page == $tasks->currentPage())
                            <li class="page-item active" aria-current="page">
                                <span class="page-link">{{ $page }}</span>
                            </li>
                            @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                            @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($tasks->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $tasks->nextPageUrl() }}" rel="next">&raquo;</a>
                            </li>
                            @else
                            <li class="page-item disabled" aria-disabled="true">
                                <span class="page-link">&raquo;</span>
                            </li>
                            @endif
                        </ul>
                    </nav>
                </div>
                @endif
            </div>
        </div>
    </section>
</div>

@push('styles')
<style>
    .card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }

    .card-header {
        border-bottom: 1px solid rgba(0,0,0,0.05);
        padding: 1.25rem 1.5rem;
    }

    .table {
        --bs-table-striped-bg: rgba(241, 243, 249, 0.5);
    }

    .table th {
        border-bottom-width: 1px;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        color: #6c757d;
    }

    .avatar {
        width: 32px;
        height: 32px;
    }

    .badge {
        font-weight: 500;
        padding: 0.35em 0.65em;
    }

    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }

    .text-primary-soft {
        color: rgba(13, 110, 253, 0.2);
    }

    .bg-primary-soft {
        background-color: rgba(13, 110, 253, 0.1);
    }

    .bg-warning-soft {
        background-color: rgba(255, 193, 7, 0.1);
    }

    .bg-success-soft {
        background-color: rgba(25, 135, 84, 0.1);
    }

    .bg-danger-soft {
        background-color: rgba(220, 53, 69, 0.1);
    }

    .bg-secondary-soft {
        background-color: rgba(108, 117, 125, 0.1);
    }
</style>
@endpush

<script>
    // Pindahkan fungsi-fungsi ke level global
    function initializeSearch() {
        const searchInput = document.getElementById('searchInput');
        let searchTimer;

        function performSearch() {
            const searchTerm = searchInput.value.trim();
            const url = new URL(window.location.href);
            const params = new URLSearchParams();

            if (searchTerm) {
                params.append('search', searchTerm);
            }

            // Show loading indicator hanya pada tabel
            const tableContainer = document.querySelector('.table-responsive');
            const originalTable = tableContainer.innerHTML;
            const paginationContainer = document.querySelector('.d-flex.justify-content-between.align-items-center.mt-3');
            const originalPagination = paginationContainer ? paginationContainer.innerHTML : '';

            tableContainer.innerHTML = `
                <div class="d-flex justify-content-center align-items-center" style="height: 200px;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            `;

            fetch(`${url.pathname}?${params.toString()}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                if (data.html) {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(data.html, 'text/html');

                    // Update hanya bagian yang diperlukan
                    const newTable = doc.querySelector('.table-responsive');
                    const newPagination = doc.querySelector('.d-flex.justify-content-between.align-items-center.mt-3');
                    const newShowingText = doc.querySelector('.card-title span');

                    if (newTable) {
                        tableContainer.innerHTML = newTable.innerHTML;
                    }

                    if (newPagination && paginationContainer) {
                        paginationContainer.innerHTML = newPagination.innerHTML;
                    }

                    if (newShowingText) {
                        document.querySelector('.card-title span').innerHTML = newShowingText.innerHTML;
                    }

                    // Re-initialize semua event listeners setelah konten diupdate
                    initializeAll();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                tableContainer.innerHTML = originalTable;
                if (paginationContainer) {
                    paginationContainer.innerHTML = originalPagination;
                }
            });
        }

        // Hapus event listener lama jika ada
        searchInput.removeEventListener('input', handleInput);
        searchInput.removeEventListener('keypress', handleKeypress);

        // Buat handler baru
        function handleInput() {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(performSearch, 500);
        }

        function handleKeypress(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                clearTimeout(searchTimer);
                performSearch();
            }
        }

        // Pasang event listener baru
        searchInput.addEventListener('input', handleInput);
        searchInput.addEventListener('keypress', handleKeypress);
    }

    function initializeAlert() {
        const successAlert = document.getElementById('success-alert');
        if (successAlert) {
            setTimeout(() => {
                successAlert.style.transition = "opacity 0.5s ease";
                successAlert.style.opacity = "0";
                setTimeout(() => successAlert.remove(), 500);
            }, 5000);
        }
    }

    function initializeAll() {
        initializeAlert();
        initializeSearch();
    }
    // Inisialisasi pertama kali
    document.addEventListener("DOMContentLoaded", initializeAll);
</script>

@endsection
