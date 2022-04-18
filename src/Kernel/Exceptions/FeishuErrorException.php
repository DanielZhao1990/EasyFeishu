<?php
/**
 * Created by PhpStorm.
 * User: zhao0
 * Date: 2022/4/2
 * Time: 17:06
 */

namespace EasyFeishu\Kernel\Exceptions;


class FeishuErrorException extends Exception
{
    /**
     * generate_access_token_fail
     */
    const EXCEPTION_CODE_EXPIRED = 20007;

}