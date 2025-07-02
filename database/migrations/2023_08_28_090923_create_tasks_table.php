<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                 ->nullable()
                  ->constrained()
                  ->nullOnDelete();

            $table->foreignId('project_id')->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('status_id')->nullable()
                   ->constrained()
                   ->nullOnDelete();

            $table->string('title',55);
            $table->tinyText('description')
                  ->nullable();
            $table->dateTime('due_at')->nullable();
            $table->string('notified')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
