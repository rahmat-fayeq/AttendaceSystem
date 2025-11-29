@extends('layout.index')

@section('content')
    <div class="container p-5">
        <h1 class="text-2xl font-semibold mb-5 text-center">{{ __('') }}</h1>

        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <div class="overflow-x-auto">
                    Welcome, Dear {{ auth()->user()?->name }}
                </div>
            </div>
        </div>
    </div>
@endsection
