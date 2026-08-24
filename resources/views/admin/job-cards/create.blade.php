@extends('layouts.admin')

@section('header', 'Create Job Card')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">New Job Card</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.job-cards.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Customer</label>
                    <select name="customer_id" class="form-control" required>
                        <option value="">Select Customer</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->mobile }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Vehicle</label>
                    <select name="vehicle_id" class="form-control" required>
                        <option value="">Select Vehicle</option>
                        @foreach($vehicles as $vehicle)
                            <option value="{{ $vehicle->id }}">{{ $vehicle->registration_number }} - {{ $vehicle->brand }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Assign Mechanic</label>
                    <select name="mechanic_id" class="form-control">
                        <option value="">None</option>
                        @foreach($mechanics as $mechanic)
                            <option value="{{ $mechanic->id }}">{{ $mechanic->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Current KM</label>
                    <input type="number" name="current_km" class="form-control">
                </div>
                <div class="col-md-12 mb-3">
                    <label>Complaint / Notes</label>
                    <textarea name="complaint" class="form-control" rows="3" required></textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Create Job Card</button>
            <a href="{{ route('admin.job-cards.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
