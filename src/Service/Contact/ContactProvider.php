<?php

namespace EasyFeishu\Service\Contact;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ContactProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple[Contact::getName()] = function ($pimple) {
            return new Contact($pimple);
        };
    }
}
