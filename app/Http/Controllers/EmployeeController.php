<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::all();
        return view('employees.employees',compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {				
        $validatedData = $request->validate(
            ['name' => 'unique:employees|max:255',],
            [
            'name.unique' =>'اسم الموظف مسجل مسبقا',
            ]);

            Employee::create([
                'name'          => $request->name,
                'address'       => $request->address,
                'national_id'   => $request->national_id,
                'date_of_birth' => $request->date_of_birth,
                'phone'         => $request->phone,
                'role'          => $request->role,
                'start_date'    => $request->start_date,
                'end_date'      => $request->end_date,
                'email'         => $request->email,
                'Salary'        => $request->Salary,
                'debt' => $request->start_debt,
                'start_debt' => $request->start_debt,
                'penalty' => 0,

            ]);
            session()->flash('Add', 'تم اضافة الموظف بنجاح ');
            return redirect('/employees');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employees
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employees
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee    = Employee::where('id',$id)->first();
        return view('employees.details_employee',compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employees
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $this->validate($request, [
            'name' => 'max:255|unique:employees,name,'.$id,  
        ],[
            'name.unique' =>'اسم العميل مسجل مسبقا',
        ]);

        $employees = Employee::find($id);

        
        $debt = $employees->debt - $employees->start_debt; 
        $debt = $debt + $request->start_debt;
        $employees->update([
            'name'          => $request->name,
            'address'       => $request->address,
            'national_id'   => $request->national_id,
            'date_of_birth' => $request->date_of_birth,
            'phone'         => $request->phone,
            'role'          => $request->role,
            'start_date'    => $request->start_date,
            'end_date'      => $request->end_date,
            'email'         => $request->email,
            'Salary'        => $request->Salary,
            'debt' => $debt,
            'start_debt' => $request->start_debt,
        ]);

        session()->flash('edit','تم تعديل الموظف بنجاج');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employees
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Employee::find($request->id)->delete();
        session()->flash('delete','تم حذف الموظف بنجاح');
        return redirect('/employees');
    }
}
