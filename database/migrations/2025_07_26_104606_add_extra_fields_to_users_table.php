<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable();
            $table->string('nid_no')->nullable();
            $table->string('nid_file')->nullable();
            $table->text('address')->nullable();
            $table->string('password')->nullable()->change(); // Make password nullable
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'nid_no', 'nid_file', 'address']);
            $table->string('password')->nullable(false)->change(); // Revert password to NOT NULL
        });
    }
};
