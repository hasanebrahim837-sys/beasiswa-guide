@extends('layouts.app')

@section('content')

<section class="section">
    <div class="section-title">
        <div>
            <h2>Manage Scholarships</h2>
            <p>Add, edit, and delete scholarship information.</p>
        </div>

        <a href="{{ route('admin.scholarships.create') }}" class="btn btn-primary">
            Add New Scholarship
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
                    <th>ID</th>
                    <th>Scholarship</th>
                    <th>Country</th>
                    <th>University</th>
                    <th>Degree</th>
                    <th>Deadline</th>
                    <th>Status</th>
                    <th>Active</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($scholarships as $scholarship)
                    <tr>
                        <td>{{ $scholarship->id }}</td>

                        <td>
                            <strong>{{ $scholarship->title }}</strong><br>
                            {{ $scholarship->funding_type }}
                        </td>

                        <td>{{ $scholarship->country->name ?? '-' }}</td>

                        <td>{{ $scholarship->university->name ?? 'General' }}</td>

                        <td>{{ $scholarship->degree }}</td>

                        <td>{{ $scholarship->deadline ?? '-' }}</td>

                        <td>
                            <span class="status-pill">{{ $scholarship->status }}</span>
                        </td>

                        <td>
                            {{ $scholarship->is_active ? 'Yes' : 'No' }}
                        </td>

                        <td>
                            <a href="{{ route('admin.scholarships.edit', $scholarship) }}" class="btn btn-primary">
                                Edit
                            </a>

                            <form method="POST"
                                  action="{{ route('admin.scholarships.destroy', $scholarship) }}"
                                  style="display:inline-block; margin-top:8px;"
                                  onsubmit="return confirm('Are you sure you want to delete this scholarship?');">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-outline">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9">No scholarships found.</td>
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