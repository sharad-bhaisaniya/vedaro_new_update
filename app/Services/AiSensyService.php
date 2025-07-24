<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiSensyService
{
    protected $apiKey;
    protected $baseUrl = 'https://api.aisensy.com';

    public function __construct()
    {
        $this->apiKey = config('services.aisensy.api_key');
    }

    public function sendOtp($phoneNumber, $otp)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/campaign/v1/send', [
                'campaignName' => config('services.aisensy.campaign_name'),
                'destination' => $phoneNumber,
                'userName' => config('services.aisensy.template_name'),
                'templateParams' => [$otp],
            ]);

            $responseData = $response->json();

            if ($response->successful() && isset($responseData['status']) && $responseData['status'] === 'success') {
                return true;
            }

            Log::error('AI Sensy API Error: ' . json_encode($responseData));
            return false;
        } catch (\Exception $e) {
            Log::error('AI Sensy Service Exception: ' . $e->getMessage());
            return false;
        }
    }
}