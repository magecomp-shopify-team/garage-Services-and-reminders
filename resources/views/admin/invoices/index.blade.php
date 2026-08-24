@extends('layouts.admin')

@section('header', 'Invoices')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Invoice List</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Invoice No</th>
                        <th>Job Card</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Balance</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoices as $invoice)
                    <tr>
                        <td>{{ $invoice->invoice_number }}</td>
                        <td>{{ $invoice->jobCard->job_number ?? 'N/A' }}</td>
                        <td>{{ $invoice->jobCard->customer->name ?? 'N/A' }}</td>
                        <td>₹{{ $invoice->total }}</td>
                        <td>₹{{ $invoice->balance }}</td>
                        <td>
                            <span class="badge bg-{{ $invoice->status == 'Paid' ? 'success' : ($invoice->status == 'Partial' ? 'warning' : 'danger') }}">
                                {{ $invoice->status }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.invoices.show', $invoice) }}" class="btn btn-sm btn-info text-white">View</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $invoices->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
