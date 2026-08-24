@extends('layouts.admin')

@section('header', 'Add Vehicle')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Vehicle Details</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.vehicles.store') }}" method="POST">
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
                    <label>Registration Number</label>
                    <input type="text" name="registration_number" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Brand</label>
                    <input type="text" name="brand" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Model</label>
                    <input type="text" name="model" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Year</label>
                    <input type="text" name="year" class="form-control">
                </div>
                <div class="col-md-4 mb-3">
                    <label>Fuel Type</label>
                    <input type="text" name="fuel_type" class="form-control">
                </div>
                <div class="col-md-4 mb-3">
                    <label>Current KM</label>
                    <input type="number" name="current_km" class="form-control">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save Vehicle</button>
            <a href="{{ route('admin.vehicles.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
