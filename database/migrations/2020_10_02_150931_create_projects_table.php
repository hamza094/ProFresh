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
            $table->string("name");
            $table->string("slug");
            $table->text("about");
            $table->foreignUuid('user_id')->constrained()->onDelete('cascade');
            $table->integer('company_id')->nullable();
            $table->unsignedInteger('group_id')->nullable();
            $table->text('notes')->nullable();
            $table->enum('stage',['initial','define','design','develop','execute','close'])
            ->default('initial');
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
