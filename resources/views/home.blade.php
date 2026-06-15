@extends('layouts.app')

@section('content')

<section class="hero">
    <div>
        <h1>Find Verified Scholarships in Indonesia</h1>
        <p>
            Beasiswa Guide helps students discover scholarship opportunities,
            understand requirements, prepare documents, and apply through official university links.
        </p>

        <a href="{{ route('scholarships.index') }}" class="btn btn-light">Explore Scholarships</a>
    </div>

    <div class="hero-card">
        <h3>What can students do?</h3>
        <ul>
            <li>✓ View scholarship details</li>
            <li>✓ Check requirements and documents</li>
            <li>✓ Open official application links</li>
            <li>✓ Request application assistance</li>
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

                <div class="meta">
                    University: {{ $scholarship->university->name ?? 'General' }}
                </div>

                <div class="meta">
                    Degree: {{ $scholarship->degree }}
                </div>

                <div class="meta">
                    Deadline: {{ $scholarship->deadline }}
                </div>

                <p>{{ Str::limit($scholarship->description, 120) }}</p>

                <a href="{{ route('scholarships.show', $scholarship) }}" class="btn btn-primary">
                    View Details
                </a>
            </div>
        @endforeach
    </div>
</section>

@endsection