<?php

namespace EasyFeishu\Service\Calendar;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class CalendarProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['calendar'] = function ($pimple) {
            return new CalendarService($pimple);
        };
        $pimple['calendar_event'] = function ($pimple) {
            return new CalendarEventService($pimple);
        };
    }
}
