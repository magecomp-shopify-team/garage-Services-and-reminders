@extends('layouts.user')

@section('header', 'Services')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Service List</h5>
        <a href="{{ route('services.create') }}" class="btn btn-sm btn-primary">Add Service</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Duration</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($services as $service)
                    <tr>
                        <td>{{ $service->name }}</td>
                        <td>{{ $service->category }}</td>
                        <td>₹{{ $service->price }}</td>
                        <td>{{ $service->duration }}</td>
                        <td>
                            <span class="badge bg-{{ $service->status == 'Active' ? 'success' : 'secondary' }}">
                                {{ $service->status }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('services.edit', $service) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('services.destroy', $service) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this service?');">
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
        {{ $services->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
