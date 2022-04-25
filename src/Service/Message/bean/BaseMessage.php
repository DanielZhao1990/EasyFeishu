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

    protected $data;

    /**
     * 在构建消息时被调用，将消息数据打包为json
     * @return string
     */
    public function build()
    {
        return $this->encode($this->data);
    }

    protected function encode($data)
    {
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 消息类型
     * @return string
     */
    public abstract function getType(): string;

}