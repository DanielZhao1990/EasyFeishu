<?php
/**
 * Created by PhpStorm.
 * User: zhao0
 * Date: 2022/4/25
 * Time: 9:31
 */

namespace EasyFeishu\Service\Message\bean\Element;


class ActionElement extends BaseElement
{

    protected $data = [
        "tag" => "action",
        "actions" => [
        ]
    ];

    /**
     * @param $placeholder
     * @return $this
     */
    public function addDatePicker($placeholder)
    {
        $action = [
            "tag" => "date_picker",
            "placeholder" => [
                "tag" => "plain_text",
                "content" => $placeholder
            ],
        ];
        $this->data["actions"][] = $action;
        return $this;
    }

    /**
     * @param $text
     * @param string $url
     * @param string $type
     * @return ActionElement
     */
    public function addButton($text, $url = "", $type = "default")
    {
        $action = [
            "tag" => "button",
            "url" => $url,
            "text" => [
                "tag" => "lark_md",
                "content" => $text
            ],
            "type" => "default"
        ];
        $this->data["actions"][] = $action;
        return $this;
    }

    /**
     * @see https://open.feishu.cn/document/ukTMukTMukTM/uIzNwUjLycDM14iM3ATN
     * @param $placeholder
     * @param array $arg_options [value=>content]
     * @return $this
     */
    public function addSelect($placeholder, array $arg_options)
    {
        $options = [];
        foreach ($arg_options as $key => $option) {
            $options[] = [
                "text" => [
                    "content" => $option,
                    "tag" => "plain_text"
                ],
                "value" => "$key"
            ];
        }
        $action = [
            "tag" => "select_static",
            "placeholder" => [
                "tag" => "plain_text",
                "content" => $placeholder
            ],
            "options" => $options
        ];
        $this->data["actions"][] = $action;
        return $this;
    }

}