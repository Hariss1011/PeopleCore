<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@peoplecore.test')
            ->firstOrFail();

        $employees = Employee::where('employment_status', 'active')
            ->orderBy('employee_number')
            ->get();

        // Ambil 10 hari kerja terakhir, termasuk hari ini jika weekday.
        $workDates = [];
        $date = Carbon::today();

        while (count($workDates) < 10) {
            if ($date->isWeekday()) {
                $workDates[] = $date->copy();
            }

            $date->subDay();
        }

        foreach ($employees as $employeeIndex => $employee) {
            foreach ($workDates as $dateIndex => $date) {
                $pattern = ($employeeIndex + $dateIndex) % 10;

                $status = match ($pattern) {
                    3 => 'late',
                    6 => 'permission',
                    8 => 'sick',
                    9 => 'absent',
                    default => 'present',
                };

                $checkIn = match ($status) {
                    'present' => '08:00:00',
                    'late' => '09:15:00',
                    default => null,
                };

                $checkOut = in_array($status, ['present', 'late'], true)
                    ? '17:00:00'
                    : null;

                Attendance::updateOrCreate(
                    [
                        'employee_id' => $employee->id,
                        'attendance_date' => $date->toDateString(),
                    ],
                    [
                        'status' => $status,
                        'check_in' => $checkIn,
                        'check_out' => $checkOut,
                        'notes' => match ($status) {
                            'permission' => 'Izin untuk keperluan pribadi (data demo).',
                            'sick' => 'Izin sakit (data demo).',
                            'absent' => 'Tidak hadir (data demo).',
                            'late' => 'Tercatat datang terlambat (data demo).',
                            default => null,
                        },
                        'recorded_by' => $admin->id,
                    ]
                );
            }
        }
    }
}
