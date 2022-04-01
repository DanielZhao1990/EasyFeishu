<?php
/**
 * Created by PhpStorm.
 * User: zhao0
 * Date: 2022/3/28
 * Time: 17:01
 */

namespace EasyFeishu\Service\Message\bean;

/**
 * @see https://open.feishu.cn/document/ukTMukTMukTM/uEjNwUjLxYDM14SM2ATN
 * @package EasyFeishu\Service\Message
 */
class CardMessage extends BaseMessage
{


    public $header = [
        "title" => [
            "tag" => "plain_text",
            "content" => "this is header"
        ]
    ];
    public $elements = [


    ];

    private $action = [
        "tag" => "action",
        "actions" => [

        ]
    ];

    /**
     * 消息类型
     * @return string
     */
    public function getType(): string
    {
        return "interactive";
    }


    public function setHeader($content, $tag = null): CardMessage
    {
        if ($tag) {
            $this->header["title"]["tag"] = $tag;
        }
        if ($content) {
            $this->header["title"]["content"] = $content;
        }
        return $this;
    }

    public function addElementText($content): CardMessage
    {
        $text = [
            "tag" => "div",
            "text" => [
                "tag" => "plain_text",
                "content" => $content
            ]
        ];
        $this->elements[] = $text;
        return $this;
    }

    public function addActionButton($text, $url = ""): CardMessage
    {
        $this->action["actions"][] = [
            "tag" => "button",
            "text" => [
                "content" => $text,
                "tag" => "plain_text"
            ],
            "url" => $url
        ];
        return $this;
    }

    public function build(): string
    {
        if ($this->action["actions"]) {
            $this->elements[] = $this->action;
        }
        return parent::build();
    }

}