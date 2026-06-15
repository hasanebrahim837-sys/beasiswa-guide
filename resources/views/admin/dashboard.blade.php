@extends('layouts.app')

@section('content')

<section class="section">
    <div class="section-title">
        <div>
            <h2>Admin Dashboard</h2>
            <p>Overview of scholarships, universities, and student assistance requests.</p>
        </div>
    </div>

    <div class="stats" style="margin-bottom: 35px;">
        <div class="stat-card">
            <h3>{{ $totalScholarships }}</h3>
            <p>Total Scholarships</p>
        </div>

        <div class="stat-card">
            <h3>{{ $activeScholarships }}</h3>
            <p>Active Scholarships</p>
        </div>

        <div class="stat-card">
            <h3>{{ $totalRequests }}</h3>
            <p>Student Requests</p>
        </div>

        <div class="stat-card">
            <h3>{{ $pendingRequests }}</h3>
            <p>Pending Requests</p>
        </div>

        <div class="stat-card">
            <h3>{{ $totalCountries }}</h3>
            <p>Countries</p>
        </div>

        <div class="stat-card">
            <h3>{{ $totalUniversities }}</h3>
            <p>Universities</p>
        </div>
    </div>

    <div class="section-title">
        <div>
            <h2>Latest Assistance Requests</h2>
            <p>Recently submitted student assistance requests.</p>
        </div>

        <a href="{{ route('admin.assistance_requests.index') }}" class="btn btn-outline">
            View All Requests
        </a>
    </div>

    <div class="table-card">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Scholarship</th>
                    <th>University</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($latestRequests as $request)
                    <tr>
                        <td>
                            <strong>{{ $request->full_name }}</strong><br>
                            {{ $request->email }}
                        </td>

                        <td>{{ $request->scholarship->title ?? '-' }}</td>

                        <td>{{ $request->university->name ?? '-' }}</td>

                        <td>
                            <span class="status-pill">{{ $request->status }}</span>
                        </td>

                        <td>{{ $request->created_at->format('d M Y') }}</td>

                        <td>
                            <a href="{{ route('admin.assistance_requests.show', $request) }}" class="btn btn-primary">
                                View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No assistance requests yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>

@endsection