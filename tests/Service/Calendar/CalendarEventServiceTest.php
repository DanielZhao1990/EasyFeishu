<?php
/**
 * Created by PhpStorm.
 * User: zhao0
 * Date: 2022/4/6
 * Time: 9:34
 */

namespace EasyFeishu\Tests\Service\Calendar;


use EasyFeishu\token\UserAccessToken;

class CalendarEventServiceTest extends BaseCalendarTest
{
    public function testDelete()
    {
        $calendar = $this->getPublicTestCalendar();
        $res = $this->getFeishuApp()->calendar_event->delete($calendar['calendar_id']);
        print_r($res);
    }

    public function testGetList()
    {

    }

    public function testCreateUserCalendarEvent()
    {
        $calendar = $this->getUserCalendar();
        $user = $this->getUser();
        $app = $this->getFeishuApp();
        $userToken = new UserAccessToken($this->getFeishuApp(), [
            "access_token" => $user['access_token'],
            "refresh_expires_in" => $user['refresh_expires_in'],
            "refresh_token" => $user['refresh_token'],
            "expires_in" => $user['expires_in'],
            "token_time" => $user['token_time'],
            "refresh_callback" => function (array $userinfo) {
                $this->setUser($userinfo);
            }
        ]);
        $res = $app->calendar_event->setAccessToken($userToken)->create($calendar['calendar_id'], $this->buildCalendarEvent());
        print_r($res);
    }

    public function testCreatePublicCalendarEvent()
    {
        $app = $this->getFeishuApp();
        $calendar = $this->getPublicTestCalendar();
        $res = $app->calendar_event->setAccessToken($app->tenant_access_token)->create($calendar['calendar_id'], $this->buildCalendarEvent());
        print_r($res);
    }

    public function testGet()
    {

    }

    /**
     * @return array
     */
    private function buildCalendarEvent(): array
    {
        return [
            "summary" => "test",
            "start_time" => [
//                "date" => date("Y-m-d"),
                "timestamp" => time(),
                "timezone" => "Asia/Shanghai"
            ],
            "end_time" => [
                // 仅全天日程使用该字段，如2018-09-01。需满足 RFC3339 格式。不能与 timestamp 同时指定
//                "date" => date("Y-m-d"),
                "timestamp" => time() + 3600,
                "timezone" => "Asia/Shanghai"
            ]
        ];
    }
}
