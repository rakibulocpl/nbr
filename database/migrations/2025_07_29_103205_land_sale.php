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
        Schema::create('land_sales', function (Blueprint $table) {
            $table->id();
            $table->string('land_purchase_id'); // FK, could be foreignId if needed
            $table->string('buyer_name', 255);
            $table->string('mobile', 20);
            $table->text('address');
            $table->string('nid_no', 30);
            $table->string('nid_file')->nullable(); // store filename/path
            $table->decimal('selling_price', 12, 2)->unsigned();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('land_buyers');
    }
};
