<?php

namespace App\Http\Controllers;

use App\Models\Employees;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EmployeesController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_employees')->only(['index', 'show']);
        $this->middleware('permission:create_employees')->only(['create', 'store']);
        $this->middleware('permission:edit_employees')->only(['edit', 'update']);
        $this->middleware('permission:delete_employees')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $employees  = Employees::where('status', 'active')->paginate(10);
        return view('Backend.Employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('Backend.Employees.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:employees',
            'phone'=> 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'gender' => 'nullable|string|in:F,M,other',
            'dob' => 'nullable|date',
            'hire_date' => 'nullable|date',
            'termination_date' => 'nullable|date',
            'status' => 'required|string|in:active,inactive',
            'salary' => 'nullable|numeric|min:0',
            'position' => 'nullable|string|max:255',
        ]);

         $age = null;
    if ($request->dob) {
        $age = Carbon::parse($request->dob)->age;
    }

        Employees::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'age'=>$age,
            'address'=>$request->address,
            'gender'=>$request->gender,
            'dob'=>$request->dob,
            'hire_date'=>$request->hire_date,
            'termination_date'=>$request->termination_date,
            'status'=>$request->status,
            'salary'=>$request->salary,
            'position'=>$request->position
        ]);

        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employees  $employees
     * @return \Illuminate\Http\Response
     */
    public function show(Employees $employees)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employees  $employees
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function edit(Employees $employee)
    {
        //
        return view('Backend.Employees.create' , compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employees  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employees $employee)
    {
        //
             $request->validate([
            'name' => 'required|string|max:255',
          'email' => 'nullable|string|email|max:255|unique:employees,email,'.$employee->id,
            'phone'=> 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'gender' => 'nullable|string|in:F,M,other',
            'dob' => 'nullable|date',
            'hire_date' => 'nullable|date',
            'termination_date' => 'nullable|date',
            'status' => 'required|string|in:active,inactive',
            'salary' => 'nullable|numeric|min:0',
            'position' => 'nullable|string|max:255',
        ]);
     $age = null;
    if ($request->dob) {
        $age = Carbon::parse($request->dob)->age;
         }
        $employee->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'age'=>$age,
            'address'=>$request->address,
            'gender'=>$request->gender,
            'dob'=>$request->dob,
            'hire_date'=>$request->hire_date,
            'termination_date'=>$request->termination_date,
            'status'=>$request->status,
            'salary'=>$request->salary,
            'position'=>$request->position
        ]);
        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employees  $employees
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employees $employees)
    {
        //
        $employees->status = 'inactive';
        $employees->save();
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }
}
