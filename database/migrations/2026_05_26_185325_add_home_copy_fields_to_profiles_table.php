<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->text('hero_lead')->nullable()->after('specializations');
            $table->string('home_about_heading')->nullable()->after('hero_lead');
            $table->string('home_selected_work_heading')->nullable()->after('home_about_heading');
        });
    }

    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn([
                'hero_lead',
                'home_about_heading',
                'home_selected_work_heading',
            ]);
        });
    }
};
