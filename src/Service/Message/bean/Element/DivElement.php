<?php
/**
 * Created by PhpStorm.
 * User: zhao0
 * Date: 2022/4/25
 * Time: 9:38
 */

namespace EasyFeishu\Service\Message\bean\Element;


/**
 * @see https://open.feishu.cn/document/ukTMukTMukTM/uMjNwUjLzYDM14yM2ATN
 * Class DivElement
 * @package EasyFeishu\Service\Message\bean\Element
 */
class DivElement extends BaseElement
{
    protected $data = [
        "tag" => "div",
    ];
    protected $fields = [
    ];

    public function addText($content)
    {
        $text = self::text($content);
        $this->data["text"] = $text;
        return $this;
    }

    /**
     * @see https://open.feishu.cn/document/ukTMukTMukTM/uYzNwUjL2cDM14iN3ATN
     * @param $text
     * @param string $type
     * @param bool $is_short
     * @return $this
     */
    public function addFiled($text, $type="plain", $is_short = false)
    {
        $field = self::text($text, $type);
        $this->fields[] = [
            "is_short" => $is_short,
            "text" => $field
        ];
        return $this;
    }



    public function build()
    {
        $this->fields && $this->data["fields"] = $this->fields;
        return parent::build();
    }

}