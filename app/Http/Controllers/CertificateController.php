<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{
    public function index(Request $request)
    {
        $query = Certificate::with('employee');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('certificate_type')) {
            $query->where('certificate_type', $request->certificate_type);
        }

        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        $certificates = $query->orderBy('created_at', 'desc')->get();
        $employees = User::all();

        return view('pages.certificates.index', compact('certificates', 'employees'));
    }

    public function create()
    {
        $employees = User::all();
        return view('pages.certificates.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'certificate_number' => 'required|string|max:255|unique:certificates,certificate_number',
            'title' => 'required|string|max:255',
            'certificate_type' => 'required|in:education,training,achievement,professional,other',
            'employee_id' => 'required|exists:users,id',
            'issuing_authority' => 'nullable|string|max:255',
            'issue_date' => 'required|date',
            'expiry_date' => 'nullable|date|after_or_equal:issue_date',
            'file' => 'nullable|file|max:10240',
            'description' => 'nullable|string',
            'status' => 'required|in:active,expired,revoked',
            'notes' => 'nullable|string',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('certificates', $fileName, 'public');
            $validated['file_path'] = $filePath;
        }

        Certificate::create($validated);

        return redirect()->route('certificates.index')->with('success', 'Certificate created successfully.');
    }

    public function show(string $id)
    {
        $certificate = Certificate::with('employee')->findOrFail($id);
        return view('pages.certificates.show', compact('certificate'));
    }

    public function edit(string $id)
    {
        $certificate = Certificate::findOrFail($id);
        $employees = User::all();
        return view('pages.certificates.edit', compact('certificate', 'employees'));
    }

    public function update(Request $request, string $id)
    {
        $certificate = Certificate::findOrFail($id);

        $validated = $request->validate([
            'certificate_number' => 'required|string|max:255|unique:certificates,certificate_number,'.$id,
            'title' => 'required|string|max:255',
            'certificate_type' => 'required|in:education,training,achievement,professional,other',
            'employee_id' => 'required|exists:users,id',
            'issuing_authority' => 'nullable|string|max:255',
            'issue_date' => 'required|date',
            'expiry_date' => 'nullable|date|after_or_equal:issue_date',
            'file' => 'nullable|file|max:10240',
            'description' => 'nullable|string',
            'status' => 'required|in:active,expired,revoked',
            'notes' => 'nullable|string',
        ]);

        if ($request->hasFile('file')) {
            if ($certificate->file_path) {
                Storage::disk('public')->delete($certificate->file_path);
            }

            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('certificates', $fileName, 'public');
            $validated['file_path'] = $filePath;
        }

        $certificate->update($validated);

        return redirect()->route('certificates.index')->with('success', 'Certificate updated successfully.');
    }

    public function destroy(string $id)
    {
        $certificate = Certificate::findOrFail($id);

        if ($certificate->file_path) {
            Storage::disk('public')->delete($certificate->file_path);
        }

        $certificate->delete();

        return redirect()->route('certificates.index')->with('success', 'Certificate deleted successfully.');
    }
}
