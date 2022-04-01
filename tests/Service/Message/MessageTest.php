<?php
/**
 * Created by PhpStorm.
 * User: zhao0
 * Date: 2022/4/1
 * Time: 8:49
 */

namespace EasyFeishu\Tests\Service\Message;
use EasyFeishu\Tests\BaseFeishuTest;

class MessageTest extends BaseFeishuTest
{

    public function testSendText()
    {
        $user = $this->getUser();
        $text = $this->getFeishuApp()->messageBuilder->buildTextMessage();
        $text->appendText("你好,")
            ->appendAtUser($user["user_id"], $user["name"])
            ->appendText("Hello world");
        $sendRes = $this->getFeishuApp()->message->send("open_id", $user['open_id'], $text);
        $this->assertArrayHasKey("message_id", $sendRes);
    }


    public function testBuildCard()
    {
        $user = $this->getUser();
        $card = $this->getFeishuApp()->messageBuilder->buildCardMessage();
        $card->setHeader("紧急消息")
            ->addElementText("您有2条任务即将过期 \n 完成测试1 \n 完成测试2")
            ->addActionButton("查看任务", "http://cloud.51zsqc.com/pearproject_admin//public/index.php/task/fei_shu/index")
            ->addActionButton("忽略");
        $sendRes = $this->getFeishuApp()->message->send("open_id", $user['open_id'], $card);
        $this->assertArrayHasKey("message_id", $sendRes);
    }

}
