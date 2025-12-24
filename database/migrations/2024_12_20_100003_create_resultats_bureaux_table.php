<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resultats_bureaux', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bureau_vote_id')->constrained('bureaux_vote')->onDelete('cascade')->unique();
            $table->integer('nombre_votants')->default(0);
            $table->integer('bulletins_nuls')->default(0);
            $table->integer('bulletins_blancs')->default(0);
            $table->integer('suffrage_exprime')->default(0);
            $table->timestamp('derniere_mise_a_jour')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resultats_bureaux');
    }
};

