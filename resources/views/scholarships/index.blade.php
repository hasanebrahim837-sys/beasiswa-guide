@extends('layouts.app')

@section('content')

<section class="section">
    <div class="section-title">
        <div>
            <h2>Scholarships</h2>
            <p>Search and filter verified scholarship opportunities.</p>
        </div>
    </div>

    <form method="GET" action="{{ route('scholarships.index') }}" class="filter-box">
        <input
            type="text"
            name="search"
            placeholder="Search scholarship..."
            value="{{ request('search') }}"
        >

        <select name="degree">
            <option value="">All Degrees</option>
            <option value="Bachelor" {{ request('degree') == 'Bachelor' ? 'selected' : '' }}>Bachelor</option>
            <option value="Master" {{ request('degree') == 'Master' ? 'selected' : '' }}>Master</option>
            <option value="PhD" {{ request('degree') == 'PhD' ? 'selected' : '' }}>PhD</option>
            <option value="Non-degree" {{ request('degree') == 'Non-degree' ? 'selected' : '' }}>Non-degree</option>
        </select>

        <select name="country_id">
            <option value="">All Countries</option>
            @foreach($countries as $country)
                <option value="{{ $country->id }}" {{ request('country_id') == $country->id ? 'selected' : '' }}>
                    {{ $country->name }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <div class="grid">
        @forelse($scholarships as $scholarship)
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
                    Country: {{ $scholarship->country->name ?? '-' }}
                </div>

                <div class="meta">
                    University: {{ $scholarship->university->name ?? 'General' }}
                </div>

                <div class="meta">
                    Degree: {{ $scholarship->degree }}
                </div>

                <div class="meta">
                    Funding: {{ $scholarship->funding_type }}
                </div>

                <div class="meta">
                    Deadline: {{ $scholarship->deadline }}
                </div>

                <p>{{ Str::limit($scholarship->description, 120) }}</p>

                <a href="{{ route('scholarships.show', $scholarship) }}" class="btn btn-primary">
                    View Details
                </a>
            </div>
        @empty
            <div class="card">
                <h3>No scholarships found</h3>
                <p>Please try another keyword or filter.</p>
            </div>
        @endforelse
    </div>

    <div style="margin-top: 30px;">
        {{ $scholarships->links() }}
    </div>
</section>

@endsection