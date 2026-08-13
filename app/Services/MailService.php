<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;

class MailService
{
    public function send(
        string $to,
        object $mailable,
        ?string $name = null
    ): void {
        $recipient = $name
            ? ['email' => $to, 'name' => $name]
            : $to;

        Mail::to($recipient)->send($mailable);
    }
}
