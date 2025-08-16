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
            $phone = preg_replace('/\D/', '', $phone); // Remove non-digits
            if (strlen($phone) !== 10) {
                Log::error('❌ Invalid phone number: ' . $phone);
                return [
                    'success' => false,
                    'message' => 'Mobile number must be exactly 10 digits.',
                ];
            }

            $fullPhone = '91' . $phone;

            $payload = [
                'apiKey'         => env('AISENSY_API_KEY'),
                'campaignName'   => env('AISENSY_API_CAMPAIGN_NAME', 'vedaro_login'),
                'destination'    => $fullPhone,
                'userName'       => 'Vedaro',
                'templateParams' => [(string) $otp],
                'source'         => 'new-landing-page form',
                'media'          => (object)[],
                'buttons'       => [
                    [
                        'type'       => 'button',
                        'sub_type'   => 'url',
                        'index'      => 0,
                        'parameters' => [
                            [
                                'type' => 'text',
                                'text' => '$sampleParam$i'
                            ]
                        ]
                    ]
                ],
                'carouselCards'      => [],
                'location'           => (object)[],
                'attributes'        => (object)[],
                'paramsFallbackValue'=> [
                    'FirstName' => 'user'
                ]
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

    public function sendCartReminder($phone, $name, $itemCount, $cartLink = 'https://vedaro.in/')
    {
        try {
            $phone = preg_replace('/\D/', '', $phone); // Clean phone
            if (strlen($phone) !== 10) {
                Log::error('❌ Invalid phone number for cart reminder: ' . $phone);
                return ['success' => false, 'message' => 'Mobile number must be exactly 10 digits.'];
            }

            $fullPhone = '91' . $phone;

            $payload = [
                'apiKey'         => env('AISENSY_API_KEY'),
                'campaignName'   => env('AISENSY_CART__API_CAMPAIGN_NAME', 'Vedaro_cart_updates'),
                'destination'    => $fullPhone,
                'userName'       => 'Vedaro',
                'templateParams' => [$name, (string) $itemCount, $cartLink],
                'source'         => 'cart-update-cron',
                'media'          => (object)[],
                'buttons'        => [],
                'carouselCards'  => [],
                'location'      => (object)[],
                'attributes'     => (object)[],
                'paramsFallbackValue'=> [
                    'FirstName' => 'User'
                ]
            ];

            Log::info("📤 Sending cart reminder to $fullPhone:", $payload);

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post('https://backend.aisensy.com/campaign/t1/api/v2', $payload);

            Log::info('📥 AiSensy cart reminder response: ' . $response->body());

            $body = $response->json();

            if (!$response->successful() || ($body['success'] ?? 'false') !== 'true') {
                Log::error('❌ Failed to send cart update via AiSensy:', $body);
                return [
                    'success' => false,
                    'message' => $body['message'] ?? 'Failed to send cart update.',
                    'data'    => $body
                ];
            }

            Log::info("✅ Cart update message sent successfully to $phone.");
            return [
                'success' => true,
                'message' => 'Cart update sent.',
                'data'    => $body
            ];
        } catch (\Exception $e) {
            Log::error('❌ Exception while sending cart update: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Exception occurred while sending cart update.',
            ];
        }
    }

    public function sendPrebookingNotification($phone, $name)
    {
        try {
            // Clean and validate phone number
            $phone = preg_replace('/\D/', '', $phone);
            if (strlen($phone) !== 10) {
                Log::error('❌ Invalid phone number for prebooking: ' . $phone);
                return [
                    'success' => false,
                    'message' => 'Mobile number must be exactly 10 digits.'
                ];
            }
    
            $fullPhone = '91' . $phone;
    
            $payload = [
                'apiKey'         => env('AISENSY_API_KEY'),
                'campaignName'   => env('AISENSY_PREBOOKING__API_CAMPAIGN_NAME', 'vedaro_prebooking'),
                'destination'    => $fullPhone,
                'userName'       => 'Vedaro',
                'templateParams' => [$name], // Only name parameter as required by template
                'source'         => 'prebooking-notification',
                'media'          => (object)[],
                'buttons'        => [],
                'carouselCards'  => [],
                'location'       => (object)[],
                'attributes'     => (object)[],
                'paramsFallbackValue' => [
                    'FirstName' => 'Customer'
                ]
            ];
    
            Log::info("📤 Sending prebooking notification to $fullPhone:", $payload);
    
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post('https://backend.aisensy.com/campaign/t1/api/v2', $payload);
    
            Log::info('📥 AiSensy prebooking response: ' . $response->body());
    
            $body = $response->json();
    
            if (!$response->successful() || ($body['success'] ?? 'false') !== 'true') {
                Log::error('❌ Failed to send prebooking notification via AiSensy:', $body);
                return [
                    'success' => false,
                    'message' => $body['message'] ?? 'Failed to send prebooking notification.',
                    'data'    => $body
                ];
            }
    
            Log::info("✅ Prebooking notification sent successfully to $phone.");
            return [
                'success' => true,
                'message' => 'Prebooking notification sent.',
                'data'    => $body
            ];
        } catch (\Exception $e) {
            Log::error('❌ Exception while sending prebooking notification: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Exception occurred while sending prebooking notification.',
            ];
        }
    }
    
    public function sendOrderConfirmation($phone, $orderId)
    {
        try {
            $phone = preg_replace('/\D/', '', $phone);
            if (strlen($phone) !== 10) {
                Log::error('❌ Invalid phone number for order confirmation: ' . $phone);
                return [
                    'success' => false,
                    'message' => 'Mobile number must be exactly 10 digits.'
                ];
            }
    
            $fullPhone = '91' . $phone;
    
            $payload = [
                'apiKey'             => env('AISENSY_API_KEY'),
                'campaignName'       => env('AISENSY_ORDER_CONFIRM_API_CAMPAIGN_NAME', 'order_success'),
                'destination'        => $fullPhone,
                'userName'           => 'Vedaro',
                'templateParams'     => ['#' . $orderId],
                'source'             => 'order-confirmation',
                'media'              => (object)[],
                'buttons'            => [],
                'carouselCards'      => [],
                'location'           => (object)[],
                'attributes'         => (object)[],
                'paramsFallbackValue'=> [
                    'FirstName' => 'Customer'
                ]
            ];
    
            Log::info("📤 Sending order confirmation to $fullPhone:", $payload);
    
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post('https://backend.aisensy.com/campaign/t1/api/v2', $payload);
    
            Log::info('📥 AiSensy order confirmation response: ' . $response->body());
    
            $body = $response->json();
    
            if (!$response->successful() || ($body['success'] ?? 'false') !== 'true') {
                Log::error('❌ Failed to send order confirmation via AiSensy:', $body);
                return [
                    'success' => false,
                    'message' => $body['message'] ?? 'Failed to send order confirmation.',
                    'data'    => $body
                ];
            }
    
            Log::info("✅ Order confirmation message sent to $phone.");
            return [
                'success' => true,
                'message' => 'Order confirmation sent.',
                'data'    => $body
            ];
    
        } catch (\Exception $e) {
            Log::error('❌ Exception while sending order confirmation: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Exception occurred while sending order confirmation.'
            ];
        }
    }

}