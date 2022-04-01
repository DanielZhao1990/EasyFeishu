<?php
/**
 * Created by PhpStorm.
 * User: zhao0
 * Date: 2022/4/1
 * Time: 8:53
 */

namespace EasyFeishu\Service\Message;


use EasyFeishu\Kernel\BaseService;
use EasyFeishu\Service\Message\bean\CardMessage;
use EasyFeishu\Service\Message\bean\TextMessage;

class MessageBuilder extends BaseService
{

    public function buildCardMessage(): CardMessage
    {
        return new CardMessage();
    }

    public function buildTextMessage(): TextMessage
    {
        return new TextMessage();
    }

}