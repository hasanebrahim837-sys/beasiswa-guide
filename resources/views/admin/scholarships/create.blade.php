@extends('layouts.app')

@section('content')

<section class="section">
    <div class="section-title">
        <div>
            <h2>Add New Scholarship</h2>
            <p>Enter verified scholarship information and official links.</p>
        </div>
    </div>

    @if($errors->any())
        <div class="alert-error">
            Please check the form fields.
        </div>
    @endif

    <div class="form-card">
        <form method="POST" action="{{ route('admin.scholarships.store') }}">
            @csrf

            <div class="form-grid">
                <div class="form-group">
                    <label>Scholarship Title *</label>
                    <input type="text" name="title" value="{{ old('title') }}" required>
                </div>

                <div class="form-group">
                    <label>Country *</label>
                    <select name="country_id" required>
                        <option value="">Select Country</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                {{ $country->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>University</label>
                    <select name="university_id">
                        <option value="">General / No specific university</option>
                        @foreach($universities as $university)
                            <option value="{{ $university->id }}" {{ old('university_id') == $university->id ? 'selected' : '' }}>
                                {{ $university->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Degree *</label>
                    <input type="text" name="degree" value="{{ old('degree') }}" placeholder="Bachelor, Master, PhD" required>
                </div>

                <div class="form-group">
                    <label>Funding Type</label>
                    <input type="text" name="funding_type" value="{{ old('funding_type') }}" placeholder="Fully Funded / Partial Funded">
                </div>

                <div class="form-group">
                    <label>Open Date</label>
                    <input type="date" name="open_date" value="{{ old('open_date') }}">
                </div>

                <div class="form-group">
                    <label>Deadline</label>
                    <input type="date" name="deadline" value="{{ old('deadline') }}">
                </div>

                <div class="form-group">
                    <label>Official Application Link *</label>
                    <input type="url" name="official_link" value="{{ old('official_link') }}" required>
                </div>

                <div class="form-group form-full">
                    <label>Source Link</label>
                    <input type="url" name="source_link" value="{{ old('source_link') }}">
                </div>

                <div class="form-group form-full">
                    <label>Description</label>
                    <textarea name="description" rows="4">{{ old('description') }}</textarea>
                </div>

                <div class="form-group form-full">
                    <label>Eligibility Requirements</label>
                    <textarea name="eligibility" rows="4">{{ old('eligibility') }}</textarea>
                </div>

                <div class="form-group form-full">
                    <label>Required Documents</label>
                    <textarea name="required_documents" rows="4">{{ old('required_documents') }}</textarea>
                </div>

                <div class="form-group form-full">
                    <label>
                        <input type="checkbox" name="is_active" value="1" checked style="width:auto;">
                        Active Scholarship
                    </label>
                </div>
            </div>

            <div style="margin-top: 25px; display:flex; gap:12px; flex-wrap:wrap;">
                <button type="submit" class="btn btn-primary">
                    Save Scholarship
                </button>

                <a href="{{ route('admin.scholarships.index') }}" class="btn btn-outline">
                    Back
                </a>
            </div>
        </form>
    </div>
</section>

@endsection