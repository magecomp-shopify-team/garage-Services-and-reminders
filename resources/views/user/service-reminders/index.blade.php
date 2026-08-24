@extends('layouts.user')

@section('header', 'Service Reminders')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Reminders List</h5>
        <a href="{{ route('service-reminders.create') }}" class="btn btn-primary btn-sm">Add Reminder</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Vehicle</th>
                        <th>Next Service Date</th>
                        <th>Next Service KM</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reminders as $reminder)
                    <tr>
                        <td>{{ $reminder->customer->name ?? 'N/A' }}<br><small>{{ $reminder->customer->mobile ?? '' }}</small></td>
                        <td>{{ $reminder->vehicle->registration_number ?? 'N/A' }}</td>
                        <td>{{ $reminder->next_service_date }}</td>
                        <td>{{ $reminder->next_service_km }}</td>
                        <td>
                            <span class="badge bg-{{ $reminder->status == 'Completed' ? 'success' : ($reminder->status == 'Upcoming' ? 'primary' : 'warning') }}">
                                {{ $reminder->status }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('service-reminders.updateStatus', $reminder) }}" method="POST" class="d-inline">
                                @csrf
                                <select name="status" class="form-select form-select-sm d-inline w-auto" onchange="this.form.submit()">
                                    <option value="Upcoming" {{ $reminder->status == 'Upcoming' ? 'selected' : '' }}>Upcoming</option>
                                    <option value="Sent" {{ $reminder->status == 'Sent' ? 'selected' : '' }}>Sent</option>
                                    <option value="Completed" {{ $reminder->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $reminders->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
