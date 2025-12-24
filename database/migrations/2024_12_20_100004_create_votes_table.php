<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bureau_vote_id')->constrained('bureaux_vote')->onDelete('cascade');
            $table->foreignId('candidat_id')->constrained('candidats')->onDelete('cascade');
            $table->integer('nombre_voix')->default(0);
            $table->timestamps();
            
            $table->unique(['bureau_vote_id', 'candidat_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};

