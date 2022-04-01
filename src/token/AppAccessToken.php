<?php

namespace EasyFeishu\token;

use EasyFeishu\token\AccessToken as BaseAccessToken;

class AppAccessToken extends BaseAccessToken
{

    /**
     * @var string
     */
    protected $endpointToGetToken = "/open-apis/auth/v3/app_access_token/internal";
    protected $tokenKey = "app_access_token";

    public function getName()
    {
        return 'app_access_token';
    }

    /**
     * Credential for get token.
     */
    protected function getCredentials(): array
    {
        return [
            'app_id' => $this->app['config']['app_id'],
            'app_secret' => $this->app['config']['app_secret'],
        ];
    }
}
