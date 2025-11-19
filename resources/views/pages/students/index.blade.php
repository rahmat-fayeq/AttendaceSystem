@extends('layout.index')

@section('content')
    <div class="container p-5">
        <h1 class="text-2xl font-semibold mb-5 text-center">{{ __('app.students') }}</h1>

        <div class="flex mb-4">
            <a href="{{ route('students.create') }}" class="btn btn-primary">+ {{ __('app.add_new') }}</a>

        </div>


        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th>{{ __('app.name') }}</th>
                        <th>{{ __('app.father_name') }}</th>
                        <th>{{ __('app.department') }}</th>
                        <th>{{ __('app.phone') }}</th>
                        <th>{{ __('app.email') }}</th>
                        <th>{{ __('app.device_user_id') }}</th>
                        <th>{{ __('app.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $index => $student)
                        <tr class="text-center">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->father_name }}</td>
                            <td>{{ $student->department }}</td>
                            <td>{{ $student->phone_number }}</td>
                            <td>{{ $student->email ?? '-' }}</td>
                            <td>{{ $student->device_user_id ?? '-' }}</td>
                            <td class="space-x-2">
                                <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('students.destroy', $student) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-error"
                                        onclick="return confirm('Delete this student?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
