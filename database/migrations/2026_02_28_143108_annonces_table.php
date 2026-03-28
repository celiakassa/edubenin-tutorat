<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('annonces', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->string('domaine');
            $table->text('description');

            $table->decimal('budget', 15, 2);
            $table->decimal('acompte', 15, 2);

            $table->string('status')->default('en_attente');

            $table->text('disponibilite')->nullable();
            $table->enum('format', ['presentiel', 'en_ligne', 'hybrid'])->default('presentiel');
            $table->boolean('is_paid')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->string('payment_reference')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('student_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('annonces');
    }
};
