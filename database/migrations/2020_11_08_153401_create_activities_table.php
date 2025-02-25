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
           $table->foreignId('user_id')->nullOnDelete();
           $table->unsignedInteger('project_id')->nullable()->constrained()->cascadeOnDelete();
           $table->nullableMorphs('subject');
           $table->boolean('is_hidden')->default(false);
           $table->json('changes')->nullable();
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
