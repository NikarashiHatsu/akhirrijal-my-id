<?php

namespace App\Models;

use Database\Factories\SeriesFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Series extends Model
{
    /** @use HasFactory<SeriesFactory> */
    use HasFactory;

    protected $table = 'series';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }

    /** @return HasMany<Photo, $this> */
    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class)->orderBy('sort_order')->orderBy('id');
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    public function nextSeries(): self
    {
        return static::query()
            ->where('sort_order', '>', $this->sort_order)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->first()
            ?? static::query()->ordered()->firstOrFail();
    }

    public function previousSeries(): self
    {
        return static::query()
            ->where('sort_order', '<', $this->sort_order)
            ->orderByDesc('sort_order')
            ->orderByDesc('id')
            ->first()
            ?? static::query()->orderByDesc('sort_order')->orderByDesc('id')->firstOrFail();
    }
}
