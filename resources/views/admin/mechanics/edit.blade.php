@extends('layouts.admin')

@section('header', 'Edit Mechanic')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Mechanic Details</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.mechanics.update', $mechanic) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $mechanic->name }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Mobile</label>
                    <input type="text" name="mobile" class="form-control" value="{{ $mechanic->mobile }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Specialization</label>
                    <input type="text" name="specialization" class="form-control" value="{{ $mechanic->specialization }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control" required>
                        <option value="Active" {{ $mechanic->status == 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ $mechanic->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Update Mechanic</button>
            <a href="{{ route('admin.mechanics.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
