<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiSensyService
{
    public function sendOtp($phone, $otp)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('AISENSY_API_KEY'),
                'Content-Type'  => 'application/json',
            ])->post('https://api.aisensy.com/campaign/v1/send', [
                'campaignName'    => 'vedaro_login',
                'destination'     => '91' . $phone,
                'userName'        => 'Vedaro',
                'templateParams'  => [$otp],
                'source'          => 'vedaro.app',
            ]);

            $body = $response->json();

            return [
                'success' => $response->successful(),
                'message' => $body['message'] ?? 'Sent successfully.',
            ];
        }catch (\Exception $e) {
            if (str_contains($e->getMessage(), 'Could not resolve host')) {
                Log::error("DNS resolution failed for AiSensy API.");
            }
        
            Log::error("AI Sensy Service Exception: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Could not connect to AiSensy API. Please try again later.',
            ];
        }

    }
}
