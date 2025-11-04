@extends('layout.index')

@section('content')
    <div class="container p-5">
        <h1 class="text-2xl font-semibold mb-5 text-center">Students</h1>

        @if (session('success'))
            <div class="alert alert-success mb-4">{{ session('success') }}</div>
        @endif

        <div class="flex justify-end mb-4">
            <a href="{{ route('students.create') }}" class="btn btn-primary">+ Add Student</a>
        </div>

        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th>Name</th>
                        <th>Father Name</th>
                        <th>Department</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Device User ID</th>
                        <th>Actions</th>
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
