@extends('layouts.user')

@section('header', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Welcome back, {{ Auth::user()->name }}!</div>
            <div class="card-body">
                <p>Role: {{ Auth::user()->role }}</p>
                <p>Use the sidebar to navigate to your accessible modules.</p>
            </div>
        </div>
    </div>
</div>
@endsection
