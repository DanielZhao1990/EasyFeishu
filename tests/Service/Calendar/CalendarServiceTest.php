<?php
/**
 * Created by PhpStorm.
 * User: zhao0
 * Date: 2022/4/2
 * Time: 11:03
 */

namespace EasyFeishu\Tests\Service\Calendar;

use EasyFeishu\Kernel\Exceptions\FeishuErrorException;

class CalendarServiceTest extends BaseCalendarTest
{

    public function testCreate()
    {
        try {
            $calendar = $this->getFeishuApp()->calendar->create([
                "summary" => "test_calendar"
            ]);
            print_r($calendar);
        } catch (FeishuErrorException $e) {
            echo "飞书错误: {$e->getMessage()}";
        }
    }

    public function testUnsubscribe()
    {
        $calendar = $this->getPublicTestCalendar();
        $res = $this->getFeishuApp()->calendar->unsubscribe($calendar['calendar_id']);
        print_r($res);
    }


    public function testGetList()
    {
        $calendars = $this->getFeishuApp()->calendar->getList();
        $this->assertEquals(0, $calendars["code"]);
    }


    public function testSubscribe()
    {
        $calendar = $this->getPublicTestCalendar();
        $res = $this->getFeishuApp()->calendar->subscribe($calendar['calendar_id']);
        print_r($res);
    }

    public function testDelete()
    {
        $calendar = $this->getPublicTestCalendar();
        $res = $this->getFeishuApp()->calendar->delete($calendar['calendar_id']);
        print_r($res);
    }

    public function testGet()
    {
        try {
            $calendar = $this->getFeishuApp()->calendar->get("wrong_id");
        } catch (FeishuErrorException $e) {
            $this->assertEquals(191001, $e->getCode());
            $this->assertEquals('invalid calendar_id', $e->getMessage());
        }

        $user = $this->getUser();
        try {
            $calendars = $this->getFeishuApp()->calendar->search($user['name']);
            $calendar_id = $calendars["items"][0]['calendar_id'];
            $calendar = $this->getFeishuApp()->calendar->get($calendar_id);
            $this->assertArrayHasKey("summary", $calendar);
        } catch (FeishuErrorException $e) {

        }
    }

    public function testPatchCalendars()
    {

    }

    public function testSearch()
    {
        $searchResult = $this->getFeishuApp()->calendar->search("test_calendar");
        $this->assertArrayHasKey('items', $searchResult);
        echo "找到 " . count($searchResult["items"]) . "个 test_calendar 日历";

        $user = $this->getUser();
        $searchResult = $this->getFeishuApp()->calendar->search($user['name']);
        $this->assertArrayHasKey('items', $searchResult);
    }

}
