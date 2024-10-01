<?php declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Http\Exceptions\HttpResponseException;

class PlaceholderException extends HttpResponseException
{
    public static function from(string $placeholder): self
    {
        return new self(response(
            base64_decode($placeholder),
            200,
            ['Content-Type' => 'image/png']
        ));
    }
}
