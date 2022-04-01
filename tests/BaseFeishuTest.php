<?php
/**
 * Created by PhpStorm.
 * User: zhao0
 * Date: 2022/3/31
 * Time: 22:59
 */

namespace EasyFeishu\Tests;

use EasyFeishu\FeiShuApp;
use PHPUnit\Framework\TestCase;


class BaseFeishuTest extends TestCase
{

    protected $userinfo_file = __DIR__ . "/data/userinfo.json";

    /**
     * @return FeiShuApp
     */
    public function getFeishuApp(): FeiShuApp
    {
        $config_path = __DIR__ . "/config.php";
        if (!file_exists($config_path)) {
            echo "请先复制config_simple.php 完成 $config_path 配置";
            die;
        } else {
            $config = require_once $config_path;
        }
        $app = new FeiShuApp($config);
        return $app;
    }


    public function getUser()
    {
        if (!file_exists($this->userinfo_file)) {
            echo "请先运行 AuthenServiceTest 进行用户数据初始化";
        } else {
            return json_decode(file_get_contents($this->userinfo_file), true);
        }
    }
}