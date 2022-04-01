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
        $app = $this->getFeishuApp();
        $userinfo = $app->contact->user("ou_fa9bdf124bcf6119726fb90b046e925e");
        print_r($userinfo);
    }
}
