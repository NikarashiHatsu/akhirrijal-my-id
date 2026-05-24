<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Experience;
use Illuminate\Contracts\View\View;

class AboutController extends Controller
{
    public function __invoke(): View
    {
        return view('about', [
            'experiences' => Experience::query()->ordered()->get(),
            'equipment' => Equipment::query()->ordered()->get(),
        ]);
    }
}
