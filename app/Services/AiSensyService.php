<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiSensyService
{
    public function sendOtp($phone, $otp)
    {
        try {
            // Clean and validate phone number
            $phone = preg_replace('/\D/', '', $phone); // Only digits
            if (strlen($phone) !== 10) {
                Log::error('❌ Invalid phone number: ' . $phone);
                return [
                    'success' => false,
                    'message' => 'Mobile number must be exactly 10 digits.',
                ];
            }

            $payload = [
                'apiKey'         => env('AISENSY_API_KEY'),
                'campaignName'   => env('AISENSY_API_CAMPAIGN_NAME', 'vedaro_login'),
                'destination'    => $phone,
                'userName'       => 'Vedaro',
                'templateParams' => [(string) $otp],
                'source'         => 'vedaro.app',
            ];

            Log::info('📤 Sending OTP via AiSensy:', $payload);

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post('https://backend.aisensy.com/campaign/t1/api/v2', $payload);

            Log::info('📥 AiSensy raw response: ' . $response->body());

            $body = $response->json();

            if (!$response->successful()) {
                Log::error('❌ HTTP Request Failed with status: ' . $response->status());
                return [
                    'success' => false,
                    'message' => 'HTTP request failed.',
                    'data'    => $body
                ];
            }

            if (isset($body['success']) && $body['success'] !== 'true') {
                Log::error('❌ AiSensy API Error:', $body);
                return [
                    'success' => false,
                    'message' => $body['message'] ?? 'OTP not sent.',
                    'data' => $body
                ];
            }

            Log::info('✅ OTP sent successfully via AiSensy.');
            return [
                'success' => true,
                'message' => 'OTP sent successfully.',
                'data'    => $body
            ];
        } catch (\Exception $e) {
            Log::error('❌ Exception while sending OTP: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Exception occurred while sending OTP.',
            ];
        }
    }
}
