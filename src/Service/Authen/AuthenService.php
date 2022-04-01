<?php
/**
 * Created by PhpStorm.
 * User: zhao0
 * Date: 2022/3/29
 * Time: 14:26
 */

namespace EasyFeishu\Service\Authen;

use EasyFeishu\Kernel\BaseHttpService;

class AuthenService extends BaseHttpService
{

    /**
     * 获取重定向的URL.
     */
    public function authorize(string $uri, string $state = ''): string
    {
        return 'https://open.feishu.cn/open-apis/authen/v1/index?' . http_build_query([
                'app_id' => $this->app['config']['app_id'],
                'redirect_uri' => $uri,
                'state' => $state,
            ]);
    }

    public function getUserInfo(string $code): array
    {
        $ret = $this->httpPostJson('open-apis/authen/v1/access_token', [
            'grant_type' => 'authorization_code',
            'code' => $code,
        ]);
        return $ret['data'] ?? [];
    }

}