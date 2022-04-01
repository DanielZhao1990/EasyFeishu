<?php
/**
 * Created by PhpStorm.
 * User: zhao0
 * Date: 2022/4/1
 * Time: 9:21
 */

namespace EasyFeishu\Service\Message\bean;


/**
 * @see https://open.feishu.cn/document/uAjLw4CM/ukTMukTMukTM/im-v1/message/create_json
 * @package EasyFeishu\Service\Message
 */
class TextMessage extends BaseMessage
{

    public $text = "";

    /**
     * 消息类型
     * @return string
     */
    public function getType(): string
    {
        return "text";
    }

    public function appendText(string $text): TextMessage
    {
        $this->text .= $text;
        return $this;
    }


    /**
     * @param string $user_id
     */
    public function appendAtUser(string $user_id, string $user_name)
    {
        $this->text .= "<at user_id=\"$user_id\">$user_name</at>";
        return $this;
    }

    /**
     *  添加@所有人
     */
    public function appendAtAll()
    {
        $this->text .= "<at user_id=\"all\">所有人</at>";
        return $this;
    }

}