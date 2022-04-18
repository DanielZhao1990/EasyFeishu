<?php

namespace EasyFeishu\Service\Cloud;

use EasyFeishu\Service\Cloud\Type\Api;
use EasyFeishu\Service\Cloud\Type\Bitable;
use EasyFeishu\Service\Cloud\Type\Doc;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class CloudProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple["cloud"] = function ($pimple) {
            return new Cloud($pimple);
        };
        $pimple["cloud.bitable"] = function ($pimple) {
            return new Bitable($pimple);
        };
        $pimple["cloud.doc"] = function ($pimple) {
            return new Doc($pimple);
        };
        $pimple["cloud.api"] = function ($pimple) {
            return new Api($pimple);
        };
    }
}
