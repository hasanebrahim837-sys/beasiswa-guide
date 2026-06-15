<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Scholarship;
use Illuminate\Http\Request;

class ScholarshipController extends Controller
{
    public function home()
    {
        $scholarships = Scholarship::with(['country', 'university'])
            ->where('is_active', true)
            ->orderBy('deadline', 'asc')
            ->take(3)
            ->get();

        $totalScholarships = Scholarship::count();
        $totalCountries = Country::count();

        return view('home', compact(
            'scholarships',
            'totalScholarships',
            'totalCountries'
        ));
    }

    public function index(Request $request)
    {
        $query = Scholarship::with(['country', 'university'])
            ->where('is_active', true);

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('degree')) {
            $query->where('degree', 'like', '%' . $request->degree . '%');
        }

        if ($request->filled('country_id')) {
            $query->where('country_id', $request->country_id);
        }

        $scholarships = $query->orderBy('deadline', 'asc')->paginate(6);
        $countries = Country::orderBy('name')->get();

        return view('scholarships.index', compact('scholarships', 'countries'));
    }

    public function show(Scholarship $scholarship)
    {
        $scholarship->load(['country', 'university']);

        return view('scholarships.show', compact('scholarship'));
    }
}