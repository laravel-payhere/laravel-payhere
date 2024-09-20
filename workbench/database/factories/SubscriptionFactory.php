<?php

declare(strict_types=1);

namespace Workbench\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use PayHere\Enums\SubscriptionStatus;
use PayHere\Models\Subscription;
use Workbench\App\Models\User;

class SubscriptionFactory extends Factory
{
    protected $model = Subscription::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'order_id' => rand(),
            'trial_ends_at' => now()->addMonth(),
            'ends_at' => now()->addYear(),
            'status' => SubscriptionStatus::Active,
        ];
    }
}
