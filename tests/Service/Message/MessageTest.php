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


    /**
     * @deprecated
     * @throws \EasyFeishu\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testBuildCard()
    {
        $user = $this->getUser();
        $card = $this->getFeishuApp()->messageBuilder->buildCardMessage();
        $card->setHeader("紧急消息")
            ->addElementText("您有2条任务即将过期 \n 完成测试1 \n 完成测试2")
            ->addActionButton("查看任务", "http://cloud.51zsqc.com/pearproject_admin//public/index.php/task/fei_shu/index")
            ->addActionButton("忽略");
        echo $card->build();
        $sendRes = $this->getFeishuApp()->message->send("open_id", $user['open_id'], $card);
        $this->assertArrayHasKey("message_id", $sendRes);
    }

    /**
     * @deprecated
     * @throws \EasyFeishu\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testBuildCardNew()
    {
        $user = $this->getUser();
        $card = $this->getFeishuApp()->messageBuilder->buildCardMessage();
        $card->setHeader("紧急消息");
        $card->buildDiv()->addText("您有2条任务即将过期 \n 完成测试1 \n 完成测试2");
        $card->buildAction()
            ->addButton("查看任务", "http://cloud.51zsqc.com/pearproject_admin//public/index.php/task/fei_shu/index")
            ->addButton("忽略", "", "primary")
            ->addDatePicker("修改结束时间");
        $card->buildAction()->addSelect("快速回复", [
            "我已收到",
            "已阅读,没问题",
            "稍后沟通",
        ]);
        echo $card->build();
        $sendRes = $this->getFeishuApp()->message->send("open_id", $user['open_id'], $card);
        $this->assertArrayHasKey("message_id", $sendRes);
    }


    public function testBuildCardNew1()
    {
        $user = $this->getUser();
        $card = $this->getFeishuApp()->messageBuilder->buildCardMessage();
        $card->setHeader("紧急消息");
        $card->buildDiv()->addText("您有2条任务即将过期 \n 完成测试1 \n 完成测试2");
        $card->buildHR();
        $card->buildDiv()->addFiled("**项目名称:** 测试项目", "md", true)
            ->addFiled("负责人: 测试人员", "md", true)
            ->addFiled("1. 测试1 \n2. 测试1");
        $card->buildHR();
        $card->buildAction()
            ->addButton("查看任务", "http://cloud.51zsqc.com/pearproject_admin//public/index.php/task/fei_shu/index")
            ->addButton("忽略", "", "primary")
            ->addDatePicker("修改结束时间");
        $card->buildAction()->addSelect("快速回复", [
            "我已收到",
            "已阅读,没问题",
            "稍后沟通",
        ]);
        echo $card->build();
        $sendRes = $this->getFeishuApp()->message->send("open_id", $user['open_id'], $card);
        $this->assertArrayHasKey("message_id", $sendRes);
        print_r($sendRes);
    }

}
