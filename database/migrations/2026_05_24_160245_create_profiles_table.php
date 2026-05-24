<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('alternate_name')->nullable();
            $table->string('monogram')->nullable();
            $table->string('job_title');
            $table->string('tagline')->nullable();
            $table->string('specializations')->nullable();

            $table->longText('bio')->nullable();
            $table->text('statement')->nullable();

            $table->string('location_city')->nullable();
            $table->string('location_country')->nullable();
            $table->string('availability_status')->nullable();

            $table->string('email')->nullable();
            $table->string('whatsapp_e164')->nullable();
            $table->string('whatsapp_display')->nullable();
            $table->string('instagram_handle')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('website_url')->nullable();

            $table->string('hero_image_path')->nullable();
            $table->string('hero_image_alt')->nullable();
            $table->string('about_portrait_image_path')->nullable();
            $table->string('about_portrait_image_alt')->nullable();
            $table->string('about_subhero_image_path')->nullable();
            $table->string('about_subhero_image_alt')->nullable();
            $table->string('portfolio_subhero_image_path')->nullable();
            $table->string('portfolio_subhero_image_alt')->nullable();
            $table->string('contact_subhero_image_path')->nullable();
            $table->string('contact_subhero_image_alt')->nullable();

            $table->string('crafted_in_label')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
