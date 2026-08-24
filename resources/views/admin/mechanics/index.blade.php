@extends('layouts.admin')

@section('header', 'Mechanics')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Mechanic List</h5>
        <a href="{{ route('admin.mechanics.create') }}" class="btn btn-sm btn-primary">Add Mechanic</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Specialization</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mechanics as $mechanic)
                    <tr>
                        <td>{{ $mechanic->name }}</td>
                        <td>{{ $mechanic->mobile }}</td>
                        <td>{{ $mechanic->specialization }}</td>
                        <td>
                            <span class="badge bg-{{ $mechanic->status == 'Active' ? 'success' : 'secondary' }}">
                                {{ $mechanic->status }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.mechanics.edit', $mechanic) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.mechanics.destroy', $mechanic) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this mechanic?');">
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
        {{ $mechanics->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
