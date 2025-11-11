<?php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\AttendanceRecorded;
use App\Models\Attendance;
use App\Models\Student;

class SendEmailJob implements ShouldQueue
{
     use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    public Student $student;
    public Attendance $attendance;

    public $tries = 3;         
    public $retryAfter = 60;   

    public function __construct(Student $student, Attendance $attendance)
    {
        $this->student = $student;
        $this->attendance = $attendance;
    }

    public function handle(): void
    {
        try {
            Mail::to($this->student->email)
                ->queue(new AttendanceRecorded($this->student, $this->attendance));

            Log::info("📧 Email queued to {$this->student->email}");
        } catch (\Throwable $e) {
            Log::error("❌ Failed to queue email to {$this->student->email}: " . $e->getMessage());
            throw $e; // allow retries
        }
    }
}
