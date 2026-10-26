<?php

namespace Database\Seeders;

use App\Models\LeaveType;
use Illuminate\Database\Seeder;

class LeaveTypeSeeder extends Seeder
{
    public function run(): void
    {
        $leaveTypes = [
            [
                'code' => 'ANNUAL',
                'name' => 'Cuti Tahunan',
                'description' => 'Cuti tahunan untuk keperluan pribadi atau istirahat.',
            ],
            [
                'code' => 'SICK',
                'name' => 'Cuti Sakit',
                'description' => 'Ketidakhadiran karena kondisi kesehatan.',
            ],
            [
                'code' => 'PERSONAL',
                'name' => 'Izin Pribadi',
                'description' => 'Izin untuk keperluan pribadi.',
            ],
            [
                'code' => 'SPECIAL',
                'name' => 'Cuti Khusus',
                'description' => 'Cuti untuk keperluan khusus sesuai kebijakan perusahaan.',
            ],
        ];

        foreach ($leaveTypes as $leaveType) {
            LeaveType::updateOrCreate(
                ['code' => $leaveType['code']],
                [
                    'name' => $leaveType['name'],
                    'description' => $leaveType['description'],
                    'is_active' => true,
                ]
            );
        }
    }
}
