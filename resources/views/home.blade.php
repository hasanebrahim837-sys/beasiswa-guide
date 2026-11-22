@extends('layouts.app')

@section('content')

<section class="hero">
    @include('partials.hero-flower')

    <div>
        <span class="hero-kicker">Scholarships in Indonesia</span>
        <h1>Your dream of studying in <span class="accent">Indonesia</span> starts here</h1>
        <p>
            IndoScholar helps international students discover scholarship opportunities,
            understand the requirements, prepare their documents, and apply through the official links.
        </p>

        <div class="hero-actions">
            <a href="{{ route('scholarships.index') }}" class="btn btn-primary btn-lg">Explore Scholarships</a>
            <a href="https://wa.me/{{ config('app.whatsapp') }}" target="_blank" rel="noopener" class="btn btn-cta btn-lg">
                @include('partials.whatsapp-icon') Contact us
            </a>
        </div>
    </div>

    <div class="hero-card">
        <h3>What can students do?</h3>
        <ul>
            <li>View scholarship details</li>
            <li>Check requirements and documents</li>
            <li>Open official application links</li>
            <li>Request application assistance</li>
        </ul>

        <div class="stats">
            <div class="stat-card">
                <h3>{{ $totalScholarships }}</h3>
                <p>Scholarships</p>
            </div>

            <div class="stat-card">
                <h3>{{ $totalCountries }}</h3>
                <p>Countries</p>
            </div>

            <div class="stat-card">
                <h3>24/7</h3>
                <p>Access</p>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="section-title">
        <div>
            <h2>Latest Scholarships</h2>
            <p>Explore updated scholarship opportunities from verified sources.</p>
        </div>

        <a href="{{ route('scholarships.index') }}" class="btn btn-outline">View All</a>
    </div>

    <div class="grid">
        @foreach($scholarships as $scholarship)
            <div class="card">
                @if($scholarship->status == 'Open')
                    <span class="badge badge-open">Open</span>
                @elseif($scholarship->status == 'Closed')
                    <span class="badge badge-closed">Closed</span>
                @else
                    <span class="badge badge-soon">{{ $scholarship->status }}</span>
                @endif

                <h3>{{ $scholarship->title }}</h3>

                <div class="meta"><b>University:</b> {{ $scholarship->university->name ?? 'General' }}</div>
                <div class="meta"><b>Degree:</b> {{ $scholarship->degree }}</div>
                <div class="meta"><b>Deadline:</b> {{ $scholarship->deadline ?? 'To be announced' }}</div>

                <p>{{ Str::limit($scholarship->description, 120) }}</p>

                <a href="{{ route('scholarships.show', $scholarship) }}" class="btn btn-primary">
                    View Details
                </a>
            </div>
        @endforeach
    </div>
</section>

@endsection