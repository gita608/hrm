<?php

namespace App\Http\Controllers;

use App\Models\JobPosting;
use App\Models\Department;
use App\Models\Designation;
use Illuminate\Http\Request;

class JobPostingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = JobPosting::with(['department', 'designation']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by department
        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        // Filter by job type
        if ($request->filled('job_type')) {
            $query->where('job_type', $request->job_type);
        }

        $jobPostings = $query->orderBy('created_at', 'desc')->get();
        $departments = Department::where('is_active', true)->orderBy('name')->get();

        return view('pages.jobs.index', compact('jobPostings', 'departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::where('is_active', true)->orderBy('name')->get();
        $designations = Designation::where('is_active', true)->orderBy('name')->get();
        return view('pages.jobs.create', compact('departments', 'designations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'job_code' => 'nullable|string|max:255|unique:job_postings,job_code',
            'title' => 'required|string|max:255',
            'department_id' => 'nullable|exists:departments,id',
            'designation_id' => 'nullable|exists:designations,id',
            'no_of_positions' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'job_type' => 'required|in:full_time,part_time,contract,internship,temporary',
            'experience_level' => 'nullable|in:entry,mid,senior,executive',
            'location' => 'nullable|string|max:255',
            'salary_from' => 'nullable|numeric|min:0',
            'salary_to' => 'nullable|numeric|min:0|gte:salary_from',
            'description' => 'nullable|string',
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
            'status' => 'required|in:draft,open,closed,cancelled',
            'is_active' => 'boolean',
            // UAE-specific fields
            'uae_emirate' => 'nullable|in:Abu Dhabi,Dubai,Sharjah,Ajman,Umm Al Quwain,Ras Al Khaimah,Fujairah',
            'uae_city' => 'nullable|string|max:255',
            'visa_sponsorship' => 'boolean',
            'work_permit_required' => 'boolean',
        ]);

        JobPosting::create($validated);

        return redirect()->route('jobs.index')->with('success', 'Job posting created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jobPosting = JobPosting::with(['department', 'designation', 'candidates'])->findOrFail($id);
        return view('pages.jobs.show', compact('jobPosting'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jobPosting = JobPosting::findOrFail($id);
        $departments = Department::where('is_active', true)->orderBy('name')->get();
        $designations = Designation::where('is_active', true)->orderBy('name')->get();
        return view('pages.jobs.edit', compact('jobPosting', 'departments', 'designations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $jobPosting = JobPosting::findOrFail($id);

        $validated = $request->validate([
            'job_code' => 'nullable|string|max:255|unique:job_postings,job_code,' . $id,
            'title' => 'required|string|max:255',
            'department_id' => 'nullable|exists:departments,id',
            'designation_id' => 'nullable|exists:designations,id',
            'no_of_positions' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'job_type' => 'required|in:full_time,part_time,contract,internship,temporary',
            'experience_level' => 'nullable|in:entry,mid,senior,executive',
            'location' => 'nullable|string|max:255',
            'salary_from' => 'nullable|numeric|min:0',
            'salary_to' => 'nullable|numeric|min:0|gte:salary_from',
            'description' => 'nullable|string',
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
            'status' => 'required|in:draft,open,closed,cancelled',
            'is_active' => 'boolean',
            // UAE-specific fields
            'uae_emirate' => 'nullable|in:Abu Dhabi,Dubai,Sharjah,Ajman,Umm Al Quwain,Ras Al Khaimah,Fujairah',
            'uae_city' => 'nullable|string|max:255',
            'visa_sponsorship' => 'boolean',
            'work_permit_required' => 'boolean',
        ]);

        $jobPosting->update($validated);

        return redirect()->route('jobs.index')->with('success', 'Job posting updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jobPosting = JobPosting::findOrFail($id);
        $jobPosting->delete();

        return redirect()->route('jobs.index')->with('success', 'Job posting deleted successfully.');
    }
}
