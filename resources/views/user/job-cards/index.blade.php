@extends('layouts.user')

@section('header', 'Job Cards')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Job Cards List</h5>
        <a href="{{ route('job-cards.create') }}" class="btn btn-sm btn-primary">Create Job Card</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Job No</th>
                        <th>Customer</th>
                        <th>Vehicle</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jobCards as $jobCard)
                    <tr>
                        <td>{{ $jobCard->job_number }}</td>
                        <td>{{ $jobCard->customer->name ?? 'N/A' }}</td>
                        <td>{{ $jobCard->vehicle->registration_number ?? 'N/A' }}</td>
                        <td>
                            <span class="badge bg-{{ $jobCard->status == 'Completed' ? 'success' : ($jobCard->status == 'Pending' ? 'warning' : 'primary') }}">
                                {{ $jobCard->status }}
                            </span>
                        </td>
                        <td>{{ $jobCard->created_at->format('Y-m-d') }}</td>
                        <td>
                            <a href="{{ route('job-cards.show', $jobCard) }}" class="btn btn-sm btn-info text-white">Manage</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $jobCards->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
