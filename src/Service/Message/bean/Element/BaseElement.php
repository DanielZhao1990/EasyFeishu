<?php
/**
 * Created by PhpStorm.
 * User: zhao0
 * Date: 2022/4/25
 * Time: 9:31
 */

namespace EasyFeishu\Service\Message\bean\Element;


class BaseElement
{
    protected $data = [];

    /**
     * @param string $tag
     */
    public function __construct($tag = "")
    {
        $tag && $this->data["tag"] = $tag;
    }


    public function build()
    {
        return $this->data;
    }

    /**
     * @param $text
     * @param string $type md|plain
     * @return array
     */
    public static function text($text, $type = "plain")
    {
        return
            [
                "tag" => $type == "md" ? "lark_md" : "plain_text",
                "content" => $text
            ];
    }

}