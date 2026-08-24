@extends('layouts.admin')

@section('header', 'Edit Service')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Service Details</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.services.update', $service) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $service->name }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Category</label>
                    <input type="text" name="category" class="form-control" value="{{ $service->category }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label>Price (₹)</label>
                    <input type="number" step="0.01" name="price" class="form-control" value="{{ $service->price }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Duration</label>
                    <input type="text" name="duration" class="form-control" value="{{ $service->duration }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control" required>
                        <option value="Active" {{ $service->status == 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ $service->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Update Service</button>
            <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
