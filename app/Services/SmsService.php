<?php

namespace App\Services;

use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;

class SmsService
{
    protected Client $client;
    protected string $from;

    public function __construct()
    {
        $this->client = new Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );

        $this->from = config('services.twilio.from');
    }

    /**
     * Convert local PH number (09xxxxxxxxx) to E.164 for Twilio (+639xxxxxxxxx)
     */
    protected function formatPhoneForTwilio(string $phone): string
    {
        
        // keep digits only
        $digits = preg_replace('/\D/', '', $phone);

        // If it starts with 09… → 63…  (PH mobile)
        if (str_starts_with($digits, '09')) {
            $digits = '63' . substr($digits, 1); // drop leading 0
        }

        // If it already starts with 63… but missing +
        if (str_starts_with($digits, '63')) {
            $digits = '+' . $digits;
        }

        // If some other format, at least ensure leading +
        if (!str_starts_with($digits, '+')) {
            $digits = '+' . $digits;
        }

        return $digits;
    }

    

    public function sendBookingStatus(?string $phone, string $message): void
    {
        if (empty($phone)) {
            return; // phone is optional
        }

        $to = $this->formatPhoneForTwilio($phone);

        try {
            $this->client->messages->create($to, [
                'from' => $this->from,
                'body' => $message,
            ]);
        } catch (\Throwable $e) {
            // Don't crash the app if SMS fails, just log it.
            Log::error('Twilio SMS failed: '.$e->getMessage());
        }
    }
}
