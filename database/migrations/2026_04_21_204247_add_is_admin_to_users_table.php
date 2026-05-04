<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        // This adds a new column 'is_admin' to your users table.
        // We set it to 'false' by default so regular users aren't admins.
        $table->boolean('is_admin')->default(false);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('users', function (Blueprint $table) {
        // This removes the column if we rollback the migration
        $table->dropColumn('is_admin');
    });
}
};
