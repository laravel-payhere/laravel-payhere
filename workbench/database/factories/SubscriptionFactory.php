<?php

declare(strict_types=1);

namespace Workbench\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use LaravelPayHere\Enums\SubscriptionStatus;
use LaravelPayHere\Models\Subscription;
use Workbench\App\Models\Order;
use Workbench\App\Models\User;

class SubscriptionFactory extends Factory
{
    protected $model = Subscription::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'order_id' => Order::factory(),
            'trial_ends_at' => now()->addMonth(),
            'ends_at' => now()->addYear(),
            'status' => SubscriptionStatus::Active,
        ];
    }
}
