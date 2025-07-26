<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiSensyService
{
    public function sendOtp($phone, $otp)
    {
        try {
            // Validate phone number (must be 10 digits)
            $phone = preg_replace('/\D/', '', $phone); // Strip non-digits
            if (strlen($phone) !== 10) {
                return [
                    'success' => false,
                    'message' => 'Mobile number must be exactly 10 digits.',
                ];
            }

            $payload = [
                'apiKey'         => env('AISENSY_API_KEY'),
                'campaignName'   => env('AISENSY_API_CAMPAIGN_NAME', 'vedaro_login'),
                'destination'    => $phone, // Do NOT prefix "91", AiSensy automatically handles it.
                'userName'       => 'Vedaro',
                'templateParams' => ["{$otp}"], // Must be array of strings
                'source'         => 'vedaro.app',
            ];

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post('https://backend.aisensy.com/campaign/t1/api/v2', $payload);

            $body = $response->json();

            if (!$response->successful() || isset($body['error'])) {
                Log::error('❌ AiSensy error response:', $body);
                return [
                    'success' => false,
                    'message' => $body['message'] ?? 'Unknown error from AiSensy',
                ];
            }

            return [
                'success' => true,
                'message' => $body['message'] ?? 'OTP sent successfully.',
                'data'    => $body,
            ];

        } catch (\Exception $e) {
            Log::error("❌ AiSensyService Exception: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Could not connect to AiSensy API.',
            ];
        }
    }
}
