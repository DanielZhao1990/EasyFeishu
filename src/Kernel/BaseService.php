<?php
/**
 * Created by PhpStorm.
 * User: zhao0
 * Date: 2022/3/29
 * Time: 14:55
 */

namespace EasyFeishu\Kernel;


class BaseService
{
    protected $app = null;
    public function __construct(ServiceContainer $app)
    {
//        echo static::class." __construct\n";
        $this->app = $app;
    }
}