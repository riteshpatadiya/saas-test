<?php

namespace App\Http\Requests\Admin\StoreUsers;

use Illuminate\Validation\Rule;

class UpdateRequest extends StoreRequest
{
    protected function prepareForValidation(): void
    {
        parent::prepareForValidation();

        $userId = $this->route('user')->id;

        $this->rules['email']['unique'] = Rule::unique('users')->ignore($userId);
        $this->rules['password']['required'] = 'nullable';
    }
}

