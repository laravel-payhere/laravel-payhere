<?php

use Dasundev\PayHere\Enums\SubscriptionStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('order_id');
            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->enum('status', [
                SubscriptionStatus::PENDING->name,
                SubscriptionStatus::ACTIVE->name,
                SubscriptionStatus::FAILED->name,
                SubscriptionStatus::COMPLETED->name,
            ])->default(SubscriptionStatus::PENDING->name)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};