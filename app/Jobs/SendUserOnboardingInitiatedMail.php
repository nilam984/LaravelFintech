<?php

namespace App\Jobs;

use App\Mail\UserOnboardingInitiated;
use App\Models\SetupCostOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendUserOnboardingInitiatedMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public function __construct(
        public int $orderId
    ) {}

    public function handle(): void
    {
        $order = SetupCostOrder::find($this->orderId);

        if (!$order) {
            Log::warning('Onboarding email skipped: order not found.', [
                'order_id' => $this->orderId,
            ]);
            return;
        }

        if ($order->status !== 'success') {
            Log::warning('Onboarding email skipped: order is not paid.', [
                'order_id' => $order->id,
                'status' => $order->status,
            ]);
            return;
        }

        if (!$order->email) {
            Log::warning('Onboarding email skipped: email not found.', [
                'order_id' => $order->id,
            ]);
            return;
        }

        if (!$order->mobile) {
            Log::warning('Onboarding email skipped: mobile not found.', [
                'order_id' => $order->id,
            ]);
            return;
        }

        Log::info('Sending onboarding email.', [
            'order_id' => $order->id,
            'email' => $order->email,
        ]);

        Mail::to($order->email)
            ->send(new UserOnboardingInitiated($order));

        Log::info('Onboarding email sent successfully.', [
            'order_id' => $order->id,
            'email' => $order->email,
        ]);
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('User onboarding email job failed.', [
            'order_id' => $this->orderId,
            'error' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
        ]);
    }
}
