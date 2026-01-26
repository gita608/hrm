<?php

namespace App\Http\Controllers;

use App\Models\Onboarding;
use App\Models\OnboardingChecklist;
use Illuminate\Http\Request;

class OnboardingChecklistController extends Controller
{
    public function index(Request $request)
    {
        $query = OnboardingChecklist::with(['onboarding.employee', 'assignedUser']);

        if ($request->filled('onboarding_id')) {
            $query->where('onboarding_id', $request->onboarding_id);
        }

        $checklists = $query->orderBy('order')->get();

        return view('pages.onboarding.checklist.index', compact('checklists'));
    }

    public function store(Request $request, string $onboarding_id)
    {
        $onboarding = Onboarding::findOrFail($onboarding_id);

        $validated = $request->validate([
            'task_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'task_type' => 'required|in:document,training,setup,other',
            'due_date' => 'nullable|date',
            'assigned_to' => 'nullable|exists:users,id',
            'order' => 'nullable|integer|min:0',
            'is_required' => 'boolean',
        ]);

        $validated['onboarding_id'] = $onboarding_id;
        $validated['order'] = $validated['order'] ?? OnboardingChecklist::where('onboarding_id', $onboarding_id)->max('order') + 1;

        OnboardingChecklist::create($validated);

        return redirect()->route('onboarding.show', $onboarding_id)->with('success', 'Checklist item added successfully.');
    }

    public function update(Request $request, string $id)
    {
        $checklist = OnboardingChecklist::findOrFail($id);

        $validated = $request->validate([
            'task_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'task_type' => 'required|in:document,training,setup,other',
            'due_date' => 'nullable|date',
            'assigned_to' => 'nullable|exists:users,id',
            'order' => 'nullable|integer|min:0',
            'is_required' => 'boolean',
        ]);

        $checklist->update($validated);

        return redirect()->route('onboarding.show', $checklist->onboarding_id)->with('success', 'Checklist item updated successfully.');
    }

    public function complete(Request $request, string $id)
    {
        $checklist = OnboardingChecklist::findOrFail($id);
        $checklist->update([
            'is_completed' => true,
            'completed_date' => now(),
        ]);

        return redirect()->route('onboarding.show', $checklist->onboarding_id)->with('success', 'Checklist item marked as completed.');
    }

    public function destroy(string $id)
    {
        $checklist = OnboardingChecklist::findOrFail($id);
        $onboardingId = $checklist->onboarding_id;
        $checklist->delete();

        return redirect()->route('onboarding.show', $onboardingId)->with('success', 'Checklist item deleted successfully.');
    }
}
