<?php
/**
 * Created by PhpStorm.
 * User: zhao0
 * Date: 2022/4/1
 * Time: 12:10
 */

return [
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