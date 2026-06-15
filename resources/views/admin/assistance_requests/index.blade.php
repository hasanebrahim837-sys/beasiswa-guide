@extends('layouts.app')

@section('content')

<section class="section">
    <div class="section-title">
        <div>
            <h2>Admin Dashboard</h2>
            <p>Manage student assistance requests.</p>
        </div>
    </div>

    <div class="table-card">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Student</th>
                    <th>Scholarship</th>
                    <th>University</th>
                    <th>Status</th>
                    <th>Submitted At</th>
                    <th>Action</th>
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

                        <td>{{ $request->scholarship->title ?? '-' }}</td>

                        <td>{{ $request->university->name ?? '-' }}</td>

                        <td>
                            <span class="status-pill">{{ $request->status }}</span>
                        </td>

                        <td>{{ $request->created_at->format('d M Y') }}</td>

                        <td>
                            <a href="{{ route('admin.assistance_requests.show', $request) }}" class="btn btn-primary">
                                View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">No assistance requests found.</td>
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