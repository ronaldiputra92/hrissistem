<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Presence;
use App\Models\Employee;
use Carbon\Carbon;

class PresenceController extends Controller
{
    public function index()
    {
        if (session('role') == 'HR') {
            $presences = Presence::all();
        } else {
            $presences = Presence::where('employee_id', session('employee_id'))->get();
        }
        return view('presences.index', compact('presences'));
    }

    public function create()
    {
        $employees = Employee::all();
        return view('presences.create', compact('employees'));
    }

    public function store(Request $request)
    {
        if (session('role') == 'HR') {
            $request->validate([
                'employee_id' => 'required|exists:employees,id',
                'check_in' => 'nullable|date',
                'check_out' => 'nullable|date',
                'date' => 'required|date',
                'status' => 'required|string|max:255',
            ]);
            Presence::create($request->all());
        } else {
            Presence::create([
                'employee_id' => session('employee_id'),
                'check_in' => Carbon::now()->format('Y-m-d H:i:s'),
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'date' => Carbon::now()->format('Y-m-d'),
                'status' => 'present',
            ]);
        }

        return redirect()->route('presences.index')->with('success', 'Presence recorded successfully.');
    }

    // edit
    public function edit($id)
    {
        $presence = Presence::findOrFail($id);
        $employees = Employee::all();
        return view('presences.edit', compact('presence', 'employees'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'check_in' => 'nullable|date',
            'check_out' => 'nullable|date',
            'date' => 'required|date',
            'status' => 'required|string|max:255',
        ]);

        $presence = Presence::findOrFail($id);
        $presence->update($request->all());

        return redirect()->route('presences.index')->with('success', 'Presence updated successfully.');
    }

    public function destroy($id)
    {
        Presence::findOrFail($id)->delete();
        return redirect()->route('presences.index')->with('success', 'Presence deleted successfully.');
    }
}
