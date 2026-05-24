<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('series_id')->index();
            $table->unsignedInteger('sort_order')->default(0)->index();

            $table->string('image_path');
            $table->string('disk')->default('public');
            $table->unsignedInteger('width')->nullable();
            $table->unsignedInteger('height')->nullable();

            $table->string('alt')->nullable();
            $table->string('title');
            $table->longText('story')->nullable();
            $table->string('location')->nullable();
            $table->string('date_label')->nullable();
            $table->date('taken_at')->nullable();
            $table->string('ratio')->default('landscape');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('photos');
    }
};
