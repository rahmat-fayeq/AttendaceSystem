@extends('layout.index')

@section('content')
    <div class="container p-5">
        <h1 class="text-2xl font-semibold mb-5 text-center">{{ __('app.users') }}</h1>

        <div class="flex mb-4">
            <a href="{{ route('accounts.create') }}" class="btn btn-primary">
                {{ __('app.add_new') }}
                <i class="fa fa-plus-circle" aria-hidden="true"></i>
            </a>

        </div>


        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th>{{ __('app.name') }}</th>
                        <th>{{ __('app.email') }}</th>
                        <th>{{ __('app.status') }}</th>
                        <th>{{ __('app.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $index => $user)
                        <tr class="text-center">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if ($user->active)
                                    <div class="badge badge-success">{{ __('app.active') }}</div>
                                @else
                                    <div class="badge badge-error">{{ __('app.inActive') }}</div>
                                @endif
                            </td>
                            <td class="space-x-2">
                                <a href="{{ route('accounts.edit', $user->id) }}"
                                    class="btn btn-sm btn-warning hover:scale-105 transition-all">
                                    <i class="fa fa-pencil text-white" aria-hidden="true"></i>
                                </a>
                                <form action="{{ route('accounts.destroy', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-error hover:scale-105 transition-all"
                                        onclick="return confirm('Delete this user?')">
                                        <i class="fa fa-trash text-white" aria-hidden="true"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
