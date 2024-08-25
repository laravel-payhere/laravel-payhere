<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payhere_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->enum('status', [
                'on_hold',
                'pending',
                'processing',
                'shipped',
                'delivered',
                'completed',
                'refunded',
                'cancelled',
            ])->default('on_hold');
            $table->float('total');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payhere_orders');
    }
};