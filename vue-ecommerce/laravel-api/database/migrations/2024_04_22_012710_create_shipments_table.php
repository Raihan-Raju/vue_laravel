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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->dateTime('delivery_date');
            $table->string('recipient', 100);
            $table->string('recipient_phone', 25);
            $table->string('address', 255);
            $table->enum('status', ['pending', 'processing', 'shipped', 'route', 'delivered', 'cancelled'])->default('pending');
            $table->unsignedBigInteger('order_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
