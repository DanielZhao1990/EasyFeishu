<?php
/**
 * Created by PhpStorm.
 * User: zhao0
 * Date: 2022/4/6
 * Time: 10:28
 */

namespace EasyFeishu\token;


use EasyFeishu\FeiShuApp;
use EasyFeishu\Kernel\ServiceContainer;
use Psr\Http\Message\RequestInterface;

class UserAccessToken extends AccessToken
{

    /**
     * @var string
     */
    protected $endpointToGetToken = "/open-apis/authen/v1/refresh_access_token";


    public function __construct($app, $token)
    {
        parent::__construct($app);
        $this->token = $token;
    }

    /**
     * @var array
     */
    protected $token;

    protected $refresh_callback;

    /**
     * @throws \EasyFeishu\Kernel\Exceptions\HttpException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \EasyFeishu\Kernel\Exceptions\InvalidConfigException
     * @throws \EasyFeishu\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyFeishu\Kernel\Exceptions\RuntimeException
     */
    public function getToken(bool $refresh = false): array
    {
        $currentTime = time();
        // 判断token是否已过期
        if (!$refresh && $currentTime - $this->token['token_time'] < $this->token['expires_in'] - 60) {
            return $this->token;
        }
        /**
         * @var FeiShuApp
         */
        $app = $this->app;
        $token = $app->authen->refreshAccessToken($this->token['refresh_token']);
        $token['token_time'] = time();
        if (isset($token['refresh_callback'])) {
            $token['refresh_callback']($token);
        }
        if (isset($this->refresh_callback)) {
            call_user_func($this->refresh_callback, $token);
        }
        $this->token = $token;
        return $token;
    }

    /**
     * 设置刷新token后的回调
     * @param mixed $refresh_callback
     */
    public function setRefreshCallback($refresh_callback)
    {
        $this->refresh_callback = $refresh_callback;
    }

    /**
     * Credential for get token.
     */
    protected function getCredentials(): array
    {
        return [
        ];
    }
}