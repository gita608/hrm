<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $query = Document::with(['uploader', 'employee']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('document_number', 'like', "%{$q}%");
            });
        }

        $documents = $query->orderBy('created_at', 'desc')->get();
        $employees = User::all();

        return view('pages.documents.index', compact('documents', 'employees'));
    }

    public function create()
    {
        $employees = User::all();
        return view('pages.documents.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'document_number' => 'nullable|string|max:255|unique:documents,document_number',
            'description' => 'nullable|string',
            'file' => 'required|file|max:10240',
            'employee_id' => 'required|exists:users,id',
            'issue_date' => 'nullable|date',
            'expiry_date' => 'nullable|date|after_or_equal:issue_date',
            'status' => 'required|in:active,expired,archived',
            'notes' => 'nullable|string',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('documents', $fileName, 'public');

            $validated['file_path'] = $filePath;
            $validated['file_name'] = $file->getClientOriginalName();
            $validated['file_type'] = $file->getClientMimeType();
            $validated['file_size'] = $file->getSize();
        }

        $validated['uploaded_by'] = auth()->id();

        Document::create($validated);

        return redirect()->route('documents.index')->with('success', 'Document created successfully.');
    }

    public function show(string $id)
    {
        $document = Document::with(['uploader', 'employee'])->findOrFail($id);
        return view('pages.documents.show', compact('document'));
    }

    public function edit(string $id)
    {
        $document = Document::findOrFail($id);
        $employees = User::all();
        return view('pages.documents.edit', compact('document', 'employees'));
    }

    public function update(Request $request, string $id)
    {
        $document = Document::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'document_number' => 'nullable|string|max:255|unique:documents,document_number,'.$id,
            'description' => 'nullable|string',
            'file' => 'nullable|file|max:10240',
            'employee_id' => 'required|exists:users,id',
            'issue_date' => 'nullable|date',
            'expiry_date' => 'nullable|date|after_or_equal:issue_date',
            'status' => 'required|in:active,expired,archived',
            'notes' => 'nullable|string',
        ]);

        if ($request->hasFile('file')) {
            if ($document->file_path) {
                Storage::disk('public')->delete($document->file_path);
            }

            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('documents', $fileName, 'public');

            $validated['file_path'] = $filePath;
            $validated['file_name'] = $file->getClientOriginalName();
            $validated['file_type'] = $file->getClientMimeType();
            $validated['file_size'] = $file->getSize();
        }

        $document->update($validated);

        return redirect()->route('documents.index')->with('success', 'Document updated successfully.');
    }

    public function destroy(string $id)
    {
        $document = Document::findOrFail($id);

        if ($document->file_path) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return redirect()->route('documents.index')->with('success', 'Document deleted successfully.');
    }
}
