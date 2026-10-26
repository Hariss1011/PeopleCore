<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $employees = [
            [
                'employee_number' => 'EMP-0001',
                'full_name' => 'Nadia Putri',
                'email' => 'nadia@peoplecore.test',
                'department' => 'HR',
                'position' => 'HR Manager',
                'gender' => 'female',
                'employment_type' => 'permanent',
                'employment_status' => 'active',
                'hire_date' => '2023-01-09',
                'contract_end_date' => null,
            ],
            [
                'employee_number' => 'EMP-0002',
                'full_name' => 'Rizky Pratama',
                'email' => 'rizky@peoplecore.test',
                'department' => 'HR',
                'position' => 'HR Staff',
                'gender' => 'male',
                'employment_type' => 'permanent',
                'employment_status' => 'active',
                'hire_date' => '2024-03-11',
                'contract_end_date' => null,
            ],
            [
                'employee_number' => 'EMP-0003',
                'full_name' => 'Dimas Saputra',
                'email' => 'dimas@peoplecore.test',
                'department' => 'IT',
                'position' => 'Software Developer',
                'gender' => 'male',
                'employment_type' => 'permanent',
                'employment_status' => 'active',
                'hire_date' => '2023-08-14',
                'contract_end_date' => null,
            ],
            [
                'employee_number' => 'EMP-0004',
                'full_name' => 'Siti Rahma',
                'email' => 'siti@peoplecore.test',
                'department' => 'IT',
                'position' => 'IT Support',
                'gender' => 'female',
                'employment_type' => 'contract',
                'employment_status' => 'active',
                'hire_date' => '2025-02-03',
                'contract_end_date' => now()->addDays(20)->toDateString(),
            ],
            [
                'employee_number' => 'EMP-0005',
                'full_name' => 'Fajar Maulana',
                'email' => 'fajar@peoplecore.test',
                'department' => 'OPS',
                'position' => 'Operations Manager',
                'gender' => 'male',
                'employment_type' => 'permanent',
                'employment_status' => 'active',
                'hire_date' => '2022-06-06',
                'contract_end_date' => null,
            ],
            [
                'employee_number' => 'EMP-0006',
                'full_name' => 'Ayu Lestari',
                'email' => 'ayu@peoplecore.test',
                'department' => 'OPS',
                'position' => 'Operations Staff',
                'gender' => 'female',
                'employment_type' => 'contract',
                'employment_status' => 'active',
                'hire_date' => '2025-05-12',
                'contract_end_date' => now()->addDays(10)->toDateString(),
            ],
            [
                'employee_number' => 'EMP-0007',
                'full_name' => 'Bima Setiawan',
                'email' => 'bima@peoplecore.test',
                'department' => 'FIN',
                'position' => 'Finance Staff',
                'gender' => 'male',
                'employment_type' => 'permanent',
                'employment_status' => 'active',
                'hire_date' => '2024-01-15',
                'contract_end_date' => null,
            ],
            [
                'employee_number' => 'EMP-0008',
                'full_name' => 'Intan Permata',
                'email' => 'intan@peoplecore.test',
                'department' => 'SAL',
                'position' => 'Sales Executive',
                'gender' => 'female',
                'employment_type' => 'contract',
                'employment_status' => 'active',
                'hire_date' => '2025-10-01',
                'contract_end_date' => now()->addDays(60)->toDateString(),
            ],
        ];

        foreach ($employees as $data) {
            $department = Department::where('code', $data['department'])
                ->firstOrFail();

            $position = Position::where('department_id', $department->id)
                ->where('name', $data['position'])
                ->firstOrFail();

            Employee::updateOrCreate(
                ['employee_number' => $data['employee_number']],
                [
                    'department_id' => $department->id,
                    'position_id' => $position->id,
                    'full_name' => $data['full_name'],
                    'email' => $data['email'],
                    'phone' => null,
                    'gender' => $data['gender'],
                    'address' => 'Alamat demo, Indonesia',
                    'hire_date' => $data['hire_date'],
                    'employment_type' => $data['employment_type'],
                    'contract_end_date' => $data['contract_end_date'],
                    'employment_status' => $data['employment_status'],
                ]
            );
        }
    }
}
