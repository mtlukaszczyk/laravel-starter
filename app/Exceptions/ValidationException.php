<?php declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\MessageBag;
use Symfony\Component\HttpFoundation\Response;

class ValidationException extends HttpResponseException
{
    /**
     * @param array<string, array<string>>|MessageBag $errors
     */
    public static function from(array|MessageBag $errors): self
    {
        return new self(response()->json([
            'errors' => $errors
        ], Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
