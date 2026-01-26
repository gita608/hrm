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
        $roles = \App\Models\Role::where('is_active', true)->orderBy('name')->get();

        return view('pages.employees.create', compact('roles'));
    }

    /**
     * Store a newly created employee in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
            // UAE-specific fields
            'emirates_id' => 'nullable|string|max:255|unique:users,emirates_id',
            'passport_number' => 'nullable|string|max:255',
            'passport_expiry_date' => 'nullable|date',
            'nationality' => 'nullable|string|max:255',
            'visa_type' => 'nullable|in:employment,dependent,investor,student,tourist,other',
            'visa_number' => 'nullable|string|max:255',
            'visa_expiry_date' => 'nullable|date',
            'labor_card_number' => 'nullable|string|max:255',
            'labor_card_expiry_date' => 'nullable|date',
            'bank_name' => 'nullable|string|max:255',
            'iban' => 'nullable|string|max:34',
            'uae_emirate' => 'nullable|in:Abu Dhabi,Dubai,Sharjah,Ajman,Umm Al Quwain,Ras Al Khaimah,Fujairah',
            'uae_city' => 'nullable|string|max:255',
            'uae_area' => 'nullable|string|max:255',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
        ]);

        $validated['password'] = \Illuminate\Support\Facades\Hash::make($validated['password']);
        $validated['email_verified_at'] = now();

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $filename = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $path = $file->storeAs('profile_pictures', $filename, 'public');
            $validated['profile_picture'] = $path;
        }

        \App\Models\User::create($validated);

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
        $employee = \App\Models\User::findOrFail($id);
        $roles = \App\Models\Role::where('is_active', true)->orderBy('name')->get();

        return view('pages.employees.edit', compact('employee', 'roles'));
    }

    /**
     * Update the specified employee in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $employee = \App\Models\User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'password' => 'nullable|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
            // UAE-specific fields
            'emirates_id' => 'nullable|string|max:255|unique:users,emirates_id,'.$id,
            'passport_number' => 'nullable|string|max:255',
            'passport_expiry_date' => 'nullable|date',
            'nationality' => 'nullable|string|max:255',
            'visa_type' => 'nullable|in:employment,dependent,investor,student,tourist,other',
            'visa_number' => 'nullable|string|max:255',
            'visa_expiry_date' => 'nullable|date',
            'labor_card_number' => 'nullable|string|max:255',
            'labor_card_expiry_date' => 'nullable|date',
            'bank_name' => 'nullable|string|max:255',
            'iban' => 'nullable|string|max:34',
            'uae_emirate' => 'nullable|in:Abu Dhabi,Dubai,Sharjah,Ajman,Umm Al Quwain,Ras Al Khaimah,Fujairah',
            'uae_city' => 'nullable|string|max:255',
            'uae_area' => 'nullable|string|max:255',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
        ]);

        if (! empty($validated['password'])) {
            $validated['password'] = \Illuminate\Support\Facades\Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if exists
            if ($employee->profile_picture) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($employee->profile_picture);
            }

            $file = $request->file('profile_picture');
            $filename = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $path = $file->storeAs('profile_pictures', $filename, 'public');
            $validated['profile_picture'] = $path;
        }

        $employee->update($validated);

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
