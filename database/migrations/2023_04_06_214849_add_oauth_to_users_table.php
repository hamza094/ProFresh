<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOAuthToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('oauth_id')->nullable();
            $table->string('oauth_provider')->nullable();
            $table->string('oauth_token')->nullable();
            $table->string('oauth_refresh_token')->nullable();
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
            $table->dropColumn('oauth_id');
            $table->dropColumn('oauth_provider');
            $table->dropColumn('oauth_token');
            $table->dropColumn('oauth_refresh_token');
        });
    }
}
