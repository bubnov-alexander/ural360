<?php

namespace App\Containers\AppSection\Callback\UI\WEB\Requests;

use App\Ship\Parents\Requests\Request as ParentRequest;

final class StoreCallbackRequestRequest extends ParentRequest
{
    protected array $decode = [];

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string', 'min:2', 'max:255'],
            'phone' => ['required', 'string', 'min:5', 'max:50'],
            'comment' => ['nullable', 'string', 'max:2000'],
            'page_url' => ['nullable', 'string', 'max:2048'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array{name: string|null, phone: string, comment: string|null, page_url: string|null}
     */
    public function callbackData(): array
    {
        return [
            'name' => $this->stringOrNull('name'),
            'phone' => (string)$this->input('phone'),
            'comment' => $this->stringOrNull('comment'),
            'page_url' => $this->stringOrNull('page_url'),
        ];
    }

    private function stringOrNull(string $key): ?string
    {
        $value = trim((string)$this->input($key));

        return $value !== '' ? $value : null;
    }
}
