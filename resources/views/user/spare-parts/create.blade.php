@extends('layouts.user')

@section('header', 'Add Spare Part')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Part Details</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('spare-parts.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>SKU</label>
                    <input type="text" name="sku" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Category</label>
                    <input type="text" name="category" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Supplier</label>
                    <input type="text" name="supplier" class="form-control">
                </div>
                <div class="col-md-3 mb-3">
                    <label>Purchase Price (₹)</label>
                    <input type="number" step="0.01" name="purchase_price" class="form-control">
                </div>
                <div class="col-md-3 mb-3">
                    <label>Selling Price (₹)</label>
                    <input type="number" step="0.01" name="selling_price" class="form-control" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label>Current Stock</label>
                    <input type="number" name="stock" class="form-control" value="0" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label>Low Stock Limit</label>
                    <input type="number" name="low_stock_limit" class="form-control" value="5" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save Part</button>
            <a href="{{ route('spare-parts.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
