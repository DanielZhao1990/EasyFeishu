<?php

namespace EasyFeishu\Service\Message;

use EasyFeishu\Service\Message\bean\BaseMessage;

class Message extends \EasyFeishu\Kernel\BaseHttpService
{

    /**
     *
     * @see https://open.feishu.cn/document/uAjLw4CM/ukTMukTMukTM/reference/im-v1/message/create
     * @param $receive_id_type string 消息发送的ID类型
     * @param $id string 接收消息的ID
     * @param $content string 要发送的内容, 可以使用MessageBuilder构建
     * @param $msg_type
     * @return array|mixed
     * @throws \EasyFeishu\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send(string $receive_id_type, string $id, BaseMessage $message)
    {
        $ret = $this->httpPostJson('open-apis/im/v1/messages', [
            "receive_id" => $id,
            "content" => $message->build(),
            "msg_type" => $message->getType(),
        ], ['receive_id_type' => $receive_id_type]);
        return $ret['data'] ?? [];
    }

    public static function getName(): string
    {
        return 'message';
    }
}
