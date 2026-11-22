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
                <span class="badge badge-open">Open</span>
            @elseif($scholarship->status == 'Closed')
                <span class="badge badge-closed">Closed</span>
            @else
                <span class="badge badge-soon">{{ $scholarship->status }}</span>
            @endif

            <h1>{{ $scholarship->title }}</h1>

            <p style="color:var(--muted); line-height:1.7;">
                {{ $scholarship->description }}
            </p>

            <div class="info-row">
                <div class="info-item">
                    <strong>Country</strong>
                    {{ $scholarship->country->name ?? '-' }}
                </div>

                <div class="info-item">
                    <strong>University</strong>
                    {{ $scholarship->university->name ?? 'General' }}
                </div>

                <div class="info-item">
                    <strong>Degree</strong>
                    {{ $scholarship->degree }}
                </div>

                <div class="info-item">
                    <strong>Funding Type</strong>
                    {{ $scholarship->funding_type }}
                </div>

                <div class="info-item">
                    <strong>Open Date</strong>
                    {{ $scholarship->open_date ?? '-' }}
                </div>

                <div class="info-item">
                    <strong>Deadline</strong>
                    {{ $scholarship->deadline ?? '-' }}
                </div>
            </div>

            <div class="content-block">
                <h3>Eligibility Requirements</h3>
                <p>{{ $scholarship->eligibility }}</p>
            </div>

            <div class="content-block">
                <h3>Required Documents</h3>
                <p>{{ $scholarship->required_documents }}</p>
            </div>

            <div style="margin-top: 30px; display: flex; gap: 12px; flex-wrap: wrap;">
                <a href="{{ $scholarship->official_link }}" target="_blank" rel="noopener" class="btn btn-primary">
                    Apply Officially
                </a>

                <a href="{{ route('scholarships.index') }}" class="btn btn-outline">
                    Back to Scholarships
                </a>
            </div>

            <div class="help-box">
                <div>
                    <h3>Need help with this application?</h3>
                    <p>We help you prepare your documents and apply. The admission decision belongs to the scholarship provider.</p>
                </div>
                <div class="actions">
                    <a href="{{ route('assistance.create', $scholarship) }}" class="btn btn-cta">
                        Request Assistance
                    </a>
                    <a href="https://wa.me/{{ config('app.whatsapp') }}?text={{ rawurlencode('Hello IndoScholar, I would like help with: ' . $scholarship->title) }}"
                       target="_blank" rel="noopener" class="btn btn-ghost-light">
                        @include('partials.whatsapp-icon') WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </section>

@endsection