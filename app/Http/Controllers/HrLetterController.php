<?php

namespace App\Http\Controllers;

use App\Models\HrLetter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HrLetterController extends Controller
{
    public function index(Request $request)
    {
        $query = HrLetter::with(['employee', 'issuer']);

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('letter_number', 'like', "%{$q}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('letter_type')) {
            $query->where('letter_type', $request->letter_type);
        }

        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        $letters = $query->orderBy('created_at', 'desc')->get();
        $employees = User::all();

        return view('pages.hr-letters.index', compact('letters', 'employees'));
    }

    public function create()
    {
        $employees = User::all();
        return view('pages.hr-letters.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'letter_number' => 'required|string|max:255|unique:hr_letters,letter_number',
            'title' => 'required|string|max:255',
            'letter_type' => 'required|in:offer,appointment,experience,relieving,warning,appreciation,promotion,transfer,other',
            'employee_id' => 'required|exists:users,id',
            'content' => 'required|string',
            'issue_date' => 'required|date',
            'file' => 'nullable|file|max:10240',
            'status' => 'required|in:draft,issued,cancelled',
            'notes' => 'nullable|string',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('hr-letters', $fileName, 'public');
            $validated['file_path'] = $filePath;
        }

        $validated['issued_by'] = auth()->id();

        HrLetter::create($validated);

        return redirect()->route('hr-letters.index')->with('success', 'HR Letter created successfully.');
    }

    public function show(string $id)
    {
        $letter = HrLetter::with(['employee', 'issuer'])->findOrFail($id);
        return view('pages.hr-letters.show', compact('letter'));
    }

    public function edit(string $id)
    {
        $letter = HrLetter::findOrFail($id);
        $employees = User::all();
        return view('pages.hr-letters.edit', compact('letter', 'employees'));
    }

    public function update(Request $request, string $id)
    {
        $letter = HrLetter::findOrFail($id);

        $validated = $request->validate([
            'letter_number' => 'required|string|max:255|unique:hr_letters,letter_number,'.$id,
            'title' => 'required|string|max:255',
            'letter_type' => 'required|in:offer,appointment,experience,relieving,warning,appreciation,promotion,transfer,other',
            'employee_id' => 'required|exists:users,id',
            'content' => 'required|string',
            'issue_date' => 'required|date',
            'file' => 'nullable|file|max:10240',
            'status' => 'required|in:draft,issued,cancelled',
            'notes' => 'nullable|string',
        ]);

        if ($request->hasFile('file')) {
            if ($letter->file_path) {
                Storage::disk('public')->delete($letter->file_path);
            }

            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('hr-letters', $fileName, 'public');
            $validated['file_path'] = $filePath;
        }

        $letter->update($validated);

        return redirect()->route('hr-letters.index')->with('success', 'HR Letter updated successfully.');
    }

    public function destroy(string $id)
    {
        $letter = HrLetter::findOrFail($id);

        if ($letter->file_path) {
            Storage::disk('public')->delete($letter->file_path);
        }

        $letter->delete();

        return redirect()->route('hr-letters.index')->with('success', 'HR Letter deleted successfully.');
    }
}
