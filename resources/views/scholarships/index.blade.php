@extends('layouts.app')

@section('content')

<section class="section">
    <div class="section-title">
        <div>
            <h2>{{ __('Scholarships') }}</h2>
            <p>{{ __('Search and filter verified scholarship opportunities.') }}</p>
        </div>
    </div>

    <form method="GET" action="{{ route('scholarships.index') }}" class="filter-box">
        <input
            type="text"
            name="search"
            placeholder="{{ __('Search scholarship...') }}"
            value="{{ request('search') }}"
        >

        <select name="degree">
            <option value="">{{ __('All Degrees') }}</option>
            <option value="Bachelor" {{ request('degree') == 'Bachelor' ? 'selected' : '' }}>{{ __('Bachelor') }}</option>
            <option value="Master" {{ request('degree') == 'Master' ? 'selected' : '' }}>{{ __('Master') }}</option>
            <option value="PhD" {{ request('degree') == 'PhD' ? 'selected' : '' }}>{{ __('PhD') }}</option>
            <option value="Non-degree" {{ request('degree') == 'Non-degree' ? 'selected' : '' }}>{{ __('Non-degree') }}</option>
        </select>

        <select name="country_id">
            <option value="">{{ __('All Countries') }}</option>
            @foreach($countries as $country)
                <option value="{{ $country->id }}" {{ request('country_id') == $country->id ? 'selected' : '' }}>
                    {{ $country->name }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-primary">{{ __('Search') }}</button>
    </form>

    <div class="grid">
        @forelse($scholarships as $scholarship)
            <div class="card">
                @if($scholarship->status == 'Open')
                    <span class="badge badge-open">{{ __('Open') }}</span>
                @elseif($scholarship->status == 'Closed')
                    <span class="badge badge-closed">{{ __('Closed') }}</span>
                @else
                    <span class="badge badge-soon">{{ $scholarship->status_label }}</span>
                @endif

                <h3>{{ $scholarship->localized('title') }}</h3>

                <div class="meta"><b>{{ __('Country') }}:</b> {{ __($scholarship->country->name ?? '-') }}</div>

                <div class="meta"><b>{{ __('University') }}:</b> {{ $scholarship->university->name ?? __('General') }}</div>

                <div class="meta"><b>{{ __('Degree') }}:</b> {{ $scholarship->degree_label }}</div>

                <div class="meta"><b>{{ __('Funding') }}:</b> {{ $scholarship->funding_label }}</div>

                <div class="meta"><b>{{ __('Deadline') }}:</b> <bdi dir="ltr">{{ $scholarship->deadline ?? __('To be announced') }}</bdi></div>

                <p>{{ Str::limit($scholarship->localized('description'), 120) }}</p>

                <a href="{{ route('scholarships.show', $scholarship) }}" class="btn btn-primary">
                    {{ __('View Details') }}
                </a>
            </div>
        @empty
            <div class="card">
                <h3>{{ __('No scholarships found') }}</h3>
                <p>{{ __('Please try another keyword or filter.') }}</p>
            </div>
        @endforelse
    </div>

    <div style="margin-top: 30px;">
        {{ $scholarships->links() }}
    </div>
</section>

@endsection