@extends('layouts.admin')

@section('header', 'Payments')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Payment List</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Invoice No</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                    <tr>
                        <td>
                            <a href="{{ route('admin.invoices.show', $payment->invoice) }}">
                                {{ $payment->invoice->invoice_number ?? 'N/A' }}
                            </a>
                        </td>
                        <td>₹{{ $payment->amount }}</td>
                        <td>{{ $payment->payment_method }}</td>
                        <td>{{ $payment->payment_date }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $payments->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
