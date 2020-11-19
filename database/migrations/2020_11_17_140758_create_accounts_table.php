<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('contact_id')->nullable();
            $table->integer('lead_id')->nullable();
            $table->string('country');
            $table->string('address');
            $table->bigInteger('zipcode')->nullable();
            $table->bigInteger('employee')->nullable();
            $table->string('website')->nullable();
            $table->string('number');
            $table->string('industry');
            $table->string('revenue')->nullable();
            $table->string('business');
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
        Schema::dropIfExists('accounts');
    }
}
