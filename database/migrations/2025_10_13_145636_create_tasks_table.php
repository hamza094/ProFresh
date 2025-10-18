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
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable()->index('tasks_user_id_foreign');
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('status_id')->nullable()->index('tasks_status_id_foreign');
            $table->string('title', 55);
            $table->tinyText('description')->nullable();
            $table->dateTime('due_at')->nullable()->index();
            $table->string('notified')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->boolean('notify_sent')->default(false);

            $table->index(['project_id', 'status_id', 'due_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
