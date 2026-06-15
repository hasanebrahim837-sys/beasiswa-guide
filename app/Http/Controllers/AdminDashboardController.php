<?php

namespace App\Http\Controllers;

use App\Models\Scholarship;
use App\Models\AssistanceRequest;
use App\Models\Country;
use App\Models\University;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalScholarships = Scholarship::count();
        $activeScholarships = Scholarship::where('is_active', true)->count();
        $totalRequests = AssistanceRequest::count();
        $pendingRequests = AssistanceRequest::where('status', 'Pending')->count();
        $totalCountries = Country::count();
        $totalUniversities = University::count();

        $latestRequests = AssistanceRequest::with(['scholarship', 'university'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalScholarships',
            'activeScholarships',
            'totalRequests',
            'pendingRequests',
            'totalCountries',
            'totalUniversities',
            'latestRequests'
        ));
    }
}