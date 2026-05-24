<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('photos', function (Blueprint $table) {
            $table->string('original_path')->nullable()->after('disk');
            $table->string('original_disk')->default('local')->after('original_path');
            $table->json('variants')->nullable()->after('original_disk');
        });
    }

    public function down(): void
    {
        Schema::table('photos', function (Blueprint $table) {
            $table->dropColumn(['original_path', 'original_disk', 'variants']);
        });
    }
};
