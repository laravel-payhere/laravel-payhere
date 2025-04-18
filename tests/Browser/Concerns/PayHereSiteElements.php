<?php

declare(strict_types=1);

namespace PayHere\Tests\Browser\Concerns;

trait PayHereSiteElements
{
    public static function siteElements(): array
    {
        return [
            '@visa' => 'div#payment_container_VISA',
            '@payment-frame' => 'iframe#pg_iframe',
            '@card-holder-name' => "input[name='cardHolderName']",
            '@card-no' => "input[name='cardNo']",
            '@card-secure-id' => "input[name='cardSecureId']",
            '@card-expiry-date' => "input[name='cardExpiry']",
            '@pay' => "button[type='submit'].btn-primary",
            '@iframe' => '#ph-iframe',
        ];
    }
}
