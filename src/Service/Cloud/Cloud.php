<?php
/**
 * Created by PhpStorm.
 * User: zhao0
 * Date: 2022/4/18
 * Time: 15:35
 */

namespace EasyFeishu\Service\Cloud;
use EasyFeishu\Kernel\PrefixedContainer;
use EasyFeishu\Service\Cloud\Type\Api;
use EasyFeishu\Service\Cloud\Type\Bitable;
use EasyFeishu\Service\Cloud\Type\Doc;


/**
 *
 * @property Bitable $bitable
 * @property Doc $doc
 * @property Api $api
 * @package EasyFeishu\Service\Doc
 */
class Cloud
{
    use PrefixedContainer;
}