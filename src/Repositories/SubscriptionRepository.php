<?php

namespace Dasundev\PayHere\Repositories;

use Dasundev\PayHere\Enums\SubscriptionStatus;
use Dasundev\PayHere\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionRepository
{
    /**
     * Activate a subscription for the given user.
     */
    public function activateSubscription($user, Request $request): Subscription
    {
        $subscriptionId = $request->custom_1;

        $subscription = Subscription::find($subscriptionId);

        $subscription->update([
            'user_id' => $user->id,
            'ends_at' => $request->item_duration,
            'status' => SubscriptionStatus::ACTIVE,
        ]);

        $subscription->refresh();

        return $subscription;
    }
}
