<?php

namespace App\Http\Controllers;

use App\Models\Interview;
use App\Models\User;
use Illuminate\Http\Request;

class InterviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Interview::with(['candidate', 'interviewer']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by interviewer
        if ($request->filled('interviewer_id')) {
            $query->where('interviewer_id', $request->interviewer_id);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('interview_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('interview_date', '<=', $request->date_to);
        }

        $interviews = $query->orderBy('interview_date', 'desc')
            ->orderBy('interview_time', 'desc')
            ->get();

        $interviewers = User::orderBy('name')->get();

        return view('pages.interviews.index', compact('interviews', 'interviewers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $candidates = User::orderBy('name')->get();
        $interviewers = User::orderBy('name')->get();

        return view('pages.interviews.create', compact('candidates', 'interviewers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'candidate_id' => 'nullable|exists:users,id',
            'candidate_name' => 'nullable|string|max:255',
            'candidate_email' => 'nullable|email|max:255',
            'candidate_phone' => 'nullable|string|max:20',
            'job_title' => 'nullable|string|max:255',
            'interviewer_id' => 'nullable|exists:users,id',
            'interview_date' => 'required|date',
            'interview_time' => 'required|date_format:H:i',
            'location' => 'nullable|string|max:255',
            'status' => 'required|in:scheduled,completed,cancelled,rescheduled',
            'notes' => 'nullable|string',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        Interview::create($validated);

        return redirect()->route('interviews.index')->with('success', 'Interview scheduled successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $interview = Interview::with(['candidate', 'interviewer', 'feedbacks.interviewer'])->findOrFail($id);

        return view('pages.interviews.show', compact('interview'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $interview = Interview::findOrFail($id);
        $candidates = User::orderBy('name')->get();
        $interviewers = User::orderBy('name')->get();

        return view('pages.interviews.edit', compact('interview', 'candidates', 'interviewers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $interview = Interview::findOrFail($id);

        $validated = $request->validate([
            'candidate_id' => 'nullable|exists:users,id',
            'candidate_name' => 'nullable|string|max:255',
            'candidate_email' => 'nullable|email|max:255',
            'candidate_phone' => 'nullable|string|max:20',
            'job_title' => 'nullable|string|max:255',
            'interviewer_id' => 'nullable|exists:users,id',
            'interview_date' => 'required|date',
            'interview_time' => 'required|date_format:H:i',
            'location' => 'nullable|string|max:255',
            'status' => 'required|in:scheduled,completed,cancelled,rescheduled',
            'notes' => 'nullable|string',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $interview->update($validated);

        return redirect()->route('interviews.index')->with('success', 'Interview updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $interview = Interview::findOrFail($id);
        $interview->delete();

        return redirect()->route('interviews.index')->with('success', 'Interview deleted successfully.');
    }
}
