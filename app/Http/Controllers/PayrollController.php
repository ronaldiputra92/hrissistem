<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payroll;
use App\Models\Employee;

class PayrollController extends Controller
{
    public function index()
    {
        if (session('role') == 'HR') {
            $payrolls = Payroll::all();
        } else {
            $payrolls = Payroll::where('employee_id', session('employee_id'))->get();
        }
        return view('payrolls.index', compact('payrolls'));
    }

    public function create()
    {
        $employees = Employee::all();
        return view('payrolls.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'salary' => 'required|numeric|min:0',
            'bonuses' => 'nullable|numeric|min:0',
            'deductions' => 'nullable|numeric|min:0',
            'net_salary' => 'nullable|numeric|min:0',
            'pay_date' => 'required|date',
        ]);

        //  kalkulasi net salary yang sudah dijumlahkan dengan bonus dan dikurangi potongan
        if ($request->bonuses && $request->deductions) {
            $request->merge([
                'net_salary' => $request->salary + $request->bonuses - $request->deductions,
            ]);
        } elseif ($request->bonuses) {
            $request->merge([
                'net_salary' => $request->salary + $request->bonuses,
            ]);
        } elseif ($request->deductions) {
            $request->merge([
                'net_salary' => $request->salary - $request->deductions,
            ]);
        } else {
            $request->merge([
                'net_salary' => $request->salary,
            ]);
        }

        Payroll::create($request->all());

        return redirect()->route('payrolls.index')->with('success', 'Payroll created successfully.');
    }

    public function edit(Payroll $payroll)
    {
        $employees = Employee::all();
        return view('payrolls.edit', compact('payroll', 'employees'));
    }

    public function update(Request $request, Payroll $payroll)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'salary' => 'required|numeric|min:0',
            'bonuses' => 'nullable|numeric|min:0',
            'deductions' => 'nullable|numeric|min:0',
            'net_salary' => 'nullable|numeric|min:0',
            'pay_date' => 'required|date',
        ]);

        //  kalkulasi net salary yang sudah dijumlahkan dengan bonus dan dikurangi potongan
        if ($request->bonuses && $request->deductions) {
            $request->merge([
                'net_salary' => $request->salary + $request->bonuses - $request->deductions,
            ]);
        } elseif ($request->bonuses) {
            $request->merge([
                'net_salary' => $request->salary + $request->bonuses,
            ]);
        } elseif ($request->deductions) {
            $request->merge([
                'net_salary' => $request->salary - $request->deductions,
            ]);
        } else {
            $request->merge([
                'net_salary' => $request->salary,
            ]);
        }

        $payroll = Payroll::findOrFail($payroll->id);
        $payroll->update($request->all());

        return redirect()->route('payrolls.index')->with('success', 'Payroll updated successfully.');
    }

    public function show(Payroll $payroll)
    {
        return view('payrolls.show', compact('payroll'));
    }

    public function destroy(Payroll $payroll)
    {
        $payroll->delete();
        return redirect()->route('payrolls.index')->with('success', 'Payroll deleted successfully.');
    }
}
