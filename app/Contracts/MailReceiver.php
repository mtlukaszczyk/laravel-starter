<?php declare(strict_types=1);

namespace App\Contracts;

/**
 * Interface for model objects to which e-mails can be sent (Class Mailable)
 */
interface MailReceiver
{
    public function getEmail(): string;

    public function getId(): int|null;
}
