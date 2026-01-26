<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use App\Models\PayrollItem;
use Illuminate\Http\Request;

class PayrollItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PayrollItem::query();

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by active status
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active == '1');
        }

        $payrollItems = $query->orderBy('type')->orderBy('name')->get();

        return view('pages.payroll.payroll-items.index', compact('payrollItems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.payroll.payroll-items.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:allowance,deduction,bonus,overtime,other',
            'calculation_type' => 'required|in:fixed,percentage,per_day,per_hour',
            'amount' => 'nullable|numeric|min:0|required_if:calculation_type,fixed',
            'percentage' => 'nullable|numeric|min:0|max:100|required_if:calculation_type,percentage',
            'description' => 'nullable|string|max:1000',
            'is_taxable' => 'boolean',
            'is_active' => 'boolean',
            'applies_to_all' => 'boolean',
        ]);

        PayrollItem::create($validated);

        return redirect()->route('payroll.items.index')->with('success', 'Payroll item created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $payrollItem = PayrollItem::findOrFail($id);

        return view('pages.payroll.payroll-items.show', compact('payrollItem'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $payrollItem = PayrollItem::findOrFail($id);

        return view('pages.payroll.payroll-items.edit', compact('payrollItem'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $payrollItem = PayrollItem::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:allowance,deduction,bonus,overtime,other',
            'calculation_type' => 'required|in:fixed,percentage,per_day,per_hour',
            'amount' => 'nullable|numeric|min:0|required_if:calculation_type,fixed',
            'percentage' => 'nullable|numeric|min:0|max:100|required_if:calculation_type,percentage',
            'description' => 'nullable|string|max:1000',
            'is_taxable' => 'boolean',
            'is_active' => 'boolean',
            'applies_to_all' => 'boolean',
        ]);

        $payrollItem->update($validated);

        return redirect()->route('payroll.items.index')->with('success', 'Payroll item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $payrollItem = PayrollItem::findOrFail($id);
        $payrollItem->delete();

        return redirect()->route('payroll.items.index')->with('success', 'Payroll item deleted successfully.');
    }
}
