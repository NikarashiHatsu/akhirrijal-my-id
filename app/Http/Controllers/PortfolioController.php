<?php

namespace App\Http\Controllers;

use App\Models\Series;
use Illuminate\Contracts\View\View;

class PortfolioController extends Controller
{
    public function __invoke(): View
    {
        return view('portfolio.index', [
            'series' => Series::query()->ordered()->limit(4)->get(),
        ]);
    }
}
