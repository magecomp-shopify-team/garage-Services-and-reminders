@extends('layouts.admin')

@section('header', 'Add Service Reminder')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">New Service Reminder</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.service-reminders.store') }}" method="POST">
            @csrf
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Customer</label>
                    <select name="customer_id" class="form-select" required id="customer_select">
                        <option value="">Select Customer</option>
                        @foreach(\App\Models\Customer::all() as $customer)
                            <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }} ({{ $customer->mobile }})
                            </option>
                        @endforeach
                    </select>
                    @error('customer_id')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Vehicle</label>
                    <select name="vehicle_id" class="form-select" required id="vehicle_select">
                        <option value="">Select Vehicle</option>
                        @foreach(\App\Models\Vehicle::all() as $vehicle)
                            <option value="{{ $vehicle->id }}" data-customer="{{ $vehicle->customer_id }}" {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                                {{ $vehicle->registration_number }}
                            </option>
                        @endforeach
                    </select>
                    @error('vehicle_id')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Last Service Date (Optional)</label>
                    <input type="date" name="last_service_date" class="form-control" value="{{ old('last_service_date') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Last Service KM (Optional)</label>
                    <input type="number" name="last_service_km" class="form-control" value="{{ old('last_service_km') }}">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Next Service Date</label>
                    <input type="date" name="next_service_date" class="form-control" value="{{ old('next_service_date') }}" required>
                    @error('next_service_date')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Next Service KM (Optional)</label>
                    <input type="number" name="next_service_km" class="form-control" value="{{ old('next_service_km') }}">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Notes (Optional)</label>
                <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Save Reminder</button>
            <a href="{{ route('admin.service-reminders.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Simple filter to only show vehicles belonging to selected customer
    document.getElementById('customer_select').addEventListener('change', function() {
        let customerId = this.value;
        let vehicleOptions = document.getElementById('vehicle_select').options;
        
        for(let i=0; i < vehicleOptions.length; i++) {
            if (i === 0) continue; // skip default
            let option = vehicleOptions[i];
            if (option.getAttribute('data-customer') == customerId || customerId === '') {
                option.style.display = '';
            } else {
                option.style.display = 'none';
            }
        }
        document.getElementById('vehicle_select').value = '';
    });
</script>
@endsection
