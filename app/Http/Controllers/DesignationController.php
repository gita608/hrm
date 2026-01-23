<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use App\Models\Department;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $designations = Designation::with('department')->orderBy('created_at', 'desc')->get();
        return view('pages.designations.index', compact('designations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::where('is_active', true)->get();
        return view('pages.designations.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255|unique:designations,code',
            'description' => 'nullable|string',
            'department_id' => 'nullable|exists:departments,id',
            'is_active' => 'boolean',
        ]);

        Designation::create($validated);

        return redirect()->route('designations.index')->with('success', 'Designation created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $designation = Designation::with('department')->findOrFail($id);
        return view('pages.designations.show', compact('designation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $designation = Designation::findOrFail($id);
        $departments = Department::where('is_active', true)->get();
        return view('pages.designations.edit', compact('designation', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $designation = Designation::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255|unique:designations,code,' . $id,
            'description' => 'nullable|string',
            'department_id' => 'nullable|exists:departments,id',
            'is_active' => 'boolean',
        ]);

        $designation->update($validated);

        return redirect()->route('designations.index')->with('success', 'Designation updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $designation = Designation::findOrFail($id);
        $designation->delete();

        return redirect()->route('designations.index')->with('success', 'Designation deleted successfully.');
    }
}
