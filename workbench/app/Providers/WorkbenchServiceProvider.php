<?php

namespace Workbench\App\Providers;

use Dasundev\PayHere\PayHere;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Workbench\App\Models\Order;
use Workbench\App\Models\User;

class WorkbenchServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Config::set('auth.providers.users.model', User::class);

        PayHere::useCustomerModel(User::class);
        PayHere::useOrderModel(Order::class);
    }
}
