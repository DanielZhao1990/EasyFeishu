<?php
/**
 * Created by PhpStorm.
 * User: zhao0
 * Date: 2022/4/18
 * Time: 14:10
 */

namespace EasyFeishu\Tests\Service\Cloud;


use EasyFeishu\Tests\BaseFeishuTest;
use EasyFeishu\token\UserAccessToken;

class ApiTest extends BaseFeishuTest
{


    public function testMeta()
    {
        $app = $this->getFeishuApp();
        $res = $app->cloud->api->meta(
            [
                [
                    "docs_token" => "boxcnVGd4eqPD12X1mCcTTj5Vkb",
                    "docs_type" => "file"
                ],
                [
                    "docs_token" => "doccnknToJ1J9176AbyEtWKxOSf",
                    "docs_type" => "doc"
                ],
            ]
        );
        print_r($res);
    }

    public function testParseToken()
    {
        $urls = [
            "https://muomkkun0c.feishu.cn/docs/doccnknToJ1J9176AbyEtWKxOSf#",
            "https://muomkkun0c.feishu.cn/docs/doccnT5Lla6fnZnK2HgrKIM6rub",
            "https://muomkkun0c.feishu.cn/file/boxcn35UeLe1ye0VmBDLQtdI3xh",
            "https://muomkkun0c.feishu.cn/mindnotes/bmncnN9b9Wq4jmHmyzMJs86fiLe",
            "https://muomkkun0c.feishu.cn/docs/doccn5BZC1xNeqplPTAJVhqvZ1e",
            "https://muomkkun0c.feishu.cn/docs/doccnMlESmdkU7OOquYAuts8FGf",
            "https://muomkkun0c.feishu.cn/mindnotes/bmncnqVZLjsiWYWr93XlSYwoxRb",
            "https://muomkkun0c.feishu.cn/file/boxcnVGd4eqPD12X1mCcTTj5Vkb",
            "https://muomkkun0c.feishu.cn/base/bascnzsQJZ84VSyA4X66pvF2l3b",
            "https://muomkkun0c.feishu.cn/sheets/shtcn6SFXJFNnt7merO6ghAUM4e",
            "https://muomkkun0c.feishu.cn/base/bascnzsQJZ84VSyA4X66pvF2l3b?table=tbl3INEw6rEiOGZn&view=vewp7nmiS4",
        ];
        $app = $this->getFeishuApp();
        $docs = [];
        foreach ($urls as $url) {
            $doc = $app->cloud->api->parseToken($url);
            $docs[] = $doc;
        }
        $user = $this->getUser();
        $userToken = new UserAccessToken($this->getFeishuApp(), $user);
        $userToken->setRefreshCallback(function ($userinfo){
            $this->setUser($userinfo);
        });
        $res = $app->cloud->api->setAccessToken($userToken)->meta(
            $docs
        );
//        $res = $app->cloud->api->meta(
//            $docs
//        );
        print_r($res);
    }

    public function testSearch()
    {
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
        $res = $app->cloud->api->setAccessToken($userToken)->search("CRM1.2");
        print_r($res);
    }
}
