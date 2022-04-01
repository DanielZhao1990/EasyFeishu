<?php

namespace EasyFeishu\token;

use EasyFeishu\token\AccessToken as BaseAccessToken;

class TenantAccessToken extends BaseAccessToken
{

    /**
     * @var string
     */
    protected $endpointToGetToken = "/open-apis/auth/v3/tenant_access_token/internal";

    protected $tokenKey="tenant_access_token";


    public function getName()
    {
        return 'tenant_access_token';
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
