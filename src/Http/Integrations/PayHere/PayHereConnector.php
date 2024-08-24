<?php

namespace LaravelPayHere\Http\Integrations\PayHere;

use Saloon\Helpers\OAuth2\OAuthConfig;
use Saloon\Http\Auth\BasicAuthenticator;
use Saloon\Http\Connector;
use Saloon\Traits\OAuth2\ClientCredentialsGrant;

class PayHereConnector extends Connector
{
    use ClientCredentialsGrant;

    private string $clientId;

    private string $clientSecret;

    public function __construct()
    {
        $this->clientId = config('payhere.app_id');
        $this->clientSecret = config('payhere.app_secret');
    }

    public function resolveBaseUrl(): string
    {
        return config('payhere.base_url');
    }

    protected function defaultOauthConfig()
    {
        return OAuthConfig::make()
            ->setClientId($this->clientId)
            ->setClientSecret($this->clientSecret)
            ->setTokenEndpoint('/merchant/v1/oauth/token');
    }

    protected function defaultAuth(): BasicAuthenticator
    {
        return new BasicAuthenticator(
            username: $this->clientId,
            password: $this->clientSecret
        );
    }
}
