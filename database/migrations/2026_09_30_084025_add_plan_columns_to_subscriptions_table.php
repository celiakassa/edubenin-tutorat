<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('subscriptions', function (Blueprint $table): void {
            $table->string('plan')->default('standard')->after('user_id');
            $table->boolean('auto_renew')->default(true)->after('statut');
            $table->timestamp('reminder_sent_at')->nullable()->after('renouvel_at');
        });
    }

    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table): void {
            $table->dropColumn(['plan', 'auto_renew', 'reminder_sent_at']);
        });
    }
};
