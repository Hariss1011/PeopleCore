<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $password = 'PeopleCore123!';

        // Akun Admin tidak terhubung dengan profil karyawan.
        User::updateOrCreate(
            ['email' => 'admin@peoplecore.test'],
            [
                'name' => 'PeopleCore Admin',
                'password' => $password,
                'role' => 'admin',
                'employee_id' => null,
            ]
        );

        // Akun HR terhubung dengan profil EMP-0001.
        $accounts = [
            [
                'email' => 'hr@peoplecore.test',
                'name' => 'Nadia Putri',
                'role' => 'hr',
                'employee_number' => 'EMP-0001',
            ],
            [
                'email' => 'employee1@peoplecore.test',
                'name' => 'Dimas Saputra',
                'role' => 'employee',
                'employee_number' => 'EMP-0003',
            ],
            [
                'email' => 'employee2@peoplecore.test',
                'name' => 'Siti Rahma',
                'role' => 'employee',
                'employee_number' => 'EMP-0004',
            ],
            [
                'email' => 'employee3@peoplecore.test',
                'name' => 'Ayu Lestari',
                'role' => 'employee',
                'employee_number' => 'EMP-0006',
            ],
            [
                'email' => 'employee4@peoplecore.test',
                'name' => 'Bima Setiawan',
                'role' => 'employee',
                'employee_number' => 'EMP-0007',
            ],
        ];

        foreach ($accounts as $account) {
            $employee = Employee::where(
                'employee_number',
                $account['employee_number']
            )->firstOrFail();

            User::updateOrCreate(
                ['email' => $account['email']],
                [
                    'name' => $account['name'],
                    'password' => $password,
                    'role' => $account['role'],
                    'employee_id' => $employee->id,
                ]
            );
        }
    }
}
