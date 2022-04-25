<?php
/**
 * Created by PhpStorm.
 * User: zhao0
 * Date: 2022/3/28
 * Time: 17:01
 */

namespace EasyFeishu\Service\Message\bean;

use EasyFeishu\Service\Message\bean\Element\ActionElement;
use EasyFeishu\Service\Message\bean\Element\BaseElement;
use EasyFeishu\Service\Message\bean\Element\DivElement;

/**
 * @see https://open.feishu.cn/document/ukTMukTMukTM/uEjNwUjLxYDM14SM2ATN
 * @package EasyFeishu\Service\Message
 */
class CardMessage extends BaseMessage
{

    protected $data = [
        "header" => [
            "template" => "blue",
            "title" => [
                "tag" => "plain_text",
                "content" => "this is header"
            ]
        ],
        "elements" => [

        ]
    ];


    /**
     * @var array
     */
    protected $elements = [];


    /**
     * 消息类型
     * @return string
     */
    public function getType(): string
    {
        return "interactive";
    }


    /**
     * @param $content
     * @param $template string blue|
     * @param null $tag
     * @return CardMessage
     */
    public function setHeader($content,$template="blue", $tag = null): CardMessage
    {
        if ($tag) {
            $this->data["header"]["title"]["tag"] = $tag;
        }
        if ($content) {
            $this->data["header"]["title"]["content"] = $content;
        }
        return $this;
    }


    /**
     * @return ActionElement
     */
    public function buildAction()
    {
        $element = new ActionElement();
        $this->addElement($element);
        return $element;
    }

    /**
     * @return DivElement
     */
    public function buildDiv()
    {
        $element = new DivElement();
        $this->addElement($element);
        return $element;
    }

    public function build(): string
    {
        $this->data["elements"]=[];
        foreach ($this->elements as $element) {
            $this->data["elements"][] = $element->build();
        }
        return parent::build();
    }

    public function buildHR()
    {
        $element = new BaseElement("hr");
        return $this->addElement($element);
    }

    /**
     * 添加一个element到节点
     * @param $element
     * @return $this
     */
    private function addElement($element): CardMessage
    {
        $this->elements[] = $element;
        return $this;
    }


    /**
     * @deprecated
     * @param $content
     * @return CardMessage
     */
    public function addElementText($content): CardMessage
    {
        $element = new DivElement();
        $element->addText($content);
        return $this->addElement($element);
    }

    /**
     * @deprecated
     * @param $text
     * @param string $url
     * @return CardMessage
     */
    public function addActionButton($text, $url = ""): CardMessage
    {
        $element = new ActionElement();
        $element->addButton($text, $url);
        return $this->addElement($element);
    }

}
