@extends('layouts.app')

@section('content')

<section class="hero">
    @include('partials.hero-flower')

    <div>
        <span class="hero-kicker">{{ __('Scholarships in Indonesia') }}</span>
        <h1>{!! __('Your dream of studying in :country starts here', ['country' => '<span class="accent">' . e(__('Indonesia')) . '</span>']) !!}</h1>
        <p>
            {{ __('IndoScholar helps international students discover scholarship opportunities, understand the requirements, prepare their documents, and apply through the official links.') }}
        </p>

        <div class="hero-actions">
            <a href="{{ route('scholarships.index') }}" class="btn btn-primary btn-lg">{{ __('Explore Scholarships') }}</a>
            <a href="https://wa.me/{{ config('app.whatsapp') }}" target="_blank" rel="noopener" class="btn btn-cta btn-lg">
                @include('partials.whatsapp-icon') {{ __('Contact us') }}
            </a>
        </div>
    </div>

    <div class="hero-card">
        <h3>{{ __('What can students do?') }}</h3>
        <ul>
            <li>{{ __('View scholarship details') }}</li>
            <li>{{ __('Check requirements and documents') }}</li>
            <li>{{ __('Open official application links') }}</li>
            <li>{{ __('Request application assistance') }}</li>
        </ul>

        <div class="stats">
            <div class="stat-card">
                <h3>{{ $totalScholarships }}</h3>
                <p>{{ __('Scholarships') }}</p>
            </div>

            <div class="stat-card">
                <h3>{{ $totalCountries }}</h3>
                <p>{{ __('Countries') }}</p>
            </div>

            <div class="stat-card">
                <h3>24/7</h3>
                <p>{{ __('Access') }}</p>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="section-title">
        <div>
            <h2>{{ __('Latest Scholarships') }}</h2>
            <p>{{ __('Explore updated scholarship opportunities from verified sources.') }}</p>
        </div>

        <a href="{{ route('scholarships.index') }}" class="btn btn-outline">{{ __('View All') }}</a>
    </div>

    <div class="grid">
        @foreach($scholarships as $scholarship)
            <div class="card">
                @if($scholarship->status == 'Open')
                    <span class="badge badge-open">{{ __('Open') }}</span>
                @elseif($scholarship->status == 'Closed')
                    <span class="badge badge-closed">{{ __('Closed') }}</span>
                @else
                    <span class="badge badge-soon">{{ $scholarship->status_label }}</span>
                @endif

                <h3>{{ $scholarship->localized('title') }}</h3>

                <div class="meta"><b>{{ __('University') }}:</b> {{ $scholarship->university->name ?? __('General') }}</div>
                <div class="meta"><b>{{ __('Degree') }}:</b> {{ $scholarship->degree_label }}</div>
                <div class="meta"><b>{{ __('Deadline') }}:</b> <bdi dir="ltr">{{ $scholarship->deadline ?? __('To be announced') }}</bdi></div>

                <p>{{ Str::limit($scholarship->localized('description'), 120) }}</p>

                <a href="{{ route('scholarships.show', $scholarship) }}" class="btn btn-primary">
                    {{ __('View Details') }}
                </a>
            </div>
        @endforeach
    </div>
</section>

@endsection