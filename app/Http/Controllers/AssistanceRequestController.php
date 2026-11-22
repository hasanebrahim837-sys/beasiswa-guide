<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Scholarship;
use App\Models\AssistanceRequest;
use Illuminate\Http\Request;

class AssistanceRequestController extends Controller
{
    public function create(Scholarship $scholarship)
    {
        $scholarship->load(['country', 'university']);

        return view('assistance.create', compact('scholarship'));
    }

    public function store(Request $request, Scholarship $scholarship)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'whatsapp' => 'nullable|string|max:50',
            'nationality' => 'nullable|string|max:100',
            'degree' => 'nullable|string|max:100',
            'student_notes' => 'nullable|string',

            'passport' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'transcript' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'cv' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'motivation_letter' => 'nullable|file|mimes:pdf,doc,docx|max:5120',

            'consent' => 'accepted',
        ]);

        $assistanceRequest = AssistanceRequest::create([
            'scholarship_id' => $scholarship->id,
            'university_id' => $scholarship->university_id,
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'whatsapp' => $validated['whatsapp'] ?? null,
            'nationality' => $validated['nationality'] ?? null,
            'degree' => $validated['degree'] ?? $scholarship->degree,
            'status' => 'Pending',
            'student_notes' => $validated['student_notes'] ?? null,
        ]);

        $files = [
            'passport' => 'Passport',
            'certificate' => 'Academic Certificate',
            'transcript' => 'Academic Transcript',
            'cv' => 'CV',
            'motivation_letter' => 'Motivation Letter',
        ];

        foreach ($files as $inputName => $documentType) {
            if ($request->hasFile($inputName)) {
                $file = $request->file($inputName);
                // Private storage: never reachable by a direct link.
                $path = $file->store('assistance-documents', Document::DISK);

                Document::create([
                    'assistance_request_id' => $assistanceRequest->id,
                    'document_type' => $documentType,
                    'file_path' => $path,
                    'original_name' => $file->getClientOriginalName(),
                ]);
            }
        }

        return redirect()
            ->route('scholarships.show', $scholarship)
            ->with('success', __('Your assistance request has been submitted successfully.'));
    }
}