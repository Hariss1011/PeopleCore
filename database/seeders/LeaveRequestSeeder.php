<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\LeaveRequestHistory;
use App\Models\LeaveType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class LeaveRequestSeeder extends Seeder
{
    public function run(): void
    {
        $hr = User::where('email', 'hr@peoplecore.test')
            ->firstOrFail();

        $requests = [
            [
                'employee_number' => 'EMP-0003',
                'leave_type_code' => 'ANNUAL',
                'start_offset' => 5,
                'duration' => 1,
                'reason' => 'Keperluan keluarga.',
                'status' => 'pending',
                'review_note' => null,
            ],
            [
                'employee_number' => 'EMP-0004',
                'leave_type_code' => 'PERSONAL',
                'start_offset' => 10,
                'duration' => 2,
                'reason' => 'Keperluan pribadi yang sudah direncanakan.',
                'status' => 'approved',
                'review_note' => 'Pengajuan disetujui.',
            ],
            [
                'employee_number' => 'EMP-0006',
                'leave_type_code' => 'ANNUAL',
                'start_offset' => 15,
                'duration' => 1,
                'reason' => 'Mengajukan cuti untuk keperluan pribadi.',
                'status' => 'rejected',
                'review_note' => 'Jadwal tersebut bertepatan dengan kebutuhan operasional.',
            ],
        ];

        foreach ($requests as $data) {
            $employee = Employee::where(
                'employee_number',
                $data['employee_number']
            )->firstOrFail();

            $employeeUser = User::where('employee_id', $employee->id)
                ->firstOrFail();

            $leaveType = LeaveType::where(
                'code',
                $data['leave_type_code']
            )->firstOrFail();

            // Gunakan hari kerja agar data demo mudah dibaca.
            $startDate = Carbon::today()->addWeekdays($data['start_offset']);
            $endDate = $startDate->copy()->addWeekdays($data['duration'] - 1);

            $reviewed = in_array(
                $data['status'],
                ['approved', 'rejected'],
                true
            );

            $leaveRequest = LeaveRequest::updateOrCreate(
                [
                    'employee_id' => $employee->id,
                    'leave_type_id' => $leaveType->id,
                    'start_date' => $startDate->toDateString(),
                    'end_date' => $endDate->toDateString(),
                ],
                [
                    'reason' => $data['reason'],
                    'status' => $data['status'],
                    'reviewed_by' => $reviewed ? $hr->id : null,
                    'reviewed_at' => $reviewed ? now() : null,
                    'review_note' => $data['review_note'],
                ]
            );

            // Riwayat saat pengajuan pertama kali dibuat.
            LeaveRequestHistory::firstOrCreate(
                [
                    'leave_request_id' => $leaveRequest->id,
                    'new_status' => 'pending',
                ],
                [
                    'changed_by' => $employeeUser->id,
                    'old_status' => null,
                    'note' => 'Pengajuan cuti dibuat oleh karyawan.',
                    'changed_at' => $leaveRequest->created_at ?? now(),
                ]
            );

            // Riwayat keputusan HR untuk pengajuan yang telah diproses.
            if ($reviewed) {
                LeaveRequestHistory::firstOrCreate(
                    [
                        'leave_request_id' => $leaveRequest->id,
                        'new_status' => $data['status'],
                    ],
                    [
                        'changed_by' => $hr->id,
                        'old_status' => 'pending',
                        'note' => $data['review_note'],
                        'changed_at' => $leaveRequest->reviewed_at ?? now(),
                    ]
                );
            }
        }
    }
}
