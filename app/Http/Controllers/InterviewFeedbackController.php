<?php

namespace App\Http\Controllers;

use App\Models\InterviewFeedback;
use App\Models\Interview;
use App\Models\User;
use Illuminate\Http\Request;

class InterviewFeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = InterviewFeedback::with(['interview.candidate', 'interview.interviewer', 'interviewer']);

        // Filter by interview
        if ($request->filled('interview_id')) {
            $query->where('interview_id', $request->interview_id);
        }

        // Filter by interviewer
        if ($request->filled('interviewer_id')) {
            $query->where('interviewer_id', $request->interviewer_id);
        }

        // Filter by recommendation
        if ($request->filled('recommendation')) {
            $query->where('recommendation', $request->recommendation);
        }

        $feedbacks = $query->orderBy('created_at', 'desc')->get();
        $interviews = Interview::where('status', 'completed')->orderBy('interview_date', 'desc')->get();
        $interviewers = User::orderBy('name')->get();

        return view('pages.interviews.feedback.index', compact('feedbacks', 'interviews', 'interviewers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $interviewId = $request->get('interview_id');
        $interviews = Interview::where('status', '!=', 'cancelled')
            ->orderBy('interview_date', 'desc')
            ->get();
        $interviewers = User::orderBy('name')->get();
        
        return view('pages.interviews.feedback.create', compact('interviews', 'interviewers', 'interviewId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'interview_id' => 'required|exists:interviews,id',
            'interviewer_id' => 'required|exists:users,id',
            'rating' => 'nullable|integer|min:1|max:5',
            'feedback' => 'nullable|string',
            'recommendation' => 'nullable|in:hire,reject,maybe,strong_hire',
            'strengths' => 'nullable|string',
            'weaknesses' => 'nullable|string',
            'additional_notes' => 'nullable|string',
        ]);

        InterviewFeedback::create($validated);

        // Update interview status to completed if not already
        $interview = Interview::findOrFail($validated['interview_id']);
        if ($interview->status !== 'completed') {
            $interview->update(['status' => 'completed']);
        }

        return redirect()->route('interviews.feedback.index')->with('success', 'Interview feedback submitted successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $feedback = InterviewFeedback::with(['interview.candidate', 'interview.interviewer', 'interviewer'])->findOrFail($id);
        return view('pages.interviews.feedback.show', compact('feedback'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $feedback = InterviewFeedback::findOrFail($id);
        $interviews = Interview::where('status', '!=', 'cancelled')
            ->orderBy('interview_date', 'desc')
            ->get();
        $interviewers = User::orderBy('name')->get();
        
        return view('pages.interviews.feedback.edit', compact('feedback', 'interviews', 'interviewers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $feedback = InterviewFeedback::findOrFail($id);

        $validated = $request->validate([
            'interview_id' => 'required|exists:interviews,id',
            'interviewer_id' => 'required|exists:users,id',
            'rating' => 'nullable|integer|min:1|max:5',
            'feedback' => 'nullable|string',
            'recommendation' => 'nullable|in:hire,reject,maybe,strong_hire',
            'strengths' => 'nullable|string',
            'weaknesses' => 'nullable|string',
            'additional_notes' => 'nullable|string',
        ]);

        $feedback->update($validated);

        return redirect()->route('interviews.feedback.index')->with('success', 'Interview feedback updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $feedback = InterviewFeedback::findOrFail($id);
        $feedback->delete();

        return redirect()->route('interviews.feedback.index')->with('success', 'Interview feedback deleted successfully.');
    }
}
