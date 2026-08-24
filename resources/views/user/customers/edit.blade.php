@extends('layouts.user')

@section('header', 'Edit Customer')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Customer Details</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('customers.update', $customer) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $customer->name }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Mobile</label>
                    <input type="text" name="mobile" class="form-control" value="{{ $customer->mobile }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $customer->email }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label>City</label>
                    <input type="text" name="city" class="form-control" value="{{ $customer->city }}">
                </div>
                <div class="col-md-12 mb-3">
                    <label>Address</label>
                    <textarea name="address" class="form-control" rows="2">{{ $customer->address }}</textarea>
                </div>
                <div class="col-md-12 mb-3">
                    <label>Notes</label>
                    <textarea name="notes" class="form-control" rows="2">{{ $customer->notes }}</textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Update Customer</button>
            <a href="{{ route('customers.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
