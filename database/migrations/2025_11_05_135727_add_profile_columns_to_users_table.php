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
        Schema::table('users', function (Blueprint $table) {
            // Colonnes pour les tuteurs
            $table->text('bio')->nullable();
            $table->string('qualifications')->nullable(); //
            $table->text('subjects')->nullable();// matiere
            $table->decimal('rate_per_hour', 10, 2)->nullable(); // tarif en FCFA/heure
            $table->json('availability')->nullable(); // calendrier dispo
            $table->string('city')->nullable(); // Cotonou, Porto-Novo

            // Colonnes pour les étudiants
           $table->text('learning_history')->nullable();

            $table->string('learning_preference')->nullable() ;//use Enum cast in pho;
            $table->decimal('satisfaction_score', 3, 2)->nullable(); // note de satisfaction sur 5.0

            // Notifications
            $table->boolean('notify_email')->default(true);
            $table->boolean('notify_push')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'bio',
                'qualifications',
                'subjects',
                'rate_per_hour',
                'city',
                'learning_history',
                'learning_preference',
                'satisfaction_score',
                'notify_email',
                'notify_push',
            ]);
        });
    }
};
