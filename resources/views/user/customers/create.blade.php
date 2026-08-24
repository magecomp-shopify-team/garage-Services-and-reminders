@extends('layouts.user')

@section('header', 'Add Customer')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Customer Details</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('customers.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Mobile</label>
                    <input type="text" name="mobile" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label>City</label>
                    <input type="text" name="city" class="form-control">
                </div>
                <div class="col-md-12 mb-3">
                    <label>Address</label>
                    <textarea name="address" class="form-control" rows="2"></textarea>
                </div>
                <div class="col-md-12 mb-3">
                    <label>Notes</label>
                    <textarea name="notes" class="form-control" rows="2"></textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save Customer</button>
            <a href="{{ route('customers.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
