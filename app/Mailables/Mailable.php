<?php declare(strict_types=1);

namespace App\Mailables;

abstract class Mailable extends \Illuminate\Mail\Mailable
{
    /**
     * @param array<string, mixed>|null $parameters
     * @return array<string, mixed>
     */
    public function getParameters(array|null $parameters = null): array
    {
        if (is_null($parameters)) {
            return config()->array('mail.params');
        }
        return array_merge($parameters, config()->array('mail.params'));
    }
}
