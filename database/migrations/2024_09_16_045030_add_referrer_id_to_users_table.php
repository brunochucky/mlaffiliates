<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReferrerIdToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Adding the referrer_id column
            $table->unsignedBigInteger('referrer_id')->nullable()->after('id');

            // Setting up the foreign key constraint
            $table->foreign('referrer_id')->references('id')->on('users')->onDelete('set null');
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
            // Dropping the foreign key and the column
            $table->dropForeign(['referrer_id']);
            $table->dropColumn('referrer_id');
        });
    }
}
