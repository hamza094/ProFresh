<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->index('due_at');
            // If you use completed_at, add index (uncomment if column exists)
            // $table->index('completed_at');
            $table->index(['project_id', 'status_id', 'due_at']);
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropIndex(['due_at']);
            // If you use completed_at, drop index (uncomment if column exists)
            // $table->dropIndex(['completed_at']);
            $table->dropIndex(['project_id', 'status_id', 'due_at']);
        });
    }
};
