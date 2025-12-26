<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('resultats_bureaux', function (Blueprint $table) {
            $table->string('pv_photo')->nullable()->after('suffrage_exprime');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resultats_bureaux', function (Blueprint $table) {
            $table->dropColumn('pv_photo');
        });
    }
};
