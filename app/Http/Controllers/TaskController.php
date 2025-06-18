<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Employee;

class TaskController extends Controller
{
    public function index()
    {
        $search = request('search');

        if (session('role') == 'HR') {
            $query = Task::with('employee')->latest();
        } else {
            $query = Task::where('assigned_to', session('employee_id'))->latest();
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhere('status', 'like', '%' . $search . '%');

                if (session('role') == 'HR') {
                    $q->orWhereHas('employee', function ($q) use ($search) {
                        $q->where('full_name', 'like', '%' . $search . '%');
                    });
                }
            });
        }

        $tasks = $query->paginate(5);

        // Jika request AJAX, kembalikan JSON dengan HTML
        if (request()->ajax()) {
            return response()->json([
                'html' => view('tasks.index', compact('tasks'))->render()
            ]);
        }

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        if (session('role') == 'HR') {
            $employees = Employee::all();
        } else {
            $employees = Employee::where('id', session('employee_id'))->get();
        }

        return view('tasks.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'required',
            'due_date' => 'required|date',
            'status' => 'required|string',
        ]);

        // Jika berhasil divalidasi, simpan data task
        Task::create($validated);

        return redirect()->route('tasks.index')->with('success', 'Data berhasil disimpan.');
    }

    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $employees = Employee::all();

        return view('tasks.edit', compact('task', 'employees'));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'required',
            'due_date' => 'required|date',
            'status' => 'required|string',
        ]);

        // Jika berhasil divalidasi, update data task
        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'Data berhasil diupdate.');
    }

    public function done(int $id)
    {
        $task = Task::find($id);
        $task->update(['status' => 'done']);

        return redirect()->route('tasks.index')->with('success', 'Task marked as done.');
    }

    public function pending(int $id)
    {
        $task = Task::find($id);
        $task->update(['status' => 'pending']);

        return redirect()->route('tasks.index')->with('success', 'Task marked as pending.');
    }

    public function rejected(int $id)
    {
        $task = Task::find($id);
        $task->update(['status' => 'rejected']);

        return redirect()->route('tasks.index')->with('success', 'Task marked as rejected.');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Data berhasil dihapus.');
    }
}
