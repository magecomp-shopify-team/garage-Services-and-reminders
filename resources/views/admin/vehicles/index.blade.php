@extends('layouts.admin')

@section('header', 'Vehicles')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Vehicle List</h5>
        <a href="{{ route('admin.vehicles.create') }}" class="btn btn-sm btn-primary">Add Vehicle</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Registration</th>
                        <th>Customer</th>
                        <th>Brand & Model</th>
                        <th>KM</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vehicles as $vehicle)
                    <tr>
                        <td>{{ $vehicle->registration_number }}</td>
                        <td>{{ $vehicle->customer->name ?? 'N/A' }}</td>
                        <td>{{ $vehicle->brand }} {{ $vehicle->model }}</td>
                        <td>{{ $vehicle->current_km }}</td>
                        <td>
                            <a href="{{ route('admin.vehicles.show', $vehicle) }}" class="btn btn-sm btn-info text-white"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('admin.vehicles.edit', $vehicle) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $vehicles->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
