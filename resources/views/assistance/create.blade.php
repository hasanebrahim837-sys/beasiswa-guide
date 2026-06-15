@extends('layouts.app')

@section('content')

<section class="section">
    <div class="section-title">
        <div>
            <h2>Request Application Assistance</h2>
            <p>Submit your information and documents to get help with this scholarship application.</p>
        </div>
    </div>

    <div class="form-card">
        <div style="margin-bottom: 25px;">
            <span class="badge badge-open">Selected Scholarship</span>
            <h2 style="margin-top: 10px;">{{ $scholarship->title }}</h2>
            <p style="color:#6b7280; margin-top:8px;">
                University: {{ $scholarship->university->name ?? 'General' }} |
                Country: {{ $scholarship->country->name ?? '-' }} |
                Degree: {{ $scholarship->degree }}
            </p>
        </div>

        @if($errors->any())
            <div class="alert-error">
                Please check the form fields and upload valid files.
            </div>
        @endif

        <form method="POST" action="{{ route('assistance.store', $scholarship) }}" enctype="multipart/form-data">
            @csrf

            <div class="form-grid">
                <div class="form-group">
                    <label>Full Name *</label>
                    <input type="text" name="full_name" value="{{ old('full_name') }}" required>
                    @error('full_name')
                        <small style="color:#991b1b;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Email *</label>
                    <input type="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <small style="color:#991b1b;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>WhatsApp Number</label>
                    <input type="text" name="whatsapp" value="{{ old('whatsapp') }}" placeholder="+62...">
                </div>

                <div class="form-group">
                    <label>Nationality</label>
                    <input type="text" name="nationality" value="{{ old('nationality') }}" placeholder="Yemen, Indonesia, etc.">
                </div>

                <div class="form-group">
                    <label>Degree</label>
                    <select name="degree">
                        <option value="">Select Degree</option>
                        <option value="Bachelor" {{ old('degree') == 'Bachelor' ? 'selected' : '' }}>Bachelor</option>
                        <option value="Master" {{ old('degree') == 'Master' ? 'selected' : '' }}>Master</option>
                        <option value="PhD" {{ old('degree') == 'PhD' ? 'selected' : '' }}>PhD</option>
                        <option value="Non-degree" {{ old('degree') == 'Non-degree' ? 'selected' : '' }}>Non-degree</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Passport</label>
                    <input type="file" name="passport">
                </div>

                <div class="form-group">
                    <label>Academic Certificate</label>
                    <input type="file" name="certificate">
                </div>

                <div class="form-group">
                    <label>Academic Transcript</label>
                    <input type="file" name="transcript">
                </div>

                <div class="form-group">
                    <label>CV</label>
                    <input type="file" name="cv">
                </div>

                <div class="form-group">
                    <label>Motivation Letter</label>
                    <input type="file" name="motivation_letter">
                </div>

                <div class="form-group form-full">
                    <label>Additional Notes</label>
                    <textarea name="student_notes" rows="5" placeholder="Write any important information...">{{ old('student_notes') }}</textarea>
                </div>
            </div>

            <div style="margin-top: 25px; display:flex; gap:12px; flex-wrap:wrap;">
                <button type="submit" class="btn btn-primary">
                    Submit Request
                </button>

                <a href="{{ route('scholarships.show', $scholarship) }}" class="btn btn-outline">
                    Back
                </a>
            </div>
        </form>
    </div>
</section>

@endsection