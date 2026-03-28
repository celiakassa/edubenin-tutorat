<?php

declare(strict_types=1);

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
        Schema::create('candidatures', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('annonce_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Professeur
            $table->string('statut')->default('en_attente'); // en_attente, acceptee, refusee
            $table->timestamps();

            // Index pour performances
            $table->index('annonce_id');
            $table->index('user_id');
            $table->index('statut');

            // Empêcher un prof de postuler deux fois à la même annonce
            $table->unique(['annonce_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidatures');
    }
};
