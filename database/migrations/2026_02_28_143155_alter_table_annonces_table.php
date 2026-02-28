<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('annonces', function (Blueprint $table) {
            // Renommer la colonne domaine en subject_id et changer le type
            $table->renameColumn('domaine', 'subject_id');
        });

        // Modifier le type de la colonne (MySQL)
        Schema::table('annonces', function (Blueprint $table) {
            $table->unsignedBigInteger('subject_id')->change();
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('restrict');
        });
    }

    public function down()
    {
        Schema::table('annonces', function (Blueprint $table) {
            $table->dropForeign(['subject_id']);
            $table->renameColumn('subject_id', 'domaine');
            $table->string('domaine')->change();
        });
    }
};
