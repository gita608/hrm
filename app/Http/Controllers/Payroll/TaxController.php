<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use App\Models\Tax;
use Illuminate\Http\Request;

class TaxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Tax::query();

        // Filter by active status
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active == '1');
        }

        // Filter by calculation method
        if ($request->filled('calculation_method')) {
            $query->where('calculation_method', $request->calculation_method);
        }

        $taxes = $query->orderBy('min_income', 'asc')->get();

        return view('pages.payroll.tax.index', compact('taxes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.payroll.tax.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'min_income' => 'required|numeric|min:0',
            'max_income' => 'nullable|numeric|min:0|gt:min_income',
            'tax_rate' => 'required|numeric|min:0|max:100',
            'fixed_amount' => 'nullable|numeric|min:0',
            'calculation_method' => 'required|in:progressive,flat,fixed',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
            'effective_from' => 'required|date',
            'effective_to' => 'nullable|date|after:effective_from',
        ]);

        Tax::create($validated);

        return redirect()->route('payroll.tax.index')->with('success', 'Tax bracket created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tax = Tax::findOrFail($id);

        return view('pages.payroll.tax.show', compact('tax'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tax = Tax::findOrFail($id);

        return view('pages.payroll.tax.edit', compact('tax'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $tax = Tax::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'min_income' => 'required|numeric|min:0',
            'max_income' => 'nullable|numeric|min:0|gt:min_income',
            'tax_rate' => 'required|numeric|min:0|max:100',
            'fixed_amount' => 'nullable|numeric|min:0',
            'calculation_method' => 'required|in:progressive,flat,fixed',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
            'effective_from' => 'required|date',
            'effective_to' => 'nullable|date|after:effective_from',
        ]);

        $tax->update($validated);

        return redirect()->route('payroll.tax.index')->with('success', 'Tax bracket updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tax = Tax::findOrFail($id);
        $tax->delete();

        return redirect()->route('payroll.tax.index')->with('success', 'Tax bracket deleted successfully.');
    }
}
