<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Recaptcha extends Component
{
    public $clientKey;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->clientKey = env('GOOGLE_RECAPTCHA_SITE_KEY');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.recaptcha');
    }
}
