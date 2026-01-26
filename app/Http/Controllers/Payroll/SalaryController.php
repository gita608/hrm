<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use App\Models\Salary;
use App\Models\User;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Salary::with('employee');

        // Filter by employee
        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $salaries = $query->orderBy('effective_from', 'desc')->get();
        $employees = User::whereHas('role', function($q) {
            $q->where('name', '!=', 'admin');
        })->orWhereDoesntHave('role')->orderBy('name')->get();

        return view('pages.payroll.salary.index', compact('salaries', 'employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = User::whereHas('role', function($q) {
            $q->where('name', '!=', 'admin');
        })->orWhereDoesntHave('role')->orderBy('name')->get();

        return view('pages.payroll.salary.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:users,id',
            'basic_salary' => 'required|numeric|min:0',
            'housing_allowance' => 'nullable|numeric|min:0',
            'transport_allowance' => 'nullable|numeric|min:0',
            'food_allowance' => 'nullable|numeric|min:0',
            'other_allowances' => 'nullable|numeric|min:0',
            'tax_deduction' => 'nullable|numeric|min:0',
            'provident_fund' => 'nullable|numeric|min:0',
            'other_deductions' => 'nullable|numeric|min:0',
            'effective_from' => 'required|date',
            'effective_to' => 'nullable|date|after:effective_from',
            'status' => 'required|in:active,inactive',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Calculate totals
        $validated['total_allowances'] = ($validated['housing_allowance'] ?? 0) + 
                                         ($validated['transport_allowance'] ?? 0) + 
                                         ($validated['food_allowance'] ?? 0) + 
                                         ($validated['other_allowances'] ?? 0);
        
        $validated['gross_salary'] = $validated['basic_salary'] + $validated['total_allowances'];
        
        $validated['total_deductions'] = ($validated['tax_deduction'] ?? 0) + 
                                         ($validated['provident_fund'] ?? 0) + 
                                         ($validated['other_deductions'] ?? 0);
        
        $validated['net_salary'] = $validated['gross_salary'] - $validated['total_deductions'];

        // Deactivate previous active salary for this employee
        if ($validated['status'] == 'active') {
            Salary::where('employee_id', $validated['employee_id'])
                ->where('status', 'active')
                ->update(['status' => 'inactive', 'effective_to' => now()]);
        }

        Salary::create($validated);

        return redirect()->route('payroll.salary.index')->with('success', 'Salary created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $salary = Salary::with('employee')->findOrFail($id);

        return view('pages.payroll.salary.show', compact('salary'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $salary = Salary::findOrFail($id);
        $employees = User::whereHas('role', function($q) {
            $q->where('name', '!=', 'admin');
        })->orWhereDoesntHave('role')->orderBy('name')->get();

        return view('pages.payroll.salary.edit', compact('salary', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $salary = Salary::findOrFail($id);

        $validated = $request->validate([
            'employee_id' => 'required|exists:users,id',
            'basic_salary' => 'required|numeric|min:0',
            'housing_allowance' => 'nullable|numeric|min:0',
            'transport_allowance' => 'nullable|numeric|min:0',
            'food_allowance' => 'nullable|numeric|min:0',
            'other_allowances' => 'nullable|numeric|min:0',
            'tax_deduction' => 'nullable|numeric|min:0',
            'provident_fund' => 'nullable|numeric|min:0',
            'other_deductions' => 'nullable|numeric|min:0',
            'effective_from' => 'required|date',
            'effective_to' => 'nullable|date|after:effective_from',
            'status' => 'required|in:active,inactive',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Calculate totals
        $validated['total_allowances'] = ($validated['housing_allowance'] ?? 0) + 
                                         ($validated['transport_allowance'] ?? 0) + 
                                         ($validated['food_allowance'] ?? 0) + 
                                         ($validated['other_allowances'] ?? 0);
        
        $validated['gross_salary'] = $validated['basic_salary'] + $validated['total_allowances'];
        
        $validated['total_deductions'] = ($validated['tax_deduction'] ?? 0) + 
                                         ($validated['provident_fund'] ?? 0) + 
                                         ($validated['other_deductions'] ?? 0);
        
        $validated['net_salary'] = $validated['gross_salary'] - $validated['total_deductions'];

        // Deactivate previous active salary for this employee if activating this one
        if ($validated['status'] == 'active' && $salary->status != 'active') {
            Salary::where('employee_id', $validated['employee_id'])
                ->where('status', 'active')
                ->where('id', '!=', $id)
                ->update(['status' => 'inactive', 'effective_to' => now()]);
        }

        $salary->update($validated);

        return redirect()->route('payroll.salary.index')->with('success', 'Salary updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $salary = Salary::findOrFail($id);
        $salary->delete();

        return redirect()->route('payroll.salary.index')->with('success', 'Salary deleted successfully.');
    }
}
