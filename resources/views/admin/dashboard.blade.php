@extends('layouts.app')

@section('content')

<section class="section">
    <div class="section-title">
        <div>
            <h2>{{ __('Admin Dashboard') }}</h2>
            <p>{{ __('Overview of scholarships, universities, and student assistance requests.') }}</p>
        </div>
    </div>

    <div class="stats" style="margin-bottom: 35px;">
        <div class="stat-card">
            <h3>{{ $totalScholarships }}</h3>
            <p>{{ __('Total Scholarships') }}</p>
        </div>

        <div class="stat-card">
            <h3>{{ $activeScholarships }}</h3>
            <p>{{ __('Active Scholarships') }}</p>
        </div>

        <div class="stat-card">
            <h3>{{ $totalRequests }}</h3>
            <p>{{ __('Student Requests') }}</p>
        </div>

        <div class="stat-card">
            <h3>{{ $pendingRequests }}</h3>
            <p>{{ __('Pending Requests') }}</p>
        </div>

        <div class="stat-card">
            <h3>{{ $totalCountries }}</h3>
            <p>{{ __('Countries') }}</p>
        </div>

        <div class="stat-card">
            <h3>{{ $totalUniversities }}</h3>
            <p>{{ __('Universities') }}</p>
        </div>
    </div>

    <div class="section-title">
        <div>
            <h2>{{ __('Latest Assistance Requests') }}</h2>
            <p>{{ __('Recently submitted student assistance requests.') }}</p>
        </div>

        <a href="{{ route('admin.assistance_requests.index') }}" class="btn btn-outline">
            {{ __('View All Requests') }}
        </a>
    </div>

    <div class="table-card">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>{{ __('Student') }}</th>
                    <th>{{ __('Scholarship') }}</th>
                    <th>{{ __('University') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Date') }}</th>
                    <th>{{ __('Action') }}</th>
                </tr>
            </thead>

            <tbody>
                @forelse($latestRequests as $request)
                    <tr>
                        <td>
                            <strong>{{ $request->full_name }}</strong><br>
                            {{ $request->email }}
                        </td>

                        <td>{{ $request->scholarship?->localized('title') ?? '-' }}</td>

                        <td>{{ $request->university->name ?? '-' }}</td>

                        <td>
                            <span class="status-pill">{{ __($request->status) }}</span>
                        </td>

                        <td><bdi dir="ltr">{{ $request->created_at->format('Y-m-d') }}</bdi></td>

                        <td>
                            <a href="{{ route('admin.assistance_requests.show', $request) }}" class="btn btn-primary">
                                {{ __('View') }}
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">{{ __('No assistance requests yet.') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>

@endsection