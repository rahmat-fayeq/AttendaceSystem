@extends('layout.auth')
@section('content')
    <div class="min-h-screen flex flex-col items-center justify-center py-6 px-4">
        <div class="max-w-[480px] w-full">
            <div class="p-6 sm:p-8 rounded-2xl bg-base-100 border border-base-300 shadow-sm">
                <h1 class="text-center text-3xl font-semibold text-base-content">{{ __('app.signin') }}</h1>
                <form method="post" action="{{ route('login.store') }}" class="mt-12 space-y-6">
                    @csrf
                    <div>
                        <label class="text-sm font-medium mb-2 block text-base-content"
                            for="email">{{ __('app.email') }}</label>
                        <div class="relative flex items-center">
                            <input name="email" id="email" type="email"
                                class="input input-bordered w-full pr-8 text-base-content @error('email') border-rose-600 @enderror "
                                required />
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                class="w-4 h-4 absolute right-4 text-gray-400" viewBox="0 0 24 24">
                                <circle cx="10" cy="7" r="6"></circle>
                                <path
                                    d="M14 15H6a5 5 0 0 0-5 5 3 3 0 0 0 3 3h12a3 3 0 0 0 3-3 5 5 0 0 0-5-5zm8-4h-2.59l.3-.29a1 1 0 0 0-1.42-1.42l-2 2a1 1 0 0 0 0 1.42l2 2a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42l-.3-.29H22a1 1 0 0 0 0-2z">
                                </path>
                            </svg>
                        </div>
                        @error('email')
                            <span class="text-rose-700">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="text-sm font-medium mb-2 block text-base-content"
                            for="password">{{ __('app.password') }}</label>
                        <div class="relative flex items-center">
                            <input id="password" name="password" type="password"
                                class="input input-bordered w-full pr-8 text-base-content @error('password') border-rose-600 @enderror"
                                autocomplete="off" required />
                            <svg id="togglePassword" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                class="w-4 h-4 absolute right-4 cursor-pointer text-gray-400" viewBox="0 0 128 128">
                                <path
                                    d="M64 104C22.127 104 1.367 67.496.504 65.943a4 4 0 0 1 0-3.887C1.367 60.504 22.127 24 64 24s62.633 36.504 63.496 38.057a4 4 0 0 1 0 3.887C126.633 67.496 105.873 104 64 104zM8.707 63.994C13.465 71.205 32.146 96 64 96c31.955 0 50.553-24.775 55.293-31.994C114.535 56.795 95.854 32 64 32 32.045 32 13.447 56.775 8.707 63.994zM64 88c-13.234 0-24-10.766-24-24s10.766-24 24-24 24 10.766 24 24-10.766 24-24 24zm0-40c-8.822 0-16 7.178-16 16s7.178 16 16 16 16-7.178 16-16-7.178-16-16-16z">
                                </path>
                            </svg>
                        </div>
                        @error('password')
                            <span class="text-rose-700">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div class="flex items-center">
                            <input id="remember" name="remember" type="checkbox" class="checkbox checkbox-primary" />
                            <label for="remember" class="mx-3 block text-sm text-base-content">
                                {{ __('app.remember_me') }}
                            </label>
                        </div>
                        <div class="text-sm">
                            <a href="{{ route('password.request') }}" class="link link-primary font-semibold">
                                {{ __('app.forgot_password') }}
                            </a>
                        </div>
                    </div>

                    <div class="mt-12">
                        <button type="submit"
                            class="btn btn-primary w-full text-[15px] font-medium tracking-wide hover:scale-105 transition-all">
                            {{ __('app.signin') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', () => {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
        });
    </script>
@endsection
