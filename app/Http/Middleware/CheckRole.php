<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Employee;



class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
   public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        // Pastikan user dan employee_id tersedia
        if (!$user || !$user->employee_id) {
            abort(403, 'Unauthorized: User or employee ID not found.');
        }

        // Ambil data employee dan relasi role-nya
        $employee = Employee::with('role')->find($user->employee_id);

        // Pastikan employee dan role ditemukan
        if (!$employee || !$employee->role) {
            abort(403, 'Unauthorized: Employee or role not found.');
        }

        // Simpan data ke session
        $request->session()->put('role', $employee->role->title);
        $request->session()->put('employee_id', $employee->id);

        // Cek apakah role sesuai dengan yang diizinkan
        if (!in_array($employee->role->title, $roles)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
