<?php

namespace App\Mail;

use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AttendanceRecorded extends Mailable
{
    use Queueable, SerializesModels;

    public $student;
    public $attendance;

    /**
     * Create a new message instance.
     */
    public function __construct(Student $student, Attendance $attendance)
    {
        $this->student = $student;
        $this->attendance = $attendance;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Attendance Recorded')
                    ->markdown('emails.attendance.recorded');
    }
}
