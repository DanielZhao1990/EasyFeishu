<?php
/**
 * Created by PhpStorm.
 * User: zhao0
 * Date: 2022/4/18
 * Time: 16:10
 */

namespace EasyFeishu\Service\Cloud\Type;


use EasyFeishu\Tests\BaseFeishuTest;
use EasyFeishu\token\UserAccessToken;

class BitableTest extends BaseFeishuTest
{

    public function testTables()
    {
        $app = $this->getFeishuApp();
        $user = $this->getUser();
        $userToken = new UserAccessToken($this->getFeishuApp(), $user);
        $datas = $app->cloud->bitable->setAccessToken($userToken)->tables("bascnzsQJZ84VSyA4X66pvF2l3b");
        print_r($datas);
    }
}
