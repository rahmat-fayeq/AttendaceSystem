@extends('layout.auth')

@section('content')
    <div class="container p-5">
        <div class="flex justify-center">
            <div class="card card-border bg-base-100 w-full md:w-[450px] mt-10">
                <div class="card-body">

                    <div class="flex justify-end mb-4">
                        <a href="{{ route('login') }}" class="btn btn-ghost btn-sm gap-2">
                            <i class="fa fa-arrow-circle-left"></i> Back
                        </a>
                    </div>

                    @if (session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif

                    <div class="mt-6">
                        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                            @csrf
                            <div class="form-control space-y-2">
                                <label class="label">
                                    <span class="label-text">{{ __('app.email') }}</span>
                                </label>
                                <input class="input input-bordered w-full" name="email" value="{{ old('email') }}"
                                    required>
                                @error('email')
                                    <span class="text-rose-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <button class="btn btn-primary w-full">{{ __('app.send-password-reset-link') }}</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
