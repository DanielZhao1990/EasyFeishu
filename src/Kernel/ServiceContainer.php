<?php
/**
 * Created by PhpStorm.
 * User: zhao0
 * Date: 2022/3/29
 * Time: 14:39
 */

namespace EasyFeishu\Kernel;

use EasyFeishu\Kernel\Providers\ConfigServiceProvider;
use EasyFeishu\Kernel\Providers\EventDispatcherServiceProvider;
use EasyFeishu\Kernel\Providers\ExtensionServiceProvider;
use EasyFeishu\Kernel\Providers\HttpClientServiceProvider;
use EasyFeishu\Kernel\Providers\LogServiceProvider;
use EasyFeishu\Kernel\Providers\RequestServiceProvider;
use Pimple\Container;

/**
 * @property Config                          $config
 * @property \Symfony\Component\HttpFoundation\Request          $request
 * @property \GuzzleHttp\Client                                 $http_client
 * @property \Monolog\Logger                                    $logger
 * @property \Symfony\Component\EventDispatcher\EventDispatcher $events
 * @package EasyFeishu\base
 */
class ServiceContainer extends Container
{
    /**
     * @var array
     */
    protected $providers = [];

    /**
     * @var array
     */
    protected $defaultConfig = [];

    /**
     * @var array
     */
    protected $userConfig = [];

    /**
     * Constructor.
     */
    public function __construct(array $config = [], array $prepends = [], string $id = null)
    {
        parent::__construct($prepends);
        $this->userConfig = $config;
        $this->id = $id;
        $this->registerProviders($this->getProviders());
    }

    /**
     * Return all providers.
     *
     * @return array
     */
    public function getProviders()
    {
        return array_merge([
            ConfigServiceProvider::class,
            LogServiceProvider::class,
            RequestServiceProvider::class,
            HttpClientServiceProvider::class,
            ExtensionServiceProvider::class,
            EventDispatcherServiceProvider::class,
        ], $this->providers);
    }

    public function registerProviders(array $providers)
    {
        foreach ($providers as $provider) {
            parent::register(new $provider());
        }
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        $base = [
            // http://docs.guzzlephp.org/en/stable/request-options.html
            'http' => [
                'timeout' => 30.0,
                'base_uri' => 'https://open.feishu.cn/',
            ],
        ];

        return array_replace_recursive($base, $this->defaultConfig, $this->userConfig);
    }


    /**
     * @param string $id
     * @param mixed  $value
     */
    public function rebind($id, $value)
    {
        $this->offsetUnset($id);
        $this->offsetSet($id, $value);
    }

    /**
     * Magic get access.
     *
     * @param string $id
     *
     * @return mixed
     */
    public function __get($id)
    {
        return $this->offsetGet($id);
    }

    /**
     * Magic set access.
     *
     * @param string $id
     * @param mixed $value
     */
    public function __set($id, $value)
    {
        $this->offsetSet($id, $value);
    }
}