<?php declare(strict_types=1);

namespace App\Exceptions;

use App\Contracts\MailReceiver;
use App\Mailables\Mailable;

class MailException extends \Exception
{
    public function __construct(
        public Mailable     $mailable,
        public MailReceiver $recipient,
        public string       $newMessage
    ) {
        parent::__construct('MailException: ' . $this->newMessage . ' (' . $this->mailable::class . ')');
    }
}
