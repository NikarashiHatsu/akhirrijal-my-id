<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class ContactShowController extends Controller
{
    public function __invoke(): View
    {
        return view('contact');
    }
}
