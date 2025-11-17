@extends('layout.index')

@section('content')
    <div class="container p-5">
        <h1 class="text-2xl font-semibold mb-5 text-center">{{ __('app.devices') }}</h1>

        @if (session('success'))
            <div class="alert alert-success mb-4">{{ session('success') }}</div>
        @endif

        <div class="flex justify-between mb-6">
            <a href="{{ route('devices.create') }}" class="btn btn-primary">+ {{ __('app.add_new') }}</a>
        </div>

        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <div class="overflow-x-auto">
                    <table class="table w-full">
                        <thead>
                            <tr class="text-center">
                                <th>#</th>
                                <th>{{ __('app.name') }}</th>
                                <th>{{ __('app.ip_address') }}</th>
                                <th>{{ __('app.port') }}</th>
                                <th>{{ __('app.status') }}</th>
                                <th>{{ __('app.connection') }}</th>
                                <th>{{ __('app.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($devices as $index => $device)
                                <tr class="text-center">
                                    <td>{{ $index + 1 }}</td>
                                    <td class="font-medium">{{ $device->name }}</td>
                                    <td>{{ $device->ip_address }}</td>
                                    <td>{{ $device->port }}</td>
                                    <td>
                                        <span class="badge {{ $device->is_active ? 'badge-success' : 'badge-error' }}">
                                            {{ $device->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($device->is_connected)
                                            <span class="badge badge-success">Connected</span>
                                        @else
                                            <span class="badge badge-error">Disconnected</span>
                                        @endif
                                    </td>
                                    <td class="space-x-2">
                                        <a href="{{ route('devices.edit', $device) }}"
                                            class="btn btn-sm btn-warning">{{ __('app.edit') }}</a>
                                        <form action="{{ route('devices.destroy', $device) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-error"
                                                onclick="return confirm('Delete this device?')">{{ __('app.delete') }}</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-gray-500 py-4">
                                        {{ __('app.not_found') }} <a href="{{ route('devices.create') }}"
                                            class="text-blue-500 underline">{{ __('app.add_new') }}</a>.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
