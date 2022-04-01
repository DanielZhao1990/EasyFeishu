<?php

/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace EasyFeishu\token;

use EasyFeishu\Kernel\ServiceContainer;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class AccessTokenProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['app_access_token'] = function ($pimple) {
            return new AppAccessToken($pimple);
        };

        $pimple['tenant_access_token'] = function ($pimple) {
            return new TenantAccessToken($pimple);
        };
        $pimple['access_token'] = function ($pimple) {
            return new TenantAccessToken($pimple);
        };
    }
}
