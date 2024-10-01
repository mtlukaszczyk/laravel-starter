<?php declare(strict_types=1);

namespace App\Events\Mail;

use App\Contracts\HasMailable;
use App\Contracts\MailReceiver;
use App\Mailables\Mailable;

class Sent implements HasMailable
{
    public function __construct(
        public Mailable $mailable,
        public MailReceiver $recipient
    ) {
    }

    #[\Override]
    public function getMailable(): Mailable
    {
        return $this->mailable;
    }
}
