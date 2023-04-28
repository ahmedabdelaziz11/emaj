<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;

class AttendanceService
{

    public function getAttendances(Employee $employee = null, $date = null)
    {
        return Attendance::when($employee, function ($query, $employee) {
            return $query->where('employee_id', $employee->id);
        })
            ->when($date, function ($query, $date) {
                return $query->whereDate('created_at', $date);
        }, function ($query) {
            return $query->whereDate('created_at', Carbon::today());
            })
            ->paginate(30);
    }

    public function checkin(Employee $employee = null, $date = null)
    {

        [$employee, $date] = $this->getEmployeeAndDate($employee, $date);
        $attendance = Attendance::create([
            'employee_id' => $employee->id,
            'check_in' => $date,
        ]);

        return $attendance;
    }

    public function checkout(Employee $employee = null, $date = null)
    {
        [$employee, $date] = $this->getEmployeeAndDate($employee, $date);
        $attendance = Attendance::where('employee_id', $employee->id)
            ->where('check_out', null)
            ->orderBy('created_at', 'desc')
            ->first();

        $attendance->update([
            'check_out' => $date,
        ]);

        return $attendance;
    }

    private function getEmployeeAndDate(Employee $employee = null, $date = null)
    {
        $employee = $employee ?? auth()->user()->employee;
        $date = $date ?? now();

        return [$employee, $date];
    }
}
