@extends('layouts.app')

@section('content')

    <section class="section">
        <div class="detail-box">
            @if(session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if($scholarship->status == 'Open')
                <span class="badge badge-open">{{ __('Open') }}</span>
            @elseif($scholarship->status == 'Closed')
                <span class="badge badge-closed">{{ __('Closed') }}</span>
            @else
                <span class="badge badge-soon">{{ $scholarship->status_label }}</span>
            @endif

            <h1>{{ $scholarship->localized('title') }}</h1>

            <p style="color:var(--muted); line-height:1.7;">
                {{ $scholarship->localized('description') }}
            </p>

            <div class="info-row">
                <div class="info-item">
                    <strong>{{ __('Country') }}</strong>
                    {{ __($scholarship->country->name ?? '-') }}
                </div>

                <div class="info-item">
                    <strong>{{ __('University') }}</strong>
                    {{ $scholarship->university->name ?? __('General') }}
                </div>

                <div class="info-item">
                    <strong>{{ __('Degree') }}</strong>
                    {{ $scholarship->degree_label }}
                </div>

                <div class="info-item">
                    <strong>{{ __('Funding Type') }}</strong>
                    {{ $scholarship->funding_label }}
                </div>

                <div class="info-item">
                    <strong>{{ __('Open Date') }}</strong>
                    <bdi dir="ltr">{{ $scholarship->open_date ?? '-' }}</bdi>
                </div>

                <div class="info-item">
                    <strong>{{ __('Deadline') }}</strong>
                    <bdi dir="ltr">{{ $scholarship->deadline ?? '-' }}</bdi>
                </div>
            </div>

            <div class="content-block">
                <h3>{{ __('Eligibility Requirements') }}</h3>
                <p>{{ $scholarship->localized('eligibility') }}</p>
            </div>

            <div class="content-block">
                <h3>{{ __('Required Documents') }}</h3>
                <p>{{ $scholarship->localized('required_documents') }}</p>
            </div>

            <div style="margin-top: 30px; display: flex; gap: 12px; flex-wrap: wrap;">
                <a href="{{ $scholarship->official_link }}" target="_blank" rel="noopener" class="btn btn-primary">
                    {{ __('Apply Officially') }}
                </a>

                <a href="{{ route('scholarships.index') }}" class="btn btn-outline">
                    {{ __('Back to Scholarships') }}
                </a>
            </div>

            <div class="help-box">
                <div>
                    <h3>{{ __('Need help with this application?') }}</h3>
                    <p>{{ __('We help you prepare your documents and apply. The admission decision belongs to the scholarship provider.') }}</p>
                </div>
                <div class="actions">
                    <a href="{{ route('assistance.create', $scholarship) }}" class="btn btn-cta">
                        {{ __('Request Assistance') }}
                    </a>
                    <a href="https://wa.me/{{ config('app.whatsapp') }}?text={{ rawurlencode(__('Hello IndoScholar, I would like help with:') . ' ' . $scholarship->localized('title')) }}"
                       target="_blank" rel="noopener" class="btn btn-ghost-light">
                        @include('partials.whatsapp-icon') {{ __('WhatsApp') }}
                    </a>
                </div>
            </div>
        </div>
    </section>

@endsection