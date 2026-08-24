@extends('layouts.admin')

@section('header', 'Customers')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Customer List</h5>
        <a href="{{ route('admin.customers.create') }}" class="btn btn-sm btn-primary">Add Customer</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>City</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customers as $customer)
                    <tr>
                        <td>{{ $customer->id }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->mobile }}</td>
                        <td>{{ $customer->city }}</td>
                        <td>
                            <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-sm btn-info text-white"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('admin.customers.edit', $customer) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $customers->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
