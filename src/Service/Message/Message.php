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

    /**
     * @deprecated
     * @see https://open.feishu.cn/document/ukTMukTMukTM/uUjNz4SN2MjL1YzM
     * @param $data = [
     *     'open_id' => 'ou_5ad573a6411d72b8305fda3a9c15c70e',
     *     'chat_id' => 'oc_5ad11d72b830411d72b836c20',
     *     'user_id' => '92e39a99',
     *     'email' => 'fanlv@gmail.com',
     * ]
     */
    public function sendText(array $data, string $text)
    {
        $data['msg_type'] = 'text';
        $data['content']['text'] = $text;

        $type = null;
        foreach (['chat_id', 'open_id', 'user_id', 'email'] as $key) {
            if (isset($data[$key])) {
                $type = $key;
                $data['receive_id'] = $data[$key];
                unset($data[$key]);
                break;
            }
        }

        if (!isset($type)) {
            throw new InvalidArgumentException("Couldn't guess the type for message request.");
        }

        return $this->send($data, $type);
    }

    public static function getName(): string
    {
        return 'message';
    }
}
