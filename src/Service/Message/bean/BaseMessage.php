<?php
/**
 * Created by PhpStorm.
 * User: zhao0
 * Date: 2022/4/1
 * Time: 9:29
 */

namespace EasyFeishu\Service\Message\bean;


abstract class BaseMessage
{


    public function build()
    {
        return json_encode($this, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 消息类型
     * @return string
     */
    public abstract function getType(): string;

}