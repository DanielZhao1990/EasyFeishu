<?php

namespace EasyFeishu\Service\Message;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class MessageProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple[Message::getName()] = function ($pimple) {
            return new Message($pimple);
        };
        $pimple['messageBuilder'] = function ($pimple) {
            return new MessageBuilder($pimple);
        };
    }
}
