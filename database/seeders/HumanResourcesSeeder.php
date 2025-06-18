<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class HumanResourcesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        DB::table('departments')->insert([
            ['name' => 'Department of Human Resources', 'description' => 'Human Resources', 'status' => 'active', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Department of Finance', 'description' => 'Finance', 'status' => 'active', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Department of IT', 'description' => 'Information Technology', 'status' => 'active', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);

        DB::table('roles')->insert([
            ['title' => 'HR Manager', 'description' => 'Manages HR operations', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['title' => 'Finance Officer', 'description' => 'Handles financial transactions', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['title' => 'IT Support', 'description' => 'Provides IT support', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);

        DB::table('employees')->insert([
            [
                'full_name' => $faker->name,
                'email' =>  $faker->unique()->safeEmail,
                'phone_number' => $faker->phoneNumber,
                'address' => $faker->address,
                'birthdate' => $faker->dateTimeBetween('-40 years', '-20 years'),
                'hire_date' => Carbon::now(),
                'department_id' => 1,
                'role_id' => 1,
                'status' => 'active',
                'salary' => $faker->randomFloat(2, 30000, 100000),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null,
            ],
            [
                'full_name' => $faker->name,
                'email' =>  $faker->unique()->safeEmail,
                'phone_number' => $faker->phoneNumber,
                'address' => $faker->address,
                'birthdate' => $faker->dateTimeBetween('-40 years', '-20 years'),
                'hire_date' => Carbon::now(),
                'department_id' => 1,
                'role_id' => 1,
                'status' => 'active',
                'salary' => $faker->randomFloat(2, 30000, 100000),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null,
            ],
        ]);

        DB::table('tasks')->insert([
            [
                'title' => $faker->sentence(3),
                'description' => $faker->paragraph,
                'assigned_to' => 1,
                'due_date' => Carbon::now()->addDays(7),
                'status' => 'pending',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => $faker->sentence(3),
                'description' => $faker->paragraph,
                'assigned_to' => 1,
                'due_date' => Carbon::now()->addDays(30),
                'status' => 'pending',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        DB::table('payroll')->insert([
            [
                'employee_id' => 1,
                'salary' => $faker->randomFloat(2, 30000, 100000),
                'bonuses' => $faker->randomFloat(2, 1000, 5000),
                'deductions' => $faker->randomFloat(2, 1000, 5000),
                'net_salary' => $faker->randomFloat(2, 25000, 90000),
                'pay_date' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'employee_id' => 2,
                'salary' => $faker->randomFloat(2, 30000, 100000),
                'bonuses' => $faker->randomFloat(2, 1000, 5000),
                'deductions' => $faker->randomFloat(2, 1000, 5000),
                'net_salary' => $faker->randomFloat(2, 25000, 90000),
                'pay_date' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        DB::table('presences')->insert([
            [
                'employee_id' => 1,
                'check_in' => Carbon::parse('2025-06-06 08:00:00'),
                'check_out' => Carbon::parse('2025-06-06 17:00:00'),
                'date' => Carbon::parse('2025-06-06'),
                'status' => 'present',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'employee_id' => 2,
                'check_in' => Carbon::parse('2025-06-07 08:00:00'),
                'check_out' => Carbon::parse('2025-06-07 17:00:00'),
                'date' => Carbon::parse('2025-06-07'),
                'status' => 'present',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        DB::table('leave_requests')->insert([
            [
                'employee_id' => 1,
                'leave_type' => 'Annual Leave',
                'start_date' => Carbon::parse('2025-06-10'),
                'end_date' => Carbon::parse('2025-06-15'),
                'status' => 'approved',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'employee_id' => 2,
                'leave_type' => 'Sick Leave',
                'start_date' => Carbon::parse('2025-06-20'),
                'end_date' => Carbon::parse('2025-06-22'),
                'status' => 'pending',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
