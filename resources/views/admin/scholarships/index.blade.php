@extends('layouts.app')

@section('content')

<section class="section">
    <div class="section-title">
        <div>
            <h2>{{ __('Manage Scholarships') }}</h2>
            <p>{{ __('Add, edit, and delete scholarship information.') }}</p>
        </div>

        <a href="{{ route('admin.scholarships.create') }}" class="btn btn-primary">
            {{ __('Add New Scholarship') }}
        </a>
    </div>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-card">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>{{ __('ID') }}</th>
                    <th>{{ __('Scholarship') }}</th>
                    <th>{{ __('Country') }}</th>
                    <th>{{ __('University') }}</th>
                    <th>{{ __('Degree') }}</th>
                    <th>{{ __('Deadline') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Active') }}</th>
                    <th>{{ __('Action') }}</th>
                </tr>
            </thead>

            <tbody>
                @forelse($scholarships as $scholarship)
                    <tr>
                        <td>{{ $scholarship->id }}</td>

                        <td>
                            <strong>{{ $scholarship->localized('title') }}</strong><br>
                            {{ $scholarship->funding_type }}
                        </td>

                        <td>{{ __($scholarship->country->name ?? '-') }}</td>

                        <td>{{ $scholarship->university->name ?? 'General' }}</td>

                        <td>{{ $scholarship->degree_label }}</td>

                        <td><bdi dir="ltr">{{ $scholarship->deadline ?? '-' }}</bdi></td>

                        <td>
                            <span class="status-pill">{{ $scholarship->status_label }}</span>
                        </td>

                        <td>
                            {{ $scholarship->is_active ? 'Yes' : 'No' }}
                        </td>

                        <td>
                            <a href="{{ route('admin.scholarships.edit', $scholarship) }}" class="btn btn-primary">
                                {{ __('Edit') }}
                            </a>

                            <form method="POST"
                                  action="{{ route('admin.scholarships.destroy', $scholarship) }}"
                                  style="display:inline-block; margin-top:8px;"
                                  onsubmit="return confirm('{{ __('Are you sure you want to delete this scholarship?') }}');">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-outline">
                                    {{ __('Delete') }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9">{{ __('No scholarships found.') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top: 25px;">
            {{ $scholarships->links() }}
        </div>
    </div>
</section>

@endsection