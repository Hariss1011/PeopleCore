<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            [
                'code' => 'HR',
                'name' => 'Human Resources',
                'description' => 'Pengelolaan sumber daya manusia dan administrasi karyawan.',
            ],
            [
                'code' => 'IT',
                'name' => 'Information Technology',
                'description' => 'Pengembangan sistem dan dukungan teknologi informasi.',
            ],
            [
                'code' => 'OPS',
                'name' => 'Operations',
                'description' => 'Pengelolaan dan pemantauan kegiatan operasional.',
            ],
            [
                'code' => 'FIN',
                'name' => 'Finance',
                'description' => 'Pengelolaan administrasi dan laporan keuangan.',
            ],
            [
                'code' => 'SAL',
                'name' => 'Sales',
                'description' => 'Pengelolaan penjualan dan hubungan pelanggan.',
            ],
        ];

        foreach ($departments as $department) {
            Department::updateOrCreate(
                ['code' => $department['code']],
                [
                    'name' => $department['name'],
                    'description' => $department['description'],
                    'is_active' => true,
                ]
            );
        }
    }
}
