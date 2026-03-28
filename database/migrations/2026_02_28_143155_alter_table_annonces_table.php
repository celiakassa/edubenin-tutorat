<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('annonces', function (Blueprint $table): void {
            // Renommer la colonne domaine en subject_id et changer le type
            $table->renameColumn('domaine', 'subject_id');
        });

        // Modifier le type de la colonne (MySQL)
        Schema::table('annonces', function (Blueprint $table): void {
            $table->unsignedBigInteger('subject_id')->change();
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::table('annonces', function (Blueprint $table): void {
            $table->dropForeign(['subject_id']);
            $table->renameColumn('subject_id', 'domaine');
            $table->string('domaine')->change();
        });
    }
};
