@extends('layouts.app')

@section('content')

<section class="section">
    <div class="section-title">
        <div>
            <h2>{{ __('Admin Dashboard') }}</h2>
            <p>{{ __('Manage student assistance requests.') }}</p>
        </div>
    </div>

    <div class="table-card">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>{{ __('ID') }}</th>
                    <th>{{ __('Student') }}</th>
                    <th>{{ __('Scholarship') }}</th>
                    <th>{{ __('University') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Submitted At') }}</th>
                    <th>{{ __('Action') }}</th>
                </tr>
            </thead>

            <tbody>
                @forelse($requests as $request)
                    <tr>
                        <td>{{ $request->id }}</td>

                        <td>
                            <strong>{{ $request->full_name }}</strong><br>
                            {{ $request->email }}<br>
                            {{ $request->whatsapp }}
                        </td>

                        <td>{{ $request->scholarship?->localized('title') ?? '-' }}</td>

                        <td>{{ $request->university->name ?? '-' }}</td>

                        <td>
                            <span class="status-pill">{{ __($request->status) }}</span>
                        </td>

                        <td><bdi dir="ltr">{{ $request->created_at->format('Y-m-d') }}</bdi></td>

                        <td>
                            <a href="{{ route('admin.assistance_requests.show', $request) }}" class="btn btn-primary">
                                {{ __('View') }}
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">{{ __('No assistance requests found.') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top: 25px;">
            {{ $requests->links() }}
        </div>
    </div>
</section>

@endsection