@extends('layout.auth')

@section('content')
    <div class="container p-5">
        <div class="flex justify-center">
            <div class="card card-bordered bg-base-100 w-full md:w-[450px] mt-10 shadow-lg">
                <div class="card-body">

                    <!-- Status Message -->
                    @if (session('status'))
                        <div class="alert alert-success shadow-lg mb-4">
                            <div>
                                <i class="fa fa-check-circle"></i>
                                <span>{{ session('status') }}</span>
                            </div>
                        </div>
                    @endif

                    <div class="mt-6">
                        <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                            @csrf
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">

                            <!-- Email Input -->
                            <div class="form-control w-full space-y-2">
                                <label class="label">
                                    <span class="label-text">{{ __('app.email') }}</span>
                                </label>
                                <input type="email" name="email" value="{{ old('email', $request->email) }}" required
                                    class="input input-bordered w-full" placeholder="Enter your email" readonly>
                                @error('email')
                                    <span class="text-rose-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- New Password Input -->
                            <div class="form-control w-full space-y-2">
                                <label class="label">
                                    <span class="label-text">{{ __('app.password') }}</span>
                                </label>
                                <input type="password" name="password" required class="input input-bordered w-full"
                                    placeholder="Enter new password">
                                @error('password')
                                    <span class="text-rose-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Confirm Password Input -->
                            <div class="form-control w-full space-y-2">
                                <label class="label">
                                    <span class="label-text">{{ __('app.password_confirmation') }}</span>
                                </label>
                                <input type="password" name="password_confirmation" required
                                    class="input input-bordered w-full" placeholder="Confirm new password">
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary w-full">
                                {{ __('app.save') }}
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
