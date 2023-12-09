<?php

namespace App\Jobs\StripeWebhooks;

use App\Models\Payment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Spatie\WebhookClient\Models\WebhookCall;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Support\Facades\Cache;

class ChargeSucceededJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var \Spatie\WebhookClient\Models\WebhookCall */
    public $webhookCall;

    public function __construct(WebhookCall $webhookCall)
    {
        $this->webhookCall = $webhookCall;
    }

    public function handle()
    {
        Log::info("ChargeSucceededJob started");
        $stripeSessionId = $this->webhookCall->payload['data']['object']['id'];

        // Find the payment associated with this Stripe session ID
        $payment = Payment::where('stripe_session_id', $stripeSessionId)->first();
    
        if ($payment) {
            // Update the payment record with the charge details and generate a passcode
            $payment->update([
                'stripe_id' => $stripeSessionId, // Assuming you want to store the Stripe session ID
                'passcode' => Str::uuid()->toString(), // Generate a unique passcode
                'status' => 'completed' // Update the status to completed
            ]);
            Log::info("Payment updated", ['payment' => $payment]);
        } else {
            Log::error("Payment not found for Stripe session", ['stripe_session_id' => $stripeSessionId]);
        }
    
        Log::info("ChargeSucceededWebhook completed");
    }
}
