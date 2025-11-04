@extends('layout.index')

@section('content')
    <div class="container p-5">
        <h1 class="text-2xl font-semibold mb-5 text-center">Daily Attendance Report</h1>

        <div class="flex justify-between mb-4">
            <form method="GET">
                <input type="date" name="date" value="{{ $date }}" class="input input-bordered">
                <button type="submit" class="btn btn-primary ml-2">Filter</button>
            </form>
            <a href="{{ route('attendance.fetch') }}" class="btn btn-secondary">Fetch Attendance Now</a>
        </div>

        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th>Student Name</th>
                        <th>Father Name</th>
                        <th>Department</th>
                        <th>Phone</th>
                        <th>Date</th>
                        <th>Time In</th>
                        <th>Time Out</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($attendanceData as $index => $data)
                        <tr class="text-center">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $data['student']->name }}</td>
                            <td>{{ $data['student']->father_name }}</td>
                            <td>{{ $data['student']->department }}</td>
                            <td>{{ $data['student']->phone_number }}</td>
                            <td>{{ \Carbon\Carbon::parse($data['date'])->format('d-m-Y') }}</td>
                            <td>{{ $data['time_in'] ? \Carbon\Carbon::parse($data['time_in'])->format('H:i:s') : '-' }}</td>
                            <td>{{ $data['time_out'] ? \Carbon\Carbon::parse($data['time_out'])->format('H:i:s') : '-' }}
                            </td>
                            <td>
                                <span
                                    class="badge
                            {{ $data['status'] == 'Present' ? 'badge-success' : ($data['status'] == 'Half Day' ? 'badge-warning' : 'badge-error') }}">
                                    {{ $data['status'] }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
