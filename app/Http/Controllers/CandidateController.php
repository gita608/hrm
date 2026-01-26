<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\JobPosting;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Candidate::with(['jobPosting']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by job posting
        if ($request->filled('job_posting_id')) {
            $query->where('job_posting_id', $request->job_posting_id);
        }

        // Filter by applied role
        if ($request->filled('applied_role')) {
            $query->where('applied_role', 'like', '%'.$request->applied_role.'%');
        }

        $candidates = $query->orderBy('created_at', 'desc')->get();
        $jobPostings = JobPosting::where('status', 'open')->orderBy('title')->get();

        return view('pages.candidates.index', compact('candidates', 'jobPostings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jobPostings = JobPosting::where('status', 'open')->orderBy('title')->get();
        $jobPostingId = request('job_posting_id');

        return view('pages.candidates.create', compact('jobPostings', 'jobPostingId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'candidate_code' => 'nullable|string|max:255|unique:candidates,candidate_code',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:candidates,email',
            'phone' => 'nullable|string|max:20',
            'job_posting_id' => 'nullable|exists:job_postings,id',
            'applied_role' => 'nullable|string|max:255',
            'applied_date' => 'required|date',
            'resume_path' => 'nullable|string|max:255',
            'cover_letter' => 'nullable|string',
            'status' => 'required|in:app_received,screening,scheduled,interviewed,shortlisted,hired,rejected,withdrawn',
            'notes' => 'nullable|string',
            'experience_summary' => 'nullable|string',
            'education' => 'nullable|string',
            'skills' => 'nullable|string',
            'is_active' => 'boolean',
            // UAE-specific fields
            'emirates_id' => 'nullable|string|max:255',
            'passport_number' => 'nullable|string|max:255',
            'nationality' => 'nullable|string|max:255',
            'visa_status' => 'nullable|in:valid,expired,not_required,pending',
            'current_location_emirate' => 'nullable|in:Abu Dhabi,Dubai,Sharjah,Ajman,Umm Al Quwain,Ras Al Khaimah,Fujairah,Outside UAE',
            'current_location_city' => 'nullable|string|max:255',
        ]);

        Candidate::create($validated);

        return redirect()->route('candidates.index')->with('success', 'Candidate created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $candidate = Candidate::with(['jobPosting'])->findOrFail($id);

        return view('pages.candidates.show', compact('candidate'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $candidate = Candidate::findOrFail($id);
        $jobPostings = JobPosting::where('status', 'open')->orderBy('title')->get();

        return view('pages.candidates.edit', compact('candidate', 'jobPostings'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $candidate = Candidate::findOrFail($id);

        $validated = $request->validate([
            'candidate_code' => 'nullable|string|max:255|unique:candidates,candidate_code,'.$id,
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:candidates,email,'.$id,
            'phone' => 'nullable|string|max:20',
            'job_posting_id' => 'nullable|exists:job_postings,id',
            'applied_role' => 'nullable|string|max:255',
            'applied_date' => 'required|date',
            'resume_path' => 'nullable|string|max:255',
            'cover_letter' => 'nullable|string',
            'status' => 'required|in:app_received,screening,scheduled,interviewed,shortlisted,hired,rejected,withdrawn',
            'notes' => 'nullable|string',
            'experience_summary' => 'nullable|string',
            'education' => 'nullable|string',
            'skills' => 'nullable|string',
            'is_active' => 'boolean',
            // UAE-specific fields
            'emirates_id' => 'nullable|string|max:255',
            'passport_number' => 'nullable|string|max:255',
            'nationality' => 'nullable|string|max:255',
            'visa_status' => 'nullable|in:valid,expired,not_required,pending',
            'current_location_emirate' => 'nullable|in:Abu Dhabi,Dubai,Sharjah,Ajman,Umm Al Quwain,Ras Al Khaimah,Fujairah,Outside UAE',
            'current_location_city' => 'nullable|string|max:255',
        ]);

        $candidate->update($validated);

        return redirect()->route('candidates.index')->with('success', 'Candidate updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $candidate = Candidate::findOrFail($id);
        $candidate->delete();

        return redirect()->route('candidates.index')->with('success', 'Candidate deleted successfully.');
    }
}
