<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use App\Models\User;
use App\Models\Department;
use App\Models\Designation;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index(Request $request)
    {
        $query = Promotion::with(['employee', 'fromDepartment', 'toDepartment', 'fromDesignation', 'toDesignation']);

        // Filter by employee
        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        // Filter by department
        if ($request->filled('department_id')) {
            $query->where('to_department_id', $request->department_id);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->where('promotion_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('promotion_date', '<=', $request->date_to);
        }

        $promotions = $query->orderBy('promotion_date', 'desc')->get();
        $employees = User::orderBy('name')->get();
        $departments = Department::where('is_active', true)->orderBy('name')->get();

        return view('pages.promotions.index', compact('promotions', 'employees', 'departments'));
    }

    public function create()
    {
        $employees = User::orderBy('name')->get();
        $departments = Department::where('is_active', true)->orderBy('name')->get();
        $designations = Designation::where('is_active', true)->orderBy('name')->get();

        return view('pages.promotions.create', compact('employees', 'departments', 'designations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:users,id',
            'from_department_id' => 'nullable|exists:departments,id',
            'to_department_id' => 'nullable|exists:departments,id',
            'from_designation_id' => 'nullable|exists:designations,id',
            'to_designation_id' => 'nullable|exists:designations,id',
            'promotion_date' => 'required|date',
            'salary' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        Promotion::create($validated);

        return redirect()->route('promotions.index')->with('success', 'Promotion created successfully.');
    }

    public function show(string $id)
    {
        $promotion = Promotion::with(['employee', 'fromDepartment', 'toDepartment', 'fromDesignation', 'toDesignation'])->findOrFail($id);
        return view('pages.promotions.show', compact('promotion'));
    }

    public function edit(string $id)
    {
        $promotion = Promotion::findOrFail($id);
        $employees = User::orderBy('name')->get();
        $departments = Department::where('is_active', true)->orderBy('name')->get();
        $designations = Designation::where('is_active', true)->orderBy('name')->get();

        return view('pages.promotions.edit', compact('promotion', 'employees', 'departments', 'designations'));
    }

    public function update(Request $request, string $id)
    {
        $promotion = Promotion::findOrFail($id);

        $validated = $request->validate([
            'employee_id' => 'required|exists:users,id',
            'from_department_id' => 'nullable|exists:departments,id',
            'to_department_id' => 'nullable|exists:departments,id',
            'from_designation_id' => 'nullable|exists:designations,id',
            'to_designation_id' => 'nullable|exists:designations,id',
            'promotion_date' => 'required|date',
            'salary' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $promotion->update($validated);

        return redirect()->route('promotions.index')->with('success', 'Promotion updated successfully.');
    }

    public function destroy(string $id)
    {
        $promotion = Promotion::findOrFail($id);
        $promotion->delete();

        return redirect()->route('promotions.index')->with('success', 'Promotion deleted successfully.');
    }
}
