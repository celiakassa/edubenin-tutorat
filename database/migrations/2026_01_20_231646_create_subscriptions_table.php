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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('type_abonnement'); // 'mensuel', 'trimestriel', 'annuel'
            $table->date('date_debut');
            $table->date('date_fin');
            $table->string('statut')->default('pending'); // pending, active, expired, cancelled
            $table->timestamp('renouvel_at')->nullable(); // Date du prochain renouvellement
            $table->timestamps();

            // Index pour améliorer les performances
            $table->index('user_id');
            $table->index('statut');
            $table->index(['date_fin', 'statut']); // Pour trouver les abonnements expirants
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
