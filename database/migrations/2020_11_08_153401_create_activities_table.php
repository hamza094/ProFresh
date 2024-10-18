<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
           $table->id();
           $table->integer('user_id');
           $table->unsignedInteger('project_id')->nullable();
           $table->nullableMorphs('subject');
           $table->boolean('is_hidden')->default(false);
           $table->text('changes')->nullable();
           $table->string('description');
           $table->string('info')->nullable();
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
        Schema::dropIfExists('activities');
    }
}
