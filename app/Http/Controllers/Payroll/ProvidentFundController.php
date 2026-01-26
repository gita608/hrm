<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use App\Models\ProvidentFund;
use App\Models\User;
use Illuminate\Http\Request;

class ProvidentFundController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ProvidentFund::with('employee');

        // Filter by employee
        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        // Filter by month/year
        if ($request->filled('month')) {
            $query->where('month', $request->month);
        }
        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        $providentFunds = $query->orderBy('year', 'desc')->orderBy('month', 'desc')->get();
        $employees = User::whereHas('role', function($q) {
            $q->where('name', '!=', 'admin');
        })->orWhereDoesntHave('role')->orderBy('name')->get();

        return view('pages.payroll.provident-fund.index', compact('providentFunds', 'employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = User::whereHas('role', function($q) {
            $q->where('name', '!=', 'admin');
        })->orWhereDoesntHave('role')->orderBy('name')->get();

        return view('pages.payroll.provident-fund.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:users,id',
            'employee_contribution' => 'nullable|numeric|min:0',
            'employer_contribution' => 'nullable|numeric|min:0',
            'employee_percentage' => 'nullable|numeric|min:0|max:100',
            'employer_percentage' => 'nullable|numeric|min:0|max:100',
            'contribution_date' => 'required|date',
            'month' => 'required|string|max:20',
            'year' => 'required|integer|min:2000|max:2100',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Calculate contributions if percentages are provided
        if ($request->filled('employee_percentage') || $request->filled('employer_percentage')) {
            // Get employee's current salary
            $salary = \App\Models\Salary::where('employee_id', $validated['employee_id'])
                ->where('status', 'active')
                ->first();
            
            if ($salary) {
                $baseAmount = $salary->basic_salary;
                
                if ($request->filled('employee_percentage') && !$request->filled('employee_contribution')) {
                    $validated['employee_contribution'] = ($baseAmount * $validated['employee_percentage']) / 100;
                }
                
                if ($request->filled('employer_percentage') && !$request->filled('employer_contribution')) {
                    $validated['employer_contribution'] = ($baseAmount * $validated['employer_percentage']) / 100;
                }
            }
        }

        // Calculate total
        $validated['total_contribution'] = ($validated['employee_contribution'] ?? 0) + 
                                          ($validated['employer_contribution'] ?? 0);

        ProvidentFund::create($validated);

        return redirect()->route('payroll.provident-fund.index')->with('success', 'Provident fund contribution created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $providentFund = ProvidentFund::with('employee')->findOrFail($id);

        return view('pages.payroll.provident-fund.show', compact('providentFund'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $providentFund = ProvidentFund::findOrFail($id);
        $employees = User::whereHas('role', function($q) {
            $q->where('name', '!=', 'admin');
        })->orWhereDoesntHave('role')->orderBy('name')->get();

        return view('pages.payroll.provident-fund.edit', compact('providentFund', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $providentFund = ProvidentFund::findOrFail($id);

        $validated = $request->validate([
            'employee_id' => 'required|exists:users,id',
            'employee_contribution' => 'nullable|numeric|min:0',
            'employer_contribution' => 'nullable|numeric|min:0',
            'employee_percentage' => 'nullable|numeric|min:0|max:100',
            'employer_percentage' => 'nullable|numeric|min:0|max:100',
            'contribution_date' => 'required|date',
            'month' => 'required|string|max:20',
            'year' => 'required|integer|min:2000|max:2100',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Calculate total
        $validated['total_contribution'] = ($validated['employee_contribution'] ?? 0) + 
                                          ($validated['employer_contribution'] ?? 0);

        $providentFund->update($validated);

        return redirect()->route('payroll.provident-fund.index')->with('success', 'Provident fund contribution updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $providentFund = ProvidentFund::findOrFail($id);
        $providentFund->delete();

        return redirect()->route('payroll.provident-fund.index')->with('success', 'Provident fund contribution deleted successfully.');
    }
}
