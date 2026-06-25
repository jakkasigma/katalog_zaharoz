<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DeleteConfirm extends Component
{
    public function __construct(
        public string $action,
        public string $message = 'Apakah Anda yakin ingin menghapus item ini? Tindakan ini tidak dapat dibatalkan.',
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.delete-confirm');
    }
}
