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
        Schema::table('payments', function (Blueprint $table) {
            if (! Schema::hasColumn('payments', 'moneroo_payment_id')) {
                $table->string('moneroo_payment_id')->nullable()->unique();
                $table->index('moneroo_payment_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            if (Schema::hasColumn('payments', 'moneroo_payment_id')) {
                $table->dropUnique(['moneroo_payment_id']);
                $table->dropIndex(['moneroo_payment_id']);
                $table->dropColumn('moneroo_payment_id');
            }
        });
    }
};
