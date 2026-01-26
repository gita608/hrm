<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use App\Models\Payslip;
use App\Models\Salary;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PayslipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Payslip::with(['employee', 'salary', 'approver']);

        // Filter by employee
        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by payment date
        if ($request->filled('payment_date_from')) {
            $query->whereDate('payment_date', '>=', $request->payment_date_from);
        }
        if ($request->filled('payment_date_to')) {
            $query->whereDate('payment_date', '<=', $request->payment_date_to);
        }

        $payslips = $query->orderBy('payment_date', 'desc')->orderBy('created_at', 'desc')->get();
        $employees = User::whereHas('role', function($q) {
            $q->where('name', '!=', 'admin');
        })->orWhereDoesntHave('role')->orderBy('name')->get();

        return view('pages.payroll.payslip.index', compact('payslips', 'employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = User::whereHas('role', function($q) {
            $q->where('name', '!=', 'admin');
        })->orWhereDoesntHave('role')->orderBy('name')->get();
        
        $salaries = Salary::where('status', 'active')->with('employee')->get();

        return view('pages.payroll.payslip.create', compact('employees', 'salaries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:users,id',
            'salary_id' => 'nullable|exists:salaries,id',
            'pay_period_start' => 'required|date',
            'pay_period_end' => 'required|date|after:pay_period_start',
            'payment_date' => 'required|date',
            'basic_salary' => 'required|numeric|min:0',
            'allowances' => 'nullable|numeric|min:0',
            'overtime' => 'nullable|numeric|min:0',
            'bonuses' => 'nullable|numeric|min:0',
            'tax_deduction' => 'nullable|numeric|min:0',
            'provident_fund' => 'nullable|numeric|min:0',
            'other_deductions' => 'nullable|numeric|min:0',
            'working_days' => 'nullable|integer|min:0',
            'present_days' => 'nullable|integer|min:0',
            'absent_days' => 'nullable|integer|min:0',
            'leave_days' => 'nullable|integer|min:0',
            'status' => 'required|in:draft,approved,paid,cancelled',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Generate payslip number
        $validated['payslip_number'] = 'PSL-' . date('Ymd') . '-' . str_pad(Payslip::count() + 1, 4, '0', STR_PAD_LEFT);

        // Calculate totals
        $validated['gross_salary'] = $validated['basic_salary'] + 
                                     ($validated['allowances'] ?? 0) + 
                                     ($validated['overtime'] ?? 0) + 
                                     ($validated['bonuses'] ?? 0);
        
        $validated['total_deductions'] = ($validated['tax_deduction'] ?? 0) + 
                                         ($validated['provident_fund'] ?? 0) + 
                                         ($validated['other_deductions'] ?? 0);
        
        $validated['net_salary'] = $validated['gross_salary'] - $validated['total_deductions'];

        // Set approved info if status is approved/paid
        if (in_array($validated['status'], ['approved', 'paid'])) {
            $validated['approved_by'] = auth()->id();
            $validated['approved_at'] = now();
        }

        Payslip::create($validated);

        return redirect()->route('payroll.payslip.index')->with('success', 'Payslip created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $payslip = Payslip::with(['employee', 'salary', 'approver'])->findOrFail($id);

        return view('pages.payroll.payslip.show', compact('payslip'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $payslip = Payslip::findOrFail($id);
        $employees = User::whereHas('role', function($q) {
            $q->where('name', '!=', 'admin');
        })->orWhereDoesntHave('role')->orderBy('name')->get();
        $salaries = Salary::where('status', 'active')->with('employee')->get();

        return view('pages.payroll.payslip.edit', compact('payslip', 'employees', 'salaries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $payslip = Payslip::findOrFail($id);

        $validated = $request->validate([
            'employee_id' => 'required|exists:users,id',
            'salary_id' => 'nullable|exists:salaries,id',
            'pay_period_start' => 'required|date',
            'pay_period_end' => 'required|date|after:pay_period_start',
            'payment_date' => 'required|date',
            'basic_salary' => 'required|numeric|min:0',
            'allowances' => 'nullable|numeric|min:0',
            'overtime' => 'nullable|numeric|min:0',
            'bonuses' => 'nullable|numeric|min:0',
            'tax_deduction' => 'nullable|numeric|min:0',
            'provident_fund' => 'nullable|numeric|min:0',
            'other_deductions' => 'nullable|numeric|min:0',
            'working_days' => 'nullable|integer|min:0',
            'present_days' => 'nullable|integer|min:0',
            'absent_days' => 'nullable|integer|min:0',
            'leave_days' => 'nullable|integer|min:0',
            'status' => 'required|in:draft,approved,paid,cancelled',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Calculate totals
        $validated['gross_salary'] = $validated['basic_salary'] + 
                                     ($validated['allowances'] ?? 0) + 
                                     ($validated['overtime'] ?? 0) + 
                                     ($validated['bonuses'] ?? 0);
        
        $validated['total_deductions'] = ($validated['tax_deduction'] ?? 0) + 
                                         ($validated['provident_fund'] ?? 0) + 
                                         ($validated['other_deductions'] ?? 0);
        
        $validated['net_salary'] = $validated['gross_salary'] - $validated['total_deductions'];

        // Update approved info if status changed to approved/paid
        if (in_array($validated['status'], ['approved', 'paid']) && !$payslip->approved_by) {
            $validated['approved_by'] = auth()->id();
            $validated['approved_at'] = now();
        } elseif ($validated['status'] == 'draft') {
            $validated['approved_by'] = null;
            $validated['approved_at'] = null;
        }

        $payslip->update($validated);

        return redirect()->route('payroll.payslip.index')->with('success', 'Payslip updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $payslip = Payslip::findOrFail($id);
        $payslip->delete();

        return redirect()->route('payroll.payslip.index')->with('success', 'Payslip deleted successfully.');
    }

    /**
     * Approve payslip.
     */
    public function approve(Request $request, string $id)
    {
        $payslip = Payslip::findOrFail($id);
        
        $payslip->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Payslip approved successfully.');
    }
}
