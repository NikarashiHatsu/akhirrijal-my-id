<?php

use App\Models\Series;
use App\Models\User;

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

it('lets an authenticated user reach the Series resource index page', function () {
    Series::factory()->count(2)->create();

    $this->get('/admin/series')->assertSuccessful();
});

it('lets an authenticated user reach the Series resource create page', function () {
    $this->get('/admin/series/create')->assertSuccessful();
});

it('lets an authenticated user reach the Series resource edit page', function () {
    $series = Series::factory()->create();

    $this->get("/admin/series/{$series->getKey()}/edit")->assertSuccessful();
});
