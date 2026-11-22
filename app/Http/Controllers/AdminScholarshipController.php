<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\University;
use App\Models\Scholarship;
use Illuminate\Http\Request;

class AdminScholarshipController extends Controller
{
    public function index()
    {
        $scholarships = Scholarship::with(['country', 'university'])
            ->latest()
            ->paginate(10);

        return view('admin.scholarships.index', compact('scholarships'));
    }

    public function create()
    {
        $countries = Country::orderBy('name')->get();
        $universities = University::orderBy('name')->get();

        return view('admin.scholarships.create', compact('countries', 'universities'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'country_id' => 'required|exists:countries,id',
            'university_id' => 'nullable|exists:universities,id',
            'title' => 'required|string|max:255',
            'degree' => 'required|string|max:255',
            'funding_type' => 'nullable|string|max:255',
            'open_date' => 'nullable|date',
            'deadline' => 'nullable|date',
            'official_link' => 'required|url',
            'source_link' => 'nullable|url',
            'description' => 'nullable|string',
            'eligibility' => 'nullable|string',
            'required_documents' => 'nullable|string',
            'title_ar' => 'nullable|string|max:255',
            'description_ar' => 'nullable|string',
            'eligibility_ar' => 'nullable|string',
            'required_documents_ar' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        Scholarship::create($validated);

        return redirect()
            ->route('admin.scholarships.index')
            ->with('success', __('Scholarship created successfully.'));
    }

    public function edit(Scholarship $scholarship)
    {
        $countries = Country::orderBy('name')->get();
        $universities = University::orderBy('name')->get();

        return view('admin.scholarships.edit', compact('scholarship', 'countries', 'universities'));
    }

    public function update(Request $request, Scholarship $scholarship)
    {
        $validated = $request->validate([
            'country_id' => 'required|exists:countries,id',
            'university_id' => 'nullable|exists:universities,id',
            'title' => 'required|string|max:255',
            'degree' => 'required|string|max:255',
            'funding_type' => 'nullable|string|max:255',
            'open_date' => 'nullable|date',
            'deadline' => 'nullable|date',
            'official_link' => 'required|url',
            'source_link' => 'nullable|url',
            'description' => 'nullable|string',
            'eligibility' => 'nullable|string',
            'required_documents' => 'nullable|string',
            'title_ar' => 'nullable|string|max:255',
            'description_ar' => 'nullable|string',
            'eligibility_ar' => 'nullable|string',
            'required_documents_ar' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $scholarship->update($validated);

        return redirect()
            ->route('admin.scholarships.index')
            ->with('success', __('Scholarship updated successfully.'));
    }

    public function destroy(Scholarship $scholarship)
    {
        $scholarship->delete();

        return redirect()
            ->route('admin.scholarships.index')
            ->with('success', __('Scholarship deleted successfully.'));
    }
}