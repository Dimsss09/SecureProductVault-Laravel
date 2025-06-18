@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card bg-dark text-light border-secondary">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h4>Welcome, {{ Auth::user()->name }}!</h4>
                    <p>What would you like to do today?</p>
                    
                    <div class="mt-4">
                        <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                            <i class="fa fa-box"></i> Manage Products
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
