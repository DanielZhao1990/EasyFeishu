<?php

namespace EasyFeishu\Service\Authen;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class AuthenServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['authen'] = function ($pimple) {
            return new AuthenService($pimple);
        };
    }
}
