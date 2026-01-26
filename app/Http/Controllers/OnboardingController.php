<?php

namespace App\Http\Controllers;

use App\Models\Onboarding;
use App\Models\OnboardingTemplate;
use App\Models\User;
use Illuminate\Http\Request;

class OnboardingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Onboarding::with(['employee', 'template', 'assignedUser']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by employee
        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        $onboardings = $query->orderBy('created_at', 'desc')->get();
        $employees = User::whereNotNull('email_verified_at')->orderBy('name')->get();

        return view('pages.onboarding.index', compact('onboardings', 'employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = User::whereNotNull('email_verified_at')->orderBy('name')->get();
        $templates = OnboardingTemplate::where('is_active', true)->orderBy('name')->get();
        $users = User::whereNotNull('email_verified_at')->orderBy('name')->get();
        $employeeId = request('employee_id');

        return view('pages.onboarding.create', compact('employees', 'templates', 'users', 'employeeId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:users,id',
            'template_id' => 'nullable|exists:onboarding_templates,id',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'start_date' => 'required|date',
            'expected_completion_date' => 'nullable|date|after:start_date',
            'notes' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $onboarding = Onboarding::create($validated);

        // Note: Template checklist items can be added manually or through template management
        // For now, template selection is stored for reference only

        return redirect()->route('onboarding.index')->with('success', 'Onboarding created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $onboarding = Onboarding::with(['employee', 'template', 'assignedUser', 'checklists.assignedUser'])->findOrFail($id);

        return view('pages.onboarding.show', compact('onboarding'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $onboarding = Onboarding::findOrFail($id);
        $employees = User::whereNotNull('email_verified_at')->orderBy('name')->get();
        $templates = OnboardingTemplate::where('is_active', true)->orderBy('name')->get();
        $users = User::whereNotNull('email_verified_at')->orderBy('name')->get();

        return view('pages.onboarding.edit', compact('onboarding', 'employees', 'templates', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $onboarding = Onboarding::findOrFail($id);

        $validated = $request->validate([
            'employee_id' => 'required|exists:users,id',
            'template_id' => 'nullable|exists:onboarding_templates,id',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'start_date' => 'required|date',
            'expected_completion_date' => 'nullable|date|after:start_date',
            'actual_completion_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        // If status is completed, set actual completion date
        if ($validated['status'] === 'completed' && ! $onboarding->actual_completion_date) {
            $validated['actual_completion_date'] = now();
        }

        $onboarding->update($validated);

        return redirect()->route('onboarding.index')->with('success', 'Onboarding updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $onboarding = Onboarding::findOrFail($id);
        $onboarding->delete();

        return redirect()->route('onboarding.index')->with('success', 'Onboarding deleted successfully.');
    }
}
