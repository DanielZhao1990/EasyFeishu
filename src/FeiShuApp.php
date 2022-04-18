<?php
/**
 * Created by PhpStorm.
 * User: zhao0
 * Date: 2022/3/29
 * Time: 14:25
 */

namespace EasyFeishu;

use EasyFeishu\Kernel\ServiceContainer;
use EasyFeishu\Service\Authen\AuthenService;
use EasyFeishu\Service\Authen\AuthenServiceProvider;
use EasyFeishu\Service\Calendar\CalendarEventService;
use EasyFeishu\Service\Calendar\CalendarProvider;
use EasyFeishu\Service\Calendar\CalendarService;
use EasyFeishu\Service\Cloud\Cloud;
use EasyFeishu\Service\Cloud\CloudProvider;
use EasyFeishu\Service\Contact\Contact;
use EasyFeishu\Service\Contact\ContactProvider;
use EasyFeishu\Service\Message\Message;
use EasyFeishu\Service\Message\MessageBuilder;
use EasyFeishu\Service\Message\MessageProvider;
use EasyFeishu\token\AccessTokenProvider;
use EasyFeishu\token\AppAccessToken;
use EasyFeishu\token\TenantAccessToken;


/**
 * @property AuthenService $authen
 * @property Contact $contact
 * @property Message $message
 * @property Cloud $cloud
 * @property CalendarService $calendar
 * @property CalendarEventService $calendar_event
 * @property MessageBuilder $messageBuilder
 * @property TenantAccessToken $tenant_access_token
 * @property AppAccessToken $app_access_token
 * Class FeiShuApp
 * @package EasyFeishu\
 */
class FeiShuApp extends ServiceContainer
{
    protected $providers = [
        AuthenServiceProvider::class,
        AccessTokenProvider::class,
        ContactProvider::class,
        MessageProvider::class,
        CalendarProvider::class,
        CloudProvider::class,
    ];


}