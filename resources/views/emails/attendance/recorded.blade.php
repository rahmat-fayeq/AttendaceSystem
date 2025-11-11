<x-mail::message>
    # Hello {{ $student->name }},

    Your attendance has been successfully recorded

    **Date:** {{ \Carbon\Carbon::parse($attendance->record_time)->format('d-m-Y') }}
    **Time:** {{ \Carbon\Carbon::parse($attendance->record_time)->format('H:i:s') }}

    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>
