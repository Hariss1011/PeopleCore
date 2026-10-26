
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\HRReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\LeaveTypeController;
use App\Http\Controllers\LeaveBalanceController;
use App\Http\Controllers\EmploymentHistoryController;

Route::get('/', function () {
    return redirect()->route(
        auth()->check() ? 'dashboard' : 'login'
    );
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.process');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ADMIN: Manajemen akun dan data referensi
    Route::middleware('role:admin')->group(function () {
        Route::resource('users', UserController::class)->except(['show']);

        Route::resource('departments', DepartmentController::class)->except(['show']);

        Route::resource('positions', PositionController::class)->except(['show']);

        Route::resource('leave-types', LeaveTypeController::class)->except(['show']);
    });

    // ADMIN DAN HR
    Route::middleware('role:admin,hr')->group(function () {
        // data karyawan
        Route::resource('employees', EmployeeController::class);
        //absensi
        Route::get('/attendances', [AttendanceController::class, 'index'])->name('attendances.index');
        Route::get('/attendances/create', [AttendanceController::class, 'create'])->name('attendances.create');
        Route::post('/attendances', [AttendanceController::class, 'store'])->name('attendances.store');
        Route::get('/attendances/{attendance}/edit', [AttendanceController::class, 'edit'])->name('attendances.edit');
        Route::put('/attendances/{attendance}', [AttendanceController::class, 'update'])->name('attendances.update');
        Route::delete('/attendances/{attendance}', [AttendanceController::class, 'destroy'])->name('attendances.destroy');
        // Laporan HR
        Route::get('/reports/attendance', [HRReportController::class, 'attendance'])->name('reports.attendance');
        Route::get('/reports/attendance/export', [HRReportController::class, 'exportAttendance'])->name('reports.attendance.export');
        // kuota cuti
        Route::resource('leave-balances', LeaveBalanceController::class)->except(['show']);
        // history karyawan
        Route::get('/employees/{employee}/employment-history', [EmploymentHistoryController::class, 'index'])->name('employees.employment-history.index');
        Route::get('/employees/{employee}/employment-history/create', [EmploymentHistoryController::class, 'create'])->name('employees.employment-history.create');
        Route::post('/employees/{employee}/employment-history', [EmploymentHistoryController::class, 'store'])->name('employees.employment-history.store');
    });

    // HR: Persetujuan cuti
    Route::middleware('role:hr')->group(function () {
        Route::get('/leave-approvals', [LeaveRequestController::class, 'approvals'])->name('leave-approvals.index');
        Route::get('/leave-approvals/{leaveRequest}', [LeaveRequestController::class, 'approvalShow'])->name('leave-approvals.show');
        Route::put('/leave-approvals/{leaveRequest}/review', [LeaveRequestController::class, 'review'])->name('leave-approvals.review');
    });

    // EMPLOYEE: Fitur pribadi
    Route::middleware('role:employee')->group(function () {
        // absensi    
        Route::get('/my/attendances', [AttendanceController::class, 'myIndex'])->name('my.attendances.index');
        // pengajuan cuti
        Route::get('/my/leave-requests', [LeaveRequestController::class, 'myIndex'])->name('my.leave-requests.index');
        Route::get('/my/leave-requests/create', [LeaveRequestController::class, 'create'])->name('my.leave-requests.create');
        Route::post('/my/leave-requests', [LeaveRequestController::class, 'store'])->name('my.leave-requests.store');
        Route::get('/my/leave-requests/{leaveRequest}', [LeaveRequestController::class, 'myShow'])->name('my.leave-requests.show');
        // kuota cuti
        Route::get('/my/leave-balances', [LeaveBalanceController::class, 'mine',])->name('my.leave-balances.index');
    });
});
