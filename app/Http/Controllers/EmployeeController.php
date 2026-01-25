<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the employees.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get departments and designations for filters
        $departments = \App\Models\Department::where('is_active', true)->orderBy('name')->get();
        $designations = \App\Models\Designation::where('is_active', true)->orderBy('name')->get();
        
        // Build query for employees (users)
        $query = \App\Models\User::with('role');
        
        // Filter by department (if users had department_id - for now we'll skip this)
        // Filter by designation (if users had designation_id - for now we'll skip this)
        
        // Filter by status (email verified = active)
        if ($request->filled('status')) {
            if ($request->status == 'active') {
                $query->whereNotNull('email_verified_at');
            } elseif ($request->status == 'inactive') {
                $query->whereNull('email_verified_at');
            }
        }
        
        $employees = $query->orderBy('created_at', 'desc')->get();
        
        // Calculate statistics
        $totalEmployees = \App\Models\User::count();
        $activeEmployees = \App\Models\User::whereNotNull('email_verified_at')->count();
        $inactiveEmployees = \App\Models\User::whereNull('email_verified_at')->count();
        $newJoiners = \App\Models\User::where('created_at', '>=', now()->subDays(30))->count();
        
        return view('pages.employees.index', compact('departments', 'designations', 'employees', 'totalEmployees', 'activeEmployees', 'inactiveEmployees', 'newJoiners'));
    }

    /**
     * Show the form for creating a new employee.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.employees.create');
    }

    /**
     * Store a newly created employee in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // TODO: Implement employee creation logic
        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    /**
     * Display the specified employee.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = \App\Models\User::with('role')->findOrFail($id);
        return view('pages.employees.show', compact('employee', 'id'));
    }

    /**
     * Show the form for editing the specified employee.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // TODO: Implement employee edit view
        return view('pages.employees.edit', compact('id'));
    }

    /**
     * Update the specified employee in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // TODO: Implement employee update logic
        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    /**
     * Remove the specified employee from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // TODO: Implement employee deletion logic
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }

    /**
     * Display employees in grid view.
     *
     * @return \Illuminate\Http\Response
     */
    public function grid()
    {
        return view('pages.employees.grid');
    }
}
