<?php
/**
 * Created by PhpStorm.
 * User: zhao0
 * Date: 2022/3/31
 * Time: 10:37
 */

namespace EasyFeishu\service\authen;

require_once "BaseFeishuTest.php";
use EasyFeishu\Tests\BaseFeishuTest;

class AuthenServiceTest extends BaseFeishuTest
{

    public function testToken()
    {
        $app=$this->getFeishuApp();
        $token = $app->tenant_access_token->getToken();
        print_r($token);
        $token = $app->app_access_token->getToken();
        print_r($token);
    }
}
