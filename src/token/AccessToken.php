<?php

/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace EasyFeishu\token;

use EasyFeishu\Kernel\Exceptions\HttpException;
use EasyFeishu\Kernel\Exceptions\InvalidArgumentException;
use EasyFeishu\Kernel\Exceptions\RuntimeException;
use EasyFeishu\Kernel\ServiceContainer;
use EasyFeishu\Kernel\Traits\HasHttpRequests;
use EasyFeishu\Kernel\Traits\InteractsWithCache;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

abstract class AccessToken implements AccessTokenInterface
{

    use HasHttpRequests;
    use InteractsWithCache;


    /**
     * @var \EasyFeishu\Kernel\ServiceContainer
     */
    protected $app;

    /**
     * @var string
     */
    protected $requestMethod = 'POST';

    /**
     * @var string
     */
    protected $endpointToGetToken;

    /**
     * @var string
     */
    protected $queryName;

    /**
     * @var array
     */
    protected $token;

    /**
     * @var string
     */
    protected $tokenKey = 'access_token';

    /**
     * @var string
     */
    protected $cachePrefix = 'easyfeishu.kernel.';

    /**
     * AccessToken constructor.
     *
     * @param ServiceContainer $app
     */
    public function __construct(ServiceContainer $app)
    {
        $this->app = $app;
    }

    public function getLastToken(): array
    {
        return $this->token;
    }

    /**
     * @throws \EasyFeishu\Kernel\Exceptions\HttpException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \EasyFeishu\Kernel\Exceptions\InvalidConfigException
     * @throws \EasyFeishu\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyFeishu\Kernel\Exceptions\RuntimeException
     */
    public function getRefreshedToken(): array
    {
        return $this->getToken(true);
    }

    /**
     * @throws \EasyFeishu\Kernel\Exceptions\HttpException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \EasyFeishu\Kernel\Exceptions\InvalidConfigException
     * @throws \EasyFeishu\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyFeishu\Kernel\Exceptions\RuntimeException
     */
    public function getToken(bool $refresh = false): array
    {
        $cacheKey = $this->getCacheKey();
        $cache = $this->getCache();

        if (!$refresh && $cache->has($cacheKey) && $result = $cache->get($cacheKey)) {
            return $result;
        }

        /** @var array $token */
        $token = $this->requestToken($this->getCredentials(), true);

        $this->setToken($token[$this->tokenKey], $token['expire'] ?? 7200);

        $this->token = $token;

        $this->app->events->dispatch(new \EasyFeishu\Kernel\Events\AccessTokenRefreshed($this));

        return $token;
    }

    /**
     * @throws \EasyFeishu\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyFeishu\Kernel\Exceptions\RuntimeException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function setToken(string $token, int $lifetime = 7200): AccessTokenInterface
    {
        $this->getCache()->set($this->getCacheKey(), [
            $this->tokenKey => $token,
            'expires_in' => $lifetime,
        ], $lifetime);

        if (!$this->getCache()->has($this->getCacheKey())) {
            throw new RuntimeException('Failed to cache access token.');
        }

        return $this;
    }

    /**
     * @throws \EasyFeishu\Kernel\Exceptions\HttpException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \EasyFeishu\Kernel\Exceptions\InvalidConfigException
     * @throws \EasyFeishu\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyFeishu\Kernel\Exceptions\RuntimeException
     */
    public function refresh(): AccessTokenInterface
    {
        $this->getToken(true);

        return $this;
    }

    /**
     * @param bool $toArray
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyFeishu\Kernel\Support\Collection|array|object|string
     *
     * @throws \EasyFeishu\Kernel\Exceptions\HttpException
     * @throws \EasyFeishu\Kernel\Exceptions\InvalidConfigException
     * @throws \EasyFeishu\Kernel\Exceptions\InvalidArgumentException
     */
    public function requestToken(array $credentials, $toArray = false)
    {
        $response = $this->sendRequest($credentials);
        $result = json_decode($response->getBody()->getContents(), true);
        $formatted = $this->castResponseToType($response, $this->app['config']->get('response_type'));

        if (empty($result[$this->tokenKey])) {
            throw new HttpException('Request access_token fail: ' . json_encode($result, JSON_UNESCAPED_UNICODE), $response, $formatted);
        }

        return $toArray ? $result : $formatted;
    }

    /**
     * @throws \EasyFeishu\Kernel\Exceptions\HttpException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \EasyFeishu\Kernel\Exceptions\InvalidConfigException
     * @throws \EasyFeishu\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyFeishu\Kernel\Exceptions\RuntimeException
     */
    public function applyToRequest(RequestInterface $request, array $requestOptions = []): RequestInterface
    {
        $token = $this->getToken();
        $request = $request->withHeader('Authorization', 'Bearer ' . $token[$this->tokenKey]);
        return $request;
    }

    /**
     * Send http request.
     *
     * @throws \EasyFeishu\Kernel\Exceptions\InvalidArgumentException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function sendRequest(array $credentials): ResponseInterface
    {
        $options = [
            ('GET' === $this->requestMethod) ? 'query' : 'json' => $credentials,
        ];

        return $this->setHttpClient($this->app['http_client'])->request($this->getEndpoint(), $this->requestMethod, $options);
    }

    /**
     * @return string
     */
    protected function getCacheKey()
    {
        return $this->cachePrefix . $this->tokenKey . md5(json_encode($this->getCredentials()));
    }

    /**
     * The request query will be used to add to the request.
     *
     * @throws \EasyFeishu\Kernel\Exceptions\HttpException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \EasyFeishu\Kernel\Exceptions\InvalidConfigException
     * @throws \EasyFeishu\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyFeishu\Kernel\Exceptions\RuntimeException
     */
    protected function getQuery(): array
    {
        return [$this->queryName ?? $this->tokenKey => $this->getToken()[$this->tokenKey]];
    }

    /**
     * @throws \EasyFeishu\Kernel\Exceptions\InvalidArgumentException
     */
    public function getEndpoint(): string
    {
        if (empty($this->endpointToGetToken)) {
            throw new InvalidArgumentException('No endpoint for access token request.');
        }

        return $this->endpointToGetToken;
    }

    /**
     * @return string
     */
    public function getTokenKey()
    {
        return $this->tokenKey;
    }

    /**
     * Credential for get token.
     */
    abstract protected function getCredentials(): array;
}
