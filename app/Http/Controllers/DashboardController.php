<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Payroll;
use App\Models\Presence;
use App\Models\Task;

class DashboardController extends Controller
{
    public function index()
    {
        $employees = Employee::count();
        $departments = Department::count();
        $payrolls = Payroll::count();
        $presences = Presence::count();

        // $tasks = Task::all();
        $tasks = Task::with('employee.department')->latest()->paginate(4);


        return view('dashboard.index', compact('employees', 'departments', 'payrolls', 'presences', 'tasks'));
    }

    public function presence()
    {
        $data = Presence::where('status', 'present')
            ->selectRaw('MONTH(date) as month, YEAR(date) as year, COUNT(*) as total_present')
            ->groupBy('year', 'month')
            ->orderBy('month', 'asc')
            ->get();

        $temp = [];
        $i = 0;

        foreach ($data as $item) {
            $temp[$i] = $item->total_present;
            $i++;
        }

        return response()->json($temp);
    }
}
