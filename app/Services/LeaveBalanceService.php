<?php

namespace App\Services;

use App\Models\LeaveBalance;
use App\Models\LeaveRequest;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class LeaveBalanceService
{
    /**
     * Menghitung hari kerja Senin-Jumat secara inklusif.
     */
    public function workingDaysBetween(
        string $startDate,
        string $endDate
    ): int {
        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->startOfDay();

        if ($end->lt($start)) {
            return 0;
        }

        $days = 0;

        foreach (CarbonPeriod::create($start, $end) as $date) {
            if ($date->isWeekday()) {
                $days++;
            }
        }

        return $days;
    }

    /**
     * Menghitung jumlah hari cuti yang disetujui
     * untuk jenis cuti dan tahun tertentu.
     */
    public function usedDays(
        int $employeeId,
        int $leaveTypeId,
        int $year,
        ?int $excludeRequestId = null
    ): int {
        $yearStart = Carbon::create($year, 1, 1)->toDateString();
        $yearEnd = Carbon::create($year, 12, 31)->toDateString();

        $query = LeaveRequest::query()
            ->where('employee_id', $employeeId)
            ->where('leave_type_id', $leaveTypeId)
            ->where('status', 'approved')
            ->whereDate('start_date', '<=', $yearEnd)
            ->whereDate('end_date', '>=', $yearStart);

        if ($excludeRequestId !== null) {
            $query->where('id', '!=', $excludeRequestId);
        }

        $requests = $query->get([
            'id',
            'start_date',
            'end_date',
        ]);

        $used = 0;

        foreach ($requests as $leaveRequest) {
            $start = Carbon::parse($leaveRequest->start_date);
            $end = Carbon::parse($leaveRequest->end_date);

            $effectiveStart = $start->greaterThan(
                Carbon::parse($yearStart)
            ) ? $start : Carbon::parse($yearStart);

            $effectiveEnd = $end->lessThan(
                Carbon::parse($yearEnd)
            ) ? $end : Carbon::parse($yearEnd);

            $used += $this->workingDaysBetween(
                $effectiveStart->toDateString(),
                $effectiveEnd->toDateString()
            );
        }

        return $used;
    }

    public function quotaDays(
        int $employeeId,
        int $leaveTypeId,
        int $year
    ): int {
        return (int) LeaveBalance::query()
            ->where('employee_id', $employeeId)
            ->where('leave_type_id', $leaveTypeId)
            ->where('year', $year)
            ->value('quota_days');
    }

    public function remainingDays(
        int $employeeId,
        int $leaveTypeId,
        int $year
    ): int {
        return max(
            0,
            $this->quotaDays($employeeId, $leaveTypeId, $year)
                - $this->usedDays($employeeId, $leaveTypeId, $year)
        );
    }

    /**
     * Memeriksa apakah pengajuan dapat ditambahkan ke pemakaian
     * yang telah disetujui tanpa melampaui kuota setiap tahun.
     *
     * $excludeRequestId digunakan ketika memeriksa pengajuan
     * yang sedang diproses oleh HR.
     */
    public function exceedsQuota(
        int $employeeId,
        int $leaveTypeId,
        string $startDate,
        string $endDate,
        ?int $excludeRequestId = null
    ): bool {
        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->startOfDay();

        for ($year = $start->year; $year <= $end->year; $year++) {
            $yearStart = Carbon::create($year, 1, 1);
            $yearEnd = Carbon::create($year, 12, 31);

            $effectiveStart = $start->greaterThan($yearStart)
                ? $start
                : $yearStart;

            $effectiveEnd = $end->lessThan($yearEnd)
                ? $end
                : $yearEnd;

            $requestedDays = $this->workingDaysBetween(
                $effectiveStart->toDateString(),
                $effectiveEnd->toDateString()
            );

            if ($requestedDays === 0) {
                continue;
            }

            $quota = $this->quotaDays(
                $employeeId,
                $leaveTypeId,
                $year
            );

            $used = $this->usedDays(
                $employeeId,
                $leaveTypeId,
                $year,
                $excludeRequestId
            );

            if (($used + $requestedDays) > $quota) {
                return true;
            }
        }

        return false;
    }
}
