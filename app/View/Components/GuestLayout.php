<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class GuestLayout extends Component
{
    public function __construct(
        public string $heroTitle = 'Welcome',
        public string $heroDescription = '',
        public string $cardLabel = 'Guest Access',
        public string $cardTitle = 'Continue',
    ) {}

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.guest');
    }
}
