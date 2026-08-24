@extends('layouts.admin')

@section('header', 'Spare Parts')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Spare Parts Inventory</h5>
        <a href="{{ route('admin.spare-parts.create') }}" class="btn btn-sm btn-primary">Add Part</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>SKU</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Selling Price</th>
                        <th>Stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($spareParts as $part)
                    <tr>
                        <td>{{ $part->sku }}</td>
                        <td>{{ $part->name }}</td>
                        <td>{{ $part->category }}</td>
                        <td>₹{{ $part->selling_price }}</td>
                        <td>
                            @if($part->stock <= $part->low_stock_limit)
                                <span class="badge bg-danger">{{ $part->stock }} (Low)</span>
                            @else
                                <span class="badge bg-success">{{ $part->stock }}</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.spare-parts.edit', $part) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.spare-parts.destroy', $part) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this part?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $spareParts->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
