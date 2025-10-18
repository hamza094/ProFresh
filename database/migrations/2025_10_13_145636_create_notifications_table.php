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
        Schema::create('notifications', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->string('type');
            $table->string('notifiable_type');
            $table->char('notifiable_id', 36);
            $table->text('data');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            $table->string('signature', 64)->nullable();

            $table->index(['notifiable_type', 'notifiable_id']);
            $table->unique(['type', 'notifiable_id', 'signature']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
