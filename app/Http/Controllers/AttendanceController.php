<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Ticket;
use App\Services\AttendanceService;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    protected $attendanceService;

    public function __construct(AttendanceService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }

    public function view()
    {
        Employee::select('id', 'name')->get()->pluck('name', 'id')->toArray();
        return view('attendance.index', compact('employees'));
    }

    public function checkin(Employee $employee, $date)
    {
        $this->attendanceService->checkin($employee, $date);
        return redirect()->back();
    }

    public function checkout(Employee $employee, $date)
    {
        $this->attendanceService->checkout($employee, $date);
        return redirect()->back();
    }
}
