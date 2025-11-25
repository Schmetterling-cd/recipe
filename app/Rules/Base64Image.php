<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Base64Image implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Проверяем формат data:image/...
        if (preg_match('/^data:image\/(\w+);base64,/', $value, $matches)) {
            $type = strtolower($matches[1]);

            // Проверяем поддерживаемые форматы
            if (!in_array($type, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                $fail('Current file is not an image.');
            }
        }
    }
}


namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Base64Image1 implements Rule
{
    public function passes($attribute, $value)
    {
        // Проверяем, что это base64 изображение
        if (!is_string($value)) {
            return false;
        }

        // Проверяем формат data:image/...
        if (preg_match('/^data:image\/(\w+);base64,/', $value, $matches)) {
            $type = strtolower($matches[1]);

            // Проверяем поддерживаемые форматы
            return in_array($type, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
        }

        return false;
    }

    public function message()
    {
        return 'Некорректный формат изображения. Допустимы: JPG, PNG, GIF, WebP.';
    }
}
