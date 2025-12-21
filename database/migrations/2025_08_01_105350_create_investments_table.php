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
        Schema::create('investments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('investor_id');
            $table->decimal('amount', 15, 2);
            $table->date('date');
            $table->enum('payment_method', ['cash', 'bank_transfer', 'mobile_banking', 'cheque', 'other']);
            $table->unsignedBigInteger('collected_by');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('investor_id')->references('id')->on('users')->onDelete('cascade');
            $table->index('date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investments');
    }
};
