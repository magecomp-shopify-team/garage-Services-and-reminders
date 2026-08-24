@extends('layouts.admin')

@section('header', 'Admin Dashboard')

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Customers</h5>
                <p class="card-text fs-2">{{ $total_customers }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">Completed Jobs</h5>
                <p class="card-text fs-2">{{ $completed_jobs }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning mb-3">
            <div class="card-body">
                <h5 class="card-title">Pending Jobs</h5>
                <p class="card-text fs-2">{{ $pending_jobs }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-danger mb-3">
            <div class="card-body">
                <h5 class="card-title">Low Stock Parts</h5>
                <p class="card-text fs-2">{{ $low_stock_parts }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
