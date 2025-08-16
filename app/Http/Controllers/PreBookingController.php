<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PreBooking;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Services\AiSensyService;
use Twilio\Rest\Client;

class PreBookingController extends Controller
{
    public function sendWhatsAppReminder($id)
    {
        try {
            $preBooking = PreBooking::with(['user', 'product'])->findOrFail($id);
            
            if (!$preBooking->user || !$preBooking->user->phone) {
                throw new \Exception('User phone number not available');
            }

            // Check which service to use (Twilio or AiSensy)
            if (env('WHATSAPP_SERVICE') === 'twilio') {
                return $this->sendViaTwilio($preBooking);
            } else {
                return $this->sendViaAiSensy($preBooking);
            }

        } catch (\Exception $e) {
            Log::error("Failed to send pre-booking WhatsApp reminder: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

   private function sendViaAiSensy($preBooking)
{
    $aiSensyService = new AiSensyService();
    $response = $aiSensyService->sendPrebookingNotification(
        $preBooking->user->phone,
        $preBooking->user->first_name // Only sending name as required by template
    );

    if ($response['success']) {
        return response()->json([
            'success' => true,
            'message' => 'WhatsApp reminder sent successfully via AiSensy!'
        ]);
    }

    throw new \Exception($response['message'] ?? 'Failed to send via AiSensy');
}

private function sendPrebookingConfirmation($user, $productId, $quantity)
{
    try {
        if (env('WHATSAPP_SERVICE') === 'aisensy') {
            $aiSensyService = new AiSensyService();
            $aiSensyService->sendPrebookingNotification(
                $user->phone,
                $user->first_name // Only sending name as required by template
            );
        } elseif (env('WHATSAPP_SERVICE') === 'twilio') {
            $twilio = new Client(
                env('TWILIO_SID'), 
                env('TWILIO_TOKEN')
            );
            
            $product = Product::find($productId);
            $message = $twilio->messages->create(
                "whatsapp:+91{$user->phone}",
                [
                    "from" => "whatsapp:".env('TWILIO_WHATSAPP_NUMBER'),
                    "body" => "Thank you for pre-booking {$quantity} x {$product->productName} from Vedaro!\n\nWe'll notify you when your item is ready."
                ]
            );
        }
    } catch (\Exception $e) {
        Log::error("Failed to send pre-booking confirmation: " . $e->getMessage());
    }
}

    public function store(Request $request, $product_id)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in to pre-book a product.');
        }

        $request->validate([
            'quantity' => 'required|integer|min:1',
            'note'     => 'nullable|string|max:1000',
        ]);

        try {
            PreBooking::create([
                'user_id'    => $user->id,
                'product_id' => $product_id,
                'quantity'   => $request->input('quantity'),
                'email'      => $user->email,
                'phone'      => $user->phone ?? null,
                'note'       => $request->input('note'),
            ]);

            // Send confirmation to user if phone exists
            if ($user->phone) {
                $this->sendPrebookingConfirmation($user, $product_id, $request->input('quantity'));
            }

            return back()->with('success', 'Product pre-booked successfully! We will notify you when it becomes available.');

        } catch (\Exception $e) {
            Log::error("Pre-booking failed: " . $e->getMessage());
            return back()->with('error', 'Failed to pre-book product. Please try again.');
        }
    }

 

    public function index()
    {
        $preBookings = PreBooking::with(['user', 'product'])
            ->latest()
            ->paginate(20);

        return view('admin.preBooking', compact('preBookings'));
    }
}