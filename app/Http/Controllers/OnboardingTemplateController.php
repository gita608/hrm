<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Designation;
use App\Models\OnboardingTemplate;
use Illuminate\Http\Request;

class OnboardingTemplateController extends Controller
{
    public function index()
    {
        $templates = OnboardingTemplate::with(['department', 'designation'])->orderBy('name')->get();

        return view('pages.onboarding.templates.index', compact('templates'));
    }

    public function create()
    {
        $departments = Department::orderBy('name')->get();
        $designations = Designation::orderBy('name')->get();

        return view('pages.onboarding.templates.create', compact('departments', 'designations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'department_id' => 'nullable|exists:departments,id',
            'designation_id' => 'nullable|exists:designations,id',
            'is_active' => 'boolean',
            'duration_days' => 'required|integer|min:1',
        ]);

        OnboardingTemplate::create($validated);

        return redirect()->route('onboarding.templates.index')->with('success', 'Template created successfully.');
    }

    public function show(string $id)
    {
        $template = OnboardingTemplate::with(['department', 'designation', 'checklistItems'])->findOrFail($id);

        return view('pages.onboarding.templates.show', compact('template'));
    }

    public function edit(string $id)
    {
        $template = OnboardingTemplate::findOrFail($id);
        $departments = Department::orderBy('name')->get();
        $designations = Designation::orderBy('name')->get();

        return view('pages.onboarding.templates.edit', compact('template', 'departments', 'designations'));
    }

    public function update(Request $request, string $id)
    {
        $template = OnboardingTemplate::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'department_id' => 'nullable|exists:departments,id',
            'designation_id' => 'nullable|exists:designations,id',
            'is_active' => 'boolean',
            'duration_days' => 'required|integer|min:1',
        ]);

        $template->update($validated);

        return redirect()->route('onboarding.templates.index')->with('success', 'Template updated successfully.');
    }

    public function destroy(string $id)
    {
        $template = OnboardingTemplate::findOrFail($id);
        $template->delete();

        return redirect()->route('onboarding.templates.index')->with('success', 'Template deleted successfully.');
    }
}
