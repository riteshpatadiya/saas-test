<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Mews\Purifier\Facades\Purifier;


abstract class BaseRequest extends FormRequest
{
    /**
     * Fields that should NOT be sanitized.
     * Child classes may override.
     */
    protected array $excludeSanitize = [];

    protected array $rules = [];

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return $this->rules;
    }

    protected function prepareForValidation(): void
    {
        $data = $this->all();

        $data = $this->sanitizeArray($data);

        $this->replace($data);
    }

    protected function sanitizeArray(array $data, string $parentKey = ''): array
    {
        foreach ($data as $key => $value) {

            $fullKey = $parentKey ? "{$parentKey}.{$key}" : $key;

            if (in_array($fullKey, $this->excludeSanitize, true)) {
                continue;
            }

            if (is_array($value)) {
                $data[$key] = $this->sanitizeArray($value, $fullKey);
            } elseif (is_string($value)) {
                $data[$key] = Purifier::clean($value, 'plain');
            }
        }

        return $data;
    }
}
