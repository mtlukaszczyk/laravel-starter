<?php declare(strict_types=1);

namespace App\Contracts;

use App\Mailables\Mailable;

interface HasMailable
{
    public function getMailable(): Mailable;
}
