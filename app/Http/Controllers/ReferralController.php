<?php

namespace App\Http\Controllers;

use App\Models\JobPosting;
use App\Models\Referral;
use App\Models\User;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Referral::with(['referrer', 'jobPosting']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by job posting
        if ($request->filled('job_posting_id')) {
            $query->where('job_posting_id', $request->job_posting_id);
        }

        // Filter by referrer
        if ($request->filled('referrer_id')) {
            $query->where('referrer_id', $request->referrer_id);
        }

        // Filter by bonus status
        if ($request->filled('bonus_status')) {
            $query->where('bonus_status', $request->bonus_status);
        }

        $referrals = $query->orderBy('created_at', 'desc')->get();
        $jobPostings = JobPosting::where('status', 'open')->orderBy('title')->get();
        $employees = User::orderBy('name')->get();

        return view('pages.referrals.index', compact('referrals', 'jobPostings', 'employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jobPostings = JobPosting::where('status', 'open')->orderBy('title')->get();
        $employees = User::orderBy('name')->get();
        $jobPostingId = request('job_posting_id');

        return view('pages.referrals.create', compact('jobPostings', 'employees', 'jobPostingId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'referral_code' => 'nullable|string|max:255|unique:referrals,referral_code',
            'referrer_id' => 'required|exists:users,id',
            'referred_first_name' => 'required|string|max:255',
            'referred_last_name' => 'required|string|max:255',
            'referred_email' => 'required|email|max:255|unique:referrals,referred_email',
            'referred_phone' => 'nullable|string|max:20',
            'job_posting_id' => 'nullable|exists:job_postings,id',
            'referral_date' => 'required|date',
            'status' => 'required|in:pending,contacted,interviewed,shortlisted,hired,rejected,withdrawn',
            'referral_bonus' => 'nullable|numeric|min:0',
            'bonus_status' => 'nullable|in:pending,approved,paid',
            'bonus_paid_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'referred_skills' => 'nullable|string',
            'referred_experience' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        Referral::create($validated);

        return redirect()->route('referrals.index')->with('success', 'Referral created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $referral = Referral::with(['referrer', 'jobPosting'])->findOrFail($id);

        return view('pages.referrals.show', compact('referral'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $referral = Referral::findOrFail($id);
        $jobPostings = JobPosting::where('status', 'open')->orderBy('title')->get();
        $employees = User::orderBy('name')->get();

        return view('pages.referrals.edit', compact('referral', 'jobPostings', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $referral = Referral::findOrFail($id);

        $validated = $request->validate([
            'referral_code' => 'nullable|string|max:255|unique:referrals,referral_code,'.$id,
            'referrer_id' => 'required|exists:users,id',
            'referred_first_name' => 'required|string|max:255',
            'referred_last_name' => 'required|string|max:255',
            'referred_email' => 'required|email|max:255|unique:referrals,referred_email,'.$id,
            'referred_phone' => 'nullable|string|max:20',
            'job_posting_id' => 'nullable|exists:job_postings,id',
            'referral_date' => 'required|date',
            'status' => 'required|in:pending,contacted,interviewed,shortlisted,hired,rejected,withdrawn',
            'referral_bonus' => 'nullable|numeric|min:0',
            'bonus_status' => 'nullable|in:pending,approved,paid',
            'bonus_paid_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'referred_skills' => 'nullable|string',
            'referred_experience' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $referral->update($validated);

        return redirect()->route('referrals.index')->with('success', 'Referral updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $referral = Referral::findOrFail($id);
        $referral->delete();

        return redirect()->route('referrals.index')->with('success', 'Referral deleted successfully.');
    }
}
