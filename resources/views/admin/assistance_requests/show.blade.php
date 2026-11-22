@extends('layouts.app')

@section('content')

<section class="section">
    <div class="detail-box">
        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        <span class="status-pill">{{ __($assistanceRequest->status) }}</span>

        <h1 style="margin-top: 15px;">{{ $assistanceRequest->full_name }}</h1>

        <div class="info-row">
            <div class="info-item">
                <strong>{{ __('Email') }}</strong>
                {{ $assistanceRequest->email }}
            </div>

            <div class="info-item">
                <strong>{{ __('WhatsApp') }}</strong>
                {{ $assistanceRequest->whatsapp ?? '-' }}
            </div>

            <div class="info-item">
                <strong>{{ __('Nationality') }}</strong>
                {{ $assistanceRequest->nationality ?? '-' }}
            </div>

            <div class="info-item">
                <strong>{{ __('Scholarship') }}</strong>
                {{ $assistanceRequest->scholarship?->localized('title') ?? '-' }}
            </div>

            <div class="info-item">
                <strong>{{ __('University') }}</strong>
                {{ $assistanceRequest->university->name ?? '-' }}
            </div>

            <div class="info-item">
                <strong>{{ __('Degree') }}</strong>
                {{ \App\Models\Scholarship::translateList($assistanceRequest->degree) }}
            </div>
        </div>

        <div class="content-block">
            <h3>{{ __('Student Notes') }}</h3>
            <p>{{ $assistanceRequest->student_notes ?? 'No notes.' }}</p>
        </div>

        <div class="content-block">
            <h3>{{ __('Uploaded Documents') }}</h3>

            @forelse($assistanceRequest->documents as $document)
                <a class="file-link" href="{{ asset('storage/' . $document->file_path) }}" target="_blank">
                    {{ __($document->document_type) }} - {{ $document->original_name }}
                </a>
            @empty
                <p>{{ __('No documents uploaded.') }}</p>
            @endforelse
        </div>

        <div class="content-block">
            <h3>{{ __('Update Request Status') }}</h3>

            <form method="POST" action="{{ route('admin.assistance_requests.update', $assistanceRequest) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>{{ __('Status') }}</label>
                    <select name="status" required>
                        @foreach(['Pending', 'Checking Documents', 'Missing Documents', 'Ready to Apply', 'Submitted', 'Completed', 'Rejected'] as $status)
                            <option value="{{ $status }}" {{ $assistanceRequest->status == $status ? 'selected' : '' }}>
                                {{ __($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>{{ __('Admin Notes') }}</label>
                    <textarea name="admin_notes" rows="5">{{ old('admin_notes', $assistanceRequest->admin_notes) }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                    {{ __('Update Status') }}
                </button>

                <a href="{{ route('admin.assistance_requests.index') }}" class="btn btn-outline">
                    {{ __('Back to Requests') }}
                </a>
            </form>
        </div>
    </div>
</section>

@endsection