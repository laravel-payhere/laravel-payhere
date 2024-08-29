<?php

declare(strict_types=1);

namespace Workbench\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use PayHere\Enums\MessageType;
use PayHere\Enums\PaymentMethod;
use PayHere\Enums\PaymentStatus;
use PayHere\Models\Payment;
use Workbench\App\Models\Order;
use Workbench\App\Models\User;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'merchant_id' => fake()->unique()->randomNumber(),
            'order_id' => Order::factory(),
            'payment_id' => fake()->unique()->randomNumber(),
            'authorization_token' => fake()->uuid,
            'subscription_id' => fake()->unique()->randomNumber(),
            'payhere_amount' => fake()->randomFloat(2, 10, 1000),
            'captured_amount' => fake()->randomFloat(2, 10, 1000),
            'payhere_currency' => fake()->currencyCode,
            'status_code' => collect(PaymentStatus::cases())->shuffle()->first(),
            'md5sig' => fake()->md5,
            'status_message' => fake()->sentence,
            'method' => collect(PaymentMethod::cases())->shuffle()->first(),
            'card_holder_name' => fake()->name,
            'card_no' => fake()->creditCardNumber,
            'card_expiry' => fake()->creditCardExpirationDateString,
            'recurring' => fake()->boolean,
            'message_type' => collect(MessageType::cases())->shuffle()->first(),
            'item_recurrence' => fake()->word,
            'item_duration' => fake()->word,
            'item_rec_status' => collect([0, -1, 1])->first(),
            'item_rec_date_next' => fake()->date,
            'item_rec_install_paid' => fake()->randomNumber(),
            'customer_token' => fake()->uuid,
            'custom_1' => fake()->word,
            'custom_2' => fake()->word,
        ];
    }
}
