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

            <p style="color:#6b7280; line-height:1.7;">
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

            <div style="margin-top: 35px; display: flex; gap: 12px; flex-wrap: wrap;">
                <a href="{{ $scholarship->official_link }}" target="_blank" class="btn btn-primary">
                    Apply Officially
                </a>

                <a href="{{ route('assistance.create', $scholarship) }}" class="btn btn-outline">
                    Request Assistance
                </a>

                <a href="{{ route('scholarships.index') }}" class="btn btn-outline">
                    Back to Scholarships
                </a>
            </div>
        </div>
    </section>

@endsection