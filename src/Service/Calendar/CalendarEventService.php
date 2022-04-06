<?php

/*
 * title 日历相关
 */

namespace EasyFeishu\Service\Calendar;

use EasyFeishu\Kernel\BaseHttpService;

class CalendarEventService extends BaseHttpService
{
    /**
     * 该接口用于以当前身份（应用 / 用户）在日历上创建一个日程。
     * @param string $calendarId
     * @param array $calendarEvents
     * @return mixed
     * @throws \EasyFeishu\Kernel\Exceptions\FeishuErrorException
     * @throws \EasyFeishu\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @see https://open.feishu.cn/document/uAjLw4CM/ukTMukTMukTM/reference/calendar-v4/calendar-event/create
     */
    public function create(string $calendarId, array $calendarEvents)
    {
        $ret = $this->httpPostJson("/open-apis/calendar/v4/calendars/$calendarId/events", $calendarEvents);
        return $ret['data'];
    }

    /**
     * 获取单个日程信息.
     * @param string $calendarId 日历id
     */
    public function get(string $calendarId, $eventId)
    {
        $ret = $this->httpGet("/open-apis/calendar/v4/calendars/$calendarId/events/$eventId");
        return $ret['data'];
    }

    /**
     * 获得当前身份（应用 / 用户）的日程列表
     * 身份由 Header Authorization 的 Token 类型决定
     * @param array $query 查询参数
     * @return array
     */
    public function getList(string $calendarId, array $query = []): array
    {
        $ret = $this->httpGet("/open-apis/calendar/v4/calendars/$calendarId", $query);
        return $ret['data']['items'];
    }


    /**
     * 删除日历.
     * @see https://open.feishu.cn/document/uAjLw4CM/ukTMukTMukTM/reference/calendar-v4/calendar/delete
     * @param string $calendarId 日历id
     */
    public function delete(string $calendarId, string $eventId)
    {
        $ret = $this->request("/open-apis/calendar/v4/calendars/$calendarId/events/$eventId", 'delete');
        return $ret;
    }
}
