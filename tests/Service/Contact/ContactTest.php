<?php
/**
 * Created by PhpStorm.
 * User: zhao0
 * Date: 2022/3/31
 * Time: 23:33
 */

namespace EasyFeishu\Tests\Service\Contact;

use EasyFeishu\Tests\BaseFeishuTest;

class ContactTest extends BaseFeishuTest
{

    public function testBatchGetUserId()
    {

    }

    public function testUsersByDepartment()
    {

    }

    public function testGetName()
    {

    }

    public function testDepartmentChildren()
    {

    }

    public function testDepartment()
    {

    }

    public function testUnit()
    {

    }

    public function testUser()
    {
        $user = $this->getUser();
        $app = $this->getFeishuApp();
        $userinfo = $app->contact->user($user["open_id"]);
        print_r($user);
        $this->assertArrayHasKey("user", $userinfo);
        $userinfo = $app->contact->user($user["user_id"], "user_id");
        $this->assertArrayHasKey("user", $userinfo);
    }
}
