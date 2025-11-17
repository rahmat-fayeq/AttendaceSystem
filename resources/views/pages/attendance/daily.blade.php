@extends('layout.index')

@section('content')
    <div class="container p-5">
        <h1 class="text-2xl font-semibold mb-5 text-center">{{ __('app.daily_report') }}</h1>

        <div class="flex mb-4">
            <form method="GET" class="flex gap-3">
                <input type="date" name="date" value="{{ $date }}" class="input input-bordered">
                <button type="submit" class="btn btn-primary ml-2">{{ __('app.filter') }}</button>
            </form>
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
                        <th>{{ __('app.date') }}</th>
                        <th>{{ __('app.time_in') }}</th>
                        <th>{{ __('app.time_out') }}</th>
                        <th>{{ __('app.status') }}</th>
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
                            <td>{{ $data['time_in'] ? \Carbon\Carbon::parse($data['time_in'])->format('H:i:s') : '-' }}
                            </td>
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
