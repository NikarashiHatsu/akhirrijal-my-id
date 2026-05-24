<?php

namespace App\Http\Controllers;

use App\Models\Series;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('home', [
            'featuredSeries' => Series::query()->ordered()->limit(4)->get(),
        ]);
    }
}
