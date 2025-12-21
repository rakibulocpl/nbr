<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('land_purchases', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('seller_name');
            $table->string('mobile', 20);
            $table->text('address');
            $table->text('land_location');
            $table->string('nid_no');
            $table->string('nid_file')->nullable(); // stores file path
            $table->string('dolil_no');
            $table->string('dag_no');
            $table->decimal('buying_price', 15, 2); // large enough for high-value land
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('land_purchases');
    }
};
