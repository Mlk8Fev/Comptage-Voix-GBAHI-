<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bureaux_vote', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lieu_vote_id')->constrained('lieux_vote')->onDelete('cascade');
            $table->string('numero');
            $table->integer('hommes_inscrits')->default(0);
            $table->integer('femmes_inscrits')->default(0);
            $table->boolean('est_ouvert')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bureaux_vote');
    }
};

