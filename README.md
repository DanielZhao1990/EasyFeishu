## 环境需求

- PHP >= 7.2
- [Composer](https://getcomposer.org/) >= 2.0

## 安装

```bash
composer require danielzhao1990/easy_feishu
```

## 使用示例

基本使用:

```php
<?php

use EasyFeishu\FeiShuApp;

$config = [
    'debug' => false,
    'app_id' => '',
    'app_secret' => '',
    'encrypt_key' => '',
    'verification_token' => '',
    'log' => [
        'file' => __DIR__ . '/../logs/' . date('Y-m-d') . '.log',
        'level' => 'debug',
    ],
];

$app = new FeiShuApp($config);
$card = $this->getFeishuApp()->messageBuilder->buildCardMessage();
$card->setHeader("紧急消息")
    ->addElementText("您有2条任务即将过期 \n 完成测试1 \n 完成测试2")
    ->addActionButton("查看任务", "http://cloud.51zsqc.com/pearproject_admin//public/index.php/task/fei_shu/index")
    ->addActionButton("忽略");
$sendRes = $this->getFeishuApp()->message->send("open_id", $user['open_id'], $card);
```
