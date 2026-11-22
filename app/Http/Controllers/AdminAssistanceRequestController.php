<?php

namespace App\Http\Controllers;

use App\Models\AssistanceRequest;
use Illuminate\Http\Request;

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