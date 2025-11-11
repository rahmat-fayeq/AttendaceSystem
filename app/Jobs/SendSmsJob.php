<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Gregwar\Serial\Serial;
use Illuminate\Bus\Batchable;
use Illuminate\Support\Facades\Log;

class SendSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels,Batchable;

    public $phoneNumber;
    public $message;

    public $tries = 3;          // Retry 3 times
    public $retryAfter = 60;    // Wait 60s before retry

    public function __construct(string $phoneNumber, string $message)
    {
        $this->phoneNumber = $phoneNumber;
        $this->message = $message;
    }

    public function handle(): void
    {
        $serial = new Serial();

        try {
            // Configure COM port and modem
            $serial->device(env('MODEM_PORT', 'COM3'));
            $serial->confBaudRate((int) env('MODEM_BAUDRATE', 9600));
            $serial->confParity("N");
            $serial->confCharacterLength(8);
            $serial->confStopBits(1);
            $serial->confFlowControl("none");

            $serial->deviceOpen();

            // Initialize modem
            $serial->sendMessage("AT\r");
            usleep(300000);
            $response = $serial->readPort();

            if (stripos($response, "OK") === false) {
                throw new \Exception("Modem not responding properly: {$response}");
            }

            // Set text mode
            $serial->sendMessage("AT+CMGF=1\r");
            usleep(300000);
            $serial->readPort();

            // Send SMS
            $serial->sendMessage("AT+CMGS=\"{$this->phoneNumber}\"\r");
            usleep(500000);
            $serial->sendMessage($this->message . chr(26)); // Ctrl+Z
            usleep(1500000);

            $response = $serial->readPort();
            Log::info("📨 SMS sent to {$this->phoneNumber}: {$response}");
        } catch (\Throwable $e) {
            Log::error("❌ Failed to send SMS to {$this->phoneNumber}: " . $e->getMessage());
            throw $e; // Re-throw to trigger retry
        } finally {
            // Always close port even if failure
            try {
                $serial->deviceClose();
            } catch (\Throwable $ignored) {
                // ignore
            }
        }
    }
}
