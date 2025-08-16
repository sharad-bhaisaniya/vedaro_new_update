<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\AiSensyService;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SendAbandonedCartReminders extends Command
{
    protected $signature = 'cart:send-reminders';
    protected $description = 'Send WhatsApp reminders via AiSensy for carts abandoned for more than 2 days';

    public function handle(AiSensyService $aiSensy)
    {
        $cutoff = now()->subDays(2); // Use subDays(2) in production

        $abandonedCarts = Cart::where('updated_at', '<', $cutoff)
            ->where('reminder_sent', 0)
            ->get();

        if ($abandonedCarts->isEmpty()) {
            Log::info("🟡 No abandoned carts found at " . now());
            $this->warn('🟡 No abandoned carts found.');
            return;
        }

        // Group by customer
        $cartsGrouped = $abandonedCarts->groupBy('customer_id');

        foreach ($cartsGrouped as $customerId => $carts) {
            $user = User::find($customerId);
            if (!$user) continue;

            $itemCount = $carts->sum('product_qty');

            if ($itemCount > 0) {
                $phone = $user->phone;
                $name = $user->first_name ?? $user->name ?? 'User';

                $result = $aiSensy->sendCartReminder($phone, $name, $itemCount);

                Log::info("🛒 Sent cart reminder to {$phone} — Items: {$itemCount} — Status: " . ($result['success'] ? '✅' : '❌'));

                // Mark all cart rows as reminder sent
                foreach ($carts as $cart) {
                    $cart->reminder_sent = 1;
                    $cart->save();
                }
            }
        }

        $this->info('✅ Abandoned cart reminders sent.');
    }
}
