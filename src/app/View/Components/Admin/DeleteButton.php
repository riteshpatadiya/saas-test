<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class DeleteButton extends Component
{
    public string $action;
    public string $message;

    public function __construct(
        string $action,
        string $message = 'Are you sure you want to delete this record?'
    ) {
        $this->action = $action;
        $this->message = $message;
    }

    public function render()
    {
        return view('components.admin.delete-button');
    }
}