@extends('layouts.app')

@section('content')

<section class="section">
    <div class="section-title">
        <div>
            <h2>{{ __('Request Application Assistance') }}</h2>
            <p>{{ __('Submit your information and documents to get help with this scholarship application.') }}</p>
        </div>
    </div>

    <div class="form-card">
        <div style="margin-bottom: 25px;">
            <span class="badge badge-open">{{ __('Selected Scholarship') }}</span>
            <h2 style="margin-top: 10px;">{{ $scholarship->localized('title') }}</h2>
            <p style="color:var(--muted); margin-top:8px;">
                {{ __('University') }}: {{ $scholarship->university->name ?? __('General') }} |
                {{ __('Country') }}: {{ __($scholarship->country->name ?? '-') }} |
                {{ __('Degree') }}: {{ $scholarship->degree_label }}
            </p>
        </div>

        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="alert-error">
                {{ __('Please check the form fields and upload valid files.') }}
            </div>
        @endif

        <form method="POST" action="{{ route('assistance.store', $scholarship) }}" enctype="multipart/form-data">
            @csrf

            <div class="form-grid">
                <div class="form-group">
                    <label>{{ __('Full Name') }} *</label>
                    <input type="text" name="full_name" value="{{ old('full_name') }}" required>
                    @error('full_name')
                        <small style="color:var(--burgundy);">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>{{ __('Email') }} *</label>
                    <input type="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <small style="color:var(--burgundy);">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>{{ __('WhatsApp Number') }}</label>
                    <input type="tel" name="whatsapp" dir="ltr" value="{{ old('whatsapp') }}" placeholder="&#x200E;+62...">
                </div>

                <div class="form-group">
                    <label>{{ __('Nationality') }}</label>
                    <input type="text" name="nationality" value="{{ old('nationality') }}" placeholder="{{ __('Yemen, Indonesia, etc.') }}">
                </div>

                <div class="form-group">
                    <label>{{ __('Degree') }}</label>
                    <select name="degree">
                        <option value="">{{ __('Select Degree') }}</option>
                        <option value="Bachelor" {{ old('degree') == 'Bachelor' ? 'selected' : '' }}>{{ __('Bachelor') }}</option>
                        <option value="Master" {{ old('degree') == 'Master' ? 'selected' : '' }}>{{ __('Master') }}</option>
                        <option value="PhD" {{ old('degree') == 'PhD' ? 'selected' : '' }}>{{ __('PhD') }}</option>
                        <option value="Non-degree" {{ old('degree') == 'Non-degree' ? 'selected' : '' }}>{{ __('Non-degree') }}</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>{{ __('Passport') }}</label>
                    @include('partials.file-input', ['name' => 'passport', 'accept' => '.pdf,.jpg,.jpeg,.png'])
                </div>

                <div class="form-group">
                    <label>{{ __('Academic Certificate') }}</label>
                    @include('partials.file-input', ['name' => 'certificate', 'accept' => '.pdf,.jpg,.jpeg,.png'])
                </div>

                <div class="form-group">
                    <label>{{ __('Academic Transcript') }}</label>
                    @include('partials.file-input', ['name' => 'transcript', 'accept' => '.pdf,.jpg,.jpeg,.png'])
                </div>

                <div class="form-group">
                    <label>{{ __('CV') }}</label>
                    @include('partials.file-input', ['name' => 'cv', 'accept' => '.pdf,.doc,.docx'])
                </div>

                <div class="form-group">
                    <label>{{ __('Motivation Letter') }}</label>
                    @include('partials.file-input', ['name' => 'motivation_letter', 'accept' => '.pdf,.doc,.docx'])
                </div>

                <div class="form-group form-full">
                    <label>{{ __('Additional Notes') }}</label>
                    <textarea name="student_notes" rows="5" placeholder="{{ __('Write any important information...') }}">{{ old('student_notes') }}</textarea>
                </div>
            </div>

            <div class="privacy-note">
                <p><strong>🔒 {{ __('Your privacy') }}</strong></p>
                <p>{{ __('Your information and documents are used only to help you with this scholarship application. Your documents are stored privately, only our team can open them, and we never share them without your permission.') }}</p>
                <label class="consent">
                    <input type="checkbox" name="consent" value="1" {{ old('consent') ? 'checked' : '' }} required>
                    <span>{{ __('I agree that IndoScholar may use my information and documents to help me with this application.') }}</span>
                </label>
                @error('consent')
                    <small style="color:var(--burgundy);">{{ $message }}</small>
                @enderror
            </div>

            <div style="margin-top: 25px; display:flex; gap:12px; flex-wrap:wrap;">
                <button type="submit" class="btn btn-cta">
                    {{ __('Submit Request') }}
                </button>

                <a href="{{ route('scholarships.show', $scholarship) }}" class="btn btn-outline">
                    {{ __('Back') }}
                </a>
            </div>
        </form>
    </div>
</section>

@endsection