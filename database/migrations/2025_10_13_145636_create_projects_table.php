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
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 150);
            $table->string('slug', 150)->unique();
            $table->mediumText('about');
            $table->unsignedBigInteger('user_id')->index('projects_user_id_foreign');
            $table->unsignedBigInteger('stage_id')->nullable()->index('projects_stage_id_foreign');
            $table->text('notes')->nullable();
            $table->string('postponed_reason')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->timestamp('stage_updated_at')->nullable();
            $table->double('health_score')->nullable()->index();
            $table->timestamp('health_score_calculated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
