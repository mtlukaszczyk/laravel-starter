<?php declare(strict_types=1);

namespace App\Http\Requests;

use App\Exceptions\ValidationException;
use Illuminate\Foundation\Http\FormRequest as FormRequestOriginal;
use Illuminate\Contracts\Validation\Validator;

abstract class FormRequest extends FormRequestOriginal
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [];
    }

    #[\Override]
    protected function failedValidation(Validator $validator): void
    {
        $errors = $validator->errors();

        throw ValidationException::from($errors);
    }
}
