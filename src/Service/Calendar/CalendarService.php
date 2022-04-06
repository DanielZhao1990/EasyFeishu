<?php

/*
 * title 日历相关
 */

namespace EasyFeishu\Service\Calendar;


use EasyFeishu\Bean\Calendar;
use EasyFeishu\Kernel\BaseHttpService;

class CalendarService extends BaseHttpService
{
    /**
     * 创建日历.
     * @param array $calendar
     * @see https://open.feishu.cn/document/uAjLw4CM/ukTMukTMukTM/reference/calendar-v4/calendar/create
     * @return Collection
     * @throws \EasyFeishu\Kernel\Exceptions\FeishuErrorException
     * @throws \EasyFeishu\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create(array $calendar)
    {
        $ret = $this->httpPostJson('/open-apis/calendar/v4/calendars', $calendar);
        return $ret['data'];
    }

    /**
     * 获取单个日历信息.
     * @param string $calendarId 日历id
     *
     */
    public function get(string $calendarId)
    {
        $ret = $this->httpGet("/open-apis/calendar/v4/calendars/$calendarId");
        return $ret['data'];
    }

    /**
     * 获得当前身份（应用 / 用户）的日历列表
     * 身份由 Header Authorization 的 Token 类型决定
     * @see https://open.feishu.cn/document/uAjLw4CM/ukTMukTMukTM/reference/calendar-v4/calendar/list
     * @param array $query 查询参数
     * @return array
     */
    public function getList(array $query = []): array
    {
        $ret = $this->httpGet("/open-apis/calendar/v4/calendars", $query);
        return $ret['data']['items'];
    }


    /**
     * 搜索日历.
     * @param string $key_word
     * @param string $page_token
     * @param string $page_size
     * @return array
     * @throws \EasyFeishu\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function search(string $key_word, string $page_token = "", string $page_size = ""): array
    {
        $query = $page_token ? [
            'page_token' => $page_token,
            'page_size' => $page_size
        ] : [];
        $ret = $this->httpPostJson('/open-apis/calendar/v4/calendars/search', ['query' => $key_word], $query);
        return $ret["data"];
    }

    /**
     * 该接口用于以当前身份（应用 / 用户）订阅某个日历。
     * 身份由 Header Authorization 的 Token 类型决定。
     * @see https://open.feishu.cn/document/uAjLw4CM/ukTMukTMukTM/reference/calendar-v4/calendar/subscribe
     * @param string $calendarId 日历id
     */
    public function subscribe(string $calendarId)
    {
        $ret = $this->httpPostJson("/open-apis/calendar/v4/calendars/$calendarId/subscribe");
        return $ret["data"];
    }

    /**
     * 取消订阅日历.
     * 身份由 Header Authorization 的 Token 类型决定。
     * @see https://open.feishu.cn/document/uAjLw4CM/ukTMukTMukTM/reference/calendar-v4/calendar/unsubscribe
     * @param string $calendarId 日历id
     */
    public function unsubscribe(string $calendarId)
    {
        $ret = $this->httpPostJson("/open-apis/calendar/v4/calendars/$calendarId/unsubscribe");
        return $ret["data"];
    }

    /**
     * 删除日历.
     * @see https://open.feishu.cn/document/uAjLw4CM/ukTMukTMukTM/reference/calendar-v4/calendar/delete
     * @param string $calendarId 日历id
     */
    public function delete(string $calendarId)
    {
        $ret = $this->request("/open-apis/calendar/v4/calendars/$calendarId", 'delete');
        return $ret;
    }
}
