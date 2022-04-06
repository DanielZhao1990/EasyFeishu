<?php
/**
 * Created by PhpStorm.
 * User: zhao0
 * Date: 2022/4/2
 * Time: 11:03
 */

namespace EasyFeishu\Tests\Service\Calendar;

use EasyFeishu\Tests\BaseFeishuTest;

class BaseCalendarTest extends BaseFeishuTest
{

    public function getPublicTestCalendar()
    {
        $searchResult = $this->getFeishuApp()->calendar->search("test_calendar");
        if (count($searchResult["items"]) > 0) {
            return $searchResult["items"][0];
        } else {
            throw new \Exception("未查找到测试日历，请运行testCreateCalendar进行创建");
        }
    }


    public function getUserCalendar()
    {
        $user = $this->getUser();
        $searchResult = $this->getFeishuApp()->calendar->search($user['name']);
        if (count($searchResult["items"]) > 0) {
            return $searchResult["items"][0];
        } else {
            throw new \Exception("未查找到用户日历");
        }
    }
}
