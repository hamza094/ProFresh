<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('zoom_access_token', 1000)->nullable();
            $table->string('zoom_refresh_token', 1000)->nullable();
            $table->dateTime('zoom_expires_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
              'zoom_access_token',
              'zoom_refresh_token',
              'zoom_expires_at',
            ]);
        });
    }
};
