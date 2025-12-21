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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->decimal('amount', 12, 2);
            $table->enum('type', [
                'invest',
                'withdraw',
                'land_buy',
                'installment_buy',
                'land_sale',
                'installment_sale',
            ]);
            $table->enum('in_out', ['in', 'out'])->comment('in = money coming in, out = money going out');
            $table->string('reference_type', 50)->nullable()->comment('e.g. Investor, LandPurchase, LandSale');
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->string('payment_method', 20)->nullable()->comment('cash, bank, mobile_bank, etc.');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
