<?php

namespace App\Http\Controllers;

use App\Models\AssistanceRequest;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminAssistanceRequestController extends Controller
{
    public function index()
    {
        $requests = AssistanceRequest::with(['scholarship', 'university', 'documents'])
            ->latest()
            ->paginate(10);

        return view('admin.assistance_requests.index', compact('requests'));
    }

    public function show(AssistanceRequest $assistanceRequest)
    {
        $assistanceRequest->load(['scholarship', 'university', 'documents']);

        return view('admin.assistance_requests.show', compact('assistanceRequest'));
    }

    /**
     * Open a student's uploaded document. Admin only (route is inside the auth + admin group).
     * PDFs and images open in the browser; other files (Word) are downloaded.
     */
    public function document(Document $document)
    {
        $disk = Storage::disk(Document::DISK);

        abort_unless($disk->exists($document->file_path), 404);

        $extension = strtolower(pathinfo($document->file_path, PATHINFO_EXTENSION));
        $disposition = in_array($extension, ['pdf', 'jpg', 'jpeg', 'png'], true) ? 'inline' : 'attachment';
        $name = $document->original_name ?: basename($document->file_path);

        return $disk->response($document->file_path, $name, [
            'X-Content-Type-Options' => 'nosniff',
            'Cache-Control' => 'private, no-store',
        ], $disposition);
    }

    public function update(Request $request, AssistanceRequest $assistanceRequest)
    {
        $validated = $request->validate([
            'status' => 'required|string',
            'admin_notes' => 'nullable|string',
        ]);

        $assistanceRequest->update([
            'status' => $validated['status'],
            'admin_notes' => $validated['admin_notes'] ?? null,
        ]);

        return redirect()
            ->route('admin.assistance_requests.show', $assistanceRequest)
            ->with('success', __('Request status updated successfully.'));
    }
}