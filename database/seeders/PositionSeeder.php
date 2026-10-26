<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Position;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    public function run(): void
    {
        $positions = [
            'HR' => [
                'HR Manager',
                'HR Staff',
            ],
            'IT' => [
                'IT Manager',
                'Software Developer',
                'IT Support',
            ],
            'OPS' => [
                'Operations Manager',
                'Operations Staff',
            ],
            'FIN' => [
                'Finance Manager',
                'Finance Staff',
            ],
            'SAL' => [
                'Sales Manager',
                'Sales Executive',
            ],
        ];

        foreach ($positions as $departmentCode => $positionNames) {
            $department = Department::where('code', $departmentCode)->firstOrFail();

            foreach ($positionNames as $positionName) {
                Position::updateOrCreate(
                    [
                        'department_id' => $department->id,
                        'name' => $positionName,
                    ],
                    [
                        'description' => 'Jabatan ' . $positionName . ' pada departemen ' . $department->name . '.',
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}
