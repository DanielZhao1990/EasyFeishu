<?php
/**
 * Created by PhpStorm.
 * User: zhao0
 * Date: 2022/4/18
 * Time: 15:18
 */

namespace EasyFeishu\Service\Cloud\Type;


use EasyFeishu\Kernel\BaseHttpService;

/**
 * 多维表格
 * Class Bitable
 * @package EasyFeishu\Service\Cloud\Type
 */
class Bitable extends BaseHttpService
{

    public function tables($app_token)
    {
        $ret = $this->httpGet("/open-apis/bitable/v1/apps/$app_token/tables");
        return $ret['data'];
    }

}