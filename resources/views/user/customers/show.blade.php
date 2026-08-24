@extends('layouts.user')

@section('header', 'Customer Details')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header">Information</div>
            <div class="card-body">
                <h5>{{ $customer->name }}</h5>
                <p><strong>Mobile:</strong> {{ $customer->mobile }}</p>
                <p><strong>Email:</strong> {{ $customer->email }}</p>
                <p><strong>City:</strong> {{ $customer->city }}</p>
                <p><strong>Address:</strong> {{ $customer->address }}</p>
                <p><strong>Notes:</strong> {{ $customer->notes }}</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header">Vehicles</div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Registration</th>
                            <th>Brand</th>
                            <th>Model</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customer->vehicles as $vehicle)
                        <tr>
                            <td>{{ $vehicle->registration_number }}</td>
                            <td>{{ $vehicle->brand }}</td>
                            <td>{{ $vehicle->model }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">Job Cards</div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Job No</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customer->jobCards as $jobCard)
                        <tr>
                            <td>{{ $jobCard->job_number }}</td>
                            <td>{{ $jobCard->created_at->format('Y-m-d') }}</td>
                            <td>{{ $jobCard->status }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
