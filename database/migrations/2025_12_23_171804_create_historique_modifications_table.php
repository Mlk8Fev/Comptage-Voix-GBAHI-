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
        Schema::create('historique_modifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bureau_vote_id')->constrained('bureaux_vote')->onDelete('cascade');
            $table->integer('nombre_votants_avant')->nullable();
            $table->integer('nombre_votants_apres');
            $table->integer('bulletins_nuls_avant')->nullable();
            $table->integer('bulletins_nuls_apres');
            $table->integer('bulletins_blancs_avant')->nullable();
            $table->integer('bulletins_blancs_apres');
            $table->integer('suffrage_exprime_avant')->nullable();
            $table->integer('suffrage_exprime_apres');
            $table->json('votes_avant')->nullable(); // Stocke les votes avant modification
            $table->json('votes_apres'); // Stocke les votes après modification
            $table->string('modifie_par')->nullable(); // Peut être un nom d'utilisateur ou IP
            $table->timestamp('date_modification')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historique_modifications');
    }
};
