<?php

namespace EasyFeishu\Service\Contact;

use EasyFeishu\Kernel\BaseHttpService;
use GuzzleHttp\RequestOptions;

class Contact extends BaseHttpService
{

    /**
     * 获取单位信息.
     */
    public function unit(string $id)
    {
        $ret = $this->httpGet('GET', 'open-apis/contact/v3/unit/' . $id);
        return $ret['data'] ?? [];
    }

    /**
     * 获取部门信息.
     * @param $extra = [
     *     'user_id_type' => 'open_id', // open_id, user_id, union_id
     *     'department_id_type' => 'open_department_id', // open_department_id, department_id
     * ]
     */
    public function department(string $id, array $extra = [])
    {
        $ret = $this->httpGet('GET', 'open-apis/contact/v3/departments/' . $id, [
            RequestOptions::QUERY => $extra,
        ]);

        return $ret['data'] ?? [];
    }

    /**
     * 获取子部门列表.
     * @param $extra = [
     *     'user_id_type' => 'open_id', // open_id, user_id, union_id
     *     'department_id_type' => 'open_department_id', // open_department_id, department_id
     *     'fetch_child' => false, // 是否递归获取子部门
     *     'page_size' => 10, // 分页大小
     *     'page_token' => '', // 分页TOKEN
     * ]
     */
    public function departmentChildren(string $id, array $extra = [])
    {
        $ret = $this->request('GET', 'open-apis/contact/v3/departments/' . $id . '/children', [
            RequestOptions::QUERY => $extra,
        ]);

        return $ret['data'] ?? [];
    }

    /**
     * 获取用户信息.
     * 支持的应用类型、自建应用、商店应用
     * @see https://open.feishu.cn/document/uAjLw4CM/ukTMukTMukTM/reference/contact-v3/user/get
     */
    public function user(string $id, string $type = 'open_id')
    {
        $ret = $this->httpGet('open-apis/contact/v3/users/' . $id, [
            'user_id_type' => $type,
        ]);
        return $ret['data'] ?? [];
    }

    /**
     * 获取部门下的用户.
     * @param $extra = [
     *     'user_id_type' => 'open_id', // open_id, user_id, union_id
     *     'department_id_type' => 'open_department_id', // open_department_id, department_id
     *     'page_size' => 10, // 分页大小
     *     'page_token' => '', // 分页TOKEN
     * ]
     */
    public function usersByDepartment(string $id, array $extra = [])
    {
        $ret = $this->request('GET', 'open-apis/contact/v3/users/find_by_department', [
            RequestOptions::QUERY => array_merge($extra, [
                'department_id' => $id,
            ]),
        ]);

        return $ret['data'] ?? [];
    }

    /**
     * 批量获取用户ID.
     */
    public function batchGetUserId(array $mobiles = [], array $emails = [], string $type = 'open_id')
    {
        $ret = $this->request('POST', 'open-apis/contact/v3/users/batch_get_id', [
            RequestOptions::QUERY => [
                'user_id_type' => $type,
            ],
            RequestOptions::JSON => [
                'mobiles' => $mobiles,
                'emails' => $emails,
            ],
        ]);

        return $ret['data'] ?? [];
    }

    public static function getName(): string
    {
        return 'contact';
    }
}
