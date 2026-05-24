<?php

namespace App\Http\Controllers;

use App\Models\Series;
use Illuminate\Contracts\View\View;

class SeriesController extends Controller
{
    public function __invoke(Series $series): View
    {
        $series->load(['photos']);

        return view('portfolio.show', [
            'series' => $series,
            'photos' => $series->photos,
            'next' => $series->nextSeries(),
            'previous' => $series->previousSeries(),
        ]);
    }
}
