<?php
/**
 * Created by PhpStorm.
 * User: zhao0
 * Date: 2022/4/18
 * Time: 15:41
 */

namespace EasyFeishu\Service\Cloud\Type;


/**
 * 云文档通用api
 */
use EasyFeishu\Kernel\BaseHttpService;

class Api extends BaseHttpService
{

    /**
     * 根据URL分析文档的token值和文档类型
     * @param $docUrl
     * @return array ["docs_token",=>"",""=>"docs_type"]
     * 1) "doc": 飞书文档
     * 2) "sheet": 飞书电子表格
     * 3) "bitable": 飞书多维表格
     * 4) "mindnote": 飞书思维笔记
     * 5) "file": 飞书文件
     */
    public function parseToken($docUrl)
    {
        $urlInfo = parse_url($docUrl);
        $paths = explode("/", $urlInfo["path"]);
        if (count($paths) !== 3) {
            throw new InvalidArgumentException("URL格式错误:$docUrl");
        }
        $typeMap = [
            "docs" => "doc",
            "docx" => "docx",
            "sheets" => "sheet",
            "mindnotes" => "mindnote",
            "base" => "bitable",
            "file" => "file",
        ];
        $type = $paths[1];
        $token = $paths[2];
        if (!isset($typeMap[$type])) {
            throw new InvalidArgumentException("错误的文档格式:$type");
        }
        return [
            "docs_token" => $token,
            "docs_type" => $typeMap[$type]
        ];
    }

    /**
     * 获取飞书文档链接的元信息
     * @param array $request_docs
     * @return array|mixed
     * @throws \EasyFeishu\Kernel\Exceptions\FeishuErrorException
     * @throws \EasyFeishu\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function meta(array $request_docs)
    {
        $ret = $this->httpPostJson('open-apis/suite/docs-api/meta', ["request_docs" => $request_docs]);
        return $ret['data'] ?? [];
    }

    /**
     * 搜索文档
     * @param string $name
     * @param array $param
     * @return array|mixed
     * @throws \EasyFeishu\Kernel\Exceptions\FeishuErrorException
     * @throws \EasyFeishu\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function search(string $name, array $param = [])
    {
        $param = array_merge($param, [
            "search_key" => $name
        ]);
        $ret = $this->httpPostJson('open-apis/suite/docs-api/search/object', $param);
        return $ret['data'] ?? [];
    }
}