<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('identity_document_path')->nullable()->after('rate_per_hour');
            $table->boolean('identity_verified')->default(false)->after('identity_document_path');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['identity_document_path', 'identity_verified']);
        });
    }
};
