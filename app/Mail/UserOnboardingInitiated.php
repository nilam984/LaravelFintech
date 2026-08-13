<?php

namespace App\Mail;

use App\Models\SetupCostOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserOnboardingInitiated extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public SetupCostOrder $order
    ) {}

    public function build()
    {
        return $this
            ->subject('Your onboarding has been initiated')
            ->view('emails.user-onboarding-initiated');
    }
}
