<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string("name",150);
            $table->string("slug",150);
            $table->mediumText("about");
            $table->foreignId('user_id')->constrained()
                  ->onDelete('cascade');
            $table->foreignId('stage_id');
            $table->boolean('completed')->default(false);
            $table->text('notes')->nullable();
            $table->string('postponed')->nullable();
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
        Schema::dropIfExists('projects');
    }
}
