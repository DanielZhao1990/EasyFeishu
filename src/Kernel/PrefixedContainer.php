<?php

namespace EasyFeishu\Kernel;

use Pimple\Container;

trait PrefixedContainer
{
    /**
     * Container.
     *
     * @var \Pimple\Container
     */
    protected $container;

    /**
     * ContainerAccess constructor.
     *
     * @param \Pimple\Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Fetches from pimple container.
     *
     * @param string $key
     * @param callable|null $callable
     *
     * @return mixed
     */
    public function fetch($key, callable $callable = null)
    {
        $instance = $this->$key;

        if (!is_null($callable)) {
            $callable($instance);
        }

        return $instance;
    }

    /**
     * Gets a parameter or an object from pimple container.
     *
     * Get the `class basename` of the current class.
     * Convert `class basename` to snake-case and concatenation with dot notation.
     *
     * E.g. Class 'EasyWechat', $key foo -> 'easy_wechat.foo'
     *
     * @param string $key The unique identifier for the parameter or object
     *
     * @throws \InvalidArgumentException If the identifier is not defined
     *
     * @return mixed The value of the parameter or an object
     */
    public function __get($key)
    {
        $className = basename(str_replace('\\', '/', static::class));
        $name = $this->uncamelize($className) . '.' . $key;
        return $this->container->offsetGet($name);
    }


    function uncamelize($camelCaps, $separator = '_')
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', "$1" . $separator . "$2", $camelCaps));
    }
}
