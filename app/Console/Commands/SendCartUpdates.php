<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\AiSensyService;
use App\Models\User;

class SendCartUpdates extends Command
{
    protected $signature = 'cart:send-updates';
    protected $description = 'Send WhatsApp cart reminders to users with pending carts';

    public function handle(AiSensyService $aiSensy)
    {
        $users = User::whereHas('cart', function ($q) {
            $q->where('updated_at', '>=', now()->subHours(2));
        })->get();

        foreach ($users as $user) {
            $cartItems = $user->cart->items ?? [];
            $count = count($cartItems);
            if ($count === 0) continue;

            $result = $aiSensy->sendCartReminder(
                $user->phone,
                $user->name ?? 'User',
                $count,
                'https://vedaro.in/cart'
            );

            $this->info("Sent to {$user->phone}: " . ($result['message'] ?? ''));
        }

        return 0;
    }
}
