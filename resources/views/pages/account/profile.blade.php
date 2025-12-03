@extends('layout.index')

@section('content')
    <div class="container p-5">
        <div class="flex justify-center">
            <div class="card card-border bg-base-100 w-full md:w-[450px] mt-10">
                <div class="card-body">

                    {{-- Tabs --}}
                    <div role="tablist" class="tabs tabs-bordered">
                        <a role="tab" class="tab tab-active hover:bg-base-300 transition-all" id="tab-password"
                            onclick="switchTab('password')">
                            {{ __('app.change_password') }}
                        </a>
                        <a role="tab" class="tab  hover:bg-base-300 transition-all" id="tab-profile"
                            onclick="switchTab('profile')">
                            {{ __('app.profile_information') }}
                        </a>
                    </div>
                    {{-- CHANGE PASSWORD TAB --}}
                    <div id="content-password" class="mt-6 hidden">
                        <form method="POST" action="{{ route('user-password.update') }}" class="space-y-6">
                            @csrf
                            @method('PUT')

                            <div class="form-control space-y-2">
                                <label class="label">
                                    <span class="label-text">{{ __('app.current_password') }}</span>
                                </label>
                                <input type="password" class="input input-bordered w-full" name="current_password" required>
                                @error('current_password')
                                    <span class="text-rose-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-control space-y-2">
                                <label class="label">
                                    <span class="label-text">{{ __('app.password') }}</span>
                                </label>
                                <input type="password" class="input input-bordered w-full" name="password" required>
                                @error('password')
                                    <span class="text-rose-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-control space-y-2">
                                <label class="label">
                                    <span class="label-text">{{ __('app.password_confirmation') }}</span>
                                </label>
                                <input type="password" class="input input-bordered w-full" name="password_confirmation"
                                    required>
                                @error('password_confirmation')
                                    <span class="text-rose-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <button class="btn btn-primary w-full">{{ __('app.change_password') }}</button>
                        </form>
                    </div>
                    {{-- PROFILE INFORMATION TAB --}}
                    <div id="content-profile" class="mt-6">
                        <form method="POST" action="{{ route('user-profile-information.update') }}" class="space-y-6">
                            @csrf
                            @method('PUT')

                            <div class="form-control space-y-2">
                                <label class="label">
                                    <span class="label-text">{{ __('app.name') }}</span>
                                </label>
                                <input class="input input-bordered w-full" name="name"
                                    value="{{ old('name', auth()->user()->name) }}" required>
                                @error('name')
                                    <span class="text-rose-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-control space-y-2">
                                <label class="label">
                                    <span class="label-text">{{ __('app.email') }}</span>
                                </label>
                                <input class="input input-bordered w-full" name="email"
                                    value="{{ old('email', auth()->user()->email) }}" required>
                                @error('email')
                                    <span class="text-rose-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <button class="btn btn-primary w-full">{{ __('app.save') }}</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Simple JS Tab Switcher --}}
    <script>
        function switchTab(tab) {
            document.getElementById('tab-profile').classList.remove('tab-active');
            document.getElementById('tab-password').classList.remove('tab-active');

            document.getElementById('content-profile').classList.add('hidden');
            document.getElementById('content-password').classList.add('hidden');

            if (tab === 'profile') {
                document.getElementById('tab-profile').classList.add('tab-active');
                document.getElementById('content-profile').classList.remove('hidden');
            } else {
                document.getElementById('tab-password').classList.add('tab-active');
                document.getElementById('content-password').classList.remove('hidden');
            }
        }
    </script>
@endsection
