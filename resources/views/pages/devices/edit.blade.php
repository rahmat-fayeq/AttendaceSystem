@extends('layout.index')

@section('content')
    <div class="container p-5">
        <div class="flex justify-center items-center content-center">
            <div class="card card-border bg-base-100 w-96 mt-10">
                <div class="card-body space-y-4">

                    <form action="{{ route('devices.update', $device) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium">{{ __('app.name') }}</span>
                            </label>
                            <input type="text" name="name" value="{{ $device->name }}"
                                class="input input-bordered w-full" required>
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium">{{ __('app.ip_address') }}</span>
                            </label>
                            <input type="text" name="ip_address" value="{{ $device->ip_address }}"
                                class="input input-bordered w-full" required>
                            @error('ip_address')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium">{{ __('app.port') }}</span>
                            </label>
                            <input type="number" name="port" value="{{ $device->port }}"
                                class="input input-bordered w-full">
                            @error('port')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium">{{ __('app.comm_key') }}</span>
                            </label>
                            <input type="number" name="comm_key" value="{{ $device->comm_key }}"
                                class="input input-bordered w-full">
                            @error('comm_key')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="cursor-pointer label">
                                <span class="label-text font-medium">{{ __('app.active') }}</span>
                                <input type="checkbox" name="is_active" class="toggle toggle-primary"
                                    {{ $device->is_active ? 'checked' : '' }}>
                            </label>
                        </div>

                        <div class="form-control mt-6">
                            <button type="submit" class="btn btn-primary w-full">{{ __('app.save') }}</button>
                            <a href="{{ route('devices.index') }}"
                                class="btn btn-secondary w-full mt-2">{{ __('app.cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
