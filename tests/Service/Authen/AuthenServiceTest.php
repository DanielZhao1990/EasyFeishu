<?php
/**
 * Created by PhpStorm.
 * User: zhao0
 * Date: 2022/3/31
 * Time: 10:37
 */

namespace EasyFeishu\Tests\Service\Authen;

use EasyFeishu\Tests\BaseFeishuTest;

class AuthenServiceTest extends BaseFeishuTest
{

    public function testAuthorize()
    {
        $app = $this->getFeishuApp();
        $authorizeUrl = $app->authen->authorize("http://cloud.51zsqc.com/pearproject_admin/public/index.php/task/fei_shu/showCode");
        echo "点击地址，授权后获取code  $authorizeUrl";
    }

    /**
     * 请先使用testAuthorize获取code，再进行用户信息获取
     */
    public function testGetUserInfo()
    {
        $app = $this->getFeishuApp();
        $userinfo = $app->authen->getUserInfo("q1E2XNiQYqBb0kcRsmgDFa");
        print_r($userinfo);
        $this->setUser($userinfo);
    }


}
