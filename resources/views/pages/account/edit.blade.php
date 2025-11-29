@extends('layout.index')

@section('content')
    <div class="container p-5">
        <div class="flex justify-center">
            <div class="card card-border bg-base-100 w-full md:w-96 mt-10">
                <div class="card-body space-y-4">

                    <form action="{{ route('accounts.update', $user->id) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PATCH')
                        <div class="form-control">
                            <label class="label" for="name"><span class="label-text">{{ __('app.name') }}</span></label>
                            <input type="text" name="name" class="input input-bordered w-full"
                                value="{{ $user->name }}">
                            @error('name')
                                <span class="text-rose-700">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label" for="email"><span
                                    class="label-text">{{ __('app.email') }}</span></label>
                            <input type="email" name="email" class="input input-bordered w-full"
                                value="{{ $user->email }}">
                            @error('email')
                                <span class="text-rose-700">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label" for="password"><span
                                    class="label-text">{{ __('app.password') }}</span></label>
                            <input type="password" name="password" class="input input-bordered w-full">
                            @error('password')
                                <span class="text-rose-700">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label" for="password_confirmation"><span
                                    class="label-text">{{ __('app.password_confirmation') }}</span></label>
                            <input type="password" name="password_confirmation" class="input input-bordered w-full">
                            @error('password_confirmation')
                                <span class="text-rose-700">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label" for="active">
                                <span class="label-text">{{ __('app.status') }}</span>
                            </label>
                            <select id="active" name="active" class="select w-full">
                                <option value="1" {{ old('active', $user->active) ? 'selected' : '' }}>
                                    {{ __('app.active') }}
                                </option>
                                <option value="0" {{ !old('active', $user->active) ? 'selected' : '' }}>
                                    {{ __('app.inActive') }}
                                </option>
                            </select>
                            @error('active')
                                <span class="text-rose-700">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-control mt-6">
                            <button type="submit" class="btn btn-primary btn-sm w-full">{{ __('app.save') }}</button>
                            <a href="{{ route('accounts.index') }}"
                                class="btn btn-secondary btn-sm w-full mt-2">{{ __('app.cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
