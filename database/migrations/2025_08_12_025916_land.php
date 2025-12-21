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
        Schema::create('lands', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('land_location');
            $table->string('dolil_no');
            $table->string('dag_no');
            $table->decimal('buying_price', 15, 2);
            $table->decimal('paid_amount', 15, 2);
            $table->decimal('others_cost', 15, 2);
            $table->decimal('total_buying_cost', 15, 2);
            $table->decimal('selling_price', 15, 2);
            $table->decimal('collected_amount', 15, 2);
            $table->enum('purchase_status', [
                'in-progress',
                'completed',
                'cancelled',
            ]);
            $table->enum('sale_status', [
                'in-progress',
                'completed',
                'cancelled',
            ])->nullable();;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
