@extends('layouts.admin')

@section('header', 'Add Mechanic')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Mechanic Details</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.mechanics.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Mobile</label>
                    <input type="text" name="mobile" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Specialization</label>
                    <input type="text" name="specialization" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control" required>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save Mechanic</button>
            <a href="{{ route('admin.mechanics.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
